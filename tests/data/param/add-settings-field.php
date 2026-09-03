<?php // phpcs:disable

declare(strict_types=1);

use PhpStubs\WordPress\Core\Tests\Faker;

use function add_settings_field;

// $args unsealed
add_settings_field(Faker::string(), Faker::string(), Faker::callable(), Faker::string(), Faker::string(), ['label_for' => Faker::string(), 'class' => Faker::string(), 'foo' => Faker::mixed()]);
