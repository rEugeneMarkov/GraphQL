<?php

use FastRoute\RouteCollector;
use App\GraphQL\GraphQLServer;

return function (RouteCollector $router) use ($container) {
    $router->addRoute('GET', '/', function () {
        echo 'Hello, World! This is GraphQL server.';
    });

    $router->addRoute('POST', '/', function () use ($container) {
        $graphQLServer = $container->get(GraphQLServer::class);
        $graphQLServer->handleRequest();
    });
};
