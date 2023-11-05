<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_term_by;
use function PHPStan\Testing\assertType;

$type = new TypeHelper();

assertType('WP_Error|WP_Term|false', get_term_by('term_id', $type->int, $type->string, OBJECT));
assertType('WP_Error|WP_Term|false', get_term_by('slug', $type->string));
assertType('array<string, int|string>|WP_Error|false', get_term_by('term_id', $type->int, $type->string, ARRAY_A));
assertType('array<int, int|string>|WP_Error|false', get_term_by('term_id', $type->int, $type->string, ARRAY_N));
