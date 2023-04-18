<?php

declare(strict_types=1);

namespace WordpressStubs\Tests;

class TypeInferenceTest extends \PHPStan\Testing\TypeInferenceTestCase
{
    /** @return iterable<mixed> */
    public function dataFileAsserts(): iterable
    {
        yield from $this->gatherAssertTypes(__DIR__ . '/data/current_time.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_object_taxonomies.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_taxonomies.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/has_filter.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/mysql2date.php');
    }

    /**
     * @dataProvider dataFileAsserts
     * @param array<string> ...$args
     */
    public function testFileAsserts(string $assertType, string $file, ...$args): void
    {
        $this->assertFileAsserts($assertType, $file, ...$args);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/phpstan.neon'];
    }
}
