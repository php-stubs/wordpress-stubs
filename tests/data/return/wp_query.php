<?php

/**
 * Note:
 * Starting from PHPStan 1.10.49, void types, including void in unions, are
 * transformed into null.
 *
 * @link https://github.com/phpstan/phpstan-src/pull/2778
 */

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function PHPStan\Testing\assertType;

assertType('bool', Faker::wpQuery()->query_vars_changed);
assertType('bool|string', Faker::wpQuery()->query_vars_hash);
assertType('null', Faker::wpQuery()->init_query_flags());
