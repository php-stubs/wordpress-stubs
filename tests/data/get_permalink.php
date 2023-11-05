<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_permalink;
use function get_post_permalink;
use function get_the_permalink;
use function PHPStan\Testing\assertType;

$type = new TypeHelper();

// get_permalink()
assertType('string|false', get_permalink());
assertType('string|false', get_permalink($type->int));
assertType('string|false', get_permalink($type->intOrWpPost));
assertType('string', get_permalink($type->wpPost));

// get_the_permalink()
assertType('string|false', get_the_permalink());
assertType('string|false', get_the_permalink($type->int));
assertType('string|false', get_the_permalink($type->intOrWpPost));
assertType('string', get_the_permalink($type->wpPost));

// get_post_permalink()
assertType('string|false', get_post_permalink());
assertType('string|false', get_post_permalink($type->int));
assertType('string|false', get_post_permalink($type->intOrWpPost));
assertType('string', get_post_permalink($type->wpPost));
