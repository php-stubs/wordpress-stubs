<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_unique_id;
use function wp_unique_prefixed_id;
use function PHPStan\Testing\assertType;

/*
 * Check return type
 */

assertType('non-falsy-string&numeric-string', wp_unique_id());
assertType('non-falsy-string&numeric-string', wp_unique_id(''));
assertType('non-falsy-string&numeric-string', wp_unique_id('1'));
assertType('non-falsy-string&numeric-string', wp_unique_id(Faker::numericString()));

assertType('non-falsy-string', wp_unique_id('string'));
assertType('non-falsy-string', wp_unique_id(Faker::string()));

assertType('non-falsy-string&numeric-string', wp_unique_prefixed_id());
assertType('non-falsy-string&numeric-string', wp_unique_prefixed_id(''));
assertType('non-falsy-string&numeric-string', wp_unique_prefixed_id('1'));
assertType('non-falsy-string&numeric-string', wp_unique_prefixed_id(Faker::numericString()));

assertType('non-falsy-string', wp_unique_prefixed_id('string'));
assertType('non-falsy-string', wp_unique_prefixed_id(Faker::string()));

/*
 * Check impurity
 */

if (wp_unique_id() === '1') {
    assertType('non-falsy-string&numeric-string', wp_unique_id());
}

if (wp_unique_prefixed_id() === 'prefix1') {
    assertType('non-falsy-string&numeric-string', wp_unique_prefixed_id());
}
