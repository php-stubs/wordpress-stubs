<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_category;
use function PHPStan\Testing\assertType;

/** @var object $category */
$category;

assertType('WP_Term', get_category($category));
assertType('WP_Term', get_category($category, 'OBJECT'));
assertType('array<string, mixed>', get_category($category, 'ARRAY_A'));
assertType('array<int, mixed>', get_category($category, 'ARRAY_N'));

/** @var int|object $category */
$category;

assertType('WP_Error|WP_Term|null', get_category($category));
assertType('WP_Error|WP_Term|null', get_category($category, 'OBJECT'));
assertType('array<string, mixed>|WP_Error|null', get_category($category, 'ARRAY_A'));
assertType('array<int, mixed>|WP_Error|null', get_category($category, 'ARRAY_N'));
