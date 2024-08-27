<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function _get_list_table;
use function PHPStan\Testing\assertType;

assertType('false', _get_list_table('Not_WP_List_Table'));

assertType('WP_List_Table', _get_list_table('WP_Posts_List_Table'));
assertType('WP_List_Table', _get_list_table('WP_Media_List_Table'));
assertType('WP_List_Table', _get_list_table('WP_Terms_List_Table'));
assertType('WP_List_Table', _get_list_table('WP_Users_List_Table'));
assertType('WP_List_Table', _get_list_table('WP_Comments_List_Table'));
assertType('WP_List_Table', _get_list_table('WP_Post_Comments_List_Table'));
assertType('WP_List_Table', _get_list_table('WP_Links_List_Table'));
assertType('WP_List_Table', _get_list_table('WP_Plugin_Install_List_Table'));
assertType('WP_List_Table', _get_list_table('WP_Themes_List_Table'));
assertType('WP_List_Table', _get_list_table('WP_Theme_Install_List_Table'));
assertType('WP_List_Table', _get_list_table('WP_Plugins_List_Table'));
assertType('WP_List_Table', _get_list_table('WP_Application_Passwords_List_Table'));
assertType('WP_List_Table', _get_list_table('WP_MS_Sites_List_Table'));
assertType('WP_List_Table', _get_list_table('WP_MS_Users_List_Table'));
assertType('WP_List_Table', _get_list_table('WP_MS_Themes_List_Table'));
assertType('WP_List_Table', _get_list_table('WP_Privacy_Data_Export_Requests_List_Table'));
assertType('WP_List_Table', _get_list_table('WP_Privacy_Data_Removal_Requests_List_Table'));
