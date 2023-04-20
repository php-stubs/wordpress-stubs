<?php

$caseInsensitiveDictionary = '\WpOrg\Requests\Utility\CaseInsensitiveDictionary';
if (file_exists(__DIR__ . '/source/wordpress/wp-includes/Requests/Cookie/Jar.php')) {
    $caseInsensitiveDictionary = '\Requests_Utility_CaseInsensitiveDictionary';
}

$httpReturnType = "array{headers: $caseInsensitiveDictionary, body: string, response: array{code: int,message: string}, cookies: array<int, \WP_HTTP_Cookie>, filename: string|null, http_response: \WP_HTTP_Requests_Response}|\WP_Error";
$cronArgsType = 'list<mixed>';
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
    'WP_Post_Type::__construct' => ['void', 'args'=>'array<string, mixed>'],
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
    'WP_Taxonomy::__construct' => ['void', 'args'=>'array<string, mixed>'],
    'wp_unschedule_event' => ['bool|WP_Error', 'args'=>$cronArgsType],
    'wp_unslash' => ['T', '@phpstan-template'=>'T', 'value'=>'T'],
    'wp_widget_rss_form' => ['void', 'args'=>$wpWidgetRssFormArgsType, 'input'=>$wpWidgetRssFormInputType],
    'WP_REST_Request' => [null, '@phpstan-template'=>'T of array', '@phpstan-implements'=>'ArrayAccess<key-of<T>, value-of<T>>'],
    'WP_REST_Request::offsetExists' => ['bool', 'offset'=>'@param key-of<T>'],
    'WP_REST_Request::offsetGet' => ['T[TOffset]', '@phpstan-template'=>'TOffset of key-of<T>', 'offset'=>'TOffset'],
    'WP_REST_Request::offsetSet' => ['void', '@phpstan-template'=>'TOffset of key-of<T>', 'offset'=>'TOffset', 'value'=>'T[TOffset]'],
    'WP_REST_Request::offsetUnset' => ['void', '@phpstan-template'=>'TOffset of key-of<T>', 'offset'=>'TOffset'],
    'WP_Theme' => [null, '@phpstan-type'=>"ThemeKey 'Name'|'Version'|'Status'|'Title'|'Author'|'Author Name'|'Author URI'|'Description'|'Template'|'Stylesheet'|'Template Files'|'Stylesheet Files'|'Template Dir'|'Stylesheet Dir'|'Screenshot'|'Tags'|'Theme Root'|'Theme Root URI'|'Parent Theme'"],
    'WP_Theme::get' => ["(\$header is 'Name'|'ThemeURI'|'Description'|'Author'|'AuthorURI'|'Version'|'Template'|'Status'|'Tags'|'TextDomain'|'DomainPath'|'RequiresWP'|'RequiresPHP'|'UpdateURI' ? (\$header is 'Tags' ? string[] : string) : false)"],
    'WP_Theme::offsetExists' => ['($offset is ThemeKey ? true : false)'],
    'WP_Theme::offsetGet' => ['($offset is ThemeKey ? mixed : null)'],
    'WP_Block_List' => [null, '@phpstan-implements'=>'ArrayAccess<int, WP_Block>'],
    'WP_Block_List::offsetExists' => ['bool', 'index'=>'int'],
    'WP_Block_List::offsetGet' => ['WP_Block|null', 'index'=>'int'],
    'WP_Block_List::offsetSet' => ['void', 'index'=>'int|null'],
    'WP_Block_List::offsetUnset' => ['void', 'index'=>'int'],
    'is_wp_error' => ['bool', '@phpstan-assert-if-true'=>'\WP_Error $thing'],
    'current_time' => ["(\$type is 'timestamp'|'U' ? int : string)"],
    'mysql2date' => ["(\$format is 'G'|'U' ? int|false : string|false)"],
    'get_post_types' => ["(\$output is 'names' ? array<int, string> : array<int, \WP_Post_Type>)"],
    'get_taxonomies' => ["(\$output is 'names' ? array<int, string> : array<int, \WP_Taxonomy>)"],
    'get_object_taxonomies' => ["(\$output is 'names' ? array<int, string> : array<string, \WP_Taxonomy>)"],
    'get_comment' => ["(\$output is 'ARRAY_A' ? array<string, mixed>|null : (\$output is 'ARRAY_N' ? array<int, mixed>|null : \WP_Comment|null))"],
    'get_post' => ["(\$output is 'ARRAY_A' ? array<string, mixed>|null : (\$output is 'ARRAY_N' ? array<int, mixed>|null : \WP_Post|null))"],
    'get_page_by_path' => ["(\$output is 'ARRAY_A' ? array<string, mixed>|null : (\$output is 'ARRAY_N' ? array<int, mixed>|null : \WP_Post|null))"],
    'has_action' => ['($callback is false ? bool : false|int)'],
    'has_filter' => ['($callback is false ? bool : false|int)'],
    'get_permalink' => ['($post is \WP_Post ? string : string|false)'],
    'get_the_permalink' => ['($post is \WP_Post ? string : string|false)'],
    'get_post_permalink' => ['($post is \WP_Post ? string : string|false)'],
    'term_exists' => ["(\$term is 0 ? 0 : (\$term is '' ? null : (\$taxonomy is '' ? string|null : array{term_id: string, term_taxonomy_id: string}|null)))"],
    'is_term' => ["(\$term is 0 ? 0 : (\$term is '' ? null : (\$taxonomy is '' ? string|null : array{term_id: string, term_taxonomy_id: string}|null)))"],
    'tag_exists' => ["(\$tag_name is 0 ? 0 : (\$tag_name is '' ? null : array{term_id: string, term_taxonomy_id: string}|null))"],
];
