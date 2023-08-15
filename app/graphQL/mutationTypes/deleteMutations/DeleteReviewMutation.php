<?php

namespace App\GraphQL\MutationTypes\DeleteMutations;

use App\Models\Review;
use GraphQL\Error\UserError;
use App\Services\AuthService;
use App\GraphQL\Types\ReviewType;
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
                    'resolve' => fn($rootValue, $args) => $this->resolveDeleteReview($args),
                ],
            ],
        ]);
    }

    private function resolveDeleteReview(array $args): void
    {
        try {
            AuthService::getInstance()->checkAuthentication();

            $author = Review::find($args['id']);

            if (is_null($author)) {
                throw new \Exception("Book don't exists");
            }

            $author->delete($args['id']);
        } catch (\Exception $e) {
            throw new UserError(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
