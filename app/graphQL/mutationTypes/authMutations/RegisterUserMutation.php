<?php

namespace App\GraphQL\MutationTypes\AuthMutations;

use GraphQL\Error\UserError;
use App\Services\AuthService;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class RegisterUserMutation extends ObjectType
{
    private static ?self $instance = null;

    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new RegisterUserMutation();
        }
        return self::$instance;
    }

    private function __construct()
    {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'registerUser' => [
                    'type' => Type::string(),
                    'args' => [
                        'name' => ['type' => Type::nonNull(Type::string())],
                        'email' => ['type' => Type::nonNull(Type::string())],
                        'password' => ['type' => Type::nonNull(Type::string())],
                    ],
                    'resolve' => fn($rootValue, $args) => $this->resolveRegisterUser($args),
                ],
            ],
        ]);
    }

    private function resolveRegisterUser(array $args): string
    {
        try {
            return AuthService::getInstance()->registerUser($args);
        } catch (\Exception $e) {
            throw new UserError(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
