<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_taxonomies_for_attachments;
use function PHPStan\Testing\assertType;

// Default
assertType('array<int, string>', get_taxonomies_for_attachments());
assertType('array<int, string>', get_taxonomies_for_attachments('names'));

// Objects
assertType('array<string, WP_Taxonomy>', get_taxonomies_for_attachments('objects'));

// Unexpected
assertType('array<string, WP_Taxonomy>', get_taxonomies_for_attachments('Hello'));

// Unknown
assertType('array<int|string, string|WP_Taxonomy>', get_taxonomies_for_attachments((string)$_GET['string']));

// Unions
assertType('array<int|string, string|WP_Taxonomy>', get_taxonomies_for_attachments($_GET['foo'] ? 'names' : 'objects'));
assertType('array<int|string, string|WP_Taxonomy>', get_taxonomies_for_attachments($_GET['foo'] ? (string)$_GET['string'] : 'names'));
assertType('array<int|string, string|WP_Taxonomy>', get_taxonomies_for_attachments($_GET['foo'] ? (string)$_GET['string'] : 'objects'));
