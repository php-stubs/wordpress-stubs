<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core;

// phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength

final class WordPressTag extends WithChildren
{
    public string $tag;

    public string $type;

    public ?string $name = null;

    public ?string $description = null;

    /**
     * @return list<string>
     */
    public function format(): array
    {
        if (! $this->hasChildren()) {
            return [
                sprintf(
                    '%s %s%s',
                    $this->tag,
                    $this->type,
                    $this->name !== null ? " \${$this->name}" : ''
                ),
            ];
        }

        if ($this->isMixedShape()) {
            return [];
        }

        $strings = [];
        $childStrings = [];
        $level = 1;
        $children = $this->children;
        $listDepth = 0;

        if (! $this->isArrayShape()) {
            $level = 0;
            $children = self::getListElementChildren($this, $listDepth);
        }

        $listOpen = str_repeat('array<array-key, ', $listDepth);
        $listClose = str_repeat('>', $listDepth);

        foreach ($children as $child) {
            $childStrings = array_merge($childStrings, $child->format($level));
        }

        if (count($childStrings) === 0) {
            return [];
        }

        $name = $this->name !== null ? " \${$this->name}" : '';

        if ($this->isArrayShape()) {
            // PHPStan doesn't support shapes of generic arrays (`array<K, V>{...}`), so turn
            // `array<K, V>` into an unsealed shape whose other elements are typed `K => V`.
            $type = $this->type;

            if (preg_match('#^(?<union>(?:.*\|)?)array(?<generic><(?:[^<>]++|(?&generic))*>)$#s', $type, $matches) === 1) {
                $type = "{$matches['union']}array";
                $childStrings[] = sprintf('  ...%s,', $matches['generic']);
            }

            $strings[] = sprintf(
                '%s %s{',
                $this->tag,
                $type
            );
        } else {
            if (! $children[0]->hasChildren()) {
                $strings[] = sprintf(
                    '%s array<int|string, %s%s%s>%s',
                    $this->tag,
                    $listOpen,
                    $listDepth === 0 ? $this->type : $children[0]->type,
                    $listClose,
                    $name
                );

                return $strings;
            }

            $strings[] = sprintf(
                '%s %s<int|string, %sarray{',
                $this->tag,
                $this->type,
                $listOpen
            );
        }

        $strings = array_merge($strings, $childStrings);
        $description = '';

        if ($this->description !== null) {
            $description = " {$this->description}";
        }

        $strings[] = $this->isArrayShape()
            ? sprintf('}%s%s', $name, $description)
            : sprintf('}%s>%s%s', $listClose, $name, $description);

        return $strings;
    }

    /**
     * Unwraps lists of lists (`@type array ...$0 {` nested in `@type array ...$0 {`),
     * counting the unwrapped lists in `$depth`.
     *
     * @return list<\PhpStubs\WordPress\Core\WordPressArg>
     */
    private static function getListElementChildren(WithChildren $node, int &$depth): array
    {
        $children = $node->children;

        if (count($children) !== 1 || $children[0]->name !== null || ! $children[0]->hasChildren() || $children[0]->isArrayShape() || $children[0]->isMixedShape()) {
            return $children;
        }

        $depth += 1;

        return self::getListElementChildren($children[0], $depth);
    }

    /**
     * Splits a type into the members of its top-level union, keeping the unions
     * nested in generics, shapes and callables together.
     *
     * @return list<string>|null
     */
    public static function getUnionMembers(string $type): ?array
    {
        $member = '(?:[^|<>{}()\'"]++|\'[^\']*\'|"[^"]*"|(?<bracket>[<{(](?:[^<>{}()\'"]++|\'[^\']*\'|"[^"]*"|(?&bracket))*[>})]))++';

        if (preg_match_all("#{$member}#", $type, $matches) === false) {
            return null;
        }

        return array_values(
            array_filter(
                array_map('trim', $matches[0]),
                static function (string $member): bool {
                    return $member !== '';
                }
            )
        );
    }
}
