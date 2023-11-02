<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_clear_scheduled_hook;
use function PHPStan\Testing\assertType;

assertType('int<0, max>|false', wp_clear_scheduled_hook('hook', []));
assertType('int<0, max>|false', wp_clear_scheduled_hook('hook', [], false));
assertType('int<0, max>|WP_Error', wp_clear_scheduled_hook('hook', [], true));
