<?php

class User {
    private $user_id;
    private $first_name;
    private $second_name;
    private $email;
    private $password;
    private $ip_address;
    // Not yet ready
    // private $photo;
    private $cv_file;


    function __construct() {

        global $db;
        $this->email = $db->sanitize($_SESSION['user']);
        $this->getUserDetails();

    }

    private function getUserDetails() {

        $sql = "SELECT user_id, first_name, second_name, email, password, ip_address, cv_file ";
        $sql .= " FROM jjb_users ";
        $sql .= " WHERE email='$this->email'";
        $user_details = $this->do_query($sql);
        if ($user_details->num_rows == 1) {
            $user_details = $user_details->fetch_assoc();
            foreach ($user_details as $k => $p) {
                if (property_exists('User',$k)) {
                    $this->$k = $p;
                }
            }
        }

    }

    private function do_query($sql) {

        global $db;
        $result = $db->execute_query($sql);
        return $result;

    }

    public function getProperty($prop) {
      if ($prop && $this->$prop) {
          return $this->$prop;
      } else {
          return "Empty";
      }

    }


    public function removeUser() {

        $this->deleteCV();
        $query = "DELETE FROM jjb_users WHERE email='$this->email'";
        $result = $this->do_query($query);
        if ($result) echo "User removed";

    }

    function fetchApplications() {

    $query = "SELECT p.posting_id, p.title, e.company_name, a.application_time, a.status FROM jjb_applications a
 				INNER JOIN jjb_postings p ON p.posting_id  = a.posting_id
                INNER JOIN jjb_users u ON u.user_id = a.user_id
                INNER JOIN jjb_employers e on e.employer_id = p.employer_id
                WHERE u.email='$this->email'";
    $result = $this->do_query($query);
    return $result;

    }

    function getAppStatus($posting_id) {

        $sql = "SELECT status FROM jjb_applications WHERE user_id='$this->user_id' and posting_id='$posting_id'";
        $status = $this->do_query($sql);
        $status = $status->fetch_assoc();
        return $status['status'];

    }

    function deleteCV() {

        $cv = $this->getProperty('cv_file');
        $cv ? unlink($cv) : "" ;

    }

}

//    public function getFirstName($email) {
//      return $this->first_name;
//    }
//
//    public function getSecondName($email) {
//       return this->second_name;
//    }
//
//    public function getEmail($email) {
//        return $this->email;
//    }

//      public function getUserID($email) {
//        $query = "SELECT user_id FROM jjb_users WHERE  email='$email'";
//        $result = $this->dbase->execute_query($query);
//        $array = $result->fetch_array();
//        return $array['user_id'];
//    }
