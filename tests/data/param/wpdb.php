<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

$wpdb = Faker::wpdb();

/*
 * Correct usage of $wpdb->get_row()
 */

$row = $wpdb->get_row(null);
$row = $wpdb->get_row(null, 'OBJECT');
$row = $wpdb->get_row(null, 'ARRAY_N');
$row = $wpdb->get_row(null, 'ARRAY_A');
$row = $wpdb->get_row(null, 'OBJECT', 0);
$row = $wpdb->get_row(null, 'OBJECT', 7);
$row = $wpdb->get_row(null, 'OBJECT', Faker::nonNegativeInt());

/*
 * Incorrect usage of $wpdb->get_row()
 */

$row = $wpdb->get_row(null, 'OBJECT_K');
$row = $wpdb->get_row(null, Faker::string());
$row = $wpdb->get_row(null, Faker::int());
$row = $wpdb->get_row(null, 'OBJECT', -1);
$row = $wpdb->get_row(null, 'OBJECT', Faker::int());
