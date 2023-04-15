<?php

$httpReturnType = 'array{headers: \Requests_Utility_CaseInsensitiveDictionary, body: string, response: array{code: int,message: string}, cookies: array<int, \WP_HTTP_Cookie>, filename: string|null, http_response: \WP_HTTP_Requests_Response}|\WP_Error';
$cronArgsType = 'list<mixed>';
$registerPostTypeArgsType = 'array{label?: string, labels?: string[], description?: string, public?: bool, hierarchical?: bool, exclude_from_search?: bool, publicly_queryable?: bool, show_ui?: bool, show_in_menu?: bool|string, show_in_nav_menus?: bool, show_in_admin_bar?: bool, show_in_rest?: bool, rest_base?: string, rest_namespace?: string, rest_controller_class?: string, menu_position?: int, menu_icon?: string, capability_type?: string|array, capabilities?: string[], map_meta_cap?: bool, supports?: array, register_meta_box_cb?: callable, taxonomies?: string[], has_archive?: bool|string, rewrite?: bool|array{slug?: string, with_front?: bool, feeds?: bool, pages?: bool, ep_mask?: int}, query_var?: string|bool, can_export?: bool, delete_with_user?: bool, template?: array, template_lock?: string|false, _builtin?: bool, _edit_link?: string}';
$registerTaxonomyArgsType = 'array{labels?: string[], description?: string, public?: bool, publicly_queryable?: bool, hierarchical?: bool, show_ui?: bool, show_in_menu?: bool, show_in_nav_menus?: bool, show_in_rest?: bool, rest_base?: string, rest_namespace?: string, rest_controller_class?: string, show_tagcloud?: bool, show_in_quick_edit?: bool, show_admin_column?: bool, meta_box_cb?: bool|callable, meta_box_sanitize_cb?: callable, capabilities?: array{manage_terms?: string, edit_terms?: string, delete_terms?: string, assign_terms?: string}, rewrite?: bool|array{slug?: string, with_front?: bool, hierarchical?: bool, ep_mask?: int}, query_var?: string|bool, update_count_callback?: callable, default_term?: string|array{name?: string, slug?: string, description?: string}, sort?: bool, args?: array, _builtin?: bool}';
$wpWidgetRssFormArgsType = 'array{number: int, error: bool, title?: string, url?: string, items?: int, show_summary?: int, show_author?: int, show_date?: int}';
$wpWidgetRssFormInputType = 'array{title?: bool, url?: bool, items?: bool, show_summary?: bool, show_author?: bool, show_date?: bool}';

/**
 * This array is in the same format as the function map array in PHPStan:
 *
 * '<function_name>' => ['<return_type>', '<arg_name>'=>'<arg_type>']
 *
 * For classes:
 *
 * '<class_name>' => [null, '<arg_name>'=>'<arg_type>']
 *
 * @link https://github.com/phpstan/phpstan-src/blob/1.5.x/resources/functionMap.php
 */
