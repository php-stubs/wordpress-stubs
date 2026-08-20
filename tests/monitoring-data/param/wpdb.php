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

/*
 * Incorrect usage of $wpdb->get_row()
 */

$row = $wpdb->get_row(null, 'OBJECT_K');
$row = $wpdb->get_row(null, Faker::string());
$row = $wpdb->get_row(null, Faker::int());
