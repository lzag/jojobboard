<?php
namespace App;

use PDOException;

class Database extends \PDO
{

    public $con;
    public static $instance;

    public function __construct()
    {
        // Enable the connection to the database. Throw and exception in case of an error
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME;
            $this->con = new \PDO($dsn, DB_USER, DB_PASS);
        } catch (PDOException $e) {
            echo '<div>There has been problems with connecting with the database. Please try again later</div>';
            echo $e->getMessage();
        }

    }

    public function sanitize($string) 
    {
        if (is_array($string)) {

//            if (get_magic_quotes_gpc()) $string = array_map("stripslashes",$string);
//            $string = array_map(array($this->con,"real_escape_string"), $string);
            return $string;

        } else {

//        if (get_magic_quotes_gpc()) $string = stripslashes($string);
//        $string = $this->con->real_escape_string($string);
        return $string;

        }
    }

    public static function getInstance(): self 
    {
        if (self::$instance === null) {
            return self::$instance = new self;
        } else {
            return self::$instance;
        }
    }

}
