<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use stdClass;

use function absint;
use function PHPStan\Testing\assertType;

/** @var int<1, max> $posInt */
$posInt = $_GET['posInt'];

/** @var int<0, max> $nonNegInt */
$nonNegInt = $_GET['nonNegInt'];

/** @var resource $resource */
$resource = $_GET['resource'];

// Returns input for non-negative integers
assertType('0', absint(0));
assertType('1', absint(1));
assertType('10', absint(10));
assertType('int<1, max>', absint($posInt));
assertType('int<0, max>', absint($nonNegInt));

// Returns 0 for "empty" input
assertType('0', absint(null));
assertType('0', absint(false));
assertType('0', absint(0.0));
assertType('0', absint(''));
assertType('0', absint([]));
// and non-numeric string
assertType('0', absint('nonNumericString'));
assertType('0', absint(' '));

// Returns 1 for true and non-empty array
assertType('1', absint(true));
assertType('1', absint(['key' => 'value']));

// Returns 0 or 1 for booleans
assertType('0|1', absint((bool)$_GET['bool']));

// Returns positive integer for strictly negative integer input
assertType('int<1, max>', absint(-1));
assertType('int<1, max>', absint(-10));

// Returns non-negative integer for floats, numeric strings, ressources
assertType('int<0, max>', absint(1.0));
assertType('int<0, max>', absint('-10'));
assertType('int<0, max>', absint($resource));
// and any other type that is not a subtype of `$maybeint`
assertType('int<0, max>', absint(new stdClass()));
