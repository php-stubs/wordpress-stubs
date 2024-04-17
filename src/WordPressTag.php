<?php

declare(strict_types=1);

final class WordPressTag extends WithChildren
{
    /** @var string */
    public $tag;

    /** @var string */
    public $type;

    /** @var ?string */
    public $name = null;

    /** @var ?string */
    public $description = null;

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
            if (count($this->children) <= 0 || count($this->children[0]->children) <= 0) {
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
