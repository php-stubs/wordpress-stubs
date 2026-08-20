<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function PHPStan\Testing\assertType;
use function stripslashes_deep;

assertType('null', stripslashes_deep(null));
assertType('bool', stripslashes_deep(Faker::bool()));
assertType('int', stripslashes_deep(Faker::int()));
assertType('float', stripslashes_deep(Faker::float()));
assertType('string', stripslashes_deep(Faker::string()));
assertType('array<mixed>', stripslashes_deep(Faker::array()));
assertType('resource', stripslashes_deep(Faker::resource()));
assertType('object', stripslashes_deep(Faker::object()));
