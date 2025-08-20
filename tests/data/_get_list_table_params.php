<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function _get_list_table;

// Incorrect usage
_get_list_table('WP_Posts_List_Table', ['screen' => 123]); // incorrect
_get_list_table('WP_Posts_List_Table', ['screen' => Faker::int()]); // incorrect

// Correct usage
_get_list_table('WP_Posts_List_Table');
_get_list_table('WP_Posts_List_Table', []);
_get_list_table('WP_Posts_List_Table', ['notScreen' => Faker::string()]);
_get_list_table('WP_Posts_List_Table', ['screen' => 'foo']);
_get_list_table('WP_Posts_List_Table', ['screen' => Faker::string()]);
