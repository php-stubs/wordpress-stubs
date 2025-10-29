<?php

// phpcs:disable

declare(strict_types=1);

use PhpStubs\WordPress\Core\Tests\Faker;

$feedname = Faker::string();

function addFeedNotOkFirst(int $isCommentFeed): void {}
function addFeedNotOkSecond(bool $isCommentFeed, int $feed): void {}
function addFeedNotOkReturn(bool $isCommentFeed, string $feed): int {return Faker::int();}
function addFeedCorrect(bool $isCommentFeed, string $feed): void {}
function addFeedCorrectFirst(bool $isCommentFeed): void {}
function addFeedCorrectNoParams(): void {}

// Incorrect usages
add_feed($feedname, ''); // Not a callable
add_feed($feedname, static function (int $isCommentFeed): void {}); // Incorrect type for $isCommentFeed
add_feed($feedname, static function (bool $isCommentFeed, int $feed): void {}); // Incorrect type for $feed
add_feed($feedname, static function (bool $isCommentFeed, string $feed): int {return Faker::int();}); // Incorrect callback return type
add_feed($feedname, 'addFeedNotOkFirst'); // Incorrect type for $isCommentFeed
add_feed($feedname, 'addFeedNotOkSecond'); // Incorrect type for $feed
add_feed($feedname, 'addFeedNotOkReturn'); // Incorrect callback return type

// Correct usages
add_feed($feedname, static function (bool $isCommentFeed, string $feed): void {});
add_feed($feedname, static function (bool $isCommentFeed): void {});
add_feed($feedname, static function (): void {});
add_feed($feedname, 'addFeedCorrect');
add_feed($feedname, 'addFeedCorrectFirst');
add_feed($feedname, 'addFeedCorrectNoParams');
