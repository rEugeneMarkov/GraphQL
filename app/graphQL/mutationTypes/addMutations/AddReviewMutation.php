<?php

namespace App\GraphQL\MutationTypes\AddMutations;

use App\GraphQL\Types\ReviewType;
use App\Models\Review;
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
                    'resolve' => fn($rootValue, $args) =>
                        Review::create(['review' => $args['review'], 'book_id' => $args['book_id']]),
                ],
            ],
        ]);
    }
}
