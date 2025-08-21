<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function PHPStan\Testing\assertType;

/*
 * Check return type
 */

assertType('false', has_shortcode('', ''));
assertType('false', has_shortcode('', 'foo'));
assertType('false', has_shortcode('foo', ''));
assertType('bool', has_shortcode('foo', 'foo'));

assertType('false', has_shortcode('', ''));
assertType('false', has_shortcode('', Faker::string()));
assertType('false', has_shortcode(Faker::string(), ''));
assertType('bool', has_shortcode(Faker::string(), Faker::string()));

/*
 * Check argument type
 */

$content = Faker::string();
$tag = Faker::string();
if (has_shortcode($content, $tag)) {
    assertType('non-falsy-string', $content);
    assertType('non-empty-string', $tag);
}
assertType('string', $content);
assertType('string', $tag);

// Check that types are not generalized
$content = 'content';
$tag = 'tag';
if (has_shortcode($content, $tag)) {
    assertType("'content'", $content);
    assertType("'tag'", $tag);
}
