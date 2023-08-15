<?php

namespace App\GraphQL\MutationTypes\AddMutations;

use App\Models\Author;
use GraphQL\Error\UserError;
use App\Services\AuthService;
use App\GraphQL\Types\AuthorType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class AddAuthorMutation extends ObjectType
{
    private static ?self $instance = null;

    public static function getInstance(): AddAuthorMutation
    {
        if (is_null(self::$instance)) {
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
                    'resolve' => fn ($rootValue, $args): array => $this->resolveAddAuthor($args),
                ],
            ],
        ]);
    }

    private function resolveAddAuthor(array $args): array
    {
        try {
            AuthService::getInstance()->checkAuthentication();

            $author = Author::create($args);
            return $author->toArray();
        } catch (\Exception $e) {
            throw new UserError(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
