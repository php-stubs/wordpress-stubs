<?php // phpcs:disable

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use WP_Widget;
use function register_widget;

class MyWidget extends WP_Widget {
    public function __construct(string $id_base, string $name)
    {
        parent::__construct($id_base, $name);
    }
}

class NoWidget {}

// Incorrect
$noWidget = new NoWidget();
register_widget($noWidget);
register_widget(new NoWidget());
register_widget(NoWidget::class);
register_widget('\PhpStubs\WordPress\Core\Tests\NoWidget');

// Correct
$widget = new MyWidget('my_widget', 'My Widget');
register_widget($widget);
register_widget(new MyWidget('my_widget', 'My Widget'));
register_widget(MyWidget::class);
register_widget('\PhpStubs\WordPress\Core\Tests\MyWidget');
