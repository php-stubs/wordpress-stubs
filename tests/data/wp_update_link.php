<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_update_link;
use function PHPStan\Testing\assertType;

assertType('int<0, max>|WP_Error', wp_update_link([]));
assertType('int<0, max>|WP_Error', wp_update_link(['linkd_id' => 123]));
assertType('int<0, max>|WP_Error', wp_update_link(Faker::array()));
