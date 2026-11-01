<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_get_environment_type;
use function PHPStan\Testing\assertType;

assertType("'development'|'local'|'production'|'staging'", wp_get_environment_type());
assertType('false', wp_get_environment_type() === 'dev');
assertType('false', wp_get_environment_type() === 'Production');
assertType('bool', wp_get_environment_type() === 'production');
assertType('bool', wp_get_environment_type() === Faker::string());
