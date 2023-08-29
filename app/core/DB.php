<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

class DB
{
    private static ?PDO $db = null;

    public static function getInstance(): PDO
    {
        $host = $_ENV['DB_HOST'];
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];
        $dbname = $_ENV['DB_DATABASE'];
        $port = $_ENV['DB_PORT'];

        if (self::$db === null) {
            self::$db = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username, $password);
        }

        return self::$db;
    }
}
