<?php

namespace App\GraphQL\MutationTypes\DeleteMutations;

use App\Models\Author;
use GraphQL\Error\UserError;
use App\Services\AuthService;
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
                    'resolve' => fn ($rootValue, $args) => $this->resolveDeleteAuthor($args)
                ],
            ],
        ]);
    }

    private function resolveDeleteAuthor(array $args): void
    {
        try {
            AuthService::getInstance()->checkAuthentication();

            $author = Author::find($args['id']);

            if (is_null($author)) {
                throw new \Exception("Author don't exists");
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
