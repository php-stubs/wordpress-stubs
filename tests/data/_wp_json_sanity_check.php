<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function PHPStan\Testing\assertType;
use function _wp_json_sanity_check;

assertType('null', _wp_json_sanity_check(null, 1));
assertType('bool', _wp_json_sanity_check(Faker::bool(), 1));
assertType('int', _wp_json_sanity_check(Faker::int(), 1));
assertType('string', _wp_json_sanity_check(Faker::string(), 1));
assertType('array', _wp_json_sanity_check(Faker::array(), 1));
assertType('stdClass', _wp_json_sanity_check(Faker::stdClass(), 1));
assertType('mixed', _wp_json_sanity_check(Faker::mixed(), 1));
