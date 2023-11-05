<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_post;
use function PHPStan\Testing\assertType;

$type = new TypeHelper();

assertType('WP_Post|null', get_post());
assertType('WP_Post|null', get_post($type::addNull($type->$intOrWpPost)));
assertType('WP_Post|null', get_post($type::addNull($type->$intOrWpPost), 'OBJECT'));
assertType('array<string, mixed>|null', get_post($type::addNull($type->$intOrWpPost), 'ARRAY_A'));
assertType('array<int, mixed>|null', get_post($type::addNull($type->$intOrWpPost), 'ARRAY_N'));

assertType('WP_Post', get_post($type->wpPost));
assertType('WP_Post', get_post($type->wpPost, 'OBJECT'));
assertType('array<string, mixed>', get_post($type->wpPost, 'ARRAY_A'));
assertType('array<int, mixed>', get_post($type->wpPost, 'ARRAY_N'));
