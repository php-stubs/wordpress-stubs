<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

class TypeInferenceTest extends \PHPStan\Testing\TypeInferenceTestCase
{
    /** @return iterable<mixed> */
    public function dataFileAsserts(): iterable
    {
        yield from $this->gatherAssertTypes(__DIR__ . '/data/current_time.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/echo_parameter.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_attachment_taxonomies.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_comment.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_object_taxonomies.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_post.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_post_stati.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_post_types.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_page_by_path.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_permalink.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_taxonomies.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_taxonomies_for_attachments.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/has_filter.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/is_wp_error.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/mysql2date.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/term_exists.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_error_parameter.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_theme.php');
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
