<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function current_time;
use function PHPStan\Testing\assertType;

// Integer types
assertType('int', current_time('timestamp'));
assertType('int', current_time('U'));

// String types
assertType('string', current_time('mysql'));
assertType('string', current_time('Hello'));

// Unknown string
assertType('int|string', current_time((string)$_GET['unknown_string']));
