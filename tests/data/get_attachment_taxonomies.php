<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_attachment_taxonomies;
use function PHPStan\Testing\assertType;

// Default
assertType('array<int, string>', get_attachment_taxonomies((int)$id));
assertType('array<int, string>', get_attachment_taxonomies((int)$id, 'names'));

// Objects
assertType('array<string, WP_Taxonomy>', get_attachment_taxonomies((int)$id, 'objects'));

// Unexpected
assertType('array<string, WP_Taxonomy>', get_attachment_taxonomies((int)$id, 'Hello'));

// Unknown
assertType('array<int|string, string|WP_Taxonomy>', get_attachment_taxonomies((int)$id, (string)$_GET['string']));

// Unions
assertType('array<int|string, string|WP_Taxonomy>', get_attachment_taxonomies((int)$id, $_GET['foo'] ? 'names' : 'objects'));
assertType('array<int|string, string|WP_Taxonomy>', get_attachment_taxonomies((int)$id, $_GET['foo'] ? (string)$_GET['string'] : 'names'));
assertType('array<int|string, string|WP_Taxonomy>', get_attachment_taxonomies((int)$id, $_GET['foo'] ? (string)$_GET['string'] : 'objects'));
