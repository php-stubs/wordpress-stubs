<?php

declare(strict_types = 1);

use PhpParser\Comment\Doc;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use StubsGenerator\NodeVisitor;

return new class extends NodeVisitor {

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
        $factory = \phpDocumentor\Reflection\DocBlockFactory::createInstance();

        try {
            $docblock = $factory->create($docCommentText);
        } catch ( RuntimeException $e ) {
            return null;
        } catch ( InvalidArgumentException $e ) {
            return null;
        }

        /** @var phpDocumentor\Reflection\DocBlock\Tags\Param[] */
        $params = $docblock->getTagsByName('param');

        if (!$params) {
            return null;
        }

        $additions = [];

        foreach ($params as $param) {
            $paramDescription = $param->getDescription()->__toString();
            $paramVariableName = $param->getVariableName();
            $paramVariableType = $param->getType();

            if (!$paramVariableName || !$paramVariableType || strpos($paramDescription, '    @type') === false) {
                continue;
            }

            $types = preg_split('/\R+    @type /', $paramDescription);
            unset($types[0]);
            $elements = [];

            foreach ($types as $typeTag) {
                list($type, $name) = preg_split('#\s+#', trim($typeTag));

                if (strpos($name, '...$') !== false) {
                    return null;
                }

                $elements[] = substr($name, 1) . '?: ' . $type;
            }

            $additions[] = sprintf(
                " * @phpstan-param %1\$s{\n *   %2\$s,\n * } $%3\$s",
                str_replace(['|string', 'string|'], '', $paramVariableType->__toString()),
                implode(",\n *   ", $elements),
                $paramVariableName
            );
        }

        if (!$additions) {
            return null;
        }

        $newDocComment = sprintf(
            "%s\n%s\n */",
            substr($docCommentText,0,-4),
            implode("\n", $additions)
        );

        return new Doc($newDocComment, $docComment->getLine(), $docComment->getFilePos());
    }
};