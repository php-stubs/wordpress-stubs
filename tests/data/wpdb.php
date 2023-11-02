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
assertType('stdClass|null', wpdb::get_results());
assertType('stdClass|null', wpdb::get_results(null, 'OBJECT'));
assertType('array<string, stdClass>|null', wpdb::get_results(null, 'OBJECT_K'));
assertType('array<string, mixed>|null', wpdb::get_results(null, 'ARRAY_A'));
assertType('array<int, mixed>|null', wpdb::get_results(null, 'ARRAY_N'));
