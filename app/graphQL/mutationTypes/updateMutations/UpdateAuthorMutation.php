<?php

namespace App\GraphQL\MutationTypes\UpdateMutations;

use App\Models\Author;
use GraphQL\Error\UserError;
use App\GraphQL\Types\AuthorType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use App\Services\AuthService;

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
                    'resolve' => fn ($rootValue, $args) => $this->resolveUpdateAuthor($args),
                ],
            ],
        ]);
    }

    private function resolveUpdateAuthor(array $args): Author
    {
        try {
            AuthService::getInstance()->checkAuthentication();

            return Author::update(['id' => $args['id'], 'name' => $args['name']]);
        } catch (\Exception $e) {
            throw new UserError(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
