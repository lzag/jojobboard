<?php
namespace App\Helpers;

class SqlQuery
{
    public $table;
    public $columns;
    public $joins;
    public $where;
    public $limit;
    public $orderBy; 

    public function getQuery(): string
    {
        // return query sting;
    }
}