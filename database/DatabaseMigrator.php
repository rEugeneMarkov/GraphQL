<?php

namespace DataBase;

use Database\Database;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

class DatabaseMigrator extends Database
{
    public static function migrate(string $environment): void
    {
        self::init();
        self::$phinxApp->run(new StringInput('migrate -e ' . $environment), new NullOutput());
    }

    public static function rollbackAllMigrations(string $environment): void
    {
        self::init();
        self::$phinxApp->run(new StringInput('rollback -e ' . $environment . ' -t 0'), new NullOutput());
    }
}
