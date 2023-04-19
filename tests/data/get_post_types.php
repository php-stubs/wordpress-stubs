<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_post_types;
use function PHPStan\Testing\assertType;

// Default output
assertType('array<int, string>', get_post_types([]));
assertType('array<int, string>', get_post_types([], 'names'));

// Objects output
assertType('array<int, WP_Post_Type>', get_post_types([], 'objects'));

// Unknown string
assertType('array<int, string|WP_Post_Type>', get_post_types([], (string)$_GET['unknown_string']));

// Unexpected output
assertType('array<int, WP_Post_Type>', get_post_types([], 'Hello'));
