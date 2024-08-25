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
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_approved_comments.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_attachment_taxonomies.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_bookmark.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_categories.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_category.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_category_by_path.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_comment.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_object_taxonomies.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_post.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_post_stati.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_post_types.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_posts.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_page_by_path.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_permalink.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_sites.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_tags.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_term_by.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_terms.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_taxonomies.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_term.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_taxonomies_for_attachments.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/has_filter.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/is_wp_error.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/mysql2date.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/rest_ensure_response.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/term_exists.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_debug_backtrace_summary.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_die.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_dropdown_languages.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_error_parameter.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_get_archives.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_get_post_categories.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_get_post_tags.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_get_post_terms.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_get_object_terms.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_is_numeric_array.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_list_bookmarks.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_list_categories.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_list_pages.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_rest_request.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_theme.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wpdb.php');
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
