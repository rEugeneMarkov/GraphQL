<?php

namespace App\Models;

use PDO;
use App\Core\DB;
use App\Core\QueryBuilder;

abstract class Model
{
    protected static $table;
    protected static $primaryKey = 'id';
    protected $attributes = [];

    public function __construct($attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public static function create(array $attributes)
    {
        $pdo = DB::getInstance();

        $keys = implode(', ', array_keys($attributes));
        $placeholders = ':' . implode(', :', array_keys($attributes));

        $sql = "INSERT INTO " . static::getTableName() . " ($keys) VALUES ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($attributes);

        $attributes[static::$primaryKey] = $pdo->lastInsertId();

        return new static($attributes);
    }

    public static function update(array $attributes)
    {
        $pdo = DB::getInstance();

        $set = [];
        foreach ($attributes as $key => $value) {
            if ($key !== static::$primaryKey) {
                $set[] = "$key = :$key";
            }
        }

        $sql = "UPDATE " . static::getTableName() .
            " SET " . implode(', ', $set) .
            " WHERE " . static::$primaryKey . " = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_merge($attributes, ['id' => $attributes[static::$primaryKey]]));

        return new static($attributes);
    }

    public static function save(array $attributes)
    {
        if (isset($attributes[static::$primaryKey])) {
            return static::update($attributes);
        } else {
            return static::create($attributes);
        }
    }

    public static function delete($id)
    {
        $pdo = DB::getInstance();
        $stmt = $pdo->prepare("DELETE FROM " . static::getTableName() . " WHERE " . static::$primaryKey . " = :id");
        $stmt->execute(['id' => $id]);
    }

    public static function find($id)
    {
        $pdo = DB::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM " . static::getTableName() . " WHERE " . static::$primaryKey . " = :id");
        $stmt->execute(['id' => $id]);

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new static($row);
        }

        return null;
    }

    public static function all()
    {
        $pdo = DB::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM " . static::getTableName());
        $stmt->execute();

        $models = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $models[] = new static($row);
        }

        return array_map(function ($model) {
            return $model->toArray();
        }, $models);
    }

    public static function getTableName()
    {
        if (static::$table) {
            return static::$table;
        }

        $className = strtolower(get_called_class());
        return $className . 's';
    }

    public static function where($column, $operator, $value)
    {
        return new QueryBuilder(static::getTableName(), $column, $operator, $value);
    }

    public static function get()
    {
        $builder = new QueryBuilder(static::getTableName());
        return $builder->get();
    }

    public function toArray()
    {
        return $this->attributes;
    }
}
