<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_term;
use function PHPStan\Testing\assertType;

$type = new TypeHelper();
/** @var WP_Term|int|object $term */
$term;

assertType('WP_Error|WP_Term|null', get_term($term));
assertType('WP_Error|WP_Term|null', get_term($term, $type->string));
assertType('WP_Error|WP_Term|null', get_term($term, $type->string, OBJECT));
assertType('array<string, int|string>|WP_Error|null', get_term($term, $type->string, ARRAY_A));
assertType('array<int, int|string>|WP_Error|null', get_term($term, $type->string, ARRAY_N));
