<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_post_types;
use function PHPStan\Testing\assertType;

// Default output
assertType('array<string, string>', get_post_types([]));
assertType('array<string, string>', get_post_types([], 'names'));

// Objects output
assertType('array<string, WP_Post_Type>', get_post_types([], 'objects'));

// Unknown string
assertType('array<string, string|WP_Post_Type>', get_post_types([], (string)$_GET['unknown_string']));

// Unexpected output
assertType('array<string, WP_Post_Type>', get_post_types([], 'Hello'));
