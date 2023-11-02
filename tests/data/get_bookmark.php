<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_bookmark;
use function PHPStan\Testing\assertType;

/** @var \stdClass|int $bookmark */
$bookmark;

assertType('stdClass|null', get_bookmark($bookmark));
assertType('stdClass|null', get_bookmark($bookmark, 'OBJECT'));
assertType('array<string, mixed>|null', get_bookmark($bookmark, 'ARRAY_A'));
assertType('array<int, mixed>|null', get_bookmark($bookmark, 'ARRAY_N'));
