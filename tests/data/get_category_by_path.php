<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_category_by_path;
use function PHPStan\Testing\assertType;

/** @var bool $bool */
$bool;

assertType('WP_Error|WP_Term|null', get_category_by_path('', $bool, ));
assertType('WP_Error|WP_Term|null', get_category_by_path('', $bool, 'OBJECT'));
assertType('array<string, mixed>|WP_Error|null', get_category_by_path('', $bool, 'ARRAY_A'));
assertType('array<int, mixed>|WP_Error|null', get_category_by_path('', $bool, 'ARRAY_N'));
