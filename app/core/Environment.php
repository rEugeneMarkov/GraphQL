<?php

namespace App\Core;

use Dotenv\Dotenv;

class Environment
{
    public static function init()
    {
        $environment = $_ENV['APP_ENV'] ?? 'development';

        if ($environment === 'testing') {
            $dotenv = Dotenv::createImmutable(dirname(dirname(__DIR__)), '.env.testing');
            $dotenv->load();
        } else {
            $dotenv = Dotenv::createImmutable(dirname(dirname(__DIR__)));
            $dotenv->load();
        }
    }
}
