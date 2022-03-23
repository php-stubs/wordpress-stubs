<?php

$httpReturnType = 'array{headers:Requests_Utility_CaseInsensitiveDictionary,body:string,response:array{code:int,message:string},cookies:array<int,WP_HTTP_Cookie>,filename:string|null,http_response:WP_HTTP_Requests_Response}|WP_Error';

return [
    'wp_remote_get' => [$httpReturnType],
    'wp_remote_head' => [$httpReturnType],
    'wp_remote_post' => [$httpReturnType],
    'wp_remote_request' => [$httpReturnType],
    'wp_safe_remote_get' => [$httpReturnType],
    'wp_safe_remote_head' => [$httpReturnType],
    'wp_safe_remote_post' => [$httpReturnType],
    'wp_safe_remote_request' => [$httpReturnType],
];
