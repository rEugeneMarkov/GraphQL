<?php

namespace App\GraphQL\MutationTypes\DeleteMutations;

use App\GraphQL\Types\ReviewType;
use App\Models\Review;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class DeleteReviewMutation extends ObjectType
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new DeleteReviewMutation();
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
                    ],
                    'resolve' => fn($rootValue, $args) =>
                        Review::delete($args['id']),
                ],
            ],
        ]);
    }
}
