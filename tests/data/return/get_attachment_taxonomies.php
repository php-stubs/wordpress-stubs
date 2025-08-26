<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_attachment_taxonomies;
use function PHPStan\Testing\assertType;

// Default
assertType('array<int, string>', get_attachment_taxonomies(Faker::int()));
assertType('array<int, string>', get_attachment_taxonomies(Faker::int(), 'names'));

// Objects
assertType('array<string, WP_Taxonomy>', get_attachment_taxonomies(Faker::int(), 'objects'));

// Unexpected
assertType('array<string, WP_Taxonomy>', get_attachment_taxonomies(Faker::int(), 'Hello'));

// Unknown
assertType('array<int|string, string|WP_Taxonomy>', get_attachment_taxonomies(Faker::int(), Faker::string()));

// Unions
assertType('array<int|string, string|WP_Taxonomy>', get_attachment_taxonomies(Faker::int(), Faker::union('names', 'objects')));
assertType('array<int|string, string|WP_Taxonomy>', get_attachment_taxonomies(Faker::int(), Faker::union(Faker::string(), 'names')));
assertType('array<int|string, string|WP_Taxonomy>', get_attachment_taxonomies(Faker::int(), Faker::union(Faker::string(), 'objects')));
