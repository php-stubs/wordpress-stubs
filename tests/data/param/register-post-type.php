<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function register_post_type;

$empty = '';
$containsUppercases = 'PostType';

// Incorrect $post_type
register_post_type($empty, Faker::array());
register_post_type($containsUppercases, Faker::array());

// Maybe incorrect $post_type
register_post_type(Faker::nonEmptyString(), Faker::array());
register_post_type(Faker::nonFalsyString(), Faker::array());
register_post_type(Faker::lowercaseString(), Faker::array());
register_post_type(Faker::string(), Faker::array());

// Correct $post_type
register_post_type('post_type', Faker::array());
register_post_type(Faker::intersection(Faker::lowercaseString(), Faker::nonEmptyString()), Faker::array());
