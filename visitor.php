<?php

declare(strict_types = 1);

use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\Tags\Param;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use phpDocumentor\Reflection\Type;
use PhpParser\Comment\Doc;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
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

        if ($this->isArrayShape()) {
            $strings[] = sprintf(
                '}%s',
                $name
            );
        } else {
            $strings[] = sprintf(
                '}>%s',
                $name
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
     * @var string
     */
    private $currentSymbolName;

    public function __construct()
    {
        $this->docBlockFactory = \phpDocumentor\Reflection\DocBlockFactory::createInstance();
    }

    public function enterNode(Node $node)
    {
        parent::enterNode($node);

        if (!($node instanceof Function_) && !($node instanceof ClassMethod)) {
            return null;
        }

        $docComment = $node->getDocComment();

        if (!($docComment instanceof Doc)) {
            return null;
        }

        $this->currentSymbolName = $node->name->name;

        if ($node instanceof ClassMethod) {
            /** @var \PhpParser\Node\Stmt\Class_ $parent */
            $parent = $this->stack[count($this->stack) - 2];

            if (isset($parent->name)) {
                $this->currentSymbolName = sprintf(
                    '%1$s::%2$s',
                    $parent->name->name,
                    $node->name->name
                );
            }
        }

        $newDocComment = $this->addArrayHashNotation($docComment);

        if ($newDocComment !== null) {
            $node->setDocComment($newDocComment);
        }

        $docComment = $node->getDocComment();

        if (!($docComment instanceof Doc)) {
            return null;
        }

        $newDocComment = $this->addAdditionalParams($docComment);

        if ($newDocComment !== null) {
            $node->setDocComment($newDocComment);
        }

        return null;
    }

    private function addArrayHashNotation(Doc $docComment): ?Doc
    {
        $docCommentText = $docComment->getText();

        try {
            $docblock = $this->docBlockFactory->create($docCommentText);
        } catch ( \RuntimeException $e ) {
            return null;
        } catch ( \InvalidArgumentException $e ) {
            return null;
        }

        /** @var \phpDocumentor\Reflection\DocBlock\Tags\Param[] */
        $params = $docblock->getTagsByName('param');

        /** @var \phpDocumentor\Reflection\DocBlock\Tags\Return_[] */
        $returns = $docblock->getTagsByName('return');

        if (!$params && !$returns) {
            return null;
        }

        /** @var WordPressTag[] $additions */
        $additions = [];

        foreach ($params as $param) {
            if (! $param instanceof Param) {
                continue;
            }

            $addition = $this->getAdditionFromParam($param);

            if ($addition !== null) {
                $additions[] = $addition;
            }
        }

        if ($returns !== [] && $returns[0] instanceof Return_) {
            $addition = $this->getAdditionFromReturn($returns[0]);

            if ($addition !== null) {
                $additions[] = $addition;
            }
        }

        if (!$additions) {
            return null;
        }

        $additions = array_map( function(WordPressTag $param): string {
            $lines = $param->format();

            if (count($lines) === 0) {
                return '';
            }

            return " * " . implode("\n * ", $lines);
        }, $additions);

        $additions = array_filter($additions);

        if (count($additions) === 0) {
            return null;
        }

        $newDocComment = sprintf(
            "%s\n%s\n */",
            substr($docCommentText, 0, -4),
            implode("\n", $additions)
        );

        return new Doc($newDocComment, $docComment->getLine(), $docComment->getFilePos());
    }

    private function addAdditionalParams(Doc $docComment): ?Doc
    {
        if (! isset($this->functionMap)) {
            $this->functionMap = require __DIR__ . '/functionMap.php';
        }

        if (! isset($this->functionMap[$this->currentSymbolName])) {
            return null;
        }

        $parameters = $this->functionMap[$this->currentSymbolName];
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

        $docCommentText = $docComment->getText();
        $newDocComment = sprintf(
            "%s\n * %s\n */",
            substr($docCommentText, 0, -4),
            implode("\n * ", $additions)
        );

        return new Doc($newDocComment, $docComment->getLine(), $docComment->getFilePos());
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

        $elements = $this->getElementsFromDescription($tagDescription, true);

        if (count($elements) === 0) {
            return null;
        }

        $tagVariableType = $this->getTypeNameFromType($tagVariableType);

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

        $elements = $this->getElementsFromDescription($tagDescription, false);

        if (count($elements) === 0) {
            return null;
        }

        $tagVariableType = $this->getTypeNameFromType($tagVariableType);

        if ($tagVariableType === null) {
            return null;
        }

        $tag = new WordPressTag();
        $tag->tag = '@phpstan-return';
        $tag->type = $tagVariableType;
        $tag->children = $elements;

        return $tag;
    }

    private function getTypeNameFromType(Type $tagVariableType): ?string
    {
        return $this->getTypeNameFromString($tagVariableType->__toString());
    }

    private function getTypeNameFromString(string $tagVariable): ?string
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
    private function getElementsFromDescription(Description $tagDescription, bool $optional): array
    {
        $text = $tagDescription->__toString();

        // Skip if the description doesn't contain at least one correctly
        // formatted `@type`, which indicates an array hash.
        if (strpos($text, '    @type ') === false) {
            return [];
        }

        return $this->getTypesAtLevel($text, $optional, 1);
    }

    /**
     * @return WordPressArg[]
     */
    private function getTypesAtLevel(string $text, bool $optional, int $level): array
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
                $optionalArg = (isset($parts[2]) && stripos($parts[2], 'optional') !== false);
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
            $subTypes = $this->getTypesAtLevel($typeTag, $optional, $nextLevel);

            if (count($subTypes) > 0) {
                $type = $this->getTypeNameFromString($type);

                if ($type !== null) {
                    $arg->type = $type;
                }
                $arg->children = $subTypes;
            }

            $elements[] = $arg;
        }

        return $elements;
    }
};
