<?php

require_once 'vendor/autoload.php';

use App\Type\QueryType;
use GraphQL\Type\Schema;
use GraphQL\Server\StandardServer;

$schema = new Schema([
    'query' => QueryType::getInstance(),
]);

$server = new StandardServer([
    'schema' => $schema,
]);

$server->handleRequest();
