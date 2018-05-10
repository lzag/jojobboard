<?php

class User {

    private $user_id;
    private $first_name;
    private $second_name;
    private $email;
    private $password;
    private $ip_address;
    private $cv_file;
    // Not yet ready
    // private $photo;


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
          return false;
      }

    }


    public function removeUser() {

        $this->deleteCV();
        $query = "DELETE FROM jjb_users WHERE email='$this->email'";
        $result = $this->do_query($query);
        if ($result) echo "User removed";

    }

    function fetchApplications() {

    $query = "SELECT p.posting_id, p.title, e.company_name, a.application_time, a.status, a.application_id FROM jjb_applications a
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

    function uploadCV() {

        global $db;
        if (isset($_SESSION['user'])) {
        if (isset($_FILES['CV'])) {
        $query = "SELECT user_id FROM jjb_users WHERE email='".$_SESSION['user']."'" ;
        $result = $db->execute_query($query);

        if ($result->num_rows){

            $user_row = $result->fetch_assoc();
            $user_id = $user_row['user_id'];
            $filename = $_FILES['CV']['name'];

            if (!move_uploaded_file($_FILES['CV']['tmp_name'], "./uploads/$user_id"."_"."$filename")) {

                echo "<span class='text-danger'>Couldn't upload the file</span>";

            } else {

                $filepath = "./uploads/$user_id"."_"."$filename";
                $query_CV = "UPDATE jjb_users SET cv_file='$filepath' WHERE email='".$_SESSION['user']."'";
                $result_upl = $db->execute_query($query_CV);
                if ($result_upl) echo "<span class='text-success'>File <a href='$filepath'>". $filename ."</a> uploaded successfully</span>";
                require_once 'footer.php';
                die;

                }
            }
        }

        } else die("You are not logged in");



    }

    function register_user() {

    global $db;
    if (isset($_POST['first_name']) &&
    isset($_POST['second_name']) &&
    isset($_POST['email']) &&
    $_POST['first_name'] != "" &&
    $_POST['second_name'] != "" &&
    $_POST['email'] != "") {

    $fn = $_POST['first_name'];
    $sn = $_POST['second_name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
    $query_add_user = "INSERT INTO jjb_users(first_name,second_name,email,password) VALUES('$fn','$sn','$email','$pass')";
    $db->execute_query($query_add_user);
    echo "User successfully registered. Please log in.";

    }
    }

}
