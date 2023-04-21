<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function comment_class;
use function edit_term_link;
use function get_calendar;
use function next_posts;
use function post_type_archive_title;
use function previous_posts;
use function single_cat_title;
use function single_month_title;
use function single_post_title;
use function single_tag_title;
use function single_term_title;
use function the_date;
use function the_modified_date;
use function the_title;
use function wp_loginout;
use function wp_register;
use function wp_title;

use function PHPStan\Testing\assertType;

// Default value of true
assertType('void', comment_class());
assertType('void', edit_term_link());
assertType('void', get_calendar());
assertType('void', next_posts());
assertType('void', post_type_archive_title());
assertType('void', previous_posts());
assertType('void', single_cat_title());
assertType('void|false', single_month_title());
assertType('void', single_post_title());
assertType('void', single_tag_title());
assertType('void', single_term_title());
assertType('void', the_date());
assertType('void', the_modified_date());
assertType('void', the_title());
assertType('void', wp_loginout());
assertType('void', wp_register());
assertType('void', wp_title());

// Explicit value of true
$value = true;
assertType('void', comment_class('', null, null, $value));
assertType('void', edit_term_link('', '', '', null, $value));
assertType('void', get_calendar(true, $value));
assertType('void', next_posts(0, $value));
assertType('void', post_type_archive_title('', $value));
assertType('void', previous_posts($value));
assertType('void', single_cat_title('', $value));
assertType('void|false', single_month_title('', $value));
assertType('void', single_post_title('', $value));
assertType('void', single_tag_title('', $value));
assertType('void', single_term_title('', $value));
assertType('void', the_date('', '', '', $value));
assertType('void', the_modified_date('', '', '', $value));
assertType('void', the_title('', '', $value));
assertType('void', wp_loginout('', $value));
assertType('void', wp_register('', '', $value));
assertType('void', wp_title('', $value));

// Explicit value of false
$value = false;
assertType('string', comment_class('', null, null, $value));
assertType('string|void', edit_term_link('', '', '', null, $value));
assertType('string', get_calendar(true, $value));
assertType('string', next_posts(0, $value));
assertType('string|void', post_type_archive_title('', $value));
assertType('string', previous_posts(false));
assertType('string|void', single_cat_title('', $value));
assertType('string|false', single_month_title('', $value));
assertType('string|void', single_post_title('', $value));
assertType('string|void', single_tag_title('', $value));
assertType('string|void', single_term_title('', $value));
assertType('string', the_date('', '', '', $value));
assertType('string', the_modified_date('', '', '', $value));
assertType('string|void', the_title('', '', $value));
assertType('string', wp_loginout('', $value));
assertType('string', wp_register('', '', $value));
assertType('string', wp_title('', $value));

// Unknown value
$value = isset($_GET['foo']);
assertType('string|void', comment_class('', null, null, $value));
assertType('string|void', edit_term_link('', '', '', null, $value));
assertType('string|void', get_calendar(true, $value));
assertType('string|void', next_posts(0, $value));
assertType('string|void', post_type_archive_title('', $value));
assertType('string|void', previous_posts($value));
assertType('string|void', single_cat_title('', $value));
assertType('string|void|false', single_month_title('', $value));
assertType('string|void', single_post_title('', $value));
assertType('string|void', single_tag_title('', $value));
assertType('string|void', single_term_title('', $value));
assertType('string|void', the_date('', '', '', $value));
assertType('string|void', the_modified_date('', '', '', $value));
assertType('string|void', the_title('', '', $value));
assertType('string|void', wp_loginout('', $value));
assertType('string|void', wp_register('', '', $value));
assertType('string|void', wp_title('', $value));
