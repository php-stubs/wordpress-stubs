<?php

$httpReturnType = 'array{headers:array,body:string,response:array{code:int,message:string},cookies:WP_HTTP_Cookie[],filename:string|null}|WP_Error';

return [
    'wp_remote_get' => [$httpReturnType, 'url'=>'string', 'args'=>'array'],
    'wp_remote_head' => [$httpReturnType, 'url'=>'string', 'args'=>'array'],
    'wp_remote_post' => [$httpReturnType, 'url'=>'string', 'args'=>'array'],
    'wp_remote_request' => [$httpReturnType, 'url'=>'string', 'args'=>'array'],
];
