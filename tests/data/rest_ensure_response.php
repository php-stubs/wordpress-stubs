<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use WP_Error;
use WP_REST_Response;
use function PHPStan\Testing\assertType;

assertType('WP_Error', rest_ensure_response(new WP_Error()));
assertType('WP_REST_Response', rest_ensure_response([]));
assertType('WP_REST_Response', rest_ensure_response(new WP_REST_Response()));
