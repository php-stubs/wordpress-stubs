<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function _get_list_table;
use function PHPStan\Testing\assertType;

// Existing class, but not a WP_List_Table class
assertType('false', _get_list_table('WP_Post'));

assertType('false', _get_list_table('WP_List_Table'));

assertType('WP_Posts_List_Table', _get_list_table('WP_Posts_List_Table'));
assertType('WP_Media_List_Table', _get_list_table('WP_Media_List_Table'));
assertType('WP_Terms_List_Table', _get_list_table('WP_Terms_List_Table'));
assertType('WP_Users_List_Table', _get_list_table('WP_Users_List_Table'));
assertType('WP_Comments_List_Table', _get_list_table('WP_Comments_List_Table'));
assertType('WP_Post_Comments_List_Table', _get_list_table('WP_Post_Comments_List_Table'));
assertType('WP_Links_List_Table', _get_list_table('WP_Links_List_Table'));
assertType('WP_Plugin_Install_List_Table', _get_list_table('WP_Plugin_Install_List_Table'));
assertType('WP_Themes_List_Table', _get_list_table('WP_Themes_List_Table'));
assertType('WP_Theme_Install_List_Table', _get_list_table('WP_Theme_Install_List_Table'));
assertType('WP_Plugins_List_Table', _get_list_table('WP_Plugins_List_Table'));
assertType('WP_Application_Passwords_List_Table', _get_list_table('WP_Application_Passwords_List_Table'));
assertType('WP_MS_Sites_List_Table', _get_list_table('WP_MS_Sites_List_Table'));
assertType('WP_MS_Users_List_Table', _get_list_table('WP_MS_Users_List_Table'));
assertType('WP_MS_Themes_List_Table', _get_list_table('WP_MS_Themes_List_Table'));
assertType('WP_Privacy_Data_Export_Requests_List_Table', _get_list_table('WP_Privacy_Data_Export_Requests_List_Table'));
assertType('WP_Privacy_Data_Removal_Requests_List_Table', _get_list_table('WP_Privacy_Data_Removal_Requests_List_Table'));

$className = $_GET['className'] ?? '';

/** @var 'WP_Posts_List_Table'|'WP_Media_List_Table' $className */
assertType('WP_Media_List_Table|WP_Posts_List_Table', _get_list_table($className));

// WP_Theme_Install_List_Table is generalized to WP_Themes_List_Table
/** @var 'WP_Themes_List_Table'|'WP_Theme_Install_List_Table' $className */
assertType('WP_Themes_List_Table', _get_list_table($className));

// WP_Post_Comments_List_Table is generalized to WP_Comments_List_Table
/** @var 'WP_Comments_List_Table'|'WP_Post_Comments_List_Table' $className */
assertType('WP_Comments_List_Table', _get_list_table($className));

// fails with actual 'WP_Post|WP_Posts_List_Table|false'
/** @var 'WP_Posts_List_Table'|'WP_Post' $className */
assertType('WP_Posts_List_Table|false', _get_list_table($className));

// fails with acutal 'object|false'
assertType('WP_Application_Passwords_List_Table|WP_Comments_List_Table|WP_Links_List_Table|WP_Media_List_Table|WP_MS_Sites_List_Table|WP_MS_Themes_List_Table|WP_MS_Users_List_Table|WP_Plugin_Install_List_Table|WP_Plugins_List_Table|WP_Posts_List_Table|WP_Privacy_Data_Export_Requests_List_Table|WP_Privacy_Data_Removal_Requests_List_Table|WP_Terms_List_Table|WP_Themes_List_Table|WP_Users_List_Table|false', _get_list_table(Faker::classString()));
