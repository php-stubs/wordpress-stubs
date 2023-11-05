<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_post_stati;
use function PHPStan\Testing\assertType;

$type = new TypeHelper();

// Default
assertType('array<string, string>', get_post_stati());
assertType('array<string, string>', get_post_stati($type->array));
assertType('array<string, string>', get_post_stati($type->array, 'names'));

// Objects
assertType('array<string, stdClass>', get_post_stati($type->array, 'objects'));

// Unexpected
assertType('array<string, stdClass>', get_post_stati($type->array, 'Hello'));

// Unknown
assertType('array<string, stdClass|string>', get_post_stati($type->array, $type->string));

// Unions
assertType('array<string, stdClass|string>', get_post_stati($type->array, $type::or('names', 'objects')));
assertType('array<string, stdClass|string>', get_post_stati($type->array, $type::stringOr('names')));
assertType('array<string, stdClass|string>', get_post_stati($type->array, $type::stringOr('objects')));
