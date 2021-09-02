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


    public static function get_posts($limit = null, $offset = null)
    {

        global $db;
        // declare SQL filter rules
        $filter_rules = array(
                        "location" => " location LIKE '%%%s%%' ",
                        "salary_min" => " a.salary >=%d",
                        "salary_max" => " a.salary <=%d",
                        "keyword" => " (CONCAT(title, description) LIKE '%%%s%%') ",
                        );

        $query = "SELECT a.posting_id, a.title, b.company_name, a.description, a.time_posted, a.location, a.salary, a.local";
        $query .= " FROM postings a ";
        $query .= " INNER JOIN employers b ON a.employer_id=b.employer_id ";

        if (!empty($_GET)) {

            if (!empty($_GET['id'])) {
                $query .= " WHERE a.posting_id=" . $_GET['id'];
            } else {
                $filters = [];
                foreach ($_GET as $key => $value) {
                    if (array_key_exists($key, $filter_rules) && !empty($value)) {
                        $filters[$key] = $db->sanitize($value);
                    }
                }

                if ($filters) {
                    $query .= " WHERE ";
                    foreach ($filters as $key => $value) {
                        if ($key == "keyword") {
                            $keywords = explode(" ", $_GET['keyword']);
                            foreach($keywords as $value) {
                                $query .= sprintf($filter_rules['keyword'],$value);
                                $query .= ($value == end($keywords)) ? " " : " AND ";
                            }
                        } else {
                            $query .= sprintf($filter_rules[$key],$_GET[$key]);
                        }
                        $query .= ($value == end($filters)) ? " " : " AND ";
                    }
                }

                if(!empty($_GET['order'])) {
                    $query .= " ORDER BY " . $_GET['order'];
                    if (!empty($_GET['order_type'])) {
                        $query .= " " . $_GET['order_type'];
                    }
                }

                if (isset($limit, $offset)) {
                    $query .= " LIMIT $offset, $limit";
                } elseif (isset($limit)) {
                    $query .= " LIMIT $limit";
                }
            }
        }

        $stmt = $db->con->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(count($result) > 0) {

        return $result;

    } else {

        show_alert("We didn't find any local offers that match your criteria","warning");
        return $result = [];

        }
    }

private static function get_backfill_filters($pagesize = 5, $start_num = 1) {

    $keywords = isset($_GET['keyword']) ? $_GET['keyword'] : "";
    $location = isset($_GET['location']) ? $_GET['location'] : "";
    if (isset($_GET['order'])) {
        switch ($_GET['order']) {
            case "title" :
                $sort = "relevance";
                break;
            case "time_posted" :
                $sort = "date";
                break;
            case "salary" :
                $sort = "salary";
                break;
            default :
                $sort = "relevance";
        }
    } else {
        $sort = 'relevance';
    }

    $filters = array(
        'keywords' => $keywords,
        'location' => $location,
        'pagesize' => $pagesize,
        'start_num' => $start_num,
        'sort' => $sort,
        'affid'      => '0afaf0173305e4b9'
    );

    return $filters;
}

public static function get_backfill($pagesize = 5, $start_num = 1) {

    $backfill = new Careerjet_API('en_US');
    $filters = self::get_backfill_filters($pagesize, $start_num);
    $result = $backfill->search($filters);

    return $result->hits ? $result : false;

}

}

?>
