<?php // phpcs:disable

declare(strict_types=1);

use PhpStubs\WordPress\Core\Tests\Faker;

$file = Faker::string();

// Incorrect $callback
register_activation_hook($file, static function (string $incorrect): void {}); // Incorrect parameter type
register_activation_hook($file, static function (bool $correct): int {return Faker::int();}); // Incorrect return type

// Correct $callback
register_activation_hook($file, static function (): void {});
register_activation_hook($file, static function (bool $correct): void {});
