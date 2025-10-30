<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_robots_max_image_preview_large;
use function wp_robots_no_robots;
use function wp_robots_noindex;
use function wp_robots_noindex_embeds;
use function wp_robots_noindex_search;
use function wp_robots_sensitive_page;

// Incorrect usages with array<string, int>
$incorrect = Faker::strArray(Faker::int());
$robots = wp_robots_max_image_preview_large($incorrect);
$robots = wp_robots_no_robots($incorrect);
$robots = wp_robots_noindex($incorrect);
$robots = wp_robots_noindex_embeds($incorrect);
$robots = wp_robots_noindex_search($incorrect);
$robots = wp_robots_sensitive_page($incorrect);

// Correct usages with array<string, string>
$correct = Faker::strArray(Faker::string());
$robots = wp_robots_max_image_preview_large($correct);
$robots = wp_robots_no_robots($correct);
$robots = wp_robots_noindex($correct);
$robots = wp_robots_noindex_embeds($correct);
$robots = wp_robots_noindex_search($correct);
$robots = wp_robots_sensitive_page($correct);
