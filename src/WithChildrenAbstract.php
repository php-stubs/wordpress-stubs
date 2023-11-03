<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core;

abstract class WithChildrenAbstract
{
    /** @var list<\PhpStubs\WordPress\Core\WordPressArg> */
    public $children = [];

    public function isArrayShape(): bool
    {
        foreach ($this->children as $child) {
            if ($child->name === null) {
                return false;
            }
        }

        return $this->hasChildren();
    }

    public function isMixedShape(): bool
    {
        $hasStaticKey = false;

        foreach ($this->children as $child) {
            if ($child->name !== null) {
                $hasStaticKey = true;
            } elseif ($hasStaticKey) {
                return true;
            }
        }

        return false;
    }

    public function hasChildren(): bool
    {
        return count($this->children) > 0;
    }
}
