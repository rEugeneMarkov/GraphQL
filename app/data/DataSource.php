<?php

namespace App\Data;

use PDO;
use App\Core\DB;

class DataSource
{
    private $db;

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    private function getAll(string $tableName)
    {
        $sql = "SELECT * FROM $tableName;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getAuthors()
    {
        $instance = new self();

        $data = $instance->getAll('authors');
        return $data;
    }

    public static function getBooks()
    {
        $instance = new self();

        $data = $instance->getAll('books');
        return $data;
    }

    public static function getReviews()
    {
        $instance = new self();

        $data = $instance->getAll('reviews');
        return $data;
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
