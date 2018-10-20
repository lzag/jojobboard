<?php

class JobPost
{

    private $posting_id;
    private $employer;
    private $employer_id;
    private $title;
    private $location;
    private $salary;
    private $description;
    private $time_posted;
    private $external;

    public function __construct()
    {

    }

    public static function showPostings() {

    }

    public static function get_posts()
    {

        global $db;

        // initialize the filter variables
        $filters = array(
                    "location" => "",
                    "salary_min" => "",
                    "salary_max" => "",
                    "keyword" => "",
                    "id" => "",
                    "order" => ""
                    );

        // declare SQL filter rules
        $filter_rules = array(
                        "location" => " location LIKE '%%%s%%' ",
                        "salary_min" => " a.salary >=%d",
                        "salary_max" => " a.salary <=%d",
                        "keyword" => " (CONCAT(title, description) LIKE '%%%s%%') ",
                        "id" => " a.posting_id=%d",
                        "order" => " ORDER BY %s "
                        );

        // check for possible filters in $_GET and assign them to the array
        if (isset($_GET) && !empty($_GET)){

            if(isset($_GET['keyword'])) {

                $_GET['keyword'] = explode(" ",$_GET['keyword']);
            }

    // GET THE FILTER VALUES AND UNASSIGN THE UNNECESSARY ONES
        foreach($filters as $key => &$value) {

            if (array_key_exists($key, $_GET) && !empty($_GET[$key])) {

                    $value = $db->sanitize($_GET[$key]);

            } else {

                    unset($filters[$key]);
                    unset($filter_rules[$key]);

                }
            }
        }

    // CHECK IF THE ORDER IS THERE AND GIVE IT A VALUE
    if(isset($filters['order'])) {

        $order = sprintf($filter_rules['order'],$filters['order']);
        unset($filter_rules['order']);
        unset($filters['order']);

    }

    // BUILD THE KEYWORD QUERY PART
    if(isset($filters['keyword'])) {

        $keyword = "";
        $last_keyword = end($filters['keyword']);
        foreach($filters['keyword'] as $value) {

            if ($value !== $last_keyword) {

            $keyword .= sprintf($filter_rules['keyword'],$value);
            $keyword .= " AND ";

                } else {

               $keyword .= sprintf($filter_rules['keyword'],$value);

                    }
                }

             unset($filter_rules['keyword']);
             unset($filters['keyword']);

    }

    $query = "SELECT a.posting_id, a.title, b.company_name, a.description, a.time_posted, a.location, a.salary, a.local";
    $query .= " FROM postings a INNER JOIN employers b ON a.employer_id=b.employer_id  ";

    // check if it's the single post page
    if(!empty($filter_rules) || isset($keyword)) {

       $query .= " WHERE ";

        if (array_key_exists("id", $filter_rules)) {

            $query .= sprintf($filter_rules['id'],$filters['id']);

        } else {

            $last_filter = end($filter_rules);
            foreach($filter_rules as $key => $value) {

                $query .= $filters[$key] ? sprintf($filter_rules[$key],$filters[$key])  : "";
                $query .= ($filter_rules[$key] == $last_filter) ? "" : " AND ";
            }

            if($keyword) {

                $query .= $keyword ;

            }

            if(isset($order)) {

                $query .= $order ;

            }

        }

    }
    echo $query;
    $stmt = $db->con->query($query);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(count($result) > 0) {

        return $result;

    } else {

        show_alert("We didn't find any offers that match your criteria","warning");

        }

    }


private static function get_backfill_filters($num = 10) {

    $keywords = isset($_GET['keyword']) ? implode(" ",$_GET['keyword']) : "";
    $location = isset($_GET['location']) ? $_GET['location'] : "";
    $sort = isset($_GET['order']) ? $_GET['order'] : null;

    $filters = array(
        'keywords' => $keywords,
        'location' => $location,
        'pagesize' => $num,
        'affid'      => '0afaf0173305e4b9'
    );

    return $filters;
}

public static function get_backfill($num) {

    $backfill = new Careerjet_API('en_US');
    $filters = self::get_backfill_filters($num);
    $result = $backfill->search($filters);

    return $result->hits ? $result : false;

}

public static function paginateResults() {



}

}

?>
