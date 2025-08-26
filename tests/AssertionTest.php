<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

final class AssertionTest extends TypeInferenceTest
{
    /** @return iterable<mixed> */
    public function dataAsserts(): iterable
    {
        yield from $this->gatherAssertTypes(__DIR__ . '/data/assert/has_shortcode.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/assert/is_wp_error.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/assert/taxonomy_exists.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/assert/wp_is_numeric_array.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/assert/wp_is_uuid.php');
    }
}
