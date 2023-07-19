<?php

namespace App\Core;

class DB
{
    private static $db = null;

    public static function getInstance()
    {
        if (self::$db === null) {
            self::$db = new \PDO("mysql:host=mysql:3306;dbname=graph-ql-db", 'root', 'root');
        }

        return self::$db;
    }
}
