<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

final class ImpureTest extends TypeInferenceTest
{
    public function getDataDirectory(): string
    {
        return __DIR__ . '/data/impure';
    }
}
