<?php

namespace App\GraphQL\MutationTypes\AddMutations;

use App\Models\Review;
use GraphQL\Error\UserError;
use App\Services\AuthService;
use App\GraphQL\Types\ReviewType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class AddReviewMutation extends ObjectType
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new AddReviewMutation();
        }
        return self::$instance;
    }

    private function __construct()
    {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'addReview' => [
                    'type' => ReviewType::getInstance(),
                    'args' => [
                        'review' => ['type' => Type::nonNull(Type::string())],
                        'book_id' => ['type' => Type::nonNull(Type::int())],
                    ],
                    'resolve' => fn($rootValue, $args) => $this->resolveAddReview($args),
                ],
            ],
        ]);
    }

    private function resolveAddReview(array $args): array
    {
        try {
            AuthService::getInstance()->checkAuthentication();

            return Review::create($args)->toArray();
        } catch (\Exception $e) {
            throw new UserError(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
