<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_post_types;
use function PHPStan\Testing\assertType;

$type = new TypeHelper();

// Default output
assertType('array<int, string>', get_post_types($type->array));
assertType('array<int, string>', get_post_types($type->array, 'names'));

// Objects output
assertType('array<int, WP_Post_Type>', get_post_types($type->array, 'objects'));

// Unknown string
assertType('array<int, string|WP_Post_Type>', get_post_types($type->array, $type->string));

// Unexpected output
assertType('array<int, WP_Post_Type>', get_post_types($type->array, 'Hello'));
