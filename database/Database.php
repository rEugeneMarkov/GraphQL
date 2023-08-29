<?php

namespace Database;

use Phinx\Console\PhinxApplication;

class Database
{
    protected static PhinxApplication $phinxApp;

    public static function init(): void
    {
        self::$phinxApp = new PhinxApplication();
        self::$phinxApp->setAutoExit(false);
    }
}
