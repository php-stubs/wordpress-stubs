<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_bookmark_field;
use function sanitize_bookmark_field;

/*
 * Incorrect usage of
 * - get_bookmark_field
 * - sanitize_bookmark_field
 */

get_bookmark_field('foo', Faker::int()); // incorrect field
get_bookmark_field('foo', Faker::int(), Faker::string()); // incorrect field
get_bookmark_field(Faker::int(), Faker::int(), Faker::string()); // incorrect field

// $context narrowed by Visitor - not part of testing yet
sanitize_bookmark_field('foo', Faker::mixed(), Faker::int(), 'raw'); // incorrect field & correct context
sanitize_bookmark_field(Faker::int(), Faker::mixed(), Faker::int(), 'raw'); // incorrect field & correct context

/*
 * Maybe incorrect usage of
 * - get_bookmark_field
 * - sanitize_bookmark_field
 */

get_bookmark_field(Faker::string(), Faker::int(), Faker::string()); // maybe incorrect field

sanitize_bookmark_field(Faker::string(), Faker::mixed(), Faker::int(), 'raw'); // maybe incorrect field & correct context

/*
 * Correct usage of
 * - get_bookmark_field
 * - sanitize_bookmark_field
 */

get_bookmark_field('link_id', Faker::int()); // correct field
get_bookmark_field('link_url', Faker::int()); // correct field
get_bookmark_field('link_name', Faker::int()); // correct field
get_bookmark_field('link_image', Faker::int()); // correct field
get_bookmark_field('link_target', Faker::int()); // correct field
get_bookmark_field('link_description', Faker::int()); // correct field
get_bookmark_field('link_visible', Faker::int()); // correct field
get_bookmark_field('link_owner', Faker::int()); // correct field
get_bookmark_field('link_rating', Faker::int()); // correct field
get_bookmark_field('link_updated', Faker::int()); // correct field
get_bookmark_field('link_rel', Faker::int()); // correct field
get_bookmark_field('link_notes', Faker::int()); // correct field
get_bookmark_field('link_rss', Faker::int()); // correct field
get_bookmark_field('link_category', Faker::int()); // correct field
get_bookmark_field('link_category', Faker::int(), Faker::string()); // correct field

sanitize_bookmark_field('link_id', Faker::mixed(), Faker::int(), 'raw'); // correct field & context
sanitize_bookmark_field('link_url', Faker::mixed(), Faker::int(), 'raw'); // correct field & context
sanitize_bookmark_field('link_name', Faker::mixed(), Faker::int(), 'raw'); // correct field & context
sanitize_bookmark_field('link_image', Faker::mixed(), Faker::int(), 'raw'); // correct field & context
sanitize_bookmark_field('link_target', Faker::mixed(), Faker::int(), 'raw'); // correct field & context
sanitize_bookmark_field('link_description', Faker::mixed(), Faker::int(), 'raw'); // correct field & context
sanitize_bookmark_field('link_visible', Faker::mixed(), Faker::int(), 'raw'); // correct field & context
sanitize_bookmark_field('link_owner', Faker::mixed(), Faker::int(), 'raw'); // correct field & context
sanitize_bookmark_field('link_rating', Faker::mixed(), Faker::int(), 'raw'); // correct field & context
sanitize_bookmark_field('link_updated', Faker::mixed(), Faker::int(), 'raw'); // correct field & context
sanitize_bookmark_field('link_rel', Faker::mixed(), Faker::int(), 'raw'); // correct field & context
sanitize_bookmark_field('link_notes', Faker::mixed(), Faker::int(), 'raw'); // correct field & context
sanitize_bookmark_field('link_rss', Faker::mixed(), Faker::int(), 'raw'); // correct field & context
sanitize_bookmark_field('link_category', Faker::mixed(), Faker::int(), 'raw'); // correct field & context
