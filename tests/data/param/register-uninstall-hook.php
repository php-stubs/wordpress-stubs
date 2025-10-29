<?php // phpcs:disable

declare(strict_types=1);

use PhpStubs\WordPress\Core\Tests\Faker;

$file = Faker::string();

// Incorrect $callback
register_uninstall_hook($file, static function (bool $incorrect): void {}); // Incorrect number of parameters
register_uninstall_hook($file, static function (): int {return Faker::int();}); // Incorrect return type

// Correct $callback
register_uninstall_hook($file, static function (): void {});
