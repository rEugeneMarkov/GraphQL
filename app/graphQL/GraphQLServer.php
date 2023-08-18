<?php

namespace App\GraphQL;

use App\GraphQL\GraphQLSchema;
use GraphQL\Server\StandardServer;

class GraphQLServer extends StandardServer
{
    public function __construct(GraphQLSchema $graphQLSchema)
    {
        parent::__construct([
            'schema' => $graphQLSchema,
        ]);
    }
}
