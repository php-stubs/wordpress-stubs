<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function PHPStan\Testing\assertType;

// Capability maps are keyed by capability name.
assertType('array<string, bool>', Faker::wpUser()->caps);
assertType('array<string, bool>', Faker::wpUser()->allcaps);
assertType('array<string, bool>', Faker::wpRole()->capabilities);
