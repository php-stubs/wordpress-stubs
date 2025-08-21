<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function PHPStan\Testing\assertType;

// Booleans
assertType('bool', Faker::bool());
assertType('true', Faker::true());
assertType('false', Faker::false());

// Numbers
assertType('int', Faker::int());
assertType('int<1, max>', Faker::positiveInt());
assertType('int<min, -1>', Faker::negativeInt());
assertType('int<min, 0>', Faker::nonPositiveInt());
assertType('int<0, max>', Faker::nonNegativeInt());
assertType('int<min, -1>|int<1, max>', Faker::nonZeroInt());
assertType('float', Faker::float());

// Strings
assertType('string', Faker::string());
assertType('numeric-string', Faker::numericString());
assertType('non-empty-string', Faker::nonEmptyString());
assertType('lowercase-string', Faker::lowercaseString());

// Arrays with default values
assertType('array<mixed>', Faker::array());
assertType('array<int, mixed>', Faker::intArray());
assertType('array<string, mixed>', Faker::strArray());
assertType('list<mixed>', Faker::list());

// Arrays with specific values
assertType('array<int>', Faker::array(Faker::int()));
assertType('array<int, string>', Faker::intArray(Faker::string()));
assertType('array<string, bool>', Faker::strArray(Faker::bool()));
assertType('list<mixed>', Faker::list());

// Non-empty arrays
assertType('non-empty-array<mixed>', Faker::nonEmptyArray());
assertType('non-empty-array<mixed>', Faker::nonEmptyArray(Faker::mixed()));
assertType('non-empty-array<int>', Faker::nonEmptyArray(Faker::int()));
assertType('non-empty-array<string, string>', Faker::nonEmptyArray(Faker::string(), Faker::string()));

// Unions
assertType('bool', Faker::union(Faker::bool()));
assertType('bool|int', Faker::union(Faker::bool(), Faker::int()));
assertType('bool|int|string', Faker::union(Faker::bool(), Faker::int(), Faker::string()));
assertType('array<int, int>|bool|int|string', Faker::union(Faker::bool(), Faker::int(), Faker::string(), Faker::intArray(Faker::int())));
assertType('array<int|string, int|string>', Faker::union(Faker::intArray(Faker::int()), Faker::strArray(Faker::string())));
assertType('array<int|string>', Faker::union(Faker::array(Faker::int()), Faker::strArray(Faker::string())));
assertType('array<mixed>', Faker::union(Faker::array(), Faker::strArray()));
assertType('array<mixed>', Faker::union(Faker::array(), Faker::intArray()));
assertType('string|null', Faker::union(Faker::string(), null));
assertType("'bar'|'foo'", Faker::union('foo', 'bar'));
assertType('string', Faker::union('foo', Faker::string()));
assertType("'foo'|int", Faker::union('foo', Faker::int()));
assertType("array{'baz'}|array{foo: 'bar'}", Faker::union(['foo' => 'bar'], ['baz']));

// Intersections
assertType('lowercase-string', Faker::intersection(Faker::string(), Faker::lowercaseString()));
assertType("'foo'", Faker::intersection(Faker::string(), 'foo'));
assertType('lowercase-string&non-falsy-string', Faker::intersection(Faker::lowercaseString(), Faker::nonFalsyString()));

// Other
assertType('bool|float|int|string', Faker::scalar());
assertType('callable(): mixed', Faker::callable());
assertType('mixed', Faker::mixed());
assertType('object', Faker::object());
assertType('resource', Faker::resource());
assertType('stdClass', Faker::stdClass());

// WordPress
assertType('WP_Block', Faker::wpBlock());
assertType('WP_Comment', Faker::wpComment());
assertType('WP_Dependencies', Faker::wpDependencies());
assertType('WP_Error', Faker::wpError());
assertType('WP_Post', Faker::wpPost());
assertType('WP_Query', Faker::wpQuery());
assertType('WP_REST_Request', Faker::wpRestRequest());
assertType('WP_REST_Response', Faker::wpRestResponse());
assertType('WP_Scripts', Faker::wpScripts());
assertType('WP_Styles', Faker::wpStyles());
assertType('WP_Term', Faker::wpTerm());
assertType('WP_Theme', Faker::wpTheme());
assertType('WP_Translations', Faker::wpTranslations());
assertType('WP_User', Faker::wpUser());
assertType('WP_Widget_Factory', Faker::wpWidgetFactory());
assertType('wpdb', Faker::wpdb());
