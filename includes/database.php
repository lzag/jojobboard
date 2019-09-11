<?php
namespace App;

class Database extends \PDO
{

    public $con;

    public function __construct()
    {
        require('db_config.php');
        // Enable the connection to the database. Throw and exception in case of an error
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
            return parent::__construct($dsn, DB_USER, DB_PASS);
            // $this->con = new $this;
            // $this->con = new \PDO();
        } catch (Exception $e) {
            echo '<div>There has been problems with connecting with the database. Please try again later</div>';
        }

    }

    public function sanitize($string) {

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

}
