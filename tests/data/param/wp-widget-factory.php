<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

// Incorrect - not a WP_Widget subclass(-string)
Faker::wpWidgetFactory()->register(Faker::wpPost());
Faker::wpWidgetFactory()->register(Faker::classString(Faker::wpPost()));
Faker::wpWidgetFactory()->register('NoClassString');
Faker::wpWidgetFactory()->unregister(Faker::wpPost());
Faker::wpWidgetFactory()->unregister(Faker::classString(Faker::wpPost()));
Faker::wpWidgetFactory()->unregister('NoClassString');

// Correct
Faker::wpWidgetFactory()->register(Faker::wpWidget());
Faker::wpWidgetFactory()->register(Faker::classString(Faker::wpWidget()));
Faker::wpWidgetFactory()->unregister(Faker::wpWidget());
Faker::wpWidgetFactory()->unregister(Faker::classString(Faker::wpWidget()));
