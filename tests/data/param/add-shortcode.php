<?php // phpcs:disable

declare(strict_types=1);

use PhpStubs\WordPress\Core\Tests\Faker;

$tag = Faker::nonEmptyString();

// Incorrect $tag
add_shortcode(1, Faker::callable());
add_shortcode('', Faker::callable());

// Maybe incorrect $tag
add_shortcode(Faker::string(), Faker::callable());

// Incorrect $callback
add_shortcode($tag, static function(): void {}); // Incorrect return type
add_shortcode($tag, static function(string $atts): string {return Faker::string();}); // Incorrect $atts type
add_shortcode($tag, static function(array $atts, string $content): string {return Faker::string();}); // Incorrect $content type (must accept null)
add_shortcode($tag, static function(array $atts, ?string $content, bool $tag): string {return Faker::string();}); // Incorrect $tag type
add_shortcode($tag, 'addShortcodeVoid'); // Incorrect callback return type
add_shortcode($tag, 'addShortcodeIntDoc'); // Incorrect callback return type

// Correct $tag
add_shortcode('0', Faker::callable()); // '0' is a valid tag
add_shortcode('tag', Faker::callable());
add_shortcode($tag, Faker::callable());

// Correct $callback
add_shortcode($tag, static function(): string {return '';});
add_shortcode($tag, static function(array $atts): string {return '';});
add_shortcode($tag, static function(array $atts, ?string $content): string {return '';});
add_shortcode($tag, static function(array $atts, ?string $content, string $tag): string {return '';});
add_shortcode($tag, 'addShortcodeStringDoc');

function addShortcodeVoid(): void {}
function addShortcodeString(): string {return Faker::string();}

/** @return int */
function addShortcodeIntDoc() {return Faker::int();}

/** @return string */
function addShortcodeStringDoc() {return Faker::string();}
