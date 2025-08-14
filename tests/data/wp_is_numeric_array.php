<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_is_numeric_array;
use function PHPStan\Testing\assertType;

/*
 * Check return type
 */

// No array
assertType('false', wp_is_numeric_array(Faker::string()));
assertType('false', wp_is_numeric_array(Faker::int()));
assertType('false', wp_is_numeric_array(Faker::bool()));
assertType('false', wp_is_numeric_array(null));

// Arrays
assertType('true', wp_is_numeric_array([]));
assertType('true', wp_is_numeric_array(Faker::list()));
assertType('true', wp_is_numeric_array(Faker::intArray()));
assertType('false', wp_is_numeric_array(Faker::strArray()));
assertType('bool', wp_is_numeric_array(Faker::array()));
assertType('bool', wp_is_numeric_array(Faker::union(Faker::strArray(), Faker::intArray())));

// Constant arrays
assertType('false', wp_is_numeric_array(['key1' => 'value1', 'key2' => 'value2']));
assertType('true', wp_is_numeric_array(['value0', 'value1']));
assertType('bool', wp_is_numeric_array(['value0', 'key1' => 'value1']));

// Maybe array
assertType('bool', wp_is_numeric_array(Faker::mixed()));

/*
 * Check type specification
 */

// if wp_is_numeric_array, it must be a numeric array, therefore:
$data = Faker::string();
if (wp_is_numeric_array($data)) {
    assertType('*NEVER*', $data);
}
// and:
$data = Faker::strArray();
if (wp_is_numeric_array($data)) {
    assertType('*NEVER*', $data);
}
// and:
$data = Faker::list(Faker::string());
if (! wp_is_numeric_array($data)) {
    assertType('*NEVER*', $data);
}
if (wp_is_numeric_array($data)) {
    assertType('list<string>', $data);
}
// Check with mixed
$data = Faker::mixed();
if (wp_is_numeric_array($data)) {
    assertType('array<int, mixed>', $data);
}
if (! wp_is_numeric_array($data)) {
    assertType('mixed~(mixed is list ? list : array<int, mixed>)', $data);
}

// Check with indetermined array
$data = Faker::array();
if (wp_is_numeric_array($data)) {
    assertType('array<int, mixed>', $data);
}
if (! wp_is_numeric_array($data)) {
    assertType('array', $data); // can still be a mixed key array
}

// Check with union
$data = Faker::union(Faker::intArray(Faker::string()), Faker::string());
if (wp_is_numeric_array($data)) {
    assertType('array<int, string>', $data);
}
if (! wp_is_numeric_array($data)) {
    assertType('string', $data);
}

// Check with constant values
$data = Faker::union([1 => 'value1', 2 => 'value2'], ['value3', 'value4'], ['key' => 'value'], 'constant');
if (wp_is_numeric_array($data)) {
    assertType("array{'value3', 'value4'}|array{1: 'value1', 2: 'value2'}", $data);
}
if (! wp_is_numeric_array($data)) {
    assertType("'constant'|array{key: 'value'}", $data);
}

// Check with mixed keys constant array
$data = [1 => 'intKey', 'key' => 'stringKey'];
if (wp_is_numeric_array($data)) {
    assertType("non-empty-array<1, 'intKey'|'stringKey'>", $data);
}
if (! wp_is_numeric_array($data)) {
    assertType("array{1: 'intKey', key: 'stringKey'}", $data);
}
