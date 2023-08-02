<?php

use App\Core\Environment;

Environment::init();

return [
    'paths' => [
        'migrations' => 'database/migrations',
        'seeds' => 'database/seeders'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => $_ENV['DB_HOST'],
            'name' => $_ENV['DB_DATABASE'],
            'user' => $_ENV['DB_USERNAME'],
            'pass' => $_ENV['DB_PASSWORD'],
            'port' => $_ENV['DB_PORT'],
            'charset' => 'utf8'
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => $_ENV['DB_HOST_TEST'],
            'name' => $_ENV['DB_DATABASE_TEST'],
            'user' => $_ENV['DB_USERNAME_TEST'],
            'pass' => $_ENV['DB_PASSWORD_TEST'],
            'port' => $_ENV['DB_PORT_TEST'],
            'charset' => 'utf8'
        ]
    ],
    'version_order' => 'creation'
];
