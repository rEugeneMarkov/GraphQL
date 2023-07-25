<?php

require_once '../vendor/autoload.php';

use App\Core\Environment;
use App\Data\DataGenerator;
use App\Data\TablesMigration;
use App\GraphQL\GraphQLServer;

Environment::init();

$tablesMigrator = new TablesMigration();
$tablesMigrator->createTables();

$generator = new DataGenerator();
$generator->init();

GraphQLServer::getInstance()->handleRequest();
