<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function PHPStan\Testing\assertType;
use function stripslashes_deep;
use function stripslashes_from_strings_only;

assertType('null', stripslashes_deep(null));
assertType('bool', stripslashes_deep(Faker::bool()));
assertType('int', stripslashes_deep(Faker::int()));
assertType('float', stripslashes_deep(Faker::float()));
assertType('string', stripslashes_deep(Faker::string()));
assertType('array', stripslashes_deep(Faker::array()));
assertType('resource', stripslashes_deep(Faker::resource()));
assertType('object', stripslashes_deep(Faker::object()));

assertType('null', stripslashes_from_strings_only(null));
assertType('bool', stripslashes_from_strings_only(Faker::bool()));
assertType('int', stripslashes_from_strings_only(Faker::int()));
assertType('float', stripslashes_from_strings_only(Faker::float()));
assertType('string', stripslashes_from_strings_only(Faker::string()));
assertType('array', stripslashes_from_strings_only(Faker::array()));
assertType('resource', stripslashes_from_strings_only(Faker::resource()));
assertType('object', stripslashes_from_strings_only(Faker::object()));
