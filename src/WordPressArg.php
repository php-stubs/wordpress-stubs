<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core;

final class WordPressArg extends WithChildren
{
    public string $type;

    public bool $optional = false;

    public ?string $name = null;

    /** @return list<string> */
    public function format(int $level = 1): array
    {
        $strings = [];
        $padding = str_repeat(' ', ($level * 2));

        if ($this->isMixedShape()) {
            return [];
        }

        if (count($this->children) === 0) {
            return $this->formatChildless($strings, $padding);
        }

        $childStrings = [];

        foreach ($this->children as $child) {
            $childStrings = array_merge($childStrings, $child->format($level + 1));
        }

        if (count($childStrings) === 0) {
            return [];
        }

        if ($this->isArrayShape()) {
            if ($this->name === null) {
                return array_merge($strings, $childStrings);
            }
            return $this->formatArrayShape($strings, $childStrings, $padding);
        }

        return $this->formatArrayWithoutShape($strings, $childStrings, $padding);
    }

    /**
     * @param list<string> $strings
     * @return list<string>
     */
    private function formatChildless(array $strings, string $padding): array
    {
        $strings[] = $this->formatLine('%s%s%s: %s,', $padding);
        return $strings;
    }

    /**
     * @param list<string> $strings
     * @param list<string> $childStrings
     * @return list<string>
     */
    private function formatArrayShape(array $strings, array $childStrings, string $padding): array
    {
        $strings[] = $this->formatLine('%s%s%s: %s{', $padding);
        $strings = array_merge($strings, $childStrings);
        $strings[] = sprintf('%s},', $padding);
        return $strings;
    }

    /**
     * @param list<string> $strings
     * @param list<string> $childStrings
     * @return list<string>
     */
    private function formatArrayWithoutShape(array $strings, array $childStrings, string $padding): array
    {
        $strings[] = $this->formatLine('%s%s%s: array<array-key, %s{', $padding);
        $strings = array_merge($strings, $childStrings);
        $strings[] = sprintf('%s}>,', $padding);
        return $strings;
    }

    private function formatLine(string $format, string $padding): string
    {
        return sprintf(
            $format,
            $padding,
            $this->name,
            ($this->optional) ? '?' : '',
            $this->type
        );
    }
}
