<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function PHPStan\Testing\assertType;
use function _get_cron_array;

assertType(
    'array<int, array<string, array<string, array{schedule: string|false, args: array<mixed>, interval?: int<0, max>}>>>',
    _get_cron_array()
);
