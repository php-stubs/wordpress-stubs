<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

class ParameterTypeTest extends IntegrationTest
{
    public function testGetListTable(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/_get-list-table.php',
            [
                ['Parameter #2 $args of function _get_list_table expects array{screen?: string}, array{screen: 123} given.', 10],
                ['Parameter #2 $args of function _get_list_table expects array{screen?: string}, array{screen: int} given.', 11],
            ]
        );
    }

    public function testAbsint(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/absint.php',
            [
                ['Parameter #1 $maybeint of function absint expects array|bool|float|int|resource|string|null, object given.', 15],
                ['Parameter #1 $maybeint of function absint expects array|bool|float|int|resource|string|null, stdClass given.', 16],
            ]
        );
    }

    public function testAddFeed(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/add-feed.php',
            [
                ["Parameter #2 \$callback of function add_feed expects callable(bool, string): void, '' given.", 19],
                ['Parameter #2 $callback of function add_feed expects callable(bool, string): void, Closure(int): void given.', 20],
                ['Parameter #2 $callback of function add_feed expects callable(bool, string): void, Closure(bool, int): void given.', 21],
                ['Parameter #2 $callback of function add_feed expects callable(bool, string): void, Closure(bool, string): int given.', 22],
                ["Parameter #2 \$callback of function add_feed expects callable(bool, string): void, 'addFeedNotOkFirst' given.", 23],
                ["Parameter #2 \$callback of function add_feed expects callable(bool, string): void, 'addFeedNotOkSecond' given.", 24],
                ["Parameter #2 \$callback of function add_feed expects callable(bool, string): void, 'addFeedNotOkReturn' given.", 25],
            ]
        );
    }

    public function testAddMenuPage(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/add-menu-page.php',
            [
                ["Parameter #5 \$callback of function add_menu_page expects ''|(callable(): mixed), 'notACallable' given.", 21],
                ["Parameter #6 \$callback of function add_submenu_page expects ''|(callable(): mixed), 'notACallable' given.", 25],
                ["Parameter #5 \$callback of function add_links_page expects ''|(callable(): mixed), 'notACallable' given.", 29],
                ["Parameter #5 \$callback of function add_media_page expects ''|(callable(): mixed), 'notACallable' given.", 33],
                ["Parameter #5 \$callback of function add_pages_page expects ''|(callable(): mixed), 'notACallable' given.", 37],
                ["Parameter #5 \$callback of function add_posts_page expects ''|(callable(): mixed), 'notACallable' given.", 41],
                ["Parameter #5 \$callback of function add_theme_page expects ''|(callable(): mixed), 'notACallable' given.", 45],
                ["Parameter #5 \$callback of function add_users_page expects ''|(callable(): mixed), 'notACallable' given.", 49],
                ["Parameter #5 \$callback of function add_options_page expects ''|(callable(): mixed), 'notACallable' given.", 53],
                ["Parameter #5 \$callback of function add_plugins_page expects ''|(callable(): mixed), 'notACallable' given.", 57],
                ["Parameter #5 \$callback of function add_comments_page expects ''|(callable(): mixed), 'notACallable' given.", 61],
                ["Parameter #5 \$callback of function add_dashboard_page expects ''|(callable(): mixed), 'notACallable' given.", 65],
                ["Parameter #5 \$callback of function add_management_page expects ''|(callable(): mixed), 'notACallable' given.", 69],
            ]
        );
    }

    public function testAddShortcode(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/add-shortcode.php',
            [
                ['Parameter #1 $tag of function add_shortcode expects non-empty-string, 1 given.', 10],
                ["Parameter #1 \$tag of function add_shortcode expects non-empty-string, '' given.", 11],
                ['Parameter #1 $tag of function add_shortcode expects non-empty-string, string given.', 14],
                ['Parameter #2 $callback of function add_shortcode expects callable(array<string>, string|null, string): string, Closure(): void given.', 17],
                ['Parameter #2 $callback of function add_shortcode expects callable(array<string>, string|null, string): string, Closure(string): string given.', 18],
                ['Parameter #2 $callback of function add_shortcode expects callable(array<string>, string|null, string): string, Closure(array, string): string given.', 19],
                ['Parameter #2 $callback of function add_shortcode expects callable(array<string>, string|null, string): string, Closure(array, string|null, bool): string given.', 20],
                ["Parameter #2 \$callback of function add_shortcode expects callable(array<string>, string|null, string): string, 'addShortcodeVoid' given.", 21],
                ["Parameter #2 \$callback of function add_shortcode expects callable(array<string>, string|null, string): string, 'addShortcodeIntDoc' given.", 22],

            ]
        );
    }

    public function testAntispambot(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/antispambot.php',
            [
                ['Parameter #2 $hex_encoding of function antispambot expects 0|1, 42 given.', 12],
                ['Parameter #2 $hex_encoding of function antispambot expects 0|1, -42 given.', 13],
                ['Parameter #2 $hex_encoding of function antispambot expects 0|1, string given.', 14],
                // Maybes
                ['Parameter #2 $hex_encoding of function antispambot expects 0|1, int given.', 17],
            ]
        );
    }

    public function testApplyFilters(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/apply-filters.php',
            [
                ["Parameter #1 \$hook_name of function apply_filters expects non-empty-string, '' given.", 8],
                ["Parameter #1 \$hook_name of function apply_filters_ref_array expects non-empty-string, '' given.", 9],
                ["Parameter #1 \$hook_name of function apply_filters_deprecated expects non-empty-string, '' given.", 10],
                ['Parameter #1 $hook_name of function apply_filters expects non-empty-string, string given.', 13],
                ['Parameter #1 $hook_name of function apply_filters_ref_array expects non-empty-string, string given.', 14],
                ['Parameter #1 $hook_name of function apply_filters_deprecated expects non-empty-string, string given.', 15],
            ]
        );
    }

    public function testBookmarks(): void
    {
        $field = "'link_category'|'link_description'|'link_id'|'link_image'|'link_name'|'link_notes'|'link_owner'|'link_rating'|'link_rel'|'link_rss'|'link_target'|'link_updated'|'link_url'|'link_visible'";

        $this->analyse(
            __DIR__ . '/data/param/bookmark.php',
            [
                ["Parameter #1 \$field of function get_bookmark_field expects $field, 'foo' given.", 16],
                ["Parameter #1 \$field of function get_bookmark_field expects $field, 'foo' given.", 17],
                ["Parameter #1 \$field of function get_bookmark_field expects $field, int given.", 18],
                ["Parameter #1 \$field of function sanitize_bookmark_field expects $field, 'foo' given.", 21],
                ["Parameter #1 \$field of function sanitize_bookmark_field expects $field, int given.", 22],
                // Maybes
                ["Parameter #1 \$field of function get_bookmark_field expects $field, string given.", 30],
                ["Parameter #1 \$field of function sanitize_bookmark_field expects $field, string given.", 32],
            ]
        );
    }

    public function testCheckAdminReferer(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/check-admin-referer.php',
            [
                ['Parameter #1 $action of function check_admin_referer expects string, int given.', 10],
                ['Parameter #1 $action of function check_admin_referer expects string, int given.', 11],
            ]
        );
    }

    public function testCheckAjaxReferer(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/check-ajax-referer.php',
            [
                ['Parameter #1 $action of function check_ajax_referer expects string, int given.', 10],
                ['Parameter #1 $action of function check_ajax_referer expects string, int given.', 11],
            ]
        );
    }

    public function testCustomBackground(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/custom-background.php',
            [
                ["Parameter #2 \$admin_image_div_callback of class Custom_Background constructor expects ''|(callable(): void), Closure(int): int given.", 20],
            ]
        );
    }

    public function testCustomImageHeader(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/custom-image-header.php',
            [
                ["Parameter #2 \$admin_image_div_callback of class Custom_Image_Header constructor expects ''|(callable(): void), Closure(int): int given.", 20],
            ]
        );
    }

    public function testDoAction(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/do-action.php',
            [
                ["Parameter #1 \$hook_name of function do_action expects non-empty-string, '' given.", 8],
                ["Parameter #1 \$hook_name of function do_action_ref_array expects non-empty-string, '' given.", 9],
                ["Parameter #1 \$hook_name of function do_action_deprecated expects non-empty-string, '' given.", 10],
                ['Parameter #1 $hook_name of function do_action expects non-empty-string, string given.', 13],
                ['Parameter #1 $hook_name of function do_action_ref_array expects non-empty-string, string given.', 14],
                ['Parameter #1 $hook_name of function do_action_deprecated expects non-empty-string, string given.', 15],
            ]
        );
    }

    public function testMaybeSerialize(): void
    {
        $this->analyse(__DIR__ . '/data/param/maybe-serialize.php', []);
    }

    public function testRegisterActivationHook(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/register-activation-hook.php',
            [
                ['Parameter #2 $callback of function register_activation_hook expects callable(bool): void, Closure(string): void given.', 10],
                ['Parameter #2 $callback of function register_activation_hook expects callable(bool): void, Closure(bool): int given.', 11],
            ]
        );
    }

    public function testRegisterDeactivationHook(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/register-deactivation-hook.php',
            [
                ['Parameter #2 $callback of function register_deactivation_hook expects callable(bool): void, Closure(string): void given.', 10],
                ['Parameter #2 $callback of function register_deactivation_hook expects callable(bool): void, Closure(bool): int given.', 11],
            ]
        );
    }

    public function testRegisterNavMenus(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/register-nav-menus.php',
            [
                ['Parameter #1 $locations of function register_nav_menus expects array<string, string>, string given.', 10],
                ['Parameter #1 $locations of function register_nav_menus expects array<string, string>, array<int, string> given.', 11],
                ['Parameter #1 $locations of function register_nav_menus expects array<string, string>, array<int, string> given.', 12],
                ['Parameter #1 $locations of function register_nav_menus expects array<string, string>, array<int|string, string> given.', 13],
            ]
        );
    }

    public function testRegisterPostType(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/register-post-type.php',
            [
                ["Parameter #1 \$post_type of function register_post_type expects lowercase-string&non-empty-string, '' given.", 13],
                ["Parameter #1 \$post_type of function register_post_type expects lowercase-string&non-empty-string, 'PostType' given.", 14],
                // Maybes
                ['Parameter #1 $post_type of function register_post_type expects lowercase-string&non-empty-string, non-empty-string given.', 17],
                ['Parameter #1 $post_type of function register_post_type expects lowercase-string&non-empty-string, non-falsy-string given.', 18],
                ['Parameter #1 $post_type of function register_post_type expects lowercase-string&non-empty-string, lowercase-string given.', 19],
                ['Parameter #1 $post_type of function register_post_type expects lowercase-string&non-empty-string, string given.', 20],
            ]
        );
    }

    public function testRegisterRestRoute(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/register-rest-route.php',
            [
                ["Parameter #1 \$route_namespace of function register_rest_route expects non-falsy-string, '' given.", 10],
                ["Parameter #1 \$route_namespace of function register_rest_route expects non-falsy-string, '0' given.", 11],
                ["Parameter #2 \$route of function register_rest_route expects non-falsy-string, '' given.", 14],
                ["Parameter #2 \$route of function register_rest_route expects non-falsy-string, '0' given.", 15],
                // Maybes
                ['Parameter #1 $route_namespace of function register_rest_route expects non-falsy-string, string given.', 18],
                ['Parameter #2 $route of function register_rest_route expects non-falsy-string, string given.', 19],
            ]
        );
    }

    public function testRegisterUninstallHook(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/register-uninstall-hook.php',
            [
                ['Parameter #2 $callback of function register_uninstall_hook expects callable(): void, Closure(bool): void given.', 10],
                ['Parameter #2 $callback of function register_uninstall_hook expects callable(): void, Closure(): int given.', 11],
            ]
        );
    }

    public function testRegisterWidget(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/register-widget.php',
            [
                ['Parameter #1 $widget of function register_widget expects class-string<WP_Widget>|WP_Widget, PhpStubs\WordPress\Core\Tests\NoWidget given.', 21],
                ['Parameter #1 $widget of function register_widget expects class-string<WP_Widget>|WP_Widget, PhpStubs\WordPress\Core\Tests\NoWidget given.', 22],
                ['Parameter #1 $widget of function register_widget expects class-string<WP_Widget>|WP_Widget, string given.', 23],
                ['Parameter #1 $widget of function register_widget expects class-string<WP_Widget>|WP_Widget, string given.', 24],
            ]
        );
    }

    public function testWpdbGetRow(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/wpdb.php',
            [
                ["Parameter #2 \$output of method wpdb::get_row() expects 'ARRAY_A'|'ARRAY_N'|'OBJECT', 'OBJECT_K' given.", 25],
                ["Parameter #2 \$output of method wpdb::get_row() expects 'ARRAY_A'|'ARRAY_N'|'OBJECT', string given.", 26],
                ["Parameter #2 \$output of method wpdb::get_row() expects 'ARRAY_A'|'ARRAY_N'|'OBJECT', int given.", 27],
                ['Parameter #3 $y of method wpdb::get_row() expects int<0, max>, -1 given.', 28],
                ['Parameter #3 $y of method wpdb::get_row() expects int<0, max>, int given.', 29],
            ]
        );
    }

    public function testWpRegisterAbility(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/wp-register-ability.php',
            [
                ["Parameter #1 \$name of function wp_register_ability expects lowercase-string&non-falsy-string, '' given.", 10],
                ["Parameter #1 \$name of function wp_register_ability expects lowercase-string&non-falsy-string, '0' given.", 11],
                ["Parameter #1 \$name of function wp_register_ability expects lowercase-string&non-falsy-string, 'Name' given.", 12],
                ['Parameter #1 $name of function wp_register_ability expects lowercase-string&non-falsy-string, non-empty-string given.', 13],
                ['Parameter #1 $name of function wp_register_ability expects lowercase-string&non-falsy-string, lowercase-string&non-empty-string given.', 14],
                // Maybes
                ['Parameter #1 $name of function wp_register_ability expects lowercase-string&non-falsy-string, string given.', 17],
            ]
        );
    }

    public function testWpRobots(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/wp-robots.php',
            [
                ['Parameter #1 $robots of function wp_robots_max_image_preview_large expects array<string, bool|string>, array<string, int> given.', 16],
                ['Parameter #1 $robots of function wp_robots_no_robots expects array<string, bool|string>, array<string, int> given.', 17],
                ['Parameter #1 $robots of function wp_robots_noindex expects array<string, bool|string>, array<string, int> given.', 18],
                ['Parameter #1 $robots of function wp_robots_noindex_embeds expects array<string, bool|string>, array<string, int> given.', 19],
                ['Parameter #1 $robots of function wp_robots_noindex_search expects array<string, bool|string>, array<string, int> given.', 20],
                ['Parameter #1 $robots of function wp_robots_sensitive_page expects array<string, bool|string>, array<string, int> given.', 21],
            ]
        );
    }

    public function testWpTriggerError(): void
    {
        $this->analyse(
            __DIR__ . '/data/param/wp-trigger-error.php',
            [
                ['Parameter #3 $error_level of function wp_trigger_error expects 256|512|1024|16384, int given.', 19],
                ['Parameter #3 $error_level of function wp_trigger_error expects 256|512|1024|16384, string given.', 20],
                ['Parameter #3 $error_level of function wp_trigger_error expects 256|512|1024|16384, 2 given.', 27],
                ['Parameter #3 $error_level of function wp_trigger_error expects 256|512|1024|16384, 2 given.', 34],
                ['Parameter #3 $error_level of function wp_trigger_error expects 256|512|1024|16384, 0 given.', 35],
            ]
        );
    }
}
