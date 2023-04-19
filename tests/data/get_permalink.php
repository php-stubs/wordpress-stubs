<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_permalink;
use function get_post_permalink;
use function get_the_permalink;
use function PHPStan\Testing\assertType;

/** @var \WP_Post $post */
$post = $post;

// get_permalink()
assertType('string|false', get_permalink());
assertType('string|false', get_permalink(1));
assertType('string|false', get_permalink($_GET['foo']));
assertType('string', get_permalink($post));

// get_the_permalink()
assertType('string|false', get_the_permalink());
assertType('string|false', get_the_permalink(1));
assertType('string|false', get_the_permalink($_GET['foo']));
assertType('string', get_the_permalink($post));

// get_post_permalink()
assertType('string|false', get_post_permalink());
assertType('string|false', get_post_permalink(1));
assertType('string|false', get_post_permalink($_GET['foo']));
assertType('string', get_post_permalink($post));
