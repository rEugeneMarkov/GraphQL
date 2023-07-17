<?php

namespace App\Data;

class DataSource
{
    public static function getAuthors()
    {
        return [
            ['id' => 1, 'name' => 'Автор 1'],
            ['id' => 2, 'name' => 'Автор 2'],
            ['id' => 3, 'name' => 'Автор 3'],
        ];
    }

    public static function getBooks()
    {
        return [
            ['id' => 1, 'name' => 'Книга 1', 'author_id' => 1],
            ['id' => 2, 'name' => 'Книга 2', 'author_id' => 2],
            ['id' => 3, 'name' => 'Книга 3', 'author_id' => 3],
        ];
    }

    public static function getReviews()
    {
        return [
            ['id' => 1, 'book_id' => 1, 'review' => 'Отзыв на книгу 1'],
            ['id' => 2, 'book_id' => 2, 'review' => 'Отзыв на книгу 2'],
            ['id' => 3, 'book_id' => 3, 'review' => 'Отзыв на книгу 3'],
        ];
    }

    public static function findBooks(int $id): array
    {
        $booksData = self::getBooks();
        $authorBooks = [];
        foreach ($booksData as $book) {
            if ($book['author_id'] === $id) {
                $authorBooks[] = $book;
            }
        }
        return $authorBooks;
    }

    public static function findReviews(int $id): array
    {
        $reviewsData = self::getReviews();
        $bookReviews = [];
        foreach ($reviewsData as $review) {
            if ($review['book_id'] === $id) {
                $bookReviews[] = $review;
            }
        }
        return $bookReviews;
    }
}
