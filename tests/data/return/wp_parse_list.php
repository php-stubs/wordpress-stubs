<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_parse_list;
use function PHPStan\Testing\assertType;

assertType('list<string>', wp_parse_list(Faker::string()));
assertType('array<bool|float|int|string>', wp_parse_list(Faker::array()));
