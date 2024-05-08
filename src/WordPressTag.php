<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core;

// phpcs:disable NeutronStandard.Functions.LongFunction.LongFunction

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

        if (! $this->isArrayShape()) {
            $level = 0;
        }

        foreach ($this->children as $child) {
            $childStrings = array_merge($childStrings, $child->format($level));
        }

        if (count($childStrings) === 0) {
            return [];
        }

        $name = $this->name !== null ? " \${$this->name}" : '';

        if ($this->isArrayShape()) {
            $strings[] = sprintf(
                '%s %s{',
                $this->tag,
                $this->type
            );
        } else {
            if (! $this->hasChildren() || ! $this->children[0]->hasChildren()) {
                $strings[] = sprintf(
                    '%s array<int|string, %s>%s',
                    $this->tag,
                    $this->type,
                    $name
                );

                return $strings;
            }

            $strings[] = sprintf(
                '%s %s<int|string, array{',
                $this->tag,
                $this->type
            );
        }

        $strings = array_merge($strings, $childStrings);
        $description = '';

        if ($this->description !== null) {
            $description = " {$this->description}";
        }

        $strings[] = $this->isArrayShape()
            ? sprintf('}%s%s', $name, $description)
            : sprintf('}>%s%s', $name, $description);

        return $strings;
    }
}
