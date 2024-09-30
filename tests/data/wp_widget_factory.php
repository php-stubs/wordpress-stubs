<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function PHPStan\Testing\assertType;

assertType('array<string, WP_Widget>', Faker::wpWidgetFactory()->widgets);
