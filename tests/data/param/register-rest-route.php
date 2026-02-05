<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function register_rest_route;

// Incorrect $route_namespace
register_rest_route('', Faker::nonFalsyString());
register_rest_route('0', Faker::nonFalsyString());

// Incorrect $route
register_rest_route(Faker::nonFalsyString(), '');
register_rest_route(Faker::nonFalsyString(), '0');

// Maybe incorrect $route_namespace, $route
register_rest_route(Faker::string(), Faker::nonFalsyString());
register_rest_route(Faker::nonFalsyString(), Faker::string());

// Correct
register_rest_route(Faker::nonFalsyString(), Faker::nonFalsyString());
register_rest_route(Faker::nonFalsyString(), Faker::nonFalsyString());
