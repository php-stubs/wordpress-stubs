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
        if (!$this->hasChildren()) {
            return [$this->formatChildless()];
        }

        if ($this->isMixedShape()) {
            return [];
        }

        $level = $this->isArrayShape() ? 1 : 0;
        $childStrings = $this->formatChildren($level);

        if (count($childStrings) === 0) {
            return [];
        }

        if (!$this->isArrayShape() && count($this->children) > 0 && count($this->children[0]->children) === 0) {
            return [sprintf('%s array<int|string, %s>%s', $this->tag, $this->type, $this->formatName())];
        }

        return $this->isArrayShape()
            ? $this->formatArrayShape($childStrings)
            : $this->formatNonArrayShape($childStrings);
    }

    private function formatChildless(): string
    {
        return sprintf(
            '%s %s%s',
            $this->tag,
            $this->type,
            ($this->name !== null) ? sprintf(' $%s', $this->name) : ''
        );
    }

    /**
     * @return list<string>
     */
    private function formatChildren(int $level): array
    {
        $childStrings = [];
        foreach ($this->children as $child) {
            $childStrings = array_merge($childStrings, $child->format($level));
        }
        return $childStrings;
    }

    /**
     * @param list<string> $childStrings
     * @return list<string>
     */
    private function formatArrayShape(array $childStrings): array
    {
        $strings = [sprintf('%s %s{', $this->tag, $this->type)];
        $strings = array_merge($strings, $childStrings);
        $strings[] = sprintf('}%s%s', $this->formatName(), $this->formatDescription());

        return $strings;
    }

    /**
     * @param list<string> $childStrings
     * @return list<string>
     */
    private function formatNonArrayShape(array $childStrings): array
    {
        $strings = [sprintf('%s %s<int|string, array{', $this->tag, $this->type)];
        $strings = array_merge($strings, $childStrings);
        $strings[] = sprintf('}>%s%s', $this->formatName(), $this->formatDescription());

        return $strings;
    }

    private function formatName(): string
    {
        return ($this->name !== null) ? sprintf(' $%s', $this->name) : '';
    }

    private function formatDescription(): string
    {
        return ($this->description !== null) ? sprintf(' %s', $this->description) : '';
    }
}