return [
    'add_meta_box' => ['void', 'context'=>'"normal"|"side"|"advanced"', 'priority'=>'"high"|"core"|"default"|"low"'],
    'addslashes_gpc' => ['T', '@phpstan-template'=>'T', 'gpc'=>'T'],
    'get_objects_in_term' => ['string[]|WP_Error', 'args'=>'array{order?: string}'],
    'have_posts' => ['bool', '@phpstan-impure'=>''],
    'rawurlencode_deep' => ['T', '@phpstan-template'=>'T', 'value'=>'T'],
    'remove_meta_box' => ['void', 'context'=>'"normal"|"side"|"advanced"'],
    'sanitize_category' => ['T', '@phpstan-template'=>'T of array|object', 'category'=>'T'],
    'sanitize_post' => ['T', '@phpstan-template'=>'T of array|object', 'post'=>'T'],
    'sanitize_term' => ['T', '@phpstan-template'=>'T of array|object', 'term'=>'T'],
    'stripslashes_deep' => ['T', '@phpstan-template'=>'T', 'value'=>'T'],
    'urldecode_deep' => ['T', '@phpstan-template'=>'T', 'value'=>'T'],
    'urlencode_deep' => ['T', '@phpstan-template'=>'T', 'value'=>'T'],
    'wp_clear_scheduled_hook' => ['int|false|WP_Error', 'args'=>$cronArgsType],
    'wp_get_schedule' => ['string|false', 'args'=>$cronArgsType],
    'wp_get_scheduled_event' => ['object|false', 'args'=>$cronArgsType],
    'WP_Http::get' => [$httpReturnType],
    'WP_Http::head' => [$httpReturnType],
    'WP_Http::post' => [$httpReturnType],
    'WP_Http::request' => [$httpReturnType],
    'WP_List_Table::bulk_actions' => ['void', 'which'=>'"top"|"bottom"'],
    'WP_List_Table::display_tablenav' => ['void', 'which'=>'"top"|"bottom"'],
    'WP_List_Table::pagination' => ['void', 'which'=>'"top"|"bottom"'],
    'WP_List_Table::set_pagination_args' => ['void', 'args'=>'array{total_items?: int, total_pages?: int, per_page?: int}'],
    'wp_next_scheduled' => ['int|false', 'args'=>$cronArgsType],
    'WP_Post_Type::__construct' => ['void', 'args'=>$registerPostTypeArgsType],
    'WP_Query::have_posts' => ['bool', '@phpstan-impure'=>''],
    'wp_remote_get' => [$httpReturnType],
    'wp_remote_head' => [$httpReturnType],
    'wp_remote_post' => [$httpReturnType],
    'wp_remote_request' => [$httpReturnType],
    'wp_reschedule_event' => ['bool|WP_Error', 'args'=>$cronArgsType],
    'wp_safe_remote_get' => [$httpReturnType],
    'wp_safe_remote_head' => [$httpReturnType],
    'wp_safe_remote_post' => [$httpReturnType],
    'wp_safe_remote_request' => [$httpReturnType],
    'wp_schedule_event' => ['bool|WP_Error', 'args'=>$cronArgsType],
    'wp_schedule_single_event' => ['bool|WP_Error', 'args'=>$cronArgsType],
    'wp_slash' => ['T', '@phpstan-template'=>'T', 'value'=>'T'],
    'WP_Taxonomy::__construct' => ['void', 'args'=>$registerTaxonomyArgsType],
    'wp_unschedule_event' => ['bool|WP_Error', 'args'=>$cronArgsType],
    'wp_unslash' => ['T', '@phpstan-template'=>'T', 'value'=>'T'],
    'wp_widget_rss_form' => ['void', 'args'=>$wpWidgetRssFormArgsType, 'input'=>$wpWidgetRssFormInputType],
    'WP_REST_Request' => [null, '@phpstan-template'=>'T of array', '@phpstan-implements'=>'ArrayAccess<key-of<T>, value-of<T>>'],
    'WP_REST_Request::offsetExists' => ['bool', 'offset'=>'@param key-of<T>'],
    'WP_REST_Request::offsetGet' => ['T[TOffset]', '@phpstan-template'=>'TOffset of key-of<T>', 'offset'=>'TOffset'],
    'WP_REST_Request::offsetSet' => ['void', '@phpstan-template'=>'TOffset of key-of<T>', 'offset'=>'TOffset', 'value'=>'T[TOffset]'],
    'WP_REST_Request::offsetUnset' => ['void', '@phpstan-template'=>'TOffset of key-of<T>', 'offset'=>'TOffset'],
    'WP_Theme' => [null, '@phpstan-type'=>"ThemeKey 'Name'|'Version'|'Status'|'Title'|'Author'|'Author Name'|'Author URI'|'Description'|'Template'|'Stylesheet'|'Template Files'|'Stylesheet Files'|'Template Dir'|'Stylesheet Dir'|'Screenshot'|'Tags'|'Theme Root'|'Theme Root URI'|'Parent Theme'"],
    'WP_Theme::offsetExists' => ['($offset is ThemeKey ? true : false)'],
    'WP_Theme::offsetGet' => ['($offset is ThemeKey ? mixed : null)'],
    'WP_Block_List' => [null, '@phpstan-implements'=>'ArrayAccess<int, WP_Block>'],
    'WP_Block_List::offsetExists' => ['bool', 'index'=>'int'],
    'WP_Block_List::offsetGet' => ['WP_Block|null', 'index'=>'int'],
    'WP_Block_List::offsetSet' => ['void', 'index'=>'int|null'],
    'WP_Block_List::offsetUnset' => ['void', 'index'=>'int'],
    'is_wp_error' => ['bool', '@phpstan-assert-if-true'=>'\WP_Error $thing']
];
