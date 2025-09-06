<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function add_shortcode;

// Incorrect $tag
add_shortcode(1, Faker::callable());
add_shortcode('', Faker::callable());

// Maybe incorrect $tag
add_shortcode(Faker::string(), Faker::callable());

// Correct $tag
add_shortcode('0', Faker::callable()); // '0' is a valid tag
add_shortcode('tag', Faker::callable());
add_shortcode(Faker::nonEmptyString(), Faker::callable()); // '0' is a valid tag
add_shortcode(Faker::nonFalsyString(), Faker::callable());
