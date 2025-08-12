<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use PHPStan\Testing\TypeInferenceTestCase;

class TypeInferenceTest extends TypeInferenceTestCase
{
    /** @return iterable<mixed> */
    public function dataFileAsserts(): iterable
    {
        yield from $this->gatherAssertTypes(__DIR__ . '/data/__return.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/_get_list_table.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/absint.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/block_version.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/bool_from_yn.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/current_time.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/echo_parameter.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/Faker.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_approved_comments.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_attachment_taxonomies.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_available_post_statuses.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_block_wrapper_attributes.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_bookmark.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_categories.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_category.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_category_by_path.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_comment.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_compat_media_markup.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_current_id.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_object_taxonomies.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_post.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_post_stati.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_post_types.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_posts.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_page_by_path.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_pagination_arrow.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_permalink.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_plugin_page_hookname.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_regex.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_site_screen_help.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_sites.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_tags.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_taxonomies.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_taxonomies_for_attachments.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_term_by.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_terms.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_term.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_user.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/get_user_by.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/has_filter.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/have_posts.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/image_link_input_fields.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/image_size_input_fields.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/is_new_day.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/is_wp_error.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/mysql2date.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/paginate_links.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/prep_atom_text_construct.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/rest_authorization_required_code.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/rest_ensure_response.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/size_format.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/stripslashes.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/term_exists.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/trailingslashit.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/validate_file.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/validate_plugin.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_caption_input_textarea.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_count_terms.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_cron.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_debug_backtrace_summary.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_die.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_dropdown_languages.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_error_parameter.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_extract_urls.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_generate_password.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_generate_tag_cloud.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_generate_uuid4.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_get_archives.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_get_comment_status.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_get_post_categories.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_get_post_tags.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_get_post_terms.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_get_object_terms.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_get_script_tag.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_get_server_protocol.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_get_speculation_rules_configuration.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_hash.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_http_validate_url.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_is_numeric_array.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_is_post_revision.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_is_uuid.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_list_bookmarks.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_list_categories.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_list_pages.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_media_insert_url_form.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_nav_menu_manage_columns.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_parse_list.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_query.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_rest_request.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_tag_cloud.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_theme.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_translations.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_unique_id.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_widget_factory.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_widget_rss.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wp_widgets_access_body_class.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/wpdb.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/zeroise.php');
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
