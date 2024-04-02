<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use wpdb;
use function PHPStan\Testing\assertType;

// wpdb::get_row()
assertType('stdClass|null', wpdb::get_row());
assertType('stdClass|null', wpdb::get_row(null, 'OBJECT'));
assertType('array|null', wpdb::get_row(null, 'ARRAY_A'));
assertType('list<mixed>|null', wpdb::get_row(null, 'ARRAY_N'));

// wpdb::get_results()
assertType('list<array>|null', wpdb::get_results(null, 'ARRAY_A'));
assertType('list<array<int, mixed>>|null', wpdb::get_results(null, 'ARRAY_N'));
assertType('list<stdClass>|null', wpdb::get_results());
assertType('list<stdClass>|null', wpdb::get_results(null, 'OBJECT'));
assertType('array<stdClass>|null', wpdb::get_results(null, 'OBJECT_K'));
