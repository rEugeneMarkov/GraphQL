<?php

require_once 'vendor/autoload.php';

use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

function runMigrationAndSeeds()
{
    $app = new PhinxApplication();
    $app->setAutoExit(false);
    $app->run(new StringInput('migrate -e testing'), new NullOutput());
    $app->run(new StringInput('seed:run -e testing'), new NullOutput());
}

runMigrationAndSeeds();
