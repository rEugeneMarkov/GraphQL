<?php

namespace App\GraphQL\MutationTypes\UpdateMutations;

use App\Models\Author;
use App\GraphQL\Types\AuthorType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class UpdateAuthorMutation extends ObjectType
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new UpdateAuthorMutation();
        }
        return self::$instance;
    }

    private function __construct()
    {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'updateAuthor' => [
                    'type' => AuthorType::getInstance(),
                    'args' => [
                        'id' => ['type' => Type::nonNull(Type::int())],
                        'name' => ['type' => Type::nonNull(Type::string())],
                    ],
                    'resolve' => fn ($rootValue, $args) =>
                        Author::update(['id' => $args['id'], 'name' => $args['name']]),
                ],
            ],
        ]);
    }
}
