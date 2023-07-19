<?php

require_once '../vendor/autoload.php';

use GraphQL\Type\Schema;
use App\Data\DataGenerator;
use App\Data\TablesMigration;
use App\GraphQL\Types\QueryType;
use GraphQL\Server\StandardServer;

$tablesMigrator = new TablesMigration();
$tablesMigrator->createTables();

$generator = new DataGenerator();
$generator->init();

$schema = new Schema([
    'query' => QueryType::getInstance(),
]);

$server = new StandardServer([
    'schema' => $schema,
]);

$server->handleRequest();
