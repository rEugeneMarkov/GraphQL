<?php

namespace App\Core;

use Dotenv\Dotenv;

class Environment
{
    public static function init()
    {
        $appEnvFromHeader = $_SERVER['HTTP_X_APP_ENV'] ?? null;

        if ($appEnvFromHeader !== null) {
            $_ENV['APP_ENV'] = $appEnvFromHeader;
        }

        $environment = $_ENV['APP_ENV'] ?? 'development';

        if ($environment === 'testing') {
            $dotenv = Dotenv::createImmutable('../', '.env.testing');
            $dotenv->load();
        } else {
            $dotenv = Dotenv::createImmutable('../');
            $dotenv->load();
        }
    }
}
