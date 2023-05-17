<?php

// config for Ikay/TheharvesterService
use App\Models\User;
use App\Models\UserActivityLog;

return [
    'model' => User::class,

    'layouts' => 'layouts.master',

    'guard' => 'web', 'middleware' => ['web'], 'auth_middleware' => 'auth',

    'dashboard' => '/', '
    log_model' => UserActivityLog::class,

    'theharvester_route' => '/tasks/theharvesters/*',
    'theharvester_index' => '/tasks/theharvesters',

    'sources' => [
        'anubis',
        'bing',
        'baidu',
        'certspotter',
        'duckduckgo',
        'dnsdumpster',
        'hackertarget',
        'qwant',
        'otx',
        'rapiddns',
        'urlscan',
        'threatminer',
    ],
];
