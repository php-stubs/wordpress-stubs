<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use PHPStan\Testing\TypeInferenceTestCase;

abstract class TypeInferenceTest extends TypeInferenceTestCase
{
    /** @return iterable<mixed> */
    abstract public function dataAsserts(): iterable;

    /**
     * @dataProvider dataAsserts
     * @param mixed ...$args
     */
    public function testAsserts(string $assertType, string $file, ...$args): void
    {
        $this->assertFileAsserts($assertType, $file, ...$args);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/phpstan.neon'];
    }
}
