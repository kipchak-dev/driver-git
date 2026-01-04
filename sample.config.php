<?php

use function Kipchak\Core\env;

return [
    'settings' => [
        'clone_dir' => '/tmp/kipchak-git'
    ],
    'repositories' => [
        'default' => [
            'origin' => '1x.ax/mamluk/kipchak/core.git', // Repositories are cloned over HTTPS. SSH is not supported due to security reasons.
            'username' => env('GIT_USERNAME', 'user'),
            'password' => env('GIT_PASSWORD', 'token'), // Or personal access token on most platforms
            'branch' => 'master' // Initial branch to checkout
        ],
        'starter' => [
            'origin' => '1x.ax/mamluk/kipchak/starter.git', // Repositories are cloned over HTTPS. SSH is not supported due to security reasons.
            'username' => env('GIT_USERNAME', 'user'),
            'password' => env('GIT_PASSWORD', 'token'), // Or personal access token on most platforms
            'branch' => 'master' // Initial branch to checkout
        ],
    ]
];
