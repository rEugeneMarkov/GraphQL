<?php

use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

require_once dirname(__DIR__) . '/vendor/autoload.php';

function runMigration()
{
    $app = new PhinxApplication();
    $app->setAutoExit(false);
    $app->run(new StringInput('migrate -e testing'), new NullOutput());
    $app->run(new StringInput('seed:run -e testing'), new NullOutput());
}

function rollbackMigration()
{
    $app = new PhinxApplication();
    $app->setAutoExit(false);
    $app->run(new StringInput('rollback -e testing -t 0'), new NullOutput());
}

//runMigration();

// register_shutdown_function(function () {
//     rollbackMigration();
// });
