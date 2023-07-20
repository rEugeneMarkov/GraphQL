<?php

namespace App\GraphQL\MutationTypes\UpdateMutations;

use App\Models\Book;
use App\GraphQL\Types\BookType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class UpdateBookMutation extends ObjectType
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new UpdateBookMutation();
        }
        return self::$instance;
    }

    private function __construct()
    {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'updateBook' => [
                    'type' => BookType::getInstance(),
                    'args' => [
                        'id' => ['type' => Type::nonNull(Type::int())],
                        'name' => ['type' => Type::nonNull(Type::string())],
                        'author_id' => ['type' => Type::nonNull(Type::int())],
                    ],
                    'resolve' => fn ($rootValue, $args) =>
                        Book::update(['id' => $args['id'], 'name' => $args['name'], 'author_id' => $args['author_id']]),
                ],
            ],
        ]);
    }
}
