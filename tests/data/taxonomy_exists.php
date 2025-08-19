<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function taxonomy_exists;
use function PHPStan\Testing\assertType;

/*
 * Check return type
 */

assertType('false', taxonomy_exists(''));
assertType('false', taxonomy_exists('0'));
assertType('bool', taxonomy_exists('tax'));
assertType('bool', taxonomy_exists(Faker::string()));
assertType('bool', taxonomy_exists(Faker::nonEmptyString()));
assertType('bool', taxonomy_exists(Faker::nonFalsyString()));

/*
 * Check impurity
 */

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

/*
 * Check type specification
 */

$taxonomy = Faker::string();
if (taxonomy_exists($taxonomy)) {
    assertType('non-falsy-string', $taxonomy);
}
if (! taxonomy_exists($taxonomy)) {
    assertType('string', $taxonomy);
}
