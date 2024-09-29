<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_bookmark;
use function PHPStan\Testing\assertType;

$stdClassOrInt = Faker::union(Faker::stdClass(), Faker::int());

assertType('stdClass|null', get_bookmark($stdClassOrInt));
assertType('stdClass|null', get_bookmark($stdClassOrInt, 'OBJECT'));
assertType('array<string, mixed>|null', get_bookmark($stdClassOrInt, 'ARRAY_A'));
assertType('array<int, mixed>|null', get_bookmark($stdClassOrInt, 'ARRAY_N'));
