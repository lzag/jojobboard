<?php
namespace App\Models;

use App\Models\Model;

class Company extends Model {
    
    public const TABLE = 'companies';
    public const FIELDS = [  
        'id',
        'name', 
    ];

    public function __construct()
    {
        parent::__construct();
    } 
}