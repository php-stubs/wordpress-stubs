<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core;

final class WordPressArg extends \PhpStubs\WordPress\Core\WithChildrenAbstract
{
    /** @var string */
    public $type;

    /** @var bool */
    public $optional = false;

    /** @var ?string */
    public $name = null;

    /** @return list<string> */
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
                    $strings[] = sprintf('%s},', $padding);
                }
            } else {
                $strings[] = sprintf('%s}>,', $padding);
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
