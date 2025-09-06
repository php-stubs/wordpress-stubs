<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function is_wp_error;
use function PHPStan\Testing\assertType;

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
