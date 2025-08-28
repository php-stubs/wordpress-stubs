<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_slash;
use function PHPStan\Testing\assertType;

assertType('string', wp_slash(''));
assertType('string', wp_slash('value'));
assertType('string', wp_slash(Faker::nonEmptyString()));
assertType('string', wp_slash(Faker::string()));

assertType('array', wp_slash([]));
assertType("array", wp_slash(['key' => 'value']));
assertType('array', wp_slash(Faker::nonEmptyArray()));
assertType('array', wp_slash(Faker::array()));
