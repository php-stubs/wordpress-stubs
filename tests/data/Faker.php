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

// Other
assertType('resource', Faker::resource());
assertType('object', Faker::object());
assertType('stdClass', Faker::stdClass());
assertType('WP_Post', Faker::wpPost());
assertType('WP_Term', Faker::wpTerm());
assertType('WP_Comment', Faker::wpComment());
assertType('WP_REST_Request', Faker::wpRestRequest());
assertType('WP_Theme', Faker::wpTheme());
assertType('WP_Translations', Faker::wpTranslations());
assertType('WP_Query', Faker::wpQuery());
assertType('WP_Widget_Factory', Faker::wpWidgetFactory());
assertType('mixed', Faker::mixed());
