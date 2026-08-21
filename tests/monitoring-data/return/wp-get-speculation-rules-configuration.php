<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_get_speculation_rules_configuration;
use function PHPStan\Testing\assertType;

assertType("array{mode: 'prefetch'|'prerender', eagerness: 'conservative'|'eager'|'moderate'}|null", wp_get_speculation_rules_configuration());
