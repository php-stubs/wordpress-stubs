<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function term_exists;
use function tag_exists;
use function PHPStan\Testing\assertType;

$termStr = Faker::string();
$termInt = Faker::int();
$termIntStr = Faker::union(Faker::int(), Faker::string());

// Term 0
assertType('0', term_exists(0));
assertType('0', term_exists(0, ''));
assertType('0', term_exists(0, 'category'));
assertType('0', term_exists(0, Faker::string()));

// tag_exists()
assertType('0', tag_exists(0));
assertType('null', tag_exists(''));
assertType('array{term_id: string, term_taxonomy_id: string}|null', tag_exists(123));
assertType('array{term_id: string, term_taxonomy_id: string}|null', tag_exists($termStr));
assertType('0|array{term_id: string, term_taxonomy_id: string}|null', tag_exists($termInt));
assertType('0|array{term_id: string, term_taxonomy_id: string}|null', tag_exists($termIntStr));
