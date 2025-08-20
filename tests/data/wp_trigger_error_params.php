<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_trigger_error;

// Default type
wp_trigger_error(Faker::string(), Faker::string()); // correct

// Basic types
wp_trigger_error(Faker::string(), Faker::string(), Faker::int()); // incorrect
wp_trigger_error(Faker::string(), Faker::string(), Faker::string()); // incorrect

// Constant types
wp_trigger_error(Faker::string(), Faker::string(), \E_USER_ERROR); // correct
wp_trigger_error(Faker::string(), Faker::string(), \E_USER_WARNING); // correct
wp_trigger_error(Faker::string(), Faker::string(), \E_USER_NOTICE); // correct
wp_trigger_error(Faker::string(), Faker::string(), \E_USER_DEPRECATED); // correct
wp_trigger_error(Faker::string(), Faker::string(), \E_WARNING); // incorrect

// Constant types
wp_trigger_error(Faker::string(), Faker::string(), 256); // correct
wp_trigger_error(Faker::string(), Faker::string(), 512); // correct
wp_trigger_error(Faker::string(), Faker::string(), 1024); // correct
wp_trigger_error(Faker::string(), Faker::string(), 16384); // correct
wp_trigger_error(Faker::string(), Faker::string(), 2); // incorrect
wp_trigger_error(Faker::string(), Faker::string(), 0); // incorrect
