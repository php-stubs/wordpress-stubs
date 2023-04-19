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

// Unexpected output
assertType('WP_Comment|null', get_comment($comment, 'Hello'));

// Unknown output
assertType('array|WP_Comment|null', get_comment($comment, $_GET['foo']));

// Associative array output
assertType('array<string, mixed>|null', get_comment($comment, ARRAY_A));

// Numeric array output
assertType('array<int, mixed>|null', get_comment($comment, ARRAY_N));
