<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_object_taxonomies;
use function PHPStan\Testing\assertType;

// Default output
assertType('array<int, string>', get_taxonomies([]));
assertType('array<int, string>', get_object_taxonomies([], 'names'));

// Objects output
assertType('array<string, WP_Taxonomy>', get_object_taxonomies([], 'objects'));

// Unexpected output
assertType('array<string, WP_Taxonomy>', get_object_taxonomies([], 'Hello'));

// Unknown string
/** @var string $string */
$string = null;
assertType('array<int|string, string|WP_Taxonomy>', get_object_taxonomies([], $string));
