<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core;

use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\Tags\Param;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Never_;
use phpDocumentor\Reflection\Types\Void_;
use PhpParser\Comment\Doc;
use PhpParser\ConstExprEvaluator;
use PhpParser\Node;
use PhpParser\NodeFinder;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Expr\Exit_;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\Return_ as Stmt_Return;
use StubsGenerator\NodeVisitor;

// phpcs:disable NeutronStandard.Functions.LongFunction.LongFunction,NeutronStandard.Functions.TypeHint.NoReturnType

class Visitor extends NodeVisitor
{
    private \phpDocumentor\Reflection\DocBlockFactoryInterface $docBlockFactory;

    /** @var array<string,array<int|string,string>> */
    private array $functionMap;

    /** @var array<string, list<\PhpStubs\WordPress\Core\WordPressTag>> */
    private array $additionalTags = [];

    /** @var array<string, list<string>> */
    private array $additionalTagStrings = [];

    private \PhpParser\NodeFinder $nodeFinder;

    public function __construct()
    {
        $this->docBlockFactory = \phpDocumentor\Reflection\DocBlockFactory::createInstance();
        $this->nodeFinder = new NodeFinder();
        $this->functionMap = require sprintf('%s/functionMap.php', dirname(__DIR__));
    }

    /**
     * @return int|null
     */
    public function enterNode(Node $node)
    {
        $voidOrNever = $this->voidOrNever($node);

        parent::enterNode($node);

        if (! ($node instanceof Function_) && ! ($node instanceof ClassMethod) && ! ($node instanceof Property) && ! ($node instanceof Class_)) {
            return null;
        }

        $docComment = $node->getDocComment();

        if (! ($docComment instanceof Doc)) {
            return null;
        }

        $symbolName = self::getNodeName($node);

        if ($node instanceof ClassMethod || $node instanceof Property) {
            $parent = $this->stack[count($this->stack) - 2];
            \assert($parent instanceof \PhpParser\Node\Stmt\ClassLike);

            if ($parent->name !== null) {
                $symbolName = sprintf(
                    '%1$s::%2$s%3$s',
                    $parent->name->name,
                    $node instanceof Property ? '$' : '',
                    $symbolName
                );
            }
        }
        $node->setAttribute('fullSymbolName', $symbolName);

        $additions = $this->generateAdditionalTagsFromDoc($docComment);
        if (count($additions) > 0) {
            $this->additionalTags[$symbolName] = $additions;
        }

        $additions = $this->getAdditionalTagsFromMap($symbolName);
        if (count($additions) > 0) {
            $this->additionalTagStrings[$symbolName] = $additions;
        }

        if ($voidOrNever !== '') {
            $addition = sprintf(
                '@phpstan-return %s',
                $voidOrNever === 'never'
                    ? (new Never_())->__toString()
                    : (new Void_())->__toString()
            );
            if (
                ! isset($this->additionalTagStrings[$symbolName])
                || ! in_array($addition, $this->additionalTagStrings[$symbolName], true)
            ) {
                $this->additionalTagStrings[$symbolName][] = $addition;
            }
        }

        return null;
    }

    private static function getNodeName(Node $node): string
    {
        if ((($node instanceof Function_) || ($node instanceof ClassMethod) || ($node instanceof Class_)) && $node->name instanceof Identifier) {
            return $node->name->name;
        }

        if ($node instanceof Property) {
            return $node->props[0]->name->name;
        }

        return '';
    }

    /**
     * @return array<\PhpParser\Node>
     */
    public function getStubStmts(): array
    {
        $stmts = parent::getStubStmts();

        foreach ($stmts as $stmt) {
            $this->postProcessNode($stmt);
        }
        return $stmts;
    }

    private function postProcessNode(Node $node): void
    {
        if ($node instanceof ClassLike || $node instanceof Namespace_) {
            foreach ($node->stmts as $stmt) {
                $this->postProcessNode($stmt);
            }
        }

        if (! ($node instanceof Function_) && ! ($node instanceof ClassMethod) && ! ($node instanceof Property) && ! ($node instanceof Class_)) {
            return;
        }

        /** @var ?string $fullSymbolName */
        $fullSymbolName = $node->getAttribute('fullSymbolName');

        if ($fullSymbolName === null) {
            return;
        }

        $docComment = $node->getDocComment();

        if (! ($docComment instanceof Doc)) {
            return;
        }

        $newDocComment = $this->addTags($fullSymbolName, $docComment);

        if ($newDocComment instanceof Doc) {
            $node->setDocComment($newDocComment);
        }

        if (! isset($this->additionalTagStrings[$fullSymbolName])) {
            return;
        }

        $docComment = $node->getDocComment();

        if (! ($docComment instanceof Doc)) {
            return;
        }

        $newDocComment = $this->addStringTags($fullSymbolName, $docComment);

        if (! ($newDocComment instanceof Doc)) {
            return;
        }

        $node->setDocComment($newDocComment);
    }

