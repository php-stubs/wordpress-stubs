<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function check_admin_referer;

// Incorrect action
check_admin_referer(-1, Faker::string());
check_admin_referer(Faker::int(), Faker::string());

// Correct action
check_admin_referer(Faker::string(), Faker::string());
