<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_register_ability;

// Incorrect $name
wp_register_ability('', Faker::array());
wp_register_ability('0', Faker::array());
wp_register_ability('Name', Faker::array());
wp_register_ability(Faker::nonEmptyString(), Faker::array());
wp_register_ability(Faker::intersection(Faker::lowercaseString(), Faker::nonEmptyString()), Faker::array());

// Maybe incorrect $name
wp_register_ability(Faker::string(), Faker::array());

// Correct $name
wp_register_ability('name', Faker::array());
wp_register_ability(Faker::intersection(Faker::lowercaseString(), Faker::nonFalsyString()), Faker::array());
