<?php

namespace App\GraphQL\MutationTypes\AddMutations;

use App\Models\Book;
use App\GraphQL\Types\BookType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class AddBookMutation extends ObjectType
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new AddBookMutation();
        }
        return self::$instance;
    }

    private function __construct()
    {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'addBook' => [
                    'type' => BookType::getInstance(),
                    'args' => [
                        'name' => ['type' => Type::nonNull(Type::string())],
                        'author_id' => ['type' => Type::nonNull(Type::int())],
                    ],
                    'resolve' => fn ($rootValue, $args) =>
                        Book::create(['name' => $args['name'], 'author_id' => $args['author_id']]),
                ],
            ],
        ]);
    }
}
