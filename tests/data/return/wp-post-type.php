<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function PHPStan\Testing\assertType;

// Labels are built by get_post_type_labels(), which fills in every default.
assertType('string', Faker::wpPostType()->labels->name);
assertType('string', Faker::wpPostType()->labels->singular_name);
assertType('string', Faker::wpPostType()->labels->menu_name);
assertType('string', Faker::wpPostType()->labels->name_admin_bar);
assertType('string', Faker::wpPostType()->labels->item_link_description);

// Only used on hierarchical post types, where the default is null otherwise.
assertType('string|null', Faker::wpPostType()->labels->parent_item_colon);

// Capabilities are built by get_post_type_capabilities().
assertType('string', Faker::wpPostType()->cap->edit_post);
assertType('string', Faker::wpPostType()->cap->edit_posts);
assertType('string', Faker::wpPostType()->cap->create_posts);

// Only present when the post type is registered with 'map_meta_cap'.
assertType('string', Faker::wpPostType()->cap->edit_published_posts);
