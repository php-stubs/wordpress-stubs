<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_attachment_taxonomies;
use function PHPStan\Testing\assertType;

$type = new TypeHelper();

// Default
assertType('array<int, string>', get_attachment_taxonomies($type->int));
assertType('array<int, string>', get_attachment_taxonomies($type->int, 'names'));

// Objects
assertType('array<string, WP_Taxonomy>', get_attachment_taxonomies($type->int, 'objects'));

// Unexpected
assertType('array<string, WP_Taxonomy>', get_attachment_taxonomies($type->int, 'Hello'));

// Unknown
assertType('array<int|string, string|WP_Taxonomy>', get_attachment_taxonomies($type->int, $type->string));

// Unions
assertType('array<int|string, string|WP_Taxonomy>', get_attachment_taxonomies($type->int, $type::or('names', 'objects')));
assertType('array<int|string, string|WP_Taxonomy>', get_attachment_taxonomies($type->int, $type::or($type->string, 'names')));
assertType('array<int|string, string|WP_Taxonomy>', get_attachment_taxonomies($type->int, $type::or($type->string, 'objects')));
