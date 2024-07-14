<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_term_by;
use function PHPStan\Testing\assertType;

assertType('WP_Error|WP_Term|false', get_term_by('term_id', 2, '', OBJECT));
assertType('WP_Error|WP_Term|false', get_term_by('slug', 'test'));
assertType('array<string, int|string>|WP_Error|false', get_term_by('term_id', 2, '', ARRAY_A));
assertType('list<int|string>|WP_Error|false', get_term_by('term_id', 2, '', ARRAY_N));
