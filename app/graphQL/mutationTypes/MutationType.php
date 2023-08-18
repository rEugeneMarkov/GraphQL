<?php

namespace App\GraphQL\MutationTypes;

use GraphQL\Type\Definition\ObjectType;
use App\GraphQL\MutationTypes\BookMutations;
use App\GraphQL\MutationTypes\UserMutations;
use App\GraphQL\MutationTypes\AuthorMutations;

class MutationType extends ObjectType
{
    public function __construct(
        AuthorMutations $authorMutations,
        BookMutations $bookMutations,
        ReviewMutations $reviewMutations,
        UserMutations $userMutations,
    ) {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => fn() => [
                ...$authorMutations->config['fields'],
                ...$bookMutations->config['fields'],
                ...$reviewMutations->config['fields'],
                ...$userMutations->config['fields'],
            ],
        ]);
    }
}
