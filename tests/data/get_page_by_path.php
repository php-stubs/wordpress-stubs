<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_page_by_path;
use function PHPStan\Testing\assertType;

// Default output
assertType('WP_Post|null', get_page_by_path('page/path'));
assertType('WP_Post|null', get_page_by_path('page/path', OBJECT));

// Associative array output
assertType('array<string, mixed>|null', get_page_by_path('page/path', ARRAY_A));

// Numeric array output
assertType('array<int, mixed>|null', get_page_by_path('page/path', ARRAY_N));

// Unknown output
assertType('array<int|string, mixed>|WP_Post|null', get_page_by_path('page/path', (string)$_GET['unknown_string']));

// Unexpected output
assertType('WP_Post|null', get_page_by_path('page/path', 'Hello'));
