<?php

namespace App\Type;

use App\Type\BookType;
use App\Data\DataSource;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class AuthorType extends ObjectType
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new AuthorType();
        }
        return self::$instance;
    }

    public function __construct()
    {
        parent::__construct([
            'name' => 'Author',
            'fields' => [
                'id' => ['type' => Type::int()],
                'name' => ['type' => Type::string()],
                'books' => [
                    'type' => Type::listOf(BookType::getInstance()),
                    'resolve' => fn ($author): array => DataSource::findBooks($author['id']),
                ]
            ]
        ]);
    }
}
