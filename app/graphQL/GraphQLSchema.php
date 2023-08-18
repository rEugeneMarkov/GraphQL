<?php

namespace App\GraphQL;

use GraphQL\Type\Schema;
use App\GraphQL\Types\QueryType;
use App\GraphQL\MutationTypes\MutationType;

class GraphQLSchema extends Schema
{
    public function __construct(
        MutationType $mutationType,
        QueryType $queryType
    ) {
        parent::__construct([
            'query' => $queryType,
            'mutation' => $mutationType,
        ]);
    }
}
