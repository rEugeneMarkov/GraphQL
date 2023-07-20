<?php

namespace App\Core;

use PDO;

class QueryBuilder
{
    protected $table;
    protected $where = [];

    public function __construct($table, $column = null, $operator = null, $value = null)
    {
        $this->table = $table;

        if ($column !== null) {
            $this->where[] = [$column, $operator, $value];
        }
    }

    public function where($column, $operator = '=', $value)
    {
        $this->where[] = [$column, $operator, $value];
        return $this;
    }

    public function get()
    {
        $pdo = DB::getInstance();
        $whereClause = $this->buildWhereClause();
        $sql = "SELECT * FROM " . $this->table . $whereClause;
        $stmt = $pdo->prepare($sql);

        foreach ($this->where as $condition) {
            list($column, $operator, $value) = $condition;
            $stmt->bindValue(":$column", $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function buildWhereClause()
    {
        if (empty($this->where)) {
            return '';
        }

        $conditions = [];
        foreach ($this->where as $condition) {
            list($column, $operator, $value) = $condition;
            $conditions[] = "$column $operator :$column";
        }

        return ' WHERE ' . implode(' AND ', $conditions);
    }
}
