<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_category_by_path;
use function PHPStan\Testing\assertType;

assertType('WP_Error|WP_Term|null', get_category_by_path('', (bool)$_GET['full_match']));
assertType('WP_Error|WP_Term|null', get_category_by_path('', (bool)$_GET['full_match'], 'OBJECT'));
assertType('array<string, mixed>|WP_Error|null', get_category_by_path('', (bool)$_GET['full_match'], 'ARRAY_A'));
assertType('array<int, mixed>|WP_Error|null', get_category_by_path('', (bool)$_GET['full_match'], 'ARRAY_N'));
