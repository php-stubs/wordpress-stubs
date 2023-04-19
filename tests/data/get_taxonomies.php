<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_taxonomies;
use function PHPStan\Testing\assertType;

// Default output
assertType('array<int, string>', get_taxonomies([]));
assertType('array<int, string>', get_taxonomies([], 'names'));

// Objects output
assertType('array<int, WP_Taxonomy>', get_taxonomies([], 'objects'));

// Unexpected output
assertType('array<int, WP_Taxonomy>', get_taxonomies([], 'Hello'));

// Unknown string
assertType('array<int, string|WP_Taxonomy>', get_taxonomies([], (string)$_GET['unknown_string']));
