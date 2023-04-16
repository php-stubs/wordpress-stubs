<?php

declare(strict_types=1);

namespace WordpressStubs\Tests;

use stdClass;

use function current_time;
use function PHPStan\Testing\assertType;

// Integer types
assertType('int', current_time('timestamp'));
assertType('int', current_time('U'));

// String types
assertType('string', current_time('mysql'));
assertType('string', current_time('Hello'));

// Unknown types
assertType('int|string', current_time($_GET['foo']));
assertType('int|string', current_time(get_option('date_format')));

// Unsupported types
assertType('string', current_time(new stdClass()));
assertType('string', current_time(false));
