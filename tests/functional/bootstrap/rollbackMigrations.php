<?php

require_once 'vendor/autoload.php';

use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

function rollbackMigration()
{
    $app = new PhinxApplication();
    $app->setAutoExit(false);
    $app->run(new StringInput('rollback -e testing -t 0'), new NullOutput());
}

rollbackMigration();
