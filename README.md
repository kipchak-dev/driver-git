# Git Driver for Kipchak

This driver is based on the  CZGit PHP library.

It supports multiple Git repository connections.

#### Composer Package

`kipchak/driver-git`

#### Sample Config File:

This config file should be placed in your Kipchak project's config directory, as in the examples
project at https://github.com/kipchak-dev/examples/blob/master/config/kipchak.git.php.

The config file should look like this (also avalable in sample.config.php):

```
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

```

## How to use it?

Install it via composer: `composer require kipchak/driver-git`.

### Example Usage

```php
// Initialise the driver in drivers/drivers.php
\Mamluk\Kipchak\Driver\Git\Git::iniitalise($container);

// Load the Git driver.
$git = Kipchak\Driver\Git\Git::get('default'); // default is the repository name in the config file.
// Use the $git client as you would the GitRepository class in the CzGit client.
```

## Detailed Documentation

https://kipchak.dev/docs/driver-git

## What is a Kipchak Driver?

Kipchak Drivers are used to connect Kipchak to various data sources or storage systems.

They provide a standardized interface for interacting with different data sources, allowing developers to
focus on building their applications rather than dealing with the complexities of each data source.

Drivers were introduced as a part of the Kipchak 2.0 release.

Drivers are basically Container Dependencies injected into Kipchak's Service Container.

## How do Kipchak Drivers work?

Some Kipchak drivers are wired into the Service Container via a config file (where required).

If applicable, you will find a sample config file in this repository as well as in the starter project at https://1x.ax/mamluk/kipchak/starter.

Each driver defines an implementation of Kipchak's Driver Interface. Where applicable, the dependency may
accept a parameter for a specific instance of the driver specified as a config property, for instance, in the case
of multiple database connections or S3 buckets.

So you may access the driver by invoking \Mamluk\Kipchak\Driver\Memcached\Memcached::get('cache'), where
`cache` is the name of one of the memcached connection pools specified in the config file.