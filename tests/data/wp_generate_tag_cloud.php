<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_generate_tag_cloud;
use function PHPStan\Testing\assertType;

/** @var array<\WP_Term> $args */
$tags = $_GET['tags'];

// Default $args['format] value.
assertType('string', wp_generate_tag_cloud($tags));
assertType('string', wp_generate_tag_cloud($tags, []));

// Requesting array
assertType('array<int, string>', wp_generate_tag_cloud($tags, ['format' => 'array', 'key' => 'value']));

// Requesting string
assertType('string', wp_generate_tag_cloud($tags, ['format' => 'list', 'key' => 'value']));
assertType('string', wp_generate_tag_cloud($tags, ['format' => 'flat', 'key' => 'value']));

// Unexpected $args['format] value
assertType('string', wp_generate_tag_cloud($tags, ['format' => 'unexpected', 'key' => 'value']));

// Unknown $args['format] value
assertType('array<int, string>|string', wp_generate_tag_cloud($tags, ['format' => (string)$_GET['format'], 'key' => 'value']));
