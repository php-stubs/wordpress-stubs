<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_unique_id;
use function PHPStan\Testing\assertType;

assertType('numeric-string', wp_unique_id());
assertType('numeric-string', wp_unique_id(''));
assertType('numeric-string', wp_unique_id('1'));
assertType('numeric-string', wp_unique_id(Faker::numericString()));

assertType('string', wp_unique_id('string'));
assertType('string', wp_unique_id(Faker::string()));
