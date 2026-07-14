<?php

use Laravel\Jetstream\Http\Middleware\AuthenticateSession;

return [
    'stack' => 'livewire',
    'middleware' => ['web'],
    'auth_session' => AuthenticateSession::class,
    'features' => [
        'account_deletion',
        'profile_photos',
        'api',
        'teams' => false,
    ],
];
