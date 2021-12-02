<?php

namespace App;

use App\Models\Model;
use Exception;

class ResultsArray
{
    private string $query;
    private ?int $offset;
    private ?int $limit;
    public array $items;

    public function __construct(array $items, string $query, ?int $offset, ?int $limit)
    {
        $this->items = $items;
        $this->query = $query;
        if ($offset < 0) {
            throw new Exception("Offset cannot be below 0");
        }
        $this->offset = $offset;
        $this->limit = $limit;
    }

    public function next(): self
    {
        $offset = $this->offset + $this->limit;
        $offsets = " LIMIT " . $this->limit . " OFFSET " . $offset;
        $query = $this->query . $offsets;
        $items = Model::fetchPrepQuery($query, []);
        $this->offset = $offset;
        $this->items = $items;
        return $this;
    }

    public function prev(): self
    {
        $offset = $this->offset - $this->limit;
        if ($offset < 0) {
            throw new Exception("Offset below zero");
        }
        $offsets = " LIMIT " . $this->limit . " OFFSET " . $offset;
        $query = $this->query . $offsets;
        $items = Model::fetchPrepQuery($query, []);
        $this->offset = $offset;
        $this->items = $items;
        return $this;
    }
}