    /**
     * @return list<\PhpStubs\WordPress\Core\WordPressTag>
     */
    private function generateAdditionalTagsFromDoc(Doc $docComment): array
    {
        $docCommentText = $docComment->getText();

        try {
            $docblock = $this->docBlockFactory->create($docCommentText);
        } catch (\RuntimeException | \InvalidArgumentException $e) {
            return [];
        }

        /** @var list<\phpDocumentor\Reflection\DocBlock\Tags\Param> $paramTags*/
        $paramTags = $docblock->getTagsByName('param');

        /** @var list<\phpDocumentor\Reflection\DocBlock\Tags\Return_> $returnTags */
        $returnTags = $docblock->getTagsByName('return');

        /** @var list<\phpDocumentor\Reflection\DocBlock\Tags\Var_> $varTags */
        $varTags = $docblock->getTagsByName('var');

        /** @var list<\PhpStubs\WordPress\Core\WordPressTag> $additions */
        $additions = [];

        foreach ($paramTags as $paramTag) {
            $addition = self::getAdditionFromParam($paramTag);

            if (! ($addition instanceof WordPressTag)) {
                continue;
            }

            $additions[] = $addition;
        }

        foreach ($returnTags as $returnTag) {
            $addition = self::getAdditionFromReturn($returnTag);

            if (! ($addition instanceof WordPressTag)) {
                continue;
            }

            $additions[] = $addition;
        }

        foreach ($varTags as $varTag) {
            $addition = self::getAdditionFromVar($varTag);

            if (! ($addition instanceof WordPressTag)) {
                continue;
            }

            $additions[] = $addition;
        }

        return $additions;
    }

    private function addTags(string $name, Doc $docComment): ?Doc
    {
        $additions = $this->additionalTags[$name] ?? [];
        $docCommentText = $docComment->getText();

        try {
            $docblock = $this->docBlockFactory->create($docCommentText);
        } catch (\RuntimeException | \InvalidArgumentException $e) {
            return null;
        }

        $additions = $this->discoverInheritedArgs($docblock, $additions);

        /** @var list<string> $additionStrings */
        $additionStrings = array_map(
            static function (WordPressTag $tag): string {
                $lines = $tag->format();

                if (count($lines) === 0) {
                    return '';
                }

                return sprintf(' * %s', implode("\n * ", $lines));
            },
            $additions
        );

        $additionStrings = array_filter($additionStrings);

        if (count($additionStrings) === 0) {
            return null;
        }

        $newDocComment = sprintf(
            "%s\n%s\n */",
            substr($docCommentText, 0, -4),
            implode("\n", $additionStrings)
        );

        return new Doc($newDocComment, $docComment->getStartLine(), $docComment->getStartFilePos());
    }

    /**
     * @param list<\PhpStubs\WordPress\Core\WordPressTag> $additions
     * @return list<\PhpStubs\WordPress\Core\WordPressTag>
     */
    private function discoverInheritedArgs(DocBlock $docblock, array $additions): array
    {
        /** @var list<\phpDocumentor\Reflection\DocBlock\Tags\Param> $params */
        $params = $docblock->getTagsByName('param');

        $phpStanParams = array_filter(
            $additions,
            static function (WordPressTag $addition): bool {
                return $addition->tag === '@phpstan-param';
            }
        );

        foreach ($params as $param) {
            $inherited = $this->getInheritedTagsForParam($param);

            if (count($inherited) === 0) {
                continue;
            }

            foreach ($phpStanParams as $addition) {
                foreach ($inherited as $inherit) {
                    if ($addition->name !== $inherit->name) {
                        continue;
                    }

                    $addition->children = array_merge($addition->children, $inherit->children);
                    continue 3;
                }
            }

            $additions = array_merge($additions, $inherited);
        }

        return $additions;
    }

