<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_password_reset_key;
use function PHPStan\Testing\assertType;

/*
 * Check impurity
 */

if (is_wp_error(get_password_reset_key(Faker::wpUser()))) {
    assertType('string|WP_Error', get_password_reset_key(Faker::wpUser()));
}

if (! is_wp_error(get_password_reset_key(Faker::wpUser()))) {
    assertType('string|WP_Error', get_password_reset_key(Faker::wpUser()));
}

if (is_string(get_password_reset_key(Faker::wpUser()))) {
    assertType('string|WP_Error', get_password_reset_key(Faker::wpUser()));
}

if (! is_string(get_password_reset_key(Faker::wpUser()))) {
    assertType('string|WP_Error', get_password_reset_key(Faker::wpUser()));
}
