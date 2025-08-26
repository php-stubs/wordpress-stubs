<?php

/**
 * `rememberPossiblyImpureFunctionValues` set to false.
 */

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests\PureDemo;

use function PHPStan\Testing\assertType;

/** @phpstan-pure */
function pureByTag(): bool {
    return true;
}

function impureByConfig(): bool {
    return (bool)random_int(0, 1);
}

if (pureByTag() === true) {
    assertType('true', pureByTag());
}

if (impureByConfig() === true) {
    assertType('bool', impureByConfig());
}
