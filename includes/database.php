<?php

require_once 'dbconfig.php';

class Database extends mysqli {

//protected $db_hostname = 'localhost';
//protected $db_username = 'johannes';
//protected $db_password = 'L1pk0vsk1';
//protected $db_database = 'jojobboard';
protected $conn;

    public function __construct(){
        // Enable the connection to the database. Throw and exception in case of an error
        try {
            $this->open_con(); }
        catch (Exception $e) {
            echo '<div>There has been problems with connecting with the database. Please try again later</div>';
        }

    }

    private function open_con() {

        $this->conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_DATABASE);
        if ($this->conn->connect_error) {
        throw new Exception("Can't connect to the database");
        }

    }


    public function execute_query($sql) {

    $result = $this->conn->query($sql);

    if ($this->conn->error) die("error".$this->conn->error);
    else {
        return $result;
        }

    }

    public function sanitize($string) {
        if (get_magic_quotes_gpc()) $string = stripslashes($string);
        $string = $this->conn->real_escape_string($string);
        return $string;

    }

   public function close() {
        $this->conn->close();
    }

}

$db = new Database;
