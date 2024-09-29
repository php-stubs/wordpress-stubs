<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_posts;
use function PHPStan\Testing\assertType;

assertType('array<int, WP_Post>', get_posts());
assertType('array<int, WP_Post>', get_posts(['key' => 'value']));
assertType('array<int, WP_Post>', get_posts(['fields' => '']));
assertType('array<int, int>', get_posts(['fields' => 'ids']));
assertType('array<int, int>', get_posts(['fields' => 'id=>parent']));
assertType('array<int, WP_Post>', get_posts(['fields' => 'Hello']));

// Nonconstant array
assertType('array<int, int|WP_Post>', get_posts(Faker::array()));

// Unions
$union = Faker::bool() ? ['key' => 'value'] : ['some' => 'thing'];
assertType('array<int, WP_Post>', get_posts($union));

$union = Faker::bool() ? ['key' => 'value'] : ['fields' => 'ids'];
assertType('array<int, int|WP_Post>', get_posts($union));

$union = Faker::bool() ? ['key' => 'value'] : ['fields' => ''];
assertType('array<int, WP_Post>', get_posts($union));

$union = Faker::bool() ? ['key' => 'value'] : ['fields' => 'id=>parent'];
assertType('array<int, int|WP_Post>', get_posts($union));

$union = Faker::bool() ? ['fields' => ''] : ['fields' => 'ids'];
assertType('array<int, int|WP_Post>', get_posts($union));

$union = Faker::bool() ? ['fields' => ''] : ['fields' => 'id=>parent'];
assertType('array<int, int|WP_Post>', get_posts($union));

$union = Faker::bool() ? ['fields' => 'ids'] : ['fields' => 'id=>parent'];
assertType('array<int, int>', get_posts($union));

$union = Faker::bool() ? Faker::array() : ['fields' => ''];
assertType('array<int, int|WP_Post>', get_posts($union));

$union = Faker::bool() ? Faker::array() : ['fields' => 'ids'];
assertType('array<int, int|WP_Post>', get_posts($union));

$union = Faker::bool() ? Faker::array() : ['fields' => 'id=>parent'];
assertType('array<int, int|WP_Post>', get_posts($union));

$union = Faker::bool() ? Faker::string() : '';
assertType('array<int, int|WP_Post>', get_posts(['fields' => $union]));

$union = Faker::bool() ? Faker::string() : 'ids';
assertType('array<int, int|WP_Post>', get_posts(['fields' => $union]));

$union = Faker::bool() ? Faker::string() : 'id=>parent';
assertType('array<int, int|WP_Post>', get_posts(['fields' => $union]));

$union = Faker::bool() ? Faker::string() : 'fields';
assertType('array<int, WP_Post>', get_posts([$union => '']));

$union = Faker::bool() ? Faker::string() : 'fields';
assertType('array<int, int|WP_Post>', get_posts([$union => 'ids']));

$union = Faker::bool() ? Faker::string() : 'fields';
assertType('array<int, int|WP_Post>', get_posts([$union => 'id=>parent']));
