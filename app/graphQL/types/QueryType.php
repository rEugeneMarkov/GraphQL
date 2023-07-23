<?php

namespace App\GraphQL\Types;

use App\Models\Book;
use App\Models\Author;
use App\Models\Review;
use App\GraphQL\Types\BookType;
use App\GraphQL\Types\AuthorType;
use App\GraphQL\Types\ReviewType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class QueryType extends ObjectType
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new QueryType();
        }
        return self::$instance;
    }

    private function __construct()
    {
        parent::__construct([
            'name' => 'Query',
            'fields' => [
                'authors' => [
                    'type' => Type::listOf(AuthorType::getInstance()),
                    'resolve' => fn() => Author::all(),
                ],
                'books' => [
                    'type' => Type::listOf(BookType::getInstance()),
                    'resolve' => fn() => Book::all(),
                ],
                'reviews' => [
                    'type' => Type::listOf(ReviewType::getInstance()),
                    'resolve' => fn() => Review::all(),
                ],
                'author' => [
                    'type' => AuthorType::getInstance(),
                    'args' => [
                        'id' => ['type' => Type::nonNull(Type::int())],
                    ],
                    'resolve' => fn ($rootValue, $args) => Author::find($args['id'])->toArray(),
                ],
                'book' => [
                    'type' => BookType::getInstance(),
                    'args' => [
                        'id' => ['type' => Type::nonNull(Type::int())],
                    ],
                    'resolve' => fn ($rootValue, $args) => Book::find($args['id'])->toArray(),
                ],
                'review' => [
                    'type' => ReviewType::getInstance(),
                    'args' => [
                        'id' => ['type' => Type::nonNull(Type::int())],
                    ],
                    'resolve' => fn ($rootValue, $args) => Review::find($args['id'])->toArray(),
                ],
            ],
        ]);
    }
}
