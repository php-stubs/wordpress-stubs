<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

final class CallToParametersTest extends IntegrationTest
{
    public function testGetListTable(): void
    {
        $this->analyse(__DIR__ . '/data/_get_list_table_params.php', [
            ["Parameter #2 \$args of function _get_list_table expects array{screen?: string}, array{screen: 123} given.", 10],
            ["Parameter #2 \$args of function _get_list_table expects array{screen?: string}, array{screen: int} given.", 11],
        ]);
    }

    public function testAbsint(): void
    {
        $this->analyse(__DIR__ . '/data/absint_params.php', [
            ["Parameter #1 \$maybeint of function absint expects array|bool|float|int|resource|string|null, object given.", 15],
            ["Parameter #1 \$maybeint of function absint expects array|bool|float|int|resource|string|null, stdClass given.", 16],
        ]);
    }

    public function testAddMenuPage(): void
    {
        $this->analyse(__DIR__ . '/data/add_menu_page_params.php', [
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
        ]);
    }

    public function testWpdbGetRow(): void
    {
        $this->analyse(__DIR__ . '/data/wpdb-params.php', [
            ["Parameter #2 \$output of method wpdb::get_row() expects 'ARRAY_A'|'ARRAY_N'|'OBJECT', 'OBJECT_K' given.", 25],
            ["Parameter #2 \$output of method wpdb::get_row() expects 'ARRAY_A'|'ARRAY_N'|'OBJECT', string given.", 26],
            ["Parameter #2 \$output of method wpdb::get_row() expects 'ARRAY_A'|'ARRAY_N'|'OBJECT', int given.", 27],
            ["Parameter #3 \$y of method wpdb::get_row() expects int<0, max>, -1 given.", 28],
            ["Parameter #3 \$y of method wpdb::get_row() expects int<0, max>, int given.", 29],
        ]);
    }

    public function testWpTriggerError(): void
    {
        $this->analyse(__DIR__ . '/data/wp_trigger_error_params.php', [
            ["Parameter #3 \$error_level of function wp_trigger_error expects 256|512|1024|16384, int given.", 13],
            ["Parameter #3 \$error_level of function wp_trigger_error expects 256|512|1024|16384, string given.", 14],
            ["Parameter #3 \$error_level of function wp_trigger_error expects 256|512|1024|16384, 2 given.", 21],
            ["Parameter #3 \$error_level of function wp_trigger_error expects 256|512|1024|16384, 2 given.", 28],
            ["Parameter #3 \$error_level of function wp_trigger_error expects 256|512|1024|16384, 0 given.", 29],
        ]);
    }
}
