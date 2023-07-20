<?php

namespace App\GraphQL\MutationTypes\DeleteMutations;

use App\Models\Author;
use App\GraphQL\Types\AuthorType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class DeleteAuthorMutation extends ObjectType
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new DeleteAuthorMutation();
        }
        return self::$instance;
    }

    private function __construct()
    {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'deleteAuthor' => [
                    'type' => AuthorType::getInstance(),
                    'args' => [
                        'id' => ['type' => Type::nonNull(Type::int())],
                    ],
                    'resolve' => fn ($rootValue, $args) =>
                        Author::delete($args['id']),
                ],
            ],
        ]);
    }
}
