<?php

namespace App\Data;

use App\Core\DB;

class TablesMigration
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function createTables()
    {
        $sql = "CREATE TABLE IF NOT EXISTS authors (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255)CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
        ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $sql = "CREATE TABLE IF NOT EXISTS books (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            author_id INT,
            FOREIGN KEY (author_id) REFERENCES authors(id) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $sql = "CREATE TABLE IF NOT EXISTS reviews (
            id INT AUTO_INCREMENT PRIMARY KEY,
            review VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            book_id INT,
            FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }
}
