<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

// Incorrect $hook_name
do_action('', Faker::mixed());
do_action_ref_array('', []);
do_action_deprecated('', [], '');

// Maybe incorrect $hook_name
do_action(Faker::string(), Faker::mixed());
do_action_ref_array(Faker::string(), []);
do_action_deprecated(Faker::string(), [], '');

// Correct $hook_name
do_action(Faker::nonEmptyString(), Faker::mixed());
do_action_ref_array(Faker::nonFalsyString(), []);
do_action_deprecated('hook_name', [], '');
