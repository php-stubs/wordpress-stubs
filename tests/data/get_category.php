<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_category;
use function PHPStan\Testing\assertType;

$type = new TypeHelper();

assertType('WP_Term', get_category($type->object));
assertType('WP_Term', get_category($type->object, 'OBJECT'));
assertType('array<string, mixed>', get_category($type->object, 'ARRAY_A'));
assertType('array<int, mixed>', get_category($type->object, 'ARRAY_N'));

assertType('WP_Error|WP_Term|null', get_category($type->intOrObject));
assertType('WP_Error|WP_Term|null', get_category($type->intOrObject, 'OBJECT'));
assertType('array<string, mixed>|WP_Error|null', get_category($type->intOrObject, 'ARRAY_A'));
assertType('array<int, mixed>|WP_Error|null', get_category($type->intOrObject, 'ARRAY_N'));
