<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_post_ancestors;
use function PHPStan\Testing\assertType;

assertType('list<int>', get_post_ancestors(123));
assertType('list<int>', get_post_ancestors(Faker::int()));
assertType('list<int>', get_post_ancestors(Faker::wpPost()));
