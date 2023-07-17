<?php

namespace App\Type;

use App\Data\DataSource;
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
                    'resolve' => fn() => DataSource::getAuthors(),
                ],
                'books' => [
                    'type' => Type::listOf(BookType::getInstance()),
                    'resolve' => fn() => DataSource::getBooks(),
                ],
                'reviews' => [
                    'type' => Type::listOf(ReviewType::getInstance()),
                    'resolve' => fn() => DataSource::getReviews(),
                ],
            ],
        ]);
    }
}
