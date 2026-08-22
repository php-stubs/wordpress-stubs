<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_post;
use function PHPStan\Testing\assertType;

$postIntNull = Faker::union(Faker::wpPost(), Faker::int(), null);

// Default output
assertType('WP_Post|null', get_post());
assertType('WP_Post|null', get_post($postIntNull));
assertType('WP_Post|null', get_post($postIntNull, 'OBJECT'));

// Associative array output
assertType('array<string, mixed>|null', get_post($postIntNull, 'ARRAY_A'));

// Numeric array output
assertType('array<int, mixed>|null', get_post($postIntNull, 'ARRAY_N'));

assertType('WP_Post', get_post(Faker::wpPost()));
assertType('WP_Post', get_post(Faker::wpPost(), 'OBJECT'));
assertType('array<string, mixed>', get_post(Faker::wpPost(), 'ARRAY_A'));
assertType('array<int, mixed>', get_post(Faker::wpPost(), 'ARRAY_N'));
