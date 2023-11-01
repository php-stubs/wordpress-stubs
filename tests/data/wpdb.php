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
