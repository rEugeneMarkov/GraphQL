<?php

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
            'host' => 'mysql:3306',
            'name' => 'graph-ql-db',
            'user' => 'root',
            'pass' => 'root',
            'port' => 3306,
            'charset' => 'utf8'
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => 'test_mysql:3306',
            'name' => 'graph-ql-test-db',
            'user' => 'root',
            'pass' => 'root',
            'port' => 3306,
            'charset' => 'utf8'
        ],
    ],
    'version_order' => 'creation'
];
