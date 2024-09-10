<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function PHPStan\Testing\assertType;
use WP_Query;

$wpQuery = new WP_Query();

assertType('bool', $wpQuery->query_vars_changed);
assertType('string|bool', $wpQuery->$query_vars_hash);
assertType('void', $wpQuery->init_query_flags());
