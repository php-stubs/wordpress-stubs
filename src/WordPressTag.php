<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core;

final class WordPressTag extends \PhpStubs\WordPress\Core\WithChildrenAbstract
{
    /** @var string */
    public $tag;

    /** @var string */
    public $type;

    /** @var ?string */
    public $name = null;

    /** @var ?string */
    public $description = null;

    public function __construct(string $tag = '', string $type = '', ?string $name = null, ?string $description = null)
    {
        $this->tag = $tag;
        $this->type = $type;
        $this->name = $name;
        $this->description = $description;
    }

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
                    ($this->name !== null) ? sprintf(' $%s', $this->name) : ''
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

        $name = ($this->name !== null) ? sprintf(' $%s', $this->name) : '';

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
            $description = sprintf(' %s', $this->description);
        }

        $strings[] = $this->isArrayShape()
            ? sprintf('}%s%s', $name, $description)
            : sprintf('}>%s%s', $name, $description);

        return $strings;
    }
}
