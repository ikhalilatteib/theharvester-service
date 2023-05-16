<?php

// config for Ikay/TheharvesterService
return [
    'model' => \App\Models\User::class,

    'layouts' => 'layouts.master',

    'guard' => 'web',
    'middleware' => ['web'],
    'auth_middleware' => 'auth',

    'dashboard' => '/',
    'log_model' => \App\Models\UserActivityLog::class,

    'theharvester_route' => 'tasks.theharvesters.*',
    'theharvester_index' => 'tasks.theharvesters.index',
];
