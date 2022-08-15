<?php

declare(strict_types = 1);

use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\Tags\Param;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use phpDocumentor\Reflection\Type;
use PhpParser\Comment\Doc;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Property;
use StubsGenerator\NodeVisitor;

abstract class WithChildren
{
    /**
     * @var WordPressArg[]
     */
    public $children = [];

    public function isArrayShape(): bool
    {
        foreach ($this->children as $child) {
            if ($child->name === null) {
                return false;
            }
        }

        return true;
    }

    public function isMixedShape(): bool
    {
        $hasStaticKey = false;

        foreach ($this->children as $child) {
            if ($child->name !== null) {
                $hasStaticKey = true;
            } elseif ($hasStaticKey) {
                return true;
            }
        }

        return false;
    }
}

final class WordPressTag extends WithChildren
{
    /**
     * @var string
     */
    public $tag;

    /**
     * @var string
     */
    public $type;

    /**
     * @var ?string
     */
    public $name = null;

    /**
     * @var ?string
     */
    public $description = null;

    /**
     * @return string[]
     */
    public function format(): array
    {
        if ($this->isMixedShape()) {
            return [];
        }

        $strings = [];
        $childStrings = [];
        $level = 1;

        if (! $this->isArrayShape()) {
            $level = 0;
        }

        foreach ($this->children as $child) {
            $childStrings = array_merge($childStrings, $child->format($level));
        }

        if (count($childStrings) === 0) {
            return [];
        }

        $name = ($this->name !== null) ? (' $' . $this->name) : '';

        if ($this->isArrayShape()) {
            $strings[] = sprintf(
                '%s %s{',
                $this->tag,
                $this->type
            );
        } else {
            if (count($this->children) > 0 && count($this->children[0]->children) > 0) {
                $strings[] = sprintf(
                    '%s %s<int|string, array{',
                    $this->tag,
                    $this->type
                );
            } else {
                $strings[] = sprintf(
                    '%s array<int|string, %s>%s',
                    $this->tag,
                    $this->type,
                    $name
                );

                return $strings;
            }
        }

        $strings = array_merge($strings, $childStrings);
        $description = '';

        if ($this->description !== null) {
            $description = ' ' . $this->description;
        }

        if ($this->isArrayShape()) {
            $strings[] = sprintf(
                '}%s%s',
                $name,
                $description
            );
        } else {
            $strings[] = sprintf(
                '}>%s%s',
                $name,
                $description
            );
        }

        return $strings;
    }
}

final class WordPressArg extends WithChildren
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var bool
     */
    public $optional = false;

    /**
     * @var ?string
     */
    public $name = null;

    /**
     * @return string[]
     */
    public function format(int $level = 1): array
    {
        $strings = [];
        $padding = str_repeat(' ', ($level * 2));

        if ($this->isMixedShape()) {
            return [];
        }

        if (count($this->children) > 0) {
            $childStrings = [];

            foreach ($this->children as $child) {
                $childStrings = array_merge($childStrings, $child->format($level + 1));
            }

            if (count($childStrings) === 0) {
                return [];
            }

            if ($this->isArrayShape()) {
                if ($this->name !== null) {
                    $strings[] = sprintf(
                        '%s%s%s: %s{',
                        $padding,
                        $this->name,
                        ($this->optional) ? '?' : '',
                        $this->type
                    );
                }
            } else {
                $strings[] = sprintf(
                    '%s%s%s: array<int|string, %s{',
                    $padding,
                    $this->name,
                    ($this->optional) ? '?' : '',
                    $this->type
                );
            }

            $strings = array_merge($strings, $childStrings);

            if ($this->isArrayShape()) {
                if ($this->name !== null) {
                    $strings[] = $padding . '},';
                }
            } else {
                $strings[] = $padding . '}>,';
            }
        } else {
            $strings[] = sprintf(
                '%s%s%s: %s,',
                $padding,
                $this->name,
                ($this->optional) ? '?' : '',
                $this->type
            );
        }

        return $strings;
    }
}

