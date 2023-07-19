<?php

namespace App\Data;

use App\Core\DB;

class DataGenerator
{
    private $db;

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function init(): void
    {
        if ($this->checkDB() > 0) {
            return;
        } else {
            $this->generateAuthors();
            $this->generateBooks();
            $this->generateReviews();
        }
    }

    public function checkDB(): int
    {
        $sql = "SELECT COUNT(*) FROM authors;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function generateAuthors(): void
    {
        $data = [
            ['id' => 1, 'name' => 'Автор 1'],
            ['id' => 2, 'name' => 'Автор 2'],
            ['id' => 3, 'name' => 'Автор 3'],
        ];
        $values = [];
        $placeholders = [];
        foreach ($data as $item) {
            $values[] = $item['name'];
            $placeholders[] = "(?)";
        }

        $sql = "INSERT INTO authors (name) VALUES " . implode(', ', $placeholders);

        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
    }

    public function generateBooks(): void
    {
        $data = [
            ['id' => 1, 'name' => 'Книга 1', 'author_id' => 1],
            ['id' => 2, 'name' => 'Книга 2', 'author_id' => 2],
            ['id' => 3, 'name' => 'Книга 3', 'author_id' => 3],
        ];
        $values = [];
        $placeholders = [];
        foreach ($data as $item) {
            $values[] = $item['name'];
            $values[] = $item['author_id'];
            $placeholders[] = "(?,?)";
        }

        $sql = "INSERT INTO books (name, author_id) VALUES " . implode(', ', $placeholders);

        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
    }

    public function generateReviews(): void
    {
        $data = [
            ['id' => 1, 'book_id' => 1, 'review' => 'Отзыв на книгу 1'],
            ['id' => 2, 'book_id' => 2, 'review' => 'Отзыв на книгу 2'],
            ['id' => 3, 'book_id' => 3, 'review' => 'Отзыв на книгу 3'],
        ];
        $values = [];
        $placeholders = [];
        foreach ($data as $item) {
            $values[] = $item['book_id'];
            $values[] = $item['review'];
            $placeholders[] = "(?,?)";
        }

        $sql = "INSERT INTO reviews (book_id, review) VALUES " . implode(', ', $placeholders);

        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
    }
}
