<?php

use FastRoute\RouteCollector;
use App\GraphQL\GraphQLServer;

return function (RouteCollector $router) {
    $router->addRoute('GET', '/', function () {
        echo 'Hello, World! This is GraphQL server.';
    });

    $router->addRoute('POST', '/', function () {
        GraphQLServer::getInstance()->handleRequest();
    });
};
