<?php
namespace App;

class Database
{

    public $con;

    public function __construct()
    {

        // Enable the connection to the database. Throw and exception in case of an error
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
            $this->con = new \PDO($dsn, DB_USER, DB_PASS);
        } catch (Exception $e) {
            echo '<div>There has been problems with connecting with the database. Please try again later</div>';
        }

    }
//
//    private function open_con() {
//
//        $this->conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_DATABASE);
//        if ($this->conn->connect_error) {
//        throw new Exception("Can't connect to the database");
//        }
//
//    }
//
//    public function execute_query($sql) {
//
//    return $result = $this->conn->query($sql);
//
//    }
//
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
//
//   public function close() {
//        $this->conn->close();
//    }
//
//    public function errno() {
//
//        return $this->conn->errno;
//
//    }
}
