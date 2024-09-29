<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_sites;
use function PHPStan\Testing\assertType;

// Default parameter
assertType('array<int, WP_Site>', get_sites());
assertType('array<int, WP_Site>', get_sites([]));

// Non constant array parameter.
assertType('array<int, int|WP_Site>|int', get_sites(Faker::array()));

// Array parameter with explicit fields value and default count value.
assertType('array<int, int>', get_sites(['fields' => 'ids']));
assertType('array<int, WP_Site>', get_sites(['fields' => '']));
assertType('array<int, WP_Site>', get_sites(['fields' => 'nonEmptyString']));

// Array parameter with count set to true.
assertType('int', get_sites(['count' => true]));
assertType('int', get_sites(['fields' => '', 'count' => true]));
assertType('int', get_sites(['fields' => 'ids', 'count' => true]));
assertType('int', get_sites(['fields' => 'nonEmptyString', 'count' => true]));

// Array parameter with count set to false.
assertType('array<int, WP_Site>', get_sites(['count' => false]));
assertType('array<int, WP_Site>', get_sites(['fields' => '', 'count' => false]));
assertType('array<int, int>', get_sites(['fields' => 'ids', 'count' => false]));
assertType('array<int, WP_Site>', get_sites(['fields' => 'nonEmptyString', 'count' => false]));
