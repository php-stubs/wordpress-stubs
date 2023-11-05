<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function is_wp_error;
use function PHPStan\Testing\assertType;

$type = new TypeHelper();

assertType('false', is_wp_error($type->string));
assertType('true', is_wp_error($type->wpError));
assertType('bool', is_wp_error($_GET['thing']));
if (is_wp_error($_GET['thing'])) {
    assertType('WP_Error', $_GET['thing']);
}
