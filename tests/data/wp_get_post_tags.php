<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_get_post_tags;
use function PHPStan\Testing\assertType;

$postID = 123;

// Default argument values (fields => all)
assertType('array<int, WP_Term>|WP_Error', wp_get_post_tags($postID));
assertType('array<int, WP_Term>|WP_Error', wp_get_post_tags($postID, []));

// Requesting names or slugs
assertType('list<string>|WP_Error', wp_get_post_tags($postID, ['fields' => 'names']));
assertType('list<string>|WP_Error', wp_get_post_tags($postID, ['fields' => 'slugs']));
assertType('array<int, string>|WP_Error', wp_get_post_tags($postID, ['fields' => 'id=>name']));
assertType('array<int, string>|WP_Error', wp_get_post_tags($postID, ['fields' => 'id=>slug']));

// Requesting IDs
assertType('list<int>|WP_Error', wp_get_post_tags($postID, ['fields' => 'ids']));
assertType('list<int>|WP_Error', wp_get_post_tags($postID, ['fields' => 'tt_ids']));

// Requesting parent IDs
assertType('array<int, int>|WP_Error', wp_get_post_tags($postID, ['fields' => 'id=>parent']));

// Requesting objects
assertType('array<int, WP_Term>|WP_Error', wp_get_post_tags($postID, ['fields' => 'all']));
assertType('array<int, WP_Term>|WP_Error', wp_get_post_tags($postID, ['fields' => 'all_with_object_id']));
assertType('array<int, WP_Term>|WP_Error', wp_get_post_tags($postID, ['fields' => 'foo']));

// Unknown fields value
assertType('array<int, int|string|WP_Term>|WP_Error', wp_get_post_tags($postID, ['fields' => (string)$_GET['fields']]));
