<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_post;
use function PHPStan\Testing\assertType;

/** @var \WP_Post|int|null $post */
$post = $post;

// Default output
assertType('WP_Post|null', get_post());
assertType('WP_Post|null', get_post($post));
assertType('WP_Post|null', get_post($post, OBJECT));

// Associative array output
assertType('array<string, mixed>|null', get_post($post, ARRAY_A));

// Numeric array output
assertType('array<int, mixed>|null', get_post($post, ARRAY_N));

// Unknown output
assertType('array<int|string, mixed>|WP_Post|null', get_post($post, (string)$_GET['unknown_string']));

// Unexpected output
assertType('WP_Post|null', get_post($post, 'Hello'));
