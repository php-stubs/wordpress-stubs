<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

// Incorrect $hook_name
apply_filters('', Faker::mixed(), Faker::mixed());
apply_filters_ref_array('', []);
apply_filters_deprecated('', [], '');

// Maybe incorrect $hook_name
apply_filters(Faker::string(), Faker::mixed(), Faker::mixed());
apply_filters_ref_array(Faker::string(), []);
apply_filters_deprecated(Faker::string(), [], '');

// Correct $hook_name
apply_filters(Faker::nonEmptyString(), Faker::mixed());
apply_filters_ref_array(Faker::nonFalsyString(), []);
apply_filters_deprecated('hook_name', [], '');
