<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_post_stati;
use function PHPStan\Testing\assertType;

// Default
assertType('array<string, string>', get_post_stati());
assertType('array<string, string>', get_post_stati([]));
assertType('array<string, string>', get_post_stati([], 'names'));

// Objects
assertType('array<string, stdClass>', get_post_stati([], 'objects'));

// Unexpected
assertType('array<string, stdClass>', get_post_stati([], 'Hello'));

// Unknown
assertType('array<string, stdClass|string>', get_post_stati([], (string)$_GET['string']));

// Unions
assertType('array<string, stdClass|string>', get_post_stati([], $_GET['foo'] ? 'names' : 'objects'));
assertType('array<string, stdClass|string>', get_post_stati([], $_GET['foo'] ? (string)$_GET['string'] : 'names'));
assertType('array<string, stdClass|string>', get_post_stati([], $_GET['foo'] ? (string)$_GET['string'] : 'objects'));
