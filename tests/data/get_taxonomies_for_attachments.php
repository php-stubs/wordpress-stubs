<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_taxonomies_for_attachments;
use function PHPStan\Testing\assertType;

$type = new TypeHelper();

assertType('array<int, string>', get_taxonomies_for_attachments());
assertType('array<int, string>', get_taxonomies_for_attachments('names'));
assertType('array<string, WP_Taxonomy>', get_taxonomies_for_attachments('objects'));
assertType('array<string, WP_Taxonomy>', get_taxonomies_for_attachments('Hello'));
assertType('array<int|string, string|WP_Taxonomy>', get_taxonomies_for_attachments($type->string));

// Unions
assertType('array<int|string, string|WP_Taxonomy>', get_taxonomies_for_attachments($type::or('names', 'objects')));
assertType('array<int|string, string|WP_Taxonomy>', get_taxonomies_for_attachments($type::stringOr('names')));
assertType('array<int|string, string|WP_Taxonomy>', get_taxonomies_for_attachments($type::stringOr('objects')));
