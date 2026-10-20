<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function sanitize_post_field;
use function PHPStan\Testing\assertType;

$postId = Faker::int();

assertType('int', sanitize_post_field('ID', Faker::mixed(), $postId, 'raw'));
assertType('int', sanitize_post_field('post_parent', Faker::mixed(), $postId, 'raw'));
assertType('int', sanitize_post_field('menu_order', Faker::mixed(), $postId, 'raw'));
assertType('int', sanitize_post_field('ID', Faker::mixed(), $postId, Faker::string()));

assertType('array<int<0, max>>', sanitize_post_field('ancestors', Faker::mixed(), $postId, Faker::string()));

assertType('string', sanitize_post_field('field', Faker::string(), $postId, 'raw'));

assertType('string', sanitize_post_field('field', 'field value', $postId, 'edit'));
assertType('string', sanitize_post_field('field', Faker::string(), $postId, 'edit'));

assertType('string', sanitize_post_field('field', 'field value', $postId, 'attribute'));
assertType('string', sanitize_post_field('field', Faker::string(), $postId, 'attribute'));
assertType('string', sanitize_post_field('field', 'field value', $postId, 'js'));
assertType('string', sanitize_post_field('field', Faker::string(), $postId, 'js'));

assertType('array<int<0, max>>|int|string', sanitize_post_field(Faker::string(), Faker::string(), $postId, 'raw'));

assertType('array<int<0, max>>|int|string', sanitize_post_field(Faker::string(), Faker::string(), $postId, 'attribute'));
assertType('array<int<0, max>>|int|string', sanitize_post_field(Faker::string(), Faker::string(), $postId, 'js'));

assertType('array<int<0, max>>|int|string', sanitize_post_field(Faker::string(), Faker::string(), $postId, 'attribute'));
assertType('array<int<0, max>>|int|string', sanitize_post_field(Faker::string(), Faker::string(), $postId, 'js'));