    /**
     * @return list<\PhpStubs\WordPress\Core\WordPressTag>
     */
    private function getInheritedTagsForParam(Param $param): array
    {
        $type = $param->getType();

        if (! $type instanceof Type) {
            return [];
        }

        $typeName = self::getTypeNameFromType($type);

        if ($typeName === null) {
            return [];
        }

        $paramDescription = $param->getDescription();

        if (! $paramDescription instanceof Description) {
            return [];
        }

        $description = explode("\n\n", $paramDescription->__toString())[0];

        if (strpos($description, '()') === false) {
            return [];
        }

        $description = str_replace("\n", ' ', $description);
        $description = str_replace('@see \\', '@see ', $description);
        $additions = [];

        foreach ($this->additionalTags as $symbolName => $tags) {
            $search = sprintf(
                'see %s()',
                $symbolName
            );

            if (stripos($description, $search) === false) {
                continue;
            }

            $match = self::getMatchingInheritedTag($param, $tags, $symbolName);

            if (! ($match instanceof WordPressTag)) {
                continue;
            }

            $additions[] = $match;
        }

        return $additions;
    }

    /**
     * @param list<\PhpStubs\WordPress\Core\WordPressTag> $tags
     */
    private static function getMatchingInheritedTag(Param $param, array $tags, string $symbolName): ?WordPressTag
    {
        $paramName = $param->getVariableName();
        $matchNames = [
            $paramName,
            'args',
            'options',
            'query',
        ];
        $matchingTags = array_filter(
            $tags,
            static function (WordPressTag $tag) use ($matchNames): bool {
                return in_array($tag->name, $matchNames, true);
            }
        );

        foreach ($matchingTags as $tag) {
            $addTag = clone $tag;
            $addTag->name = $paramName;
            $addTag->description = sprintf(
                'See %s()',
                $symbolName
            );

            return $addTag;
        }

        return null;
    }

    /**
     * @return list<string>
     */
    private function getAdditionalTagsFromMap(string $symbolName): array
    {
        if (! array_key_exists($symbolName, $this->functionMap)) {
            return [];
        }

        $parameters = $this->functionMap[$symbolName];
        $returnType = array_shift($parameters);
        /** @var array<string, string> $parameters */

        $additions = [];

        foreach ($parameters as $paramName => $paramType) {
            if (strpos($paramName, '@') === 0) {
                $format = ( $paramType === '' ) ? '%s' : '%s %s';
                $additions[] = sprintf(
                    $format,
                    $paramName,
                    $paramType
                );
                continue;
            }

            $additions[] = sprintf(
                '@phpstan-param %s $%s',
                $paramType,
                $paramName
            );
        }

        if ($returnType !== null) {
            $additions[] = sprintf(
                '@phpstan-return %s',
                $returnType
            );
        }

        return $additions;
    }

    private function addStringTags(string $name, Doc $docComment): ?Doc
    {
        if (! isset($this->additionalTagStrings[$name])) {
            return null;
        }

        $additions = $this->additionalTagStrings[$name];

        $docCommentText = $docComment->getText();
        $newDocComment = sprintf(
            "%s\n * %s\n */",
            substr($docCommentText, 0, -4),
            implode("\n * ", $additions)
        );

        return new Doc($newDocComment, $docComment->getStartLine(), $docComment->getStartFilePos());
    }

    private function getAdditionFromParam(Param $tag): ?WordPressTag
    {
        $tagDescription = $tag->getDescription();
        $tagVariableName = $tag->getVariableName();
        $tagVariableType = $tag->getType();

        // Skip if information we need is missing.
        if (! $tagDescription instanceof Description || $tagVariableName === null || $tagVariableName === '' || ! $tagVariableType instanceof Type) {
            return null;
        }

        $tagDescriptionType = self::getTypeNameFromDescription($tagDescription, $tagVariableType);

        if ($tagDescriptionType !== null) {
            $tag = new WordPressTag();
            $tag->tag = '@phpstan-param';
            $tag->type = $tagDescriptionType;
            $tag->name = $tagVariableName;

            return $tag;
        }

        $elements = self::getElementsFromDescription($tagDescription, true);

        if (count($elements) === 0) {
            return null;
        }

        $tagVariableType = self::getTypeNameFromType($tagVariableType);

        if ($tagVariableType === null) {
            return null;
        }

        // It's common for an args parameter to accept a query var string or array with `string|array`.
        // Remove the accepted string type for these so we get the strongest typing we can manage.
        $tagVariableType = str_replace(['|string', 'string|'], '', $tagVariableType);

        $tag = new WordPressTag();
        $tag->tag = '@phpstan-param';
        $tag->type = $tagVariableType;
        $tag->name = $tagVariableName;
        $tag->children = $elements;

        return $tag;
    }

