<?php

namespace App\Services;

use App\Helpers\SqlQuery;
use Exception;
use App\ResultsArray;
use App\Database;
use PDO;
use App\Helpers\Pagination;

abstract class Service
{
    // private SqlQuery $sql_query;
    private $db;

    public function __construct()
    {
        // $this->sql_query = new SqlQuery;
        $this->sql_query = '';
    }

    public function limit($limit)
    {
        return $this;
    }

    public static function orderBy($name)
    {
        return $this;
    }

    public static function where($where)
    {
        return new static();
    }

    public function get(): ResultsArray
    {
        $main_class = array_keys($this::FIELDS)[0];
        $main_table = $main_class::TABLE;

        $sql_fields = [];
        $joins = [];
        $i = 0;
        foreach ($this::FIELDS as $class => $class_fields) {
            if ($i > 0) {
                if (!isset($main_class::LINKS[$class])) {
                    throw new Exception('Class is not linked');
                }
                $joins[$class] = $main_class::LINKS[$class];
            }
            $new_fields = array_map(
                function ($el) use (&$class) {
                    return $class::TABLE . '.' . $el;
                },
                $class_fields
            );
            $sql_fields = array_merge($sql_fields, $new_fields);
            $i++;
        }
        $query = "SELECT " . join(', ', $sql_fields) . " ";

        $query .= "FROM " .  $main_table . " ";

        foreach ($joins as $class => $field) {
            $query .= "LEFT JOIN " . $class::TABLE . " ON " . $main_class::TABLE . '.' . $field . '=' . $class::TABLE . '.id ';
        }

        $query .= $this->sql_query;

        $this->db = Database::getInstance();

        $stmt = $this->db->con->query($query);
        $items = $stmt->fetchAll(PDO::FETCH_CLASS, static::class);

        return new ResultsArray(
            $items,
            $query,
            null,
            null
        );
    }

    public function paginate(Pagination $pagination)
    {
        $offset = ($pagination->page * $pagination->perPage) - $pagination->perPage;
        $limit = $pagination->perPage;
        $this->sql_query .= " LIMIT {$limit} OFFSET {$offset}";
        return $this;
    }
}
