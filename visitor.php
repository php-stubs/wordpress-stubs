<?php

declare(strict_types = 1);

use phpDocumentor\Reflection\DocBlock\Tags\Param;
use PhpParser\Comment\Doc;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use StubsGenerator\NodeVisitor;

return new class extends NodeVisitor {

    private \phpDocumentor\Reflection\DocBlockFactory $docBlockFactory;

    public function __construct()
    {
        $this->docBlockFactory = \phpDocumentor\Reflection\DocBlockFactory::createInstance();
    }

    public function enterNode(Node $node)
    {
        parent::enterNode($node);

        if (!($node instanceof Function_) && !($node instanceof ClassMethod)) {
            return;
        }

        $docComment = $node->getDocComment();

        if (!($docComment instanceof Doc)) {
            return;
        }

        $newDocComment = $this->addArrayHashNotation($docComment);

        if ($newDocComment !== null) {
            $node->setDocComment($newDocComment);
        }
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

        if (!$params) {
            return null;
        }

        $additions = [];

        foreach ($params as $param) {
            $addition = $this->getAdditionFromParam($param);

            if ($addition !== null) {
                $additions[] = $addition;
            }
        }

        if (!$additions) {
            return null;
        }

        $newDocComment = sprintf(
            "%s\n%s\n */",
            substr($docCommentText, 0, -4),
            implode("\n", $additions)
        );

        return new Doc($newDocComment, $docComment->getLine(), $docComment->getFilePos());
    }

    private function getAdditionFromParam(Param $tag): ?string
    {
        $tagDescription = $tag->getDescription()->__toString();
        $tagVariableName = $tag->getVariableName();
        $tagVariableType = $tag->getType();

        // Skip if the parameter variable name or type are missing.
        if (!$tagVariableName || !$tagVariableType) {
            return null;
        }

        // Skip if the description doesn't contain at least one correctly
        // formatted `@type`, which indicates an array hash.
        if (strpos($tagDescription, '    @type') === false) {
            return null;
        }

        // Populate `$types` with the value of each top level `@type`.
        $types = preg_split('/\R+    @type /', $tagDescription);
        unset($types[0]);
        $elements = [];

        // PHPStan dosn't support typed array shapes (`int[]{...}`) so replace
        // typed arrays such as `int[]` with `array`.
        $tagVariableType = preg_replace('#[a-zA-Z0-9_]+\[\]#', 'array', $tagVariableType->__toString());

        if (strpos($tagVariableType, 'array') === false) {
            // Skip if we have hash notation that's not for an array (ie. for `object`).
            return null;
        }

        if (strpos($tagVariableType, 'array|') !== false) {
            // Move `array` to the end of union types so the appended array shape works.
            $tagVariableType = str_replace('array|', '', $tagVariableType) . '|array';
        }

        foreach ($types as $typeTag) {
            list($type, $name) = preg_split('#\s+#', trim($typeTag));

            // Bail out completely if any element doesn't have a static key.
            if (strpos($name, '...$') !== false) {
                return null;
            }

            // Bail out completely if the name of any element is invalid.
            if (strpos($name, '$') !== 0) {
                return null;
            }

            $elements[] = substr($name, 1) . '?: ' . $type;
        }

        return sprintf(
            " * @phpstan-param %1\$s{\n *   %2\$s,\n * } $%3\$s",
            str_replace(['|string', 'string|'], '', $tagVariableType),
            implode(",\n *   ", $elements),
            $tagVariableName
        );
    }
};