    private function getAdditionFromReturn(Return_ $tag): ?WordPressTag
    {
        $tagDescription = $tag->getDescription();
        $tagVariableType = $tag->getType();

        // Skip if information we need is missing.
        if (! $tagDescription instanceof Description || ! $tagVariableType instanceof Type) {
            return null;
        }

        $tagDescriptionType = self::getTypeNameFromDescription($tagDescription, $tagVariableType);

        if ($tagDescriptionType !== null) {
            $tag = new WordPressTag();
            $tag->tag = '@phpstan-return';
            $tag->type = $tagDescriptionType;

            return $tag;
        }

        $elements = self::getElementsFromDescription($tagDescription, false);

        if (count($elements) === 0) {
            return null;
        }

        $tagVariableType = self::getTypeNameFromType($tagVariableType);

        if ($tagVariableType === null) {
            return null;
        }

        $tag = new WordPressTag();
        $tag->tag = '@phpstan-return';
        $tag->type = $tagVariableType;
        $tag->children = $elements;

        return $tag;
    }

    private static function getAdditionFromVar(Var_ $tag): ?WordPressTag
    {
        $tagDescription = $tag->getDescription();
        $tagVariableType = $tag->getType();

        // Skip if information we need is missing.
        if (! $tagDescription instanceof Description || ! $tagVariableType instanceof Type) {
            return null;
        }

        $elements = self::getElementsFromDescription($tagDescription, false);

        if (count($elements) === 0) {
            return null;
        }

        $tagVariableType = self::getTypeNameFromType($tagVariableType);

        if ($tagVariableType === null) {
            return null;
        }

        $tag = new WordPressTag();
        $tag->tag = '@phpstan-var';
        $tag->type = $tagVariableType;
        $tag->children = $elements;

        return $tag;
    }

    private static function getTypeNameFromDescription(Description $tagVariableDescription, Type $tagVariableType): ?string
    {
        if (! ($tagVariableType instanceof \phpDocumentor\Reflection\Types\String_)) {
            return null;
        }

        return self::getTypeNameFromDescriptionString($tagVariableDescription->__toString());
    }

    private static function getTypeNameFromDescriptionString(?string $tagDescription = null): ?string
    {
        if ($tagDescription === null) {
            return null;
        }

        $fullDescription = str_replace("\n", ' ', $tagDescription);

        /**
         * This matches phrases that contain a list of two or more single-quoted strings, with the last
         * item separated by 'or' or 'and'. The Oxford comma is optional. For example:
         *
         * - Either 'am', 'pm', 'AM', or 'PM'
         * - Accepts 'comment' or 'term'
         * - Either 'plugin' or 'theme'
         * - Accepts 'big', or 'little'.
         * - One of 'default', 'theme', or 'custom'
         * - Either 'network-active', 'active' or 'inactive'
         * - : 'top' or 'bottom'
         */
        $matched = preg_match("#(?>returns|either|one of|accepts|values are|:) ('.+'),? (?>or|and) '([^']+)'#i", $fullDescription, $matches);

        if ($matched !== 1) {
            return null;
        }

        $items = $matches[1];
        $final = $matches[2];

        // Pluck out phrases between single quotes, so messy sentences are handled:
        preg_match_all("#'([^']+)'#", $items, $matches);

        $accepted = $matches[1];

        // Append the final item:
        $accepted[] = $final;

        return sprintf("'%s'", implode("'|'", $accepted));
    }

    private static function getTypeNameFromType(Type $tagVariableType): ?string
    {
        return self::getTypeNameFromString($tagVariableType->__toString());
    }

    private static function getTypeNameFromString(string $tagVariable): ?string
    {
        // PHPStan doesn't support typed array shapes (`int[]{...}`) so replace
        // typed arrays such as `int[]` with `array`.
        $tagVariableType = preg_replace('#[a-zA-Z0-9_]+\[\]#', 'array', $tagVariable);

        if ($tagVariableType === null) {
            return null;
        }

        $tagVariableType = str_replace(
            [
            'stdClass',
            '\\object',
            ],
            'object',
            $tagVariableType
        );

        $supportedTypes = [
            'object',
            'array',
        ];

        foreach ($supportedTypes as $supportedType) {
            if (strpos($tagVariableType, "{$supportedType}|") === false) {
                continue;
            }
            // Move the type that uses the hash notation to the end of union types so the shape works.
            $tagVariableType = sprintf('%s|%s', str_replace("{$supportedType}|", '', $tagVariableType), $supportedType);
        }

        return $tagVariableType;
    }

    /**
     * @return list<\PhpStubs\WordPress\Core\WordPressArg>
     */
    private static function getElementsFromDescription(Description $tagDescription, bool $optional): array
    {
        $text = $tagDescription->__toString();

        // Skip if the description doesn't contain at least one correctly
        // formatted `@type`, which indicates an array hash.
        if (strpos($text, '    @type ') === false) {
            return [];
        }

        return self::getTypesAtLevel($text, $optional, 1);
    }

