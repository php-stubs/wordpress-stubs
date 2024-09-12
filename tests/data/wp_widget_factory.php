<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use WP_Widget_Factory;

use function PHPStan\Testing\assertType;

$factory = new WP_Widget_Factory();

assertType('array<string, WP_Widget>', $factory->widgets);
