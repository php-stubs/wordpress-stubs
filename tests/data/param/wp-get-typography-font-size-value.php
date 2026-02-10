<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_get_typography_font_size_value;

$preset = [
    'name' => 'name',
    'slug' => 'slug',
    'size' => 42,
];

// Incorrect $settings
wp_get_typography_font_size_value($preset, true);
wp_get_typography_font_size_value($preset, false);
wp_get_typography_font_size_value($preset, Faker::bool());

// Correct $settings
wp_get_typography_font_size_value($preset, Faker::array());
