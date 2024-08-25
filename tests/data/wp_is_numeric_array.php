<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_is_numeric_array;
use function PHPStan\Testing\assertType;

assertType('false', wp_is_numeric_array((string)$_GET['thing']));
assertType('false', wp_is_numeric_array((int)$_GET['thing']));
assertType('false', wp_is_numeric_array((bool)$_GET['value']));
assertType('false', wp_is_numeric_array(null));

assertType('true', wp_is_numeric_array([]));

/** @var list<mixed> $value */
$value = $_GET['value'];
assertType('true', wp_is_numeric_array($value));

/** @var array<int, mixed> $value */
$value = $_GET['value'];
assertType('true', wp_is_numeric_array($value));

/** @var array<string, mixed> $value */
$value = $_GET['value'];
assertType('false', wp_is_numeric_array($value));

/** @var array $value */
$value = $_GET['value'];
assertType('bool', wp_is_numeric_array($value));

/** @var array<int|string, mixed> $value */
$value = $_GET['value'];
assertType('bool', wp_is_numeric_array($value));

/** @var array<int|string, mixed> $value */
$value = $_GET['value'];
assertType('bool', wp_is_numeric_array($value));

/** @var array{'key1': 'value1', 'key2': 'value2'} $value */
$value = $_GET['value'];
assertType('false', wp_is_numeric_array($value));

/** @var array{0: 'value0', 1: 'value1'} $value */
$value = $_GET['value'];
assertType('true', wp_is_numeric_array($value));

/** @var array{0: 'value0', key1: 'value1'} $value */
$value = $_GET['value'];
assertType('bool', wp_is_numeric_array($value));

assertType('bool', wp_is_numeric_array($_GET['value']));

/** @var list<string>|string */
$value = $_GET['value'];
if (wp_is_numeric_array($value)) {
    assertType('list<string>', $value);
}

/** @var array<int, string>|string */
$value = $_GET['value'];
if (wp_is_numeric_array($value)) {
    assertType('array<int, string>', $value);
}

if (wp_is_numeric_array($_GET['value'])) {
    assertType('array<int, mixed>', $_GET['value']);
}
