<?php

namespace App\Type;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class ReviewType extends ObjectType
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new ReviewType();
        }
        return self::$instance;
    }

    private function __construct()
    {
        parent::__construct([
            'name' => 'Review',
            'fields' => [
                'id' => ['type' => Type::int()],
                'review' => ['type' => Type::string()]
            ]
        ]);
    }
}
