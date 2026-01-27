<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

final class FinalTagTest extends IntegrationTest {
    public function test(): void
    {
        $this->analyse(
            __DIR__ . '/data/final-tag.php',
            [
                ['Method PhpStubs\WordPress\Core\Tests\A::display_callback() overrides @final method WP_Widget<array<string, mixed>>::display_callback().', 13],
               ['Method PhpStubs\WordPress\Core\Tests\A::form_callback() overrides @final method WP_Widget<array<string, mixed>>::form_callback().', 18],
                ['Method PhpStubs\WordPress\Core\Tests\A::update_callback() overrides @final method WP_Widget<array<string, mixed>>::update_callback().', 24],
            ]
        );
    }
}
