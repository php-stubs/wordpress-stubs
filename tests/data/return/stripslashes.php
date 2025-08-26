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
assertType('array<mixed>', stripslashes_deep(Faker::array()));
assertType('resource', stripslashes_deep(Faker::resource()));
assertType('object', stripslashes_deep(Faker::object()));

assertType('null', stripslashes_from_strings_only(null));
assertType('true', stripslashes_from_strings_only(true));
assertType('false', stripslashes_from_strings_only(false));
assertType('bool', stripslashes_from_strings_only(Faker::bool()));
assertType('123', stripslashes_from_strings_only(123));
assertType('int', stripslashes_from_strings_only(Faker::int()));
assertType('1.23', stripslashes_from_strings_only(1.23));
assertType('float', stripslashes_from_strings_only(Faker::float()));
assertType("''", stripslashes_from_strings_only(''));
assertType('string', stripslashes_from_strings_only('value'));
assertType('string', stripslashes_from_strings_only(Faker::string()));
assertType("array{key: 'value'}", stripslashes_from_strings_only(['key' => 'value']));
assertType('array<mixed>', stripslashes_from_strings_only(Faker::array()));
assertType('resource', stripslashes_from_strings_only(Faker::resource()));
assertType("object{key: 'value'}&stdClass", stripslashes_from_strings_only((object)['key' => 'value']));
assertType('WP_Post', stripslashes_from_strings_only(Faker::wpPost()));
assertType('object', stripslashes_from_strings_only(Faker::object()));
