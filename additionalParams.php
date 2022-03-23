<?php

$httpReturnType = 'array{headers:Requests_Utility_CaseInsensitiveDictionary,body:string,response:array{code:int,message:string},cookies:array<int,WP_HTTP_Cookie>,filename:string|null,http_response:WP_HTTP_Requests_Response}|WP_Error';

return [
    'wp_remote_get' => [$httpReturnType, 'url'=>'string', 'args'=>'array'],
    'wp_remote_head' => [$httpReturnType, 'url'=>'string', 'args'=>'array'],
    'wp_remote_post' => [$httpReturnType, 'url'=>'string', 'args'=>'array'],
    'wp_remote_request' => [$httpReturnType, 'url'=>'string', 'args'=>'array'],
];
