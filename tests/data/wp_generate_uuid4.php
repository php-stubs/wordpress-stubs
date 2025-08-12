<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_generate_uuid4;
use function PHPStan\Testing\assertType;

/*
 * Check return type
 */

assertType('lowercase-string&non-falsy-string', wp_generate_uuid4());

/*
 * Check impurity
 */

if (wp_generate_uuid4() === 'uuid') {
    assertType('lowercase-string&non-falsy-string', wp_generate_uuid4());
}
