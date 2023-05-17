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
        'Anubis',
        'Bing',
        'Baidu',
        'Certspotter',
        'Duckduckgo',
        'Dnsdumpster',
        'Hackertarget',
        'CRTsh',
        'Qwant',
        'Otx',
        'Rapiddns',
        'Sublist3r',
        'Threatcrowd',
        'Urlscan',
        'Threatminer',
        'Omnisint',
    ],
];
