<?php

namespace App\Models;

use App\Database;
use Exception;
use PDO;
use PDOException;
use stdClass;

class Model
{
    protected static $db;
    public const FIELDS = [];
    public const TABLE = '';
    public const TRACKED = true;
    public const LINKS = [];

    public function __construct()
    {
    }

    public static function getAll()
    {
        self::$db = Database::getInstance();
        if (!static::TABLE) {
            throw new Exception('No table set on the model');
        }

        if (empty(static::FIELDS) || !is_array(static::FIELDS)) {
            throw new Exception('Fields error');
        }

        $query = "SELECT " . implode(', ', static::FIELDS);
        $query .= " FROM " . static::TABLE;
        $stmt = self::$db->con->query($query);
        $items = $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
        return $items;
    }

    public static function getAllJoined(): array
    {
        self::$db = Database::getInstance();
        if (!static::TABLE) {
            throw new Exception('No table set on the model');
        }

        if (empty(static::FIELDS) || !is_array(static::FIELDS)) {
            throw new Exception('Fields error');
        }
        $linked_tables = count(self::LINKS);
        if ($linked_tables >= 1) {
            $table_indexes = 'abcdefg';
            $basic_fields = array_map(
                function ($el) use ($table_indexes) {
                    return $table_indexes[0] . $el;
                },
                static::FIELDS
            );
            $query = "SELECT " . implode(', ', $basic_fields);
            $query .= " FROM " . static::TABLE . ' ' . $table_indexes[0];
            $i = 1;
            foreach (self::LINKS as $class => $field) {
                "LEFT JOIN " . $class::TABLE . " ON " . $table_indexes[0]  . $field . '=';
            }
            $stmt = self::$db->con->query($query);
        } else {
            $query = "SELECT " . implode(', ', static::FIELDS);
            $query .= " FROM " . static::TABLE;
            $stmt = self::$db->con->query($query);
        }
        $items = $stmt->fetchAll(PDO::FETCH_CLASS, 'stdClass');
        return $items;
    }

    public static function fetchPrepQuery($query_string, $args): array
    {
        try {
            $stmt = self::$db->con->prepare($query_string);
            $stmt->execute($args);
            if ($stmt === false) {
                throw new PDOException('Error preparing the statement');
            }
            $items = $stmt->fetchAll(PDO::FETCH_CLASS, 'stdClass');
        } catch (PDOException $e) {
            echo "Error in PDO execution";
            print_r($stmt->errorInfo());
        }
        return $items;
    }

    public function __set(string $name, $value)
    {
        if (!in_array($name, static::FIELDS)) {
            throw new Exception("Field does not belong to the model");
        }
    }
}
