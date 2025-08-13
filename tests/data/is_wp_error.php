<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use WP_Error;

use function is_wp_error;
use function PHPStan\Testing\assertType;

/*
 * Check return type
 */

assertType('false', is_wp_error(Faker::string()));
assertType('true', is_wp_error(new WP_Error()));
assertType('bool', is_wp_error(Faker::mixed()));

/*
 * Check type specification
 */

$stringOrWpError = Faker::union(Faker::string(), Faker::wpError());
if (is_wp_error($stringOrWpError)) {
    assertType('WP_Error', $stringOrWpError);
    return;
}
assertType('string', $stringOrWpError);

$stringOrWpError = Faker::union(Faker::string(), Faker::wpError());
if (! is_wp_error($stringOrWpError)) {
    assertType('string', $stringOrWpError);
    return;
}
assertType('WP_Error', $stringOrWpError);
