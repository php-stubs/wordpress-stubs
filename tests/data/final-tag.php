<?php // phpcs:disable

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use WP_Widget;

class A extends WP_Widget
{
    // Has final tag
    /** @param array<mixed> $args */
    public function display_callback($args, $widget_args = 1): void
    {
    }

    // Has final tag
    public function form_callback($widget_args = 1)
    {
        return null;
    }

    // Has final tag
    public function update_callback($deprecated = 1): void
    {
    }

    // No final tag
    public function form($instance): void {
    }
}
