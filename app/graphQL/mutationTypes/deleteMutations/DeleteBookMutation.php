<?php

namespace App\GraphQL\MutationTypes\DeleteMutations;

use App\Models\Book;
use GraphQL\Error\UserError;
use App\Services\AuthService;
use App\GraphQL\Types\BookType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class DeleteBookMutation extends ObjectType
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new DeleteBookMutation();
        }
        return self::$instance;
    }

    private function __construct()
    {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'deleteBook' => [
                    'type' => BookType::getInstance(),
                    'args' => [
                        'id' => ['type' => Type::nonNull(Type::int())],
                    ],
                    'resolve' => fn ($rootValue, $args) => $this->resolveDeleteBook($args),
                ],
            ],
        ]);
    }

    private function resolveDeleteBook(array $args): void
    {
        try {
            AuthService::getInstance()->checkAuthentication();

            $author = Book::find($args['id']);

            if (is_null($author)) {
                throw new \Exception("Book don't exists");
            }

            $author->delete($args['id']);
        } catch (\Exception $e) {
            throw new UserError(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
