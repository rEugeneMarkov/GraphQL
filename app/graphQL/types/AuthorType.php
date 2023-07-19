<?php

namespace App\GraphQL\Types;

use App\Models\Author;
use App\GraphQL\Types\BookType;
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
                    'resolve' => fn ($author): array => Author::find($author['id'])->books(),
                ]
            ]
        ]);
    }
}
