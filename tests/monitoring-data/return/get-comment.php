<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_comment;
use function PHPStan\Testing\assertType;

$commentIntStringNull = Faker::union(
    Faker::wpComment(),
    Faker::int(),
    Faker::string(),
    null
);

// Default output
assertType('WP_Comment|null', get_comment());
assertType('WP_Comment|null', get_comment($commentIntStringNull));
assertType('WP_Comment|null', get_comment($commentIntStringNull, 'OBJECT'));

// Associative array output
assertType('array<string, mixed>|null', get_comment($commentIntStringNull, 'ARRAY_A'));

// Numeric array output
assertType('array<int, mixed>|null', get_comment($commentIntStringNull, 'ARRAY_N'));

assertType('WP_Comment', get_comment(Faker::wpComment()));
assertType('WP_Comment', get_comment(Faker::wpComment(), 'OBJECT'));
assertType('array<string, mixed>', get_comment(Faker::wpComment(), 'ARRAY_A'));
assertType('array<int, mixed>', get_comment(Faker::wpComment(), 'ARRAY_N'));
