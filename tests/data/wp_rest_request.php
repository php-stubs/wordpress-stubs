<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function PHPStan\Testing\assertType;

/**
 * @var \WP_REST_Request<array> $request
 */
$request = new WP_REST_Request();

assertType('mixed', $request->get_param('maybeParam'));

assertType('mixed', $request['maybeParam']);

assertType('array', $request->get_params());

assertType('bool', $request->has_param('maybeParam'));

/**
 * @var \WP_REST_Request<array{
 *      stringParam: string,
 *      intParam: int,
 *      boolParam: bool
 * }> $request
 */
$request = new WP_REST_Request();

assertType('string', $request->get_param('stringParam'));
assertType('int', $request->get_param('intParam'));
assertType('bool', $request->get_param('boolParam'));
assertType('null', $request->get_param('nonExistentParam'));

assertType('string', $request['stringParam']);
assertType('int', $request['intParam']);
assertType('bool', $request['boolParam']);
assertType('null', $request['nonExistentParam']);

assertType('array{stringParam: string, intParam: int, boolParam: bool}', $request->get_params());

assertType('bool', $request->has_param('stringParam'));
assertType('bool', $request->has_param('intParam'));
assertType('bool', $request->has_param('boolParam'));
assertType('bool', $request->has_param('nonExistentParam'));
