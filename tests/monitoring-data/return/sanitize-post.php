<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use stdClass;

use function sanitize_post;
use function PHPStan\Testing\assertType;

assertType('WP_Post', sanitize_post(Faker::wpPost(), Faker::string()));
assertType('object', sanitize_post(Faker::object(), Faker::string()));
assertType('object', sanitize_post(new stdClass(), Faker::string()));
assertType('array', sanitize_post(Faker::array(), Faker::string()));
assertType('array', sanitize_post(Faker::strArray(), Faker::string()));
assertType('array', sanitize_post(Faker::intArray(), Faker::string()));
assertType('array', sanitize_post(Faker::array(Faker::string()), Faker::string()));

// Incorrect type of $post is returned as-is.
assertType("'foo'", sanitize_post('foo', Faker::string()));
assertType('123', sanitize_post(123, Faker::string()));
assertType('string', sanitize_post(Faker::string(), Faker::string()));
assertType('int', sanitize_post(Faker::int(), Faker::string()));
assertType('bool', sanitize_post(Faker::bool(), Faker::string()));
