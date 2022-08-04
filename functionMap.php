<?php

$httpReturnType = 'array{headers: \Requests_Utility_CaseInsensitiveDictionary, body: string, response: array{code: int,message: string}, cookies: array<int, \WP_HTTP_Cookie>, filename: string|null, http_response: \WP_HTTP_Requests_Response}|\WP_Error';
$cronArgsType = 'list<mixed>';

/**
 * This array is in the same format as the function map array in PHPStan:
 *
 * '<function_name>' => ['<return_type>', '<arg_name>'=>'<arg_type>']
 *
 * @link https://github.com/phpstan/phpstan-src/blob/1.5.x/resources/functionMap.php
 */
return [
    'add_meta_box' => ['void', 'context'=>'"normal"|"side"|"advanced"', 'priority'=>'"high"|"core"|"default"|"low"'],
    'addslashes_gpc' => ['T', '@phpstan-template'=>'T', 'gpc'=>'T'],
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
    'wp_next_scheduled' => ['int|false', 'args'=>$cronArgsType],
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
    'wp_unschedule_event' => ['bool|WP_Error', 'args'=>$cronArgsType],
    'wp_unslash' => ['T', '@phpstan-template'=>'T', 'value'=>'T'],
];