return new class extends NodeVisitor {

    /**
     * @var \phpDocumentor\Reflection\DocBlockFactory
     */
    private $docBlockFactory;

    /**
     * @var ?array<string,array<int|string,string>>
     */
    private $functionMap = null;

    /**
     * @var array<string, array<int, WordPressTag>>
     */
    private $additionalTags = [];

    /**
     * @var array<string, array<int, string>>
     */
    private $additionalTagStrings = [];

    public function __construct()
    {
        $this->docBlockFactory = \phpDocumentor\Reflection\DocBlockFactory::createInstance();
    }

    public function enterNode(Node $node)
    {
        parent::enterNode($node);

        if (!($node instanceof Function_) && !($node instanceof ClassMethod) && !($node instanceof Property)) {
            return null;
        }

        $docComment = $node->getDocComment();

        if (!($docComment instanceof Doc)) {
            return null;
        }

        $symbolName = self::getNodeName($node);

        if ($node instanceof ClassMethod) {
            /** @var \PhpParser\Node\Stmt\Class_ $parent */
            $parent = $this->stack[count($this->stack) - 2];

            if (isset($parent->name)) {
                $symbolName = sprintf(
                    '%1$s::%2$s',
                    $parent->name->name,
                    $node->name->name
                );
            }
        }

        $additions = $this->generateAdditionalTagsFromDoc($docComment);
        $node->setAttribute('fullSymbolName', $symbolName);

        if (count($additions) > 0) {
            $this->additionalTags[ $symbolName ] = $additions;
        }

        $additions = $this->getAdditionalTagsFromMap($symbolName);

        if (count($additions) > 0) {
            $this->additionalTagStrings[ $symbolName ] = $additions;
        }

        return null;
    }

    private static function getNodeName(Node $node): string
    {
        if (($node instanceof Function_) || ($node instanceof ClassMethod)) {
            return $node->name->name;
        }

        if ($node instanceof Property) {
            return sprintf(
                'property_%s',
                uniqid()
            );
        }

        return '';
    }

    /**
     * @return Node[]
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
        if (isset($node->stmts) && is_array($node->stmts)) {
            foreach ($node->stmts as $stmt) {
                $this->postProcessNode($stmt);
            }
        }

        if (! ($node instanceof Function_) && ! ($node instanceof ClassMethod) && ! ($node instanceof Property)) {
            return;
        }

        $name = $node->getAttribute('fullSymbolName');

        if ($name === null) {
            return;
        }

        $docComment = $node->getDocComment();

        if (!($docComment instanceof Doc)) {
            return;
        }

        $newDocComment = $this->addTags($name, $docComment);

        if ($newDocComment !== null) {
            $node->setDocComment($newDocComment);
        }

        if (! isset($this->additionalTagStrings[ $name ])) {
            return;
        }

        $docComment = $node->getDocComment();

        if (!($docComment instanceof Doc)) {
            return;
        }

        $newDocComment = $this->addStringTags($name, $docComment);

        if ($newDocComment !== null) {
            $node->setDocComment($newDocComment);
        }
    }

    /**
     * @return array<int, WordPressTag>
     */
    private function generateAdditionalTagsFromDoc(Doc $docComment): array
    {
        $docCommentText = $docComment->getText();

        try {
            $docblock = $this->docBlockFactory->create($docCommentText);
        } catch ( \RuntimeException $e ) {
            return [];
        } catch ( \InvalidArgumentException $e ) {
            return [];
        }

        /** @var \phpDocumentor\Reflection\DocBlock\Tags\Param[] */
        $params = $docblock->getTagsByName('param');

        /** @var \phpDocumentor\Reflection\DocBlock\Tags\Return_[] */
        $returns = $docblock->getTagsByName('return');

        /** @var \phpDocumentor\Reflection\DocBlock\Tags\Var_[] */
        $vars = $docblock->getTagsByName('var');

        /** @var WordPressTag[] $additions */
        $additions = [];

        foreach ($params as $param) {
            if (! $param instanceof Param) {
                continue;
            }

            $addition = self::getAdditionFromParam($param);

            if ($addition !== null) {
                $additions[] = $addition;
            }
        }

        foreach ($returns as $return) {
            if (! $return instanceof Return_) {
                continue;
            }

            $addition = self::getAdditionFromReturn($return);

            if ($addition !== null) {
                $additions[] = $addition;
            }
        }

        foreach ($vars as $var) {
            if (! $var instanceof Var_) {
                continue;
            }

            $addition = self::getAdditionFromVar($var);

            if ($addition !== null) {
                $additions[] = $addition;
            }
        }

        return $additions;
    }

    private function addTags(string $name, Doc $docComment): ?Doc
    {
        if (isset($this->additionalTags[ $name ])) {
            $additions = $this->additionalTags[ $name ];
        } else {
            $additions = [];
        }

        $docCommentText = $docComment->getText();

        try {
            $docblock = $this->docBlockFactory->create($docCommentText);
        } catch ( \RuntimeException $e ) {
            return null;
        } catch ( \InvalidArgumentException $e ) {
            return null;
        }

        $additions = $this->discoverInheritedArgs($docblock, $additions);

        /** @var string[] $additionStrings */
        $additionStrings = array_map( function(WordPressTag $tag): string {
            $lines = $tag->format();

            if (count($lines) === 0) {
                return '';
            }

            return " * " . implode("\n * ", $lines);
        }, $additions);

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
     * @param array<int, WordPressTag> $additions
     * @return array<int, WordPressTag>
     */
    private function discoverInheritedArgs(DocBlock $docblock, array $additions): array
    {
        /** @var Param[] $params */
        $params = $docblock->getTagsByName('param');

        $phpStanParams = array_filter($additions, function(WordPressTag $addition): bool {
            return $addition->tag === '@phpstan-param';
        });

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
     * @return array<int, WordPressTag>
     */
    private function getInheritedTagsForParam(Param $param): array
    {
        $type = $param->getType();

        if ($type === null) {
            return [];
        }

        $typeName = self::getTypeNameFromType($type);

        if ($typeName === null) {
            return [];
        }

        $paramDescription = $param->getDescription();

        if ($paramDescription === null) {
            return [];
        }

        list($description) = explode("\n\n", $paramDescription->__toString());

        if (strpos($description, '()') === false) {
            return [];
        }

        $description = str_replace("\n", ' ', $description);
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

            if ($match !== null) {
                $additions[] = $match;
            }
        }

        return $additions;
    }

    /**
     * @param array<int, WordPressTag> $tags
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
        $matchingTags = array_filter($tags, static function(WordPressTag $tag) use ($matchNames): bool {
            return in_array($tag->name, $matchNames, true);
        });

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
     * @return string[]
     */
    private function getAdditionalTagsFromMap(string $symbolName): array
    {
        if (! isset($this->functionMap)) {
            $this->functionMap = require __DIR__ . '/functionMap.php';
        }

        if (! isset($this->functionMap[$symbolName])) {
            return [];
        }

        $parameters = $this->functionMap[$symbolName];
        $returnType = array_shift($parameters);
        $additions = [];

        foreach ($parameters as $paramName => $paramType) {
            if (strpos($paramName, '@') === 0) {
                $additions[] = sprintf(
                    '%s %s',
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

        $additions[] = sprintf(
            '@phpstan-return %s',
            $returnType
        );

        return $additions;
    }

    private function addStringTags(string $name, Doc $docComment): ?Doc
    {
        if ( !isset($this->additionalTagStrings[ $name ])) {
            return null;
        }

        $additions = $this->additionalTagStrings[ $name ];

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
        if (!$tagDescription || !$tagVariableName || !$tagVariableType) {
            return null;
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
        if (!$tagDescription || !$tagVariableType) {
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
        if (!$tagDescription || !$tagVariableType) {
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

    private static function getTypeNameFromType(Type $tagVariableType): ?string
    {
        return self::getTypeNameFromString($tagVariableType->__toString());
    }

    private static function getTypeNameFromString(string $tagVariable): ?string
    {
        // PHPStan dosn't support typed array shapes (`int[]{...}`) so replace
        // typed arrays such as `int[]` with `array`.
        $tagVariableType = preg_replace('#[a-zA-Z0-9_]+\[\]#', 'array', $tagVariable);

        if ($tagVariableType === null) {
            return null;
        }

        if (strpos($tagVariableType, 'array') === false) {
            // Skip if we have hash notation that's not for an array (ie. for `object`).
            return null;
        }

        if (strpos($tagVariableType, 'array|') !== false) {
            // Move `array` to the end of union types so the appended array shape works.
            $tagVariableType = str_replace('array|', '', $tagVariableType) . '|array';
        }

        return $tagVariableType;
    }

    /**
     * @return WordPressArg[]
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
     * @return WordPressArg[]
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

            list($type, $name) = $parts;

            $optionalArg = $optional;
            $nameTrimmed = ltrim($name, '$');

            if (is_numeric($nameTrimmed)) {
                $optionalArg = false;
            } elseif ($optional && ($level > 1)) {
                $optionalArg = isset($parts[2]) && self::isOptional($parts[2]);
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
            || (stripos($description, 'Defaults to ') !== false)
        ;
    }
};
