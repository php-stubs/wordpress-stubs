<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_terms;
use function PHPStan\Testing\assertType;

// Default argument values (fields => all)
assertType('array<int, WP_Term>|WP_Error', get_terms());
assertType('array<int, WP_Term>|WP_Error', get_terms([]));

// Requesting a count
assertType('numeric-string|WP_Error', get_terms(['fields' => 'count']));
assertType('numeric-string|WP_Error', get_terms(['foo' => 'bar','fields' => 'count']));

// Requesting names or slugs
assertType('list<string>|WP_Error', get_terms(['fields' => 'names']));
assertType('list<string>|WP_Error', get_terms(['fields' => 'slugs']));
assertType('array<int, string>|WP_Error', get_terms(['fields' => 'id=>name']));
assertType('array<int, string>|WP_Error', get_terms(['fields' => 'id=>slug']));

// Requesting IDs
assertType('list<int>|WP_Error', get_terms(['fields' => 'ids']));
assertType('list<int>|WP_Error', get_terms(['fields' => 'tt_ids']));

// Requesting parent IDs
assertType('array<int, int>|WP_Error', get_terms(['fields' => 'id=>parent']));

// Requesting objects
assertType('array<int, WP_Term>|WP_Error', get_terms(['fields' => 'all']));
assertType('array<int, WP_Term>|WP_Error', get_terms(['fields' => 'all_with_object_id']));
assertType('array<int, WP_Term>|WP_Error', get_terms(['fields' => 'foo']));

// Unknown fields value
assertType('array<int, int|string|WP_Term>|numeric-string|WP_Error', get_terms(['fields' => Faker::string()]));
