<?php

namespace App\GraphQL;

use GraphQL\Type\Schema;
use App\GraphQL\Types\QueryType;
use App\GraphQL\MutationTypes\MutationType;

class GraphQLSchema extends Schema
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new GraphQLSchema();
        }
        return self::$instance;
    }

    public function __construct()
    {
        parent::__construct([
            'query' => QueryType::getInstance(),
            'mutation' => MutationType::getInstance(),
        ]);
    }
}
