<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_taxonomies;
use function PHPStan\Testing\assertType;

$type = new TypeHelper();

// Default output
assertType('array<int, string>', get_taxonomies($type->array));
assertType('array<int, string>', get_taxonomies($type->array, 'names'));

// Objects output
assertType('array<int, WP_Taxonomy>', get_taxonomies($type->array, 'objects'));

// Unexpected output
assertType('array<int, WP_Taxonomy>', get_taxonomies($type->array, 'Hello'));

// Unknown string
assertType('array<int, string|WP_Taxonomy>', get_taxonomies($type->array, $type->string));
