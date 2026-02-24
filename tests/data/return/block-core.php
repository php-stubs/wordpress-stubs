<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function block_core_navigation_link_render_submenu_icon;
use function block_core_navigation_render_submenu_icon;
use function block_core_navigation_submenu_render_submenu_icon;
use function block_core_post_time_to_read_word_count;
use function build_dropdown_script_block_core_categories;
use function render_block_core_archives;
use function render_block_core_categories;
use function render_block_core_latest_comments;
use function render_block_core_latest_posts;
use function render_block_core_loginout;
use function render_block_core_query_total;
use function render_block_core_rss;
use function render_block_core_search;
use function render_block_core_site_logo;
use function render_block_core_widget_group;
use function PHPStan\Testing\assertType;

assertType('non-falsy-string', block_core_navigation_link_render_submenu_icon());
assertType('non-falsy-string', block_core_navigation_render_submenu_icon());
assertType('non-falsy-string', block_core_navigation_submenu_render_submenu_icon());

assertType('int<0, max>', block_core_post_time_to_read_word_count(Faker::string(), Faker::string()));

assertType('non-falsy-string', build_dropdown_script_block_core_categories(Faker::string()));

assertType('non-falsy-string', render_block_core_archives(Faker::array()));
assertType('non-falsy-string', render_block_core_categories(Faker::array(), Faker::string(), Faker::wpBlock()));
assertType('non-falsy-string', render_block_core_latest_comments(Faker::array()));
assertType('non-falsy-string', render_block_core_latest_posts(Faker::array()));
assertType('non-falsy-string', render_block_core_loginout(Faker::array()));
assertType('non-falsy-string', render_block_core_query_total(Faker::array(), Faker::string(), Faker::wpBlock()));
assertType('non-falsy-string', render_block_core_rss(Faker::array()));
assertType('non-falsy-string', render_block_core_search(Faker::array()));
assertType('non-falsy-string', render_block_core_site_logo(Faker::array()));
assertType('non-falsy-string', render_block_core_widget_group(Faker::array(), Faker::string(), Faker::wpBlock()));
