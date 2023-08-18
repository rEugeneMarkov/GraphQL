<?php

namespace App\GraphQL\MutationTypes;

use App\Services\AuthService;
use GraphQL\Type\Definition\Type;
use App\Factories\UserErrorFactory;
use GraphQL\Type\Definition\ObjectType;

class UserMutations extends ObjectType
{
    public function __construct(
        private AuthService $authService,
        private UserErrorFactory $userErrorFactory,
    ) {
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

    private function resolveRegisterUser(array $args): string
    {
        try {
            return $this->authService->registerUser($args);
        } catch (\Exception $e) {
            throw $this->userErrorFactory->create($e);
        }
    }

    private function resolveLoginUser(array $args): string
    {
        try {
            return $this->authService->loginUser($args);
        } catch (\Exception $e) {
            throw $this->userErrorFactory->create($e);
        }
    }
}
