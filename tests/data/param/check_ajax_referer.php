<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function check_ajax_referer;

// Incorrect action
check_ajax_referer(-1, Faker::string());
check_ajax_referer(Faker::int(), Faker::string());

// Correct action
check_ajax_referer(Faker::string(), Faker::string());
