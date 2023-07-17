<?php

namespace App\Type;

use App\Data\Datasource;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class GraphQLTypes
{
    public static function getAuthorType()
    {
        $authorType = new ObjectType([
            'name' => 'Author',
            'fields' => [
                'id' => ['type' => Type::int()],
                'name' => ['type' => Type::string()],
                'books' => [
                    'type' => Type::listOf(self::getBookType()),
                    'resolve' => fn ($author): array => DataSource::findBooks($author['id']),
                ],
            ],
        ]);
        return $authorType;
    }

    public static function getBookType()
    {
        $bookType = new ObjectType([
            'name' => 'Book',
            'fields' => [
                'id' => ['type' => Type::int()],
                'name' => ['type' => Type::string()],
                'reviews' => [
                    'type' => Type::listOf(self::getReviewType()),
                    'resolve' => fn ($book): array => DataSource::findReviews($book['id']),
                ],
            ],
        ]);
        return $bookType;
    }

    public static function getReviewType()
    {
        $reviewType = new ObjectType([
            'name' => 'Review',
            'fields' => [
                'id' => ['type' => Type::int()],
                'book_id' => ['type' => Type::int()],
                'review' => ['type' => Type::string()],
            ],
        ]);
        return $reviewType;
    }
}
