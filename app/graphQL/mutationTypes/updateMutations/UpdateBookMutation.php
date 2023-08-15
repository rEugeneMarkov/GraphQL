<?php

namespace App\GraphQL\MutationTypes\UpdateMutations;

use App\Models\Book;
use GraphQL\Error\UserError;
use App\Services\AuthService;
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
                    'resolve' => fn ($rootValue, $args) => $this->resolveUpdateBook($args),
                ],
            ],
        ]);
    }

    private function resolveUpdateBook(array $args): Book
    {
        try {
            AuthService::getInstance()->checkAuthentication();

            return Book::update($args);
        } catch (\Exception $e) {
            throw new UserError(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
