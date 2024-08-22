<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_get_post_categories;
use function PHPStan\Testing\assertType;

$postID = 123;

// Default argument values (fields => ids)
assertType('list<int>|WP_Error', wp_get_post_categories($postID));
assertType('list<int>|WP_Error', wp_get_post_categories($postID, []));

// Requesting names or slugs
assertType('list<string>|WP_Error', wp_get_post_categories($postID, ['fields' => 'names']));
assertType('list<string>|WP_Error', wp_get_post_categories($postID, ['fields' => 'slugs']));
assertType('array<int, string>|WP_Error', wp_get_post_categories($postID, ['fields' => 'id=>name']));
assertType('array<int, string>|WP_Error', wp_get_post_categories($postID, ['fields' => 'id=>slug']));

// Requesting IDs
assertType('list<int>|WP_Error', wp_get_post_categories($postID, ['fields' => 'ids']));
assertType('list<int>|WP_Error', wp_get_post_categories($postID, ['fields' => 'tt_ids']));

// Requesting parent IDs
assertType('array<int, int>|WP_Error', wp_get_post_categories($postID, ['fields' => 'id=>parent']));

// Requesting objects
assertType('array<int, WP_Term>|WP_Error', wp_get_post_categories($postID, ['fields' => 'all']));
assertType('array<int, WP_Term>|WP_Error', wp_get_post_categories($postID, ['fields' => 'all_with_object_id']));
assertType('list<int>|WP_Error', wp_get_post_categories($postID, ['fields' => 'foo']));

// Unknown fields value
assertType('array<int, int|string|WP_Term>|WP_Error', wp_get_post_categories($postID, ['fields' => (string)$_GET['fields']]));
