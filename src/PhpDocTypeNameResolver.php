<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core;

use PHPStan\PhpDocParser\Ast\AbstractNodeVisitor;
use PHPStan\PhpDocParser\Ast\ConstExpr\ConstFetchNode;
use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode;
use PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode;
use PHPStan\PhpDocParser\Ast\Type\CallableTypeNode;
use PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\ObjectShapeItemNode;

use function in_array;
use function spl_object_id;
use function sprintf;
use function strncmp;
use function strpos;
use function strtolower;
use function substr;

// phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength

final class PhpDocTypeNameResolver extends AbstractNodeVisitor
{
    private const RESERVED = [
        'int',
        'integer',
        'float',
        'double',
        'string',
        'bool',
        'boolean',
        'true',
        'false',
        'null',
        'void',
        'never',
        'iterable',
        'object',
        'mixed',
        'array',
        'callable',
        'self',
        'static',
        'parent',
        '$this',
    ];

    /** @var array<string, string> */
    private array $aliases;

    /** @var array<int, true> */
    private array $skip = [];

    /** @var array<string, true> */
    private array $templateNames = [];

    /**
     * @param array<string, string> $aliases
     */
    public function __construct(array $aliases)
    {
        $this->aliases = $aliases;
    }

    /**
     * @return null
     */
    public function enterNode(Node $node): ?Node
    {
        if ($node instanceof TemplateTagValueNode) {
            $this->templateNames[strtolower($node->name)] = true;

            return null;
        }

        if (
            ($node instanceof ArrayShapeItemNode || $node instanceof ObjectShapeItemNode)
            && $node->keyName !== null
        ) {
            $this->skip[spl_object_id($node->keyName)] = true;
        }

        if ($node instanceof GenericTypeNode && strtolower($node->type->name) === 'int') {
            foreach ($node->genericTypes as $bound) {
                if (! ($bound instanceof IdentifierTypeNode) || ! in_array(strtolower($bound->name), ['min', 'max'], true)) {
                    continue;
                }

                $this->skip[spl_object_id($bound)] = true;
            }
        }

        if ($node instanceof CallableTypeNode) {
            $this->skip[spl_object_id($node->identifier)] = true;
        }

        if ($node instanceof ConstFetchNode && $node->className !== '') {
            if (! isset($this->skip[spl_object_id($node)])) {
                $resolved = $this->resolveName($node->className);
                if ($resolved !== null) {
                    $node->className = $resolved;
                }
            }

            return null;
        }

        if (! ($node instanceof IdentifierTypeNode)) {
            return null;
        }

        if (isset($this->skip[spl_object_id($node)]) || isset($this->templateNames[strtolower($node->name)])) {
            return null;
        }

        $resolved = $this->resolveName($node->name);
        if ($resolved !== null) {
            $node->name = $resolved;
        }

        return null;
    }

    private function resolveName(string $name): ?string
    {
        if (strncmp($name, '\\', 1) === 0) {
            return null; // already fully qualified
        }

        $separatorPos = strpos($name, '\\');
        $firstSegment = $separatorPos === false ? $name : substr($name, 0, $separatorPos);

        if (in_array(strtolower($firstSegment), self::RESERVED, true)) {
            return null;
        }

        $alias = strtolower($firstSegment);
        if (! isset($this->aliases[$alias])) {
            return null;
        }

        $remainder = $separatorPos === false ? '' : substr($name, $separatorPos);

        return sprintf('%s%s', $this->aliases[$alias], $remainder);
    }
}
