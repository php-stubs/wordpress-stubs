<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function PHPStan\Testing\assertType;
use function stripslashes_deep;
use function stripslashes_from_strings_only;

assertType('null', stripslashes_deep(null));
assertType('bool', stripslashes_deep(Faker::fake('bool')));
assertType('int', stripslashes_deep(Faker::fake('int')));
assertType('float', stripslashes_deep(Faker::fake('float')));
assertType('string', stripslashes_deep(Faker::fake('string')));
assertType('array', stripslashes_deep(Faker::fake('array')));
assertType('resource', stripslashes_deep(Faker::fake('resource')));
assertType('object', stripslashes_deep(Faker::fake('object')));

assertType('null', stripslashes_from_strings_only(null));
assertType('bool', stripslashes_from_strings_only(Faker::fake('bool')));
assertType('int', stripslashes_from_strings_only(Faker::fake('int')));
assertType('float', stripslashes_from_strings_only(Faker::fake('float')));
assertType('string', stripslashes_from_strings_only(Faker::fake('string')));
assertType('array', stripslashes_from_strings_only(Faker::fake('array')));
assertType('resource', stripslashes_from_strings_only(Faker::fake('resource')));
assertType('object', stripslashes_from_strings_only(Faker::fake('object')));
