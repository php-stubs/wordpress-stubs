<?php // phpcs:disable

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function register_widget;

// Incorrect
$noWidget = Faker::wpPost();
register_widget($noWidget);
register_widget(Faker::wpPost());
register_widget(Faker::classString(Faker::wpPost()));
register_widget('\NoWidget');

// Correct
$widget = Faker::wpWidget();
register_widget($widget);
register_widget(Faker::wpWidget());
register_widget(Faker::classString(Faker::wpWidget()));
register_widget('\WP_Widget');
