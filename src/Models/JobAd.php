<?php
namespace App\Models;

use App\Models\Model;
use App\Database;
use App\Helpers\Pagination;
use App\Models\Company;
use App\ResultsArray;
use Exception;

class JobAd extends Model {
    
    public const TABLE = 'job_ads';
    public const FIELDS = [  
        'id',
        'title', 
        'description', 
        '_id', 
        'salary_min', 
        'salary_max',
        'location',
    ];
    public const LINKS = [
        Company::class => 'employer_id',
    ];

    public function __construct()
    {
        parent::__construct();
    } 

    public static function fetchList(?array $filter, ?Pagination $pagination): ResultsArray {
        self::$db = Database::getInstance();
        if (!static::TABLE) {
            throw new Exception('No table set on the model');
        }
        $base_query = "SELECT a.id, a.title, a.description, b.name AS company_name, a.created_at  
                FROM " . self::TABLE . " a 
                LEFT JOIN " . Company::TABLE . " b ON a.employer_id=b.id";
        if (!is_null($filter)) {
            // TODO: add filter to the query
        }

        if (!is_null($pagination)) {
            $offset = ($pagination->page - 1) * $pagination->perPage;
            $limit = $pagination->perPage;
            $query = $base_query . " LIMIT " . $limit . " OFFSET " . $offset;
        } else {
            $query = $base_query;
            $offset = null;
            $limit = null;
        }
        $items = self::fetchPrepQuery($query, []);

        return new ResultsArray($items, $base_query, $offset, $limit);
    }
}