    /**
     * @return list<\PhpStubs\WordPress\Core\WordPressArg>
     */
    private static function getTypesAtLevel(string $text, bool $optional, int $level): array
    {
        // Populate `$types` with the value of each top level `@type`.
        $spaces = str_repeat(' ', ($level * 4));
        $types = preg_split("/\R+{$spaces}@type /", $text);

        if ($types === false) {
            return [];
        }

        unset($types[0]);
        $elements = [];

        foreach ($types as $typeTag) {
            $parts = preg_split('#\s+#', trim($typeTag), 3);

            if ($parts === false || count($parts) < 2) {
                return [];
            }

            $type = $parts[0];
            $name = $parts[1];

            $optionalArg = $optional;
            $nameTrimmed = ltrim($name, '$');

            if (is_numeric($nameTrimmed)) {
                $optionalArg = false;
            } elseif ($optional && ($level > 1)) {
                $optionalArg = self::isOptional($parts[2]);
            }

            if (strpos($name, '...$') !== false) {
                $name = null;
            } elseif (strpos($name, '$') !== 0) {
                return [];
            } else {
                $name = $nameTrimmed;
            }

            $arg = new WordPressArg();
            $arg->type = $type;
            $arg->optional = $optionalArg;
            $arg->name = $name;

            $nextLevel = $level + 1;
            $subTypes = self::getTypesAtLevel($typeTag, $optional, $nextLevel);

            if (count($subTypes) > 0) {
                $type = self::getTypeNameFromString($type);

                if ($type !== null) {
                    $arg->type = $type;
                }
                $arg->children = $subTypes;
            }

            $elements[] = $arg;
        }

        return $elements;
    }

    private static function isOptional(string $description): bool
    {
        return (stripos($description, 'Optional') !== false)
            || (stripos($description, 'Default ') !== false)
            || (stripos($description, 'Default: ') !== false)
            || (stripos($description, 'Defaults to ') !== false);
    }

    private function voidOrNever(Node $node): string
    {
        if (! ($node instanceof Function_) && ! ($node instanceof ClassMethod)) {
            return '';
        }

        if (! isset($node->stmts) || count($node->stmts) === 0) {
            // Interfaces and abstract methods.
            return '';
        }

        $returnStmts = $this->nodeFinder->findInstanceOf($node, Stmt_Return::class);

        // If there is a return statement, it's not return type never.
        if (count($returnStmts) !== 0) {
            // If there is at least one return statement that is not void,
            // it's not return type void.
            if (
                $this->nodeFinder->findFirst(
                    $returnStmts,
                    static function (Node $node): bool {
                        return property_exists($node, 'expr') && $node->expr !== null;
                    }
                ) instanceof Node
            ) {
                return '';
            }
            // If there is no return statement that is not void,
            // it's return type void.
            return 'void';
        }

        // Check for never return type.
        foreach ($node->stmts as $stmt) {
            if (! ($stmt instanceof Expression)) {
                continue;
            }
            // If a first level statement is exit/die, it's return type never.
            if ($stmt->expr instanceof Exit_) {
                if (! $stmt->expr->expr instanceof String_) {
                    return 'never';
                }
                if (strpos($stmt->expr->expr->value, 'must be overridden') !== false) {
                    return '';
                }
                return 'never';
            }
            if (! ($stmt->expr instanceof FuncCall) || ! ($stmt->expr->name instanceof Name)) {
                continue;
            }
            $name = $stmt->expr->name;
            // If a first level statement is a call to wp_send_json(_success/error),
            // it's return type never.
            if (strpos($name->toString(), 'wp_send_json') === 0) {
                return 'never';
            }
            // Skip all functions but wp_die().
            if (strpos($name->toString(), 'wp_die') !== 0) {
                continue;
            }
            $args = $stmt->expr->getArgs();
            // If wp_die is called without 3rd parameter, it's return type never.
            if (count($args) < 3) {
                return 'never';
            }
            // If wp_die is called with 3rd parameter, we need additional checks.
            try {
                $arg = (new ConstExprEvaluator())->evaluateSilently($args[2]->value);
            } catch (\PhpParser\ConstExprEvaluationException $e) {
                // If we don't know the value of the 3rd parameter, we can't be sure.
                continue;
            }

            if (is_int($arg)) {
                return 'never';
            }

            if (! is_array($arg)) {
                continue;
            }

            if (! array_key_exists('exit', $arg) || (bool)$arg['exit']) {
                return 'never';
            }
        }
        return '';
    }
}
