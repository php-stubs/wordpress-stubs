<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function taxonomy_exists;
use function PHPStan\Testing\assertType;

if (taxonomy_exists('taxonomy')) {
    assertType('bool', taxonomy_exists('taxonomy'));
}
if (! taxonomy_exists('taxonomy')) {
    assertType('bool', taxonomy_exists('taxonomy'));
}

$taxonomy = Faker::string();
if (taxonomy_exists($taxonomy)) {
    assertType('bool', taxonomy_exists($taxonomy));
}
if (! taxonomy_exists($taxonomy)) {
    assertType('bool', taxonomy_exists($taxonomy));
}
