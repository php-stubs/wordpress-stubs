<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_comment;
use function PHPStan\Testing\assertType;

/** @var \WP_Comment|int|string|null $comment */
$comment;

// Default output
assertType('WP_Comment|null', get_comment());
assertType('WP_Comment|null', get_comment($comment));
assertType('WP_Comment|null', get_comment($comment, 'OBJECT'));

// Associative array output
assertType('array<string, mixed>|null', get_comment($comment, 'ARRAY_A'));

// Numeric array output
assertType('array<int, mixed>|null', get_comment($comment, 'ARRAY_N'));

/** @var \WP_Comment $comment */
$comment;

assertType('WP_Comment', get_comment($comment));
assertType('WP_Comment', get_comment($comment, 'OBJECT'));
assertType('array<string, mixed>', get_comment($comment, 'ARRAY_A'));
assertType('array<int, mixed>', get_comment($comment, 'ARRAY_N'));
