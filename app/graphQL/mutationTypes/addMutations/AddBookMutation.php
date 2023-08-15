<?php

namespace App\GraphQL\MutationTypes\AddMutations;

use App\Models\Book;
use GraphQL\Error\UserError;
use App\Services\AuthService;
use App\GraphQL\Types\BookType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class AddBookMutation extends ObjectType
{
    private static ?self $instance = null;

    public static function getInstance(): AddBookMutation
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
                    'resolve' => fn ($rootValue, $args): array => $this->resolveAddBook($args),
                ],
            ],
        ]);
    }

    private function resolveAddBook(array $args): array
    {
        try {
            AuthService::getInstance()->checkAuthentication();

            return Book::create($args)->toArray();
        } catch (\Exception $e) {
            throw new UserError(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
