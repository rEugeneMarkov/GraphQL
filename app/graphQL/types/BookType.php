<?php

namespace App\GraphQL\Types;

use App\Models\Book;
use App\GraphQL\Types\ReviewType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class BookType extends ObjectType
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new BookType();
        }
        return self::$instance;
    }

    private function __construct()
    {
        parent::__construct([
            'name' => 'Book',
            'fields' => [
                'id' => ['type' => Type::int()],
                'name' => ['type' => Type::string()],
                'reviews' => [
                    'type' => Type::listOf(ReviewType::getInstance()),
                    'resolve' => fn ($book): array => Book::find($book['id'])->reviews(),
                ]
            ]
        ]);
    }
}
