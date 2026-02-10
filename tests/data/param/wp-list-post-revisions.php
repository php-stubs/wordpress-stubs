<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_list_post_revisions;

// Incorrect $type
wp_list_post_revisions(Faker::union(Faker::int(), Faker::wpPost()), 'foo');

// Maybe incorrect $type
wp_list_post_revisions(Faker::union(Faker::int(), Faker::wpPost()), Faker::string());

// Correct $type
wp_list_post_revisions(Faker::union(Faker::int(), Faker::wpPost()), 'all');
wp_list_post_revisions(Faker::union(Faker::int(), Faker::wpPost()), 'revision');
wp_list_post_revisions(Faker::union(Faker::int(), Faker::wpPost()), 'autosave');
