<?php

namespace App\GraphQL\MutationTypes\UpdateMutations;

use App\GraphQL\Types\ReviewType;
use App\Models\Review;
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
                    'resolve' => fn($rootValue, $args) =>
                        Review::update(['id' => $args['id'], 'review' => $args['review'], 'book_id' => $args['book_id']]),
                ],
            ],
        ]);
    }
}
