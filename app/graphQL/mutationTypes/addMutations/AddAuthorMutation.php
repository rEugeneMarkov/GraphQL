<?php

namespace App\GraphQL\MutationTypes\AddMutations;

use App\Models\Author;
use App\GraphQL\Types\AuthorType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class AddAuthorMutation extends ObjectType
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new AddAuthorMutation();
        }
        return self::$instance;
    }

    private function __construct()
    {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'addAuthor' => [
                    'type' => AuthorType::getInstance(),
                    'args' => [
                        'name' => ['type' => Type::nonNull(Type::string())],
                    ],
                    'resolve' => fn ($rootValue, $args) =>
                        Author::create(['name' => $args['name']]),
                ],
            ],
        ]);
    }
}
