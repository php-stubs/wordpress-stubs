<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function mysql2date;
use function PHPStan\Testing\assertType;

$type = new TypeHelper();

// Constant strings
assertType('int|false', mysql2date('G', $type->string));
assertType('int|false', mysql2date('U', $type->string));
assertType('string|false', mysql2date('Y-m-d H:i:s', $type->string));

// Unknown string
assertType('int|string|false', mysql2date($type->string, $type->string));
