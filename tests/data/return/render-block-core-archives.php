<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function render_block_core_archives;
use function PHPStan\Testing\assertType;

assertType('non-falsy-string', render_block_core_archives(Faker::array()));
