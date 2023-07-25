<?php

namespace App\GraphQL;

use GraphQL\Server\StandardServer;

class GraphQLServer extends StandardServer
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new GraphQLServer();
        }
        return self::$instance;
    }

    public function __construct()
    {
        parent::__construct([
            'schema' => GraphQLSchema::getInstance(),
        ]);
    }
}
