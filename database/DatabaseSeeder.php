<?php

namespace Database;

use Database\Database;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

class DatabaseSeeder extends Database
{
    public static function seed(string $environment): void
    {
        self::init();
        self::$phinxApp->run(new StringInput('seed:run -e ' . $environment), new NullOutput());
    }
}
