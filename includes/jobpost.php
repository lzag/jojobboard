<?php

class JobPost {

    private $posting_id;
    private $employer;
    private $employer_id;
    private $title;
    private $location;
    private $salary;
    private $description;
    private $time_posted;
    private $external;

public static function show_postings() {



}


public static function get_posts() {

global $db;

// initialize the filter variables
$filters = array("location" => "",
                "salary_min" => "",
                "salary_max" => "",
                "keyword" => "",
                "id" => "",
                "order" => ""
                );

// declare SQL filter rules
$filter_rules = array("location" => " location LIKE '%%%s%%' ",
                "salary_min" => " a.salary >=%d",
                "salary_max" => " a.salary <=%d",
                "keyword" => " CONCAT(title, description) LIKE '%%%s%%' ",
                "id" => " a.posting_id=%d",
                "order" => " ORDER BY %s "
                );


// check for possible filters in $_GET and assigne them to the array
if (isset($_GET)){


    foreach($filters as $key => &$value) {

        if (array_key_exists($key, $_GET) && $_GET[$key] !== "") {

                $value = $db->sanitize($_GET[$key]);

        } else {

                unset($filters[$key]);
                unset($filter_rules[$key]);

            }

        }

    }

if(isset($filter_rules['order'])) {

    $order = sprintf($filter_rules['order'],$filters['order']);
    unset($filter_rules['order']);

}

$query = "SELECT a.posting_id, a.title,b.company_name, a.description, a.time_posted, a.location, a.salary, a.local";
$query .= " FROM jjb_postings a INNER JOIN jjb_employers b ON a.employer_id=b.employer_id  ";

// check if it's the single post page
if(!empty($filter_rules)) {

   $query .= " WHERE ";

    if (array_key_exists("id", $filter_rules)) {

        $query .= $filter_rules["id"];

    } else {

        $last_filter = end($filter_rules);
        foreach($filter_rules as $key => $value) {

            $query .= $filters[$key] ? sprintf($filter_rules[$key],$filters[$key])  : "";
            $query .= ($filter_rules[$key] == $last_filter) ? "" : " AND ";
        }

        if(isset($order)) {

            $query .= $order ;

        }

    }

}

$result = $db->execute_query($query);

if($result->num_rows >= 1) {

    return $result;

} else {

    show_alert("We didn't find any offers that match your criteria","warning");

    }

}

public static function add_url_filter($filter) {

(isset($_GET['order'])) ? $query_post .= " ORDER BY ". $_GET['order'] . " desc" : "" ;

}

private static function get_backfill_filters($num = 10) {

    $keywords = isset($_GET['keyword']) ? $_GET['keyword'] : "";
    $location = isset($_GET['location']) ? $_GET['location'] : "";
    $sort = isset($_GET['order']) ? $_GET['order'] : null;

    $filters = array( 'keywords' => $keywords,
                   'location' => $location,
                    'pagesize' => $num,
                    'affid'      => '0afaf0173305e4b9');

    return $filters;
}

public static function get_backfill() {

    $backfill = new Careerjet_API('en_US');
    $filters = self::get_backfill_filters();
    $result = $backfill->search($filters);


    return $result->jobs;

}

}

?>
