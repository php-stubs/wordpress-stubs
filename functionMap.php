<?php

declare(strict_types=1);

$httpReturnType = 'array{headers: \WpOrg\Requests\Utility\CaseInsensitiveDictionary, body: string, response: array{code: int,message: string}, cookies: array<int, \WP_Http_Cookie>, filename: string|null, http_response: \WP_HTTP_Requests_Response}|\WP_Error';

if (file_exists(sprintf('%s/source/wordpress/wp-includes/Requests/Cookie/Jar.php', __DIR__))) {
    $httpReturnType = 'array{headers: \Requests_Utility_CaseInsensitiveDictionary, body: string, response: array{code: int,message: string}, cookies: array<int, \WP_Http_Cookie>, filename: string|null, http_response: \WP_HTTP_Requests_Response}|\WP_Error';
}
$cronArgsType = 'list<mixed>';
$wpWidgetRssFormArgsType = 'array{number: int, error: bool, title?: string, url?: string, items?: int, show_summary?: int, show_author?: int, show_date?: int}';
$wpWidgetRssFormInputsType = 'array{title?: bool, url?: bool, items?: bool, show_summary?: bool, show_author?: bool, show_date?: bool}';
$filesystemDirlistReturnType = "false|array<string, array{name: string, perms: string, permsn: string, owner: string|false, size: int|string|false, lastmodunix: int|string|false, lastmod: string|false, time: string|false, type: 'f'|'d'|'l', group: string|false, number: int|string|false, files?: array|false}>";

/**
 * This array is in the same format as the function map array in PHPStan:
 *
 * '<function_name>' => ['<return_type>', '<arg_name>' => '<arg_type>']
 *
 * For classes, or if you don't wish to define the `@phpstan-return` tag:
 *
 * '<class_name>' => [null, '<arg_name>' => '<arg_type>']
 *
 * For class methods:
 *
 * '<class_name::method_name>' => ['<return_type>', '<arg_name>' => '<arg_type>']
 *
 * For class properties:
 *
 * '<class_name::$property_name>' => [null, '@phpstan-var' => '<property_type>']
 *
 * @link https://github.com/phpstan/phpstan-src/blob/1.10.x/resources/functionMap.php
 */
