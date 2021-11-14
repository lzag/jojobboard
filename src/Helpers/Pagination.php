<?php
namespace App\Helpers;

class Pagination
{
    public int $page = 1;
    public int $perPage = 5;

    public function __construct(int $page, int $perPage) 
    {
        $this->page = $page;
        $this->perPage = $perPage;
    }
}