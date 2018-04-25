<?php

class User {
    private $first_name;
    private $second_name;
    public $email;
    private $photo;
    private $cv;
    private $dbase;
    public $user_id;


    function __construct() {
        $this->dbase = new Database();
        $this->email = $_SESSION['user'];
        $this->user_id = $this->getUserID($this->email);

    }

    public function getFirstName($email) {
        $query = "SELECT first_name FROM jjb_users WHERE email='$email'";
        $result = $this->dbase->execute_query($query);
        $first_name = $result->fetch_array();
        return $first_name['first_name'];
    }

    public function getSecondName($email) {
        $query = "SELECT second_name FROM jjb_users WHERE email='$email'";
        $result = $this->dbase->execute_query($query);
        $first_name = $result->fetch_array();
        return $first_name['second_name'];
    }

    public function getEmail($email) {
        $query = "SELECT email FROM jjb_users WHERE  email='$email'";
        $result = $this->dbase->execute_query($query);
        $first_name = $result->fetch_array();
        return $first_name['email'];
    }

    public function getCV($email) {
        $query = "SELECT cv_file FROM jjb_users WHERE  email='$email'";
        $result = $this->dbase->execute_query($query);
        $first_name = $result->fetch_array();
        if ($first_name['cv_file']) return $first_name['cv_file'];
        else return "";

    }

      public function getUserID($email) {
        $query = "SELECT user_id FROM jjb_users WHERE  email='$email'";
        $result = $this->dbase->execute_query($query);
        $array = $result->fetch_array();
        return $array['user_id'];
    }

    public function removeUser() {
        $this->deleteCV();
        $query = "DELETE FROM jjb_users WHERE email='$this->email'";
        $result = $this->dbase->execute_query($query);
        if ($result) echo "User removed";
    }

    function fetchApplications() {
    $query = "SELECT p.posting_id as 'ID',p.title as 'Job Title', e.company_name as 'Company Name', a.application_time as 'Time applied', a.status as 'Status' FROM jjb_applications a
 				INNER JOIN jjb_postings p ON p.posting_id  = a.posting_id
                INNER JOIN jjb_users u ON u.user_id = a.user_id
                INNER JOIN jjb_employers e on e.employer_id = p.employer_id
                WHERE u.email='$this->email'";
    $result = $this->dbase->execute_query($query);
    return $result;
}
    function getAppStatus($posting_id) {
        $query = "SELECT status FROM jjb_applications WHERE user_id='$this->user_id' and posting_id='$posting_id'";
        $result = $this->dbase->execute_query($query);
        $status = $result->fetch_assoc();
        return $status['status'];
    }

    function deleteCV() {
        $cv = $this->getCV($this->email);
        unlink($cv);
    }


}
