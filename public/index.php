<?php

require_once '../vendor/autoload.php';

use App\Core\Environment;
use App\GraphQL\GraphQLServer;

Environment::init();

GraphQLServer::getInstance()->handleRequest();
