<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use wpdb;
use function PHPStan\Testing\assertType;

// wpdb::get_row()
assertType('stdClass|void|null', wpdb::get_row());
assertType('stdClass|void|null', wpdb::get_row(null, 'OBJECT'));
assertType('array<string, mixed>|void|null', wpdb::get_row(null, 'ARRAY_A'));
assertType('array<int, mixed>|void|null', wpdb::get_row(null, 'ARRAY_N'));

// wpdb::get_results()
    /*
     *                       Any of ARRAY_A | ARRAY_N | OBJECT | OBJECT_K constants.
	 *                       ARRAY_A | ARRAY_N | OBJECT: return an array of rows indexed from 0 by SQL result row number.
     *
     *                       ARRAY_A: Each row is an associative array (column => value, ...),
     *                       ARRAY_N: a numerically indexed array (0 => value, ...),
	 *                       OBJECT: an object ( ->column = value ), respectively.
     *
     *                       With OBJECT_K: return an associative array of row objects keyed by the value
	 *                       of each row's first column's value.
     */
assertType('array<int, array<string, mixed>>|null', wpdb::get_results(null, 'ARRAY_A'));
assertType('array<int, array<int, mixed>>|null', wpdb::get_results(null, 'ARRAY_N'));
assertType('array<int, stdClass>|null', wpdb::get_results());
assertType('array<int, stdClass>|null', wpdb::get_results(null, 'OBJECT'));
assertType('array<array-key, stdClass>|null', wpdb::get_results(null, 'OBJECT_K'));
