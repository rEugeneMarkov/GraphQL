<?php

namespace App\GraphQL\MutationTypes;

use App\Models\Review;
use App\Services\AuthService;
use App\Traits\ResolversTrait;
use App\GraphQL\Types\ReviewType;
use GraphQL\Type\Definition\Type;
use App\Factories\UserErrorFactory;
use GraphQL\Type\Definition\ObjectType;

class ReviewMutations extends ObjectType
{
    use ResolversTrait;

    public function __construct(
        private AuthService $authService,
        private UserErrorFactory $userErrorFactory,
    ) {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'addReview' => [
                    'type' => ReviewType::getInstance(),
                    'args' => [
                        'review' => ['type' => Type::nonNull(Type::string())],
                        'book_id' => ['type' => Type::nonNull(Type::int())],
                    ],
                    'resolve' => fn($rootValue, $args): Review =>
                        $this->resolversFactory('resolveAddReview', $args),
                ],
                'updateReview' => [
                    'type' => ReviewType::getInstance(),
                    'args' => [
                        'id' => ['type' => Type::nonNull(Type::int())],
                        'review' => ['type' => Type::nonNull(Type::string())],
                        'book_id' => ['type' => Type::nonNull(Type::int())],
                    ],
                    'resolve' => fn($rootValue, $args): Review =>
                        $this->resolversFactory('resolveUpdateReview', $args),
                ],
                'deleteReview' => [
                    'type' => Type::string(),
                    'args' => [
                        'id' => ['type' => Type::nonNull(Type::int())],
                    ],
                    'resolve' => fn($rootValue, $args): string =>
                        $this->resolversFactory('resolveDeleteReview', $args),
                ],
            ],
        ]);
    }

    private function resolveAddReview(array $args): Review
    {
        return Review::create($args);
    }

    private function resolveUpdateReview(array $args): Review
    {
        $review = Review::find($args['id']);

        if (is_null($review)) {
            throw new \Exception("Review don't exists");
        }

        return Review::update($args);
    }

    private function resolveDeleteReview(array $args): string
    {
        $review = Review::find($args['id']);

        if (is_null($review)) {
            throw new \Exception("Review don't exists");
        }

        $review->delete($args['id']);
        return "Success";
    }
}
