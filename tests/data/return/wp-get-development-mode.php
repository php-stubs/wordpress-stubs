<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_get_development_mode;
use function PHPStan\Testing\assertType;

assertType("''|'all'|'core'|'plugin'|'theme'", wp_get_development_mode());
assertType('false', wp_get_development_mode() === 'dev');
assertType('false', wp_get_development_mode() === 'Theme');
assertType('bool', wp_get_development_mode() === 'theme');
assertType('bool', wp_get_development_mode() === Faker::string());
