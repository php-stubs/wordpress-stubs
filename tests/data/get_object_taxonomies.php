<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_object_taxonomies;
use function PHPStan\Testing\assertType;

$type = new TypeHelper();

// Default output
assertType('array<int, string>', get_object_taxonomies('post'));
assertType('array<int, string>', get_object_taxonomies('post', 'names'));

// Objects output
assertType('array<string, WP_Taxonomy>', get_object_taxonomies('post', 'objects'));

// Unexpected output
assertType('array<string, WP_Taxonomy>', get_object_taxonomies('post', 'Hello'));

// Unknown string
assertType('array<int|string, string|WP_Taxonomy>', get_object_taxonomies('post', $type->string));

// Unions
assertType('array<int|string, string|WP_Taxonomy>', get_object_taxonomies('post', $type::or('names', 'objects')));
assertType('array<int|string, string|WP_Taxonomy>', get_object_taxonomies('post', $type::stringOr('names')));
assertType('array<int|string, string|WP_Taxonomy>', get_object_taxonomies('post', $type::stringOr('objects')));