return [
    'addslashes_gpc' => ['T', '@phpstan-template' => 'T', 'gpc' => 'T'],
    'add_submenu_page' => [null, 'callback' => "''|callable"],
    'have_posts' => [null, '@phpstan-impure' => ''],
    'rawurlencode_deep' => ['T', '@phpstan-template' => 'T', 'value' => 'T'],
    'sanitize_category' => ['T', '@phpstan-template' => 'T of array|object', 'category' => 'T'],
    'sanitize_post' => ['T', '@phpstan-template' => 'T of array|object', 'post' => 'T'],
    'sanitize_term' => ['T', '@phpstan-template' => 'T of array|object', 'term' => 'T'],
    'stripslashes_deep' => ['T', '@phpstan-template' => 'T', 'value' => 'T'],
    'urldecode_deep' => ['T', '@phpstan-template' => 'T', 'value' => 'T'],
    'urlencode_deep' => ['T', '@phpstan-template' => 'T', 'value' => 'T'],
    'wp_clear_scheduled_hook' => ['(0|positive-int|($wp_error is false ? false : \WP_Error))', 'args' => $cronArgsType],
    'wp_get_schedule' => [null, 'args' => $cronArgsType],
    'wp_get_scheduled_event' => [null, 'args' => $cronArgsType],
    'WP_Http::get' => [$httpReturnType],
    'WP_Http::head' => [$httpReturnType],
    'WP_Http::post' => [$httpReturnType],
    'WP_Http::request' => [$httpReturnType],
    'WP_List_Table::set_pagination_args' => ['void', 'args' => 'array{total_items?: int, total_pages?: int, per_page?: int}'],
    'wp_next_scheduled' => [null, 'args' => $cronArgsType],
    'WP_Query::have_posts' => [null, '@phpstan-impure' => ''],
    'wp_remote_get' => [$httpReturnType],
    'wp_remote_head' => [$httpReturnType],
    'wp_remote_post' => [$httpReturnType],
    'wp_remote_request' => [$httpReturnType],
    'wp_reschedule_event' => ['($wp_error is false ? bool : true|\WP_Error)', 'args' => $cronArgsType],
    'wp_safe_remote_get' => [$httpReturnType],
    'wp_safe_remote_head' => [$httpReturnType],
    'wp_safe_remote_post' => [$httpReturnType],
    'wp_safe_remote_request' => [$httpReturnType],
    'wp_schedule_event' => ['($wp_error is false ? bool : true|\WP_Error)', 'args' => $cronArgsType],
    'wp_schedule_single_event' => ['($wp_error is false ? bool : true|\WP_Error)', 'args' => $cronArgsType],
    'wp_slash' => ['T', '@phpstan-template' => 'T', 'value' => 'T'],
    'wp_unschedule_event' => ['($wp_error is false ? bool : true|\WP_Error)', 'args' => $cronArgsType],
    'wp_unslash' => ['T', '@phpstan-template' => 'T', 'value' => 'T'],
    'wp_widget_rss_form' => ['void', 'args' => $wpWidgetRssFormArgsType, 'inputs' => $wpWidgetRssFormInputsType],
    'rest_ensure_response' => ['($response is WP_Error ? WP_Error : WP_REST_Response)'],
    'WP_REST_Request' => [null, '@phpstan-template' => 'T of array', '@phpstan-implements' => 'ArrayAccess<key-of<T>, value-of<T>>'],
    'WP_REST_Request::offsetExists' => [null, 'offset' => 'key-of<T>'],
    'WP_REST_Request::offsetGet' => ['T[TOffset]|null', '@phpstan-template' => 'TOffset of key-of<T>', 'offset' => 'TOffset'],
    'WP_REST_Request::offsetSet' => ['void', '@phpstan-template' => 'TOffset of key-of<T>', 'offset' => 'TOffset', 'value' => 'T[TOffset]'],
    'WP_REST_Request::offsetUnset' => ['void', '@phpstan-template' => 'TOffset of key-of<T>', 'offset' => 'TOffset'],
    'WP_REST_Request::get_param' => ['T[TOffset]|null', '@phpstan-template' => 'TOffset of key-of<T>', 'key' => 'TOffset'],
    'WP_REST_Request::get_params' => ['T'],
    'WP_REST_Request::set_param' => ['void', '@phpstan-template' => 'TOffset of key-of<T>', 'key' => 'TOffset', 'value' => 'T[TOffset]'],
    'WP_REST_Request::has_param' => [null, 'key' => 'key-of<T>'],
    'WP_Theme' => [null, '@phpstan-type' => "ThemeKey 'Name'|'Version'|'Status'|'Title'|'Author'|'Author Name'|'Author URI'|'Description'|'Template'|'Stylesheet'|'Template Files'|'Stylesheet Files'|'Template Dir'|'Stylesheet Dir'|'Screenshot'|'Tags'|'Theme Root'|'Theme Root URI'|'Parent Theme'"],
    'WP_Theme::get' => ["(\$header is 'Name'|'ThemeURI'|'Description'|'Author'|'AuthorURI'|'Version'|'Template'|'Status'|'Tags'|'TextDomain'|'DomainPath'|'RequiresWP'|'RequiresPHP'|'UpdateURI' ? (\$header is 'Tags' ? string[] : string) : false)"],
    'WP_Theme::offsetExists' => ['($offset is ThemeKey ? true : false)'],
    'WP_Theme::offsetGet' => ['($offset is ThemeKey ? mixed : null)'],
    'WP_Block_List' => [null, '@phpstan-implements' => 'ArrayAccess<int, WP_Block>'],
    'WP_Block_List::offsetExists' => [null, 'offset' => 'int'],
    'WP_Block_List::offsetGet' => ['WP_Block|null', 'offset' => 'int'],
    'WP_Block_List::offsetSet' => ['void', 'offset' => 'int|null'],
    'WP_Block_List::offsetUnset' => ['void', 'offset' => 'int'],
    'is_wp_error' => ['($thing is \WP_Error ? true : false)', '@phpstan-assert-if-true' => '\WP_Error $thing'],
    'current_time' => ["(\$type is 'timestamp'|'U' ? int : string)"],
    'mysql2date' => ["(\$format is 'G'|'U' ? int|false : string|false)"],
    'get_post_types' => ["(\$output is 'names' ? array<string, string> : array<string, \WP_Post_Type>)"],
    'get_taxonomies' => ["(\$output is 'names' ? array<int, string> : array<int, \WP_Taxonomy>)"],
    'get_object_taxonomies' => ["(\$output is 'names' ? array<int, string> : array<string, \WP_Taxonomy>)"],
    'get_attachment_taxonomies' => ["(\$output is 'names' ? array<int, string> : array<string, \WP_Taxonomy>)"],
    'get_taxonomies_for_attachments' => ["(\$output is 'names' ? array<int, string> : array<string, \WP_Taxonomy>)"],
    'get_post_stati' => ["(\$output is 'names' ? array<string, string> : array<string, \stdClass>)"],
    'get_comment' => ["(\$comment is \WP_Comment ? array<array-key, mixed>|\WP_Comment : array<array-key, mixed>|\WP_Comment|null) & (\$output is 'ARRAY_A' ? array<string, mixed>|null : (\$output is 'ARRAY_N' ? array<int, mixed>|null : \WP_Comment|null))", 'output' => "'OBJECT'|'ARRAY_A'|'ARRAY_N'"],
    'get_post' => ["(\$post is \WP_Post ? array<array-key, mixed>|\WP_Post : array<array-key, mixed>|\WP_Post|null) & (\$output is 'ARRAY_A' ? array<string, mixed>|null : (\$output is 'ARRAY_N' ? array<int, mixed>|null : \WP_Post|null))", 'output' => "'OBJECT'|'ARRAY_A'|'ARRAY_N'" ],
    'get_term_by' => ["(\$output is 'ARRAY_A' ? array<string, string|int>|\WP_Error|false : (\$output is 'ARRAY_N' ? list<string|int>|\WP_Error|false : \WP_Term|\WP_Error|false))"],
    'get_page_by_path' => ["(\$output is 'ARRAY_A' ? array<string, mixed>|null : (\$output is 'ARRAY_N' ? array<int, mixed>|null : \WP_Post|null))"],
    'get_term' => ["(\$output is 'ARRAY_A' ? array<string, string|int>|\WP_Error|null : (\$output is 'ARRAY_N' ? list<string|int>|\WP_Error|null : \WP_Term|\WP_Error|null))", 'output' => "'OBJECT'|'ARRAY_A'|'ARRAY_N'"],
    'has_action' => ['($callback is false ? bool : false|int)'],
    'has_filter' => ['($callback is false ? bool : false|int)'],
    'get_permalink' => ['($post is \WP_Post ? string : string|false)'],
    'get_the_permalink' => ['($post is \WP_Post ? string : string|false)'],
    'get_post_permalink' => ['($post is \WP_Post ? string : string|false)'],
    'term_exists' => ["(\$term is 0 ? 0 : (\$term is '' ? null : (\$taxonomy is '' ? string|null : array{term_id: string, term_taxonomy_id: string}|null)))"],
    'is_term' => ["(\$term is 0 ? 0 : (\$term is '' ? null : (\$taxonomy is '' ? string|null : array{term_id: string, term_taxonomy_id: string}|null)))"],
    'tag_exists' => ["(\$tag_name is 0 ? 0 : (\$tag_name is '' ? null : array{term_id: string, term_taxonomy_id: string}|null))"],
    'wp_insert_link' => ['($wp_error is false ? 0|positive-int : positive-int|\WP_Error)'],
    'wp_insert_category' => ['($wp_error is false ? 0|positive-int : positive-int|\WP_Error)'],
    'wp_insert_post' => ['($wp_error is false ? 0|positive-int : positive-int|\WP_Error)'],
    'wp_insert_attachment' => ['($wp_error is false ? 0|positive-int : positive-int|\WP_Error)'],
    'wp_update_post' => ['($wp_error is false ? 0|positive-int : positive-int|\WP_Error)'],
    'wp_unschedule_hook' => ['($wp_error is false ? 0|positive-int|false : 0|positive-int|\WP_Error)'],
    'wp_update_comment' => ['($wp_error is false ? 0|1|false : 0|1|\WP_Error)'],
    'wp_set_comment_status' => ['($wp_error is false ? bool : true|\WP_Error)'],
    'comment_class' => ['($display is true ? void : string)'],
    'edit_term_link' => ['($display is true ? void : string|void)'],
    'get_calendar' => ['($display is true ? void : string)'],
    'next_posts' => ['($display is true ? void : string)'],
    'post_type_archive_title' => ['($display is true ? void : string|void)'],
    'previous_posts' => ['($display is true ? void : string)'],
    'single_term_title' => ['($display is true ? void : string|void)'],
    'single_cat_title' => ['($display is true ? void : string|void)'],
    'single_month_title' => ['($display is true ? false|void : false|string)'],
    'single_post_title' => ['($display is true ? void : string|void)'],
    'single_tag_title' => ['($display is true ? void : string|void)'],
    'the_date' => ['($display is true ? void : string)'],
    'the_modified_date' => ['($display is true ? void : string)'],
    'the_title' => ['($display is true ? void : string|void)'],
    'wp_debug_backtrace_summary' => ['($pretty is true ? string : list<string>)'],
    'wp_loginout' => ['($display is true ? void : string)'],
    'wp_register' => ['($display is true ? void : string)'],
    'wp_title' => ['($display is true ? void : string)'],
    'WP_Filesystem_Direct::dirlist' => [$filesystemDirlistReturnType],
    'WP_Filesystem_FTPext::dirlist' => [$filesystemDirlistReturnType],
    'WP_Filesystem_Base::dirlist' => [$filesystemDirlistReturnType],
    'WP_Filesystem_SSH2::dirlist' => [$filesystemDirlistReturnType],
    'WP_Filesystem_ftpsockets::dirlist' => [$filesystemDirlistReturnType],
    'wpdb::prepare' => [null, 'query' => 'literal-string'],
    'wpdb::get_row' => ["null|void|(\$output is 'ARRAY_A' ? array<array-key, mixed> : (\$output is 'ARRAY_N' ? list<mixed> : \stdClass))", 'output' => "'OBJECT'|'ARRAY_A'|'ARRAY_N'", 'y' => '0|positive-int'],
    'wpdb::get_results' => ["null|(\$output is 'ARRAY_A' ? list<array<array-key, mixed>> : (\$output is 'ARRAY_N' ? list<array<int, mixed>> : (\$output is 'OBJECT_K' ? array<array-key, \stdClass> : list<\stdClass>)))", 'output' => "'OBJECT'|'OBJECT_K'|'ARRAY_A'|'ARRAY_N'"],
    'get_bookmark' => ["null|(\$output is 'ARRAY_A' ? array<string, mixed> : (\$output is 'ARRAY_N' ? array<int, mixed> : \stdClass))", 'output' => "'OBJECT'|'ARRAY_A'|'ARRAY_N'"],
    'get_category' => ["(\$category is object ? array<array-key, mixed>|\WP_Term : array<array-key, mixed>|\WP_Term|\WP_Error|null) & (\$output is 'ARRAY_A' ? array<string, mixed>|\WP_Error|null : (\$output is 'ARRAY_N' ? array<int, mixed>|\WP_Error|null : \WP_Term|\WP_Error|null))", 'output' => "'OBJECT'|'ARRAY_A'|'ARRAY_N'"],
    'get_category_by_path' => ["(\$output is 'ARRAY_A' ? array<string, mixed>|\WP_Error|null : (\$output is 'ARRAY_N' ? array<int, mixed>|\WP_Error|null : \WP_Term|\WP_Error|null))", 'output' => "'OBJECT'|'ARRAY_A'|'ARRAY_N'"],
    'WP_Widget' => [null, '@phpstan-template' => 'T of array<string, mixed>'],
    'WP_Widget::form' => [null, 'instance' => 'T'],
    'WP_Widget::update' => [null, 'new_instance' => 'T', 'old_instance' => 'T'],
    'WP_Widget::widget' => [null, 'instance' => 'T', 'args' => 'array{name:string,id:string,description:string,class:string,before_widget:string,after_widget:string,before_title:string,after_title:string,before_sidebar:string,after_sidebar:string,show_in_rest:boolean,widget_id:string,widget_name:string}'],
];
