<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use stdClass;

use function PHPStan\Testing\assertType;
use function _wp_json_sanity_check;

assertType('null', _wp_json_sanity_check(null, 1));
assertType('bool', _wp_json_sanity_check((bool)$_GET['value'], 1));
assertType('int', _wp_json_sanity_check((int)$_GET['value'], 1));
assertType('string', _wp_json_sanity_check((string)$_GET['value'], 1));
assertType('array', _wp_json_sanity_check((array)$_GET['value'], 1));
assertType('stdClass', _wp_json_sanity_check(new stdClass(), 1));
assertType('mixed', _wp_json_sanity_check($_GET['value'], 1));
