<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function term_exists;
use function tag_exists;
use function PHPStan\Testing\assertType;

$term = $_GET['term'] ?? 123;
$taxo = $_GET['taxo'] ?? 'category';

// Empty taxonomy
assertType('string|null', term_exists(123));
assertType('string|null', term_exists(123, ''));
assertType('0|string|null', term_exists($term));
assertType('0|string|null', term_exists($term, ''));

// Fixed taxonomy string
assertType('array{term_id: string, term_taxonomy_id: string}|null', term_exists(123, 'category'));
assertType('0|array{term_id: string, term_taxonomy_id: string}|null', term_exists($term, 'category'));

// Unknown taxonomy type
assertType('array{term_id: string, term_taxonomy_id: string}|string|null', term_exists(123, $taxo));
assertType('0|array{term_id: string, term_taxonomy_id: string}|string|null', term_exists($term, $taxo));
assertType('null', term_exists('', $taxo));

// Term 0
assertType('0', term_exists(0));
assertType('0', term_exists(0, ''));
assertType('0', term_exists(0, 'category'));
assertType('0', term_exists(0, $taxo));

// Term empty string
assertType('null', term_exists(''));
assertType('null', term_exists('', ''));
assertType('null', term_exists('', 'category'));
assertType('null', term_exists('', $taxo));

// tag_exists()
assertType('array{term_id: string, term_taxonomy_id: string}|null', tag_exists(123));
assertType('0|array{term_id: string, term_taxonomy_id: string}|null', tag_exists($term));
assertType('0', tag_exists(0));
assertType('null', tag_exists(''));
