<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

class DB
{
    private static ?PDO $db = null;

    public static function getInstance(): PDO
    {
        $environment = $_ENV['APP_ENV'] ?? 'development';

        if ($environment === 'testing') {
            $host = $_ENV['DB_HOST_TEST'];
            $username = $_ENV['DB_USERNAME_TEST'];
            $password = $_ENV['DB_PASSWORD_TEST'];
            $dbname = $_ENV['DB_DATABASE_TEST'];
            $port = $_ENV['DB_PORT_TEST'];
        } else {
            $host = $_ENV['DB_HOST'];
            $username = $_ENV['DB_USERNAME'];
            $password = $_ENV['DB_PASSWORD'];
            $dbname = $_ENV['DB_DATABASE'];
            $port = $_ENV['DB_PORT'];
        }

        if (self::$db === null) {
            self::$db = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username, $password);
        }

        return self::$db;
    }
}
