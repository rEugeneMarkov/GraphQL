<?php

use App\Core\Environment;
use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

require_once dirname(__DIR__) . '/vendor/autoload.php';

Environment::init();

// uncomment if using phpunit tests

// function runMigrationAndSeeds()
// {
//     $app = new PhinxApplication();
//     $app->setAutoExit(false);
//     $app->run(new StringInput('migrate -e testing'), new NullOutput());
//     $app->run(new StringInput('seed:run -e testing'), new NullOutput());
// }

// function rollbackMigration()
// {
//     $app = new PhinxApplication();
//     $app->setAutoExit(false);
//     $app->run(new StringInput('rollback -e testing -t 0'), new NullOutput());
// }

// runMigrationAndSeeds();

// register_shutdown_function(function () {
//     rollbackMigration();
// });
