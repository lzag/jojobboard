<?php
namespace App\Helpers;

class Pagination
{
    public int $page = 1;
    public int $perPage = 5;
    public int $nextPage;
    public int $prevPage;

    public function __construct(int $page, int $perPage) 
    {
        $this->page = $page;
        $this->perPage = $perPage;
        $this->nextPage = $page + 1;
        $this->prevPage = $this->page - 1 > 0 ? $this->page - 1 : 0;
    }
}