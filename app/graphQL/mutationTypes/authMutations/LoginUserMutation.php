<?php

namespace App\GraphQL\MutationTypes\AuthMutations;

use GraphQL\Error\UserError;
use App\Services\AuthService;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class LoginUserMutation extends ObjectType
{
    private static ?self $instance = null;

    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new LoginUserMutation();
        }
        return self::$instance;
    }

    private function __construct()
    {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'loginUser' => [
                    'type' => Type::string(),
                    'args' => [
                        'email' => ['type' => Type::nonNull(Type::string())],
                        'password' => ['type' => Type::nonNull(Type::string())],
                    ],
                    'resolve' => fn($rootValue, $args) => $this->resolveLoginUser($args),
                ],
            ],
        ]);
    }

    private function resolveLoginUser(array $args): string
    {
        try {
            return AuthService::getInstance()->loginUser($args);
        } catch (\Exception $e) {
            throw new UserError(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
