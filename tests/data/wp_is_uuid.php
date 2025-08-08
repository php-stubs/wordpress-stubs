<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_is_uuid;
use function PHPStan\Testing\assertType;

/*
 * Check return type
 */

// Default $version
assertType('bool', wp_is_uuid(''));
assertType('bool', wp_is_uuid('abc'));
assertType('bool', wp_is_uuid(Faker::string()));

// $version = 4
assertType('bool', wp_is_uuid('', 4));
assertType('bool', wp_is_uuid('foo', 4));
assertType('bool', wp_is_uuid(Faker::string(), 4));

// $version != 4
assertType('false', wp_is_uuid('', 1));
assertType('false', wp_is_uuid('foo', 1));
assertType('false', wp_is_uuid(Faker::string(), 1));

// Unknown version
assertType('bool', wp_is_uuid('', Faker::int()));
assertType('bool', wp_is_uuid('foo', Faker::int()));
assertType('bool', wp_is_uuid(Faker::string(), Faker::int()));

/*
 * Check type specification
 */

$uuid = Faker::string();

if (wp_is_uuid($uuid)) {
    assertType('lowercase-string&non-falsy-string', $uuid);
}
assertType('string', $uuid);

if (! wp_is_uuid($uuid)) {
    assertType('string', $uuid);
    return;
}
assertType('lowercase-string&non-falsy-string', $uuid);

$uuid = 'foo';

if (wp_is_uuid($uuid)) {
    assertType("'foo'", $uuid);
}
assertType("'foo'", $uuid);

if (! wp_is_uuid($uuid)) {
    assertType("'foo'", $uuid);
    return;
}
assertType("'foo'", $uuid);
