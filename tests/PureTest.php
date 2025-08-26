<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

final class PureTest extends TypeInferenceTest
{
    public function getDataDirectory(): string
    {
        return __DIR__ . '/data/pure';
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/data/pure/forget-possibly-impure-values.neon'];
    }
}
