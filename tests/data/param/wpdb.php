<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

$wpdb = Faker::wpdb();

/*
 * Correct usage of $wpdb->get_row()
 */

$row = $wpdb->get_row(null, 'OBJECT', 0);
$row = $wpdb->get_row(null, 'OBJECT', 7);
$row = $wpdb->get_row(null, 'OBJECT', Faker::nonNegativeInt());

/*
 * Incorrect usage of $wpdb->get_row()
 */

$row = $wpdb->get_row(null, 'OBJECT', -1);
$row = $wpdb->get_row(null, 'OBJECT', Faker::int());
