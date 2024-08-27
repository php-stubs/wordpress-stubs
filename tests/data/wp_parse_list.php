<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function PHPStan\Testing\assertType;

assertType('list<string>', wp_parse_list((string)$_GET['input_list']));
assertType('array<bool|float|int|string>', wp_parse_list((array)$_GET['input_list']));
