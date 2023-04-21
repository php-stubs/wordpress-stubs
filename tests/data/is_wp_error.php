<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use WP_Error;

use function is_wp_error;
use function PHPStan\Testing\assertType;

assertType('false', is_wp_error((string)$_GET['thing']));
assertType('true', is_wp_error(new WP_Error()));
assertType('bool', is_wp_error($_GET['thing']));
if (is_wp_error($_GET['thing'])) {
    assertType('WP_Error', $_GET['thing']);
}
