<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_convert_hr_to_bytes;
use function PHPStan\Testing\assertType;

assertType('int<0, max>', wp_convert_hr_to_bytes(Faker::string()));
