<?php



class Database extends mysqli {

protected $db_hostname = 'localhost';
protected $db_username = 'johannes';
protected $db_password = 'L1pk0vsk1';
protected $db_database = 'jojobboard';
protected $conn;

    public function __construct(){
    $this->conn = new mysqli($this->db_hostname,$this->db_username,$this->db_password,$this->db_database);
    parent::__construct(this->conn);
    if ($this->conn->connect_error) die("Couldn't connect to the database");
    }

    public function execute_query($sql) {
    $result = $this->conn->query($sql);
    if ($this->conn->error) die("error".$this->conn->error);
    else {
        return $result;
        }

    }

   public function close() {
        $this->conn->close();
    }


}
