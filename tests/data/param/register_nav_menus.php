<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function register_nav_menus;

// Incorrect
register_nav_menus(Faker::string());
register_nav_menus(Faker::intArray(Faker::string()));
register_nav_menus([0 => 'description']);
register_nav_menus([0 => 'description 1', 'location' => 'description 2']);

// Correct
register_nav_menus(); // default
register_nav_menus(Faker::array()); // explicit default
register_nav_menus(['location' => 'description']);
