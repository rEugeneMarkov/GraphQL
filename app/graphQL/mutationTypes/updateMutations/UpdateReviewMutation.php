<?php

namespace App\GraphQL\MutationTypes\UpdateMutations;

use App\Models\Review;
use GraphQL\Error\UserError;
use App\Services\AuthService;
use App\GraphQL\Types\ReviewType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class UpdateReviewMutation extends ObjectType
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new UpdateReviewMutation();
        }
        return self::$instance;
    }

    private function __construct()
    {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'updateReview' => [
                    'type' => ReviewType::getInstance(),
                    'args' => [
                        'id' => ['type' => Type::nonNull(Type::int())],
                        'review' => ['type' => Type::nonNull(Type::string())],
                        'book_id' => ['type' => Type::nonNull(Type::int())],
                    ],
                    'resolve' => fn($rootValue, $args) => $this->resolveUpdateReview($args),
                ],
            ],
        ]);
    }

    private function resolveUpdateReview(array $args): Review
    {
        try {
            AuthService::getInstance()->checkAuthentication();

            return Review::update($args);
        } catch (\Exception $e) {
            throw new UserError(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
