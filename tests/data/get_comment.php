<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_comment;
use function PHPStan\Testing\assertType;

/** @var \WP_Comment|int $comment */
$comment = $comment;

// Default output
assertType('WP_Comment|null', get_comment());
assertType('WP_Comment|null', get_comment($comment));
assertType('WP_Comment|null', get_comment($comment, OBJECT));

// Associative array output
assertType('array<string, mixed>|null', get_comment($comment, ARRAY_A));

// Numeric array output
assertType('array<int, mixed>|null', get_comment($comment, ARRAY_N));

// Unknown output
assertType('array<int|string, mixed>|WP_Comment|null', get_comment($comment, (string)$_GET['unknown_string']));

// Unexpected output
assertType('WP_Comment|null', get_comment($comment, 'Hello'));
