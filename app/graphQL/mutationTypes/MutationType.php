<?php

namespace App\GraphQL\MutationTypes;

use GraphQL\Type\Definition\ObjectType;
use App\GraphQL\MutationTypes\AddMutations\AddBookMutation;
use App\GraphQL\MutationTypes\AddMutations\AddAuthorMutation;
use App\GraphQL\MutationTypes\AddMutations\AddReviewMutation;
use App\GraphQL\MutationTypes\AuthMutations\LoginUserMutation;
use App\GraphQL\MutationTypes\AuthMutations\RegisterUserMutation;
use App\GraphQL\MutationTypes\DeleteMutations\DeleteBookMutation;
use App\GraphQL\MutationTypes\UpdateMutations\UpdateBookMutation;
use App\GraphQL\MutationTypes\DeleteMutations\DeleteAuthorMutation;
use App\GraphQL\MutationTypes\DeleteMutations\DeleteReviewMutation;
use App\GraphQL\MutationTypes\UpdateMutations\UpdateAuthorMutation;
use App\GraphQL\MutationTypes\UpdateMutations\UpdateReviewMutation;

class MutationType extends ObjectType
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new MutationType();
        }
        return self::$instance;
    }

    private function __construct()
    {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => fn() => [
                ...AddAuthorMutation::getInstance()->config['fields'],
                ...AddBookMutation::getInstance()->config['fields'],
                ...AddReviewMutation::getInstance()->config['fields'],
                ...UpdateAuthorMutation::getInstance()->config['fields'],
                ...UpdateBookMutation::getInstance()->config['fields'],
                ...UpdateReviewMutation::getInstance()->config['fields'],
                ...DeleteAuthorMutation::getInstance()->config['fields'],
                ...DeleteBookMutation::getInstance()->config['fields'],
                ...DeleteReviewMutation::getInstance()->config['fields'],
                ...RegisterUserMutation::getInstance()->config['fields'],
                ...LoginUserMutation::getInstance()->config['fields'],
            ],
        ]);
    }
}
