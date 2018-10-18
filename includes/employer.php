<?php

class Employer {
    public $employer_id;
    var $tax_id;
    var $company_name;
    private $password;
    var $contact_first_name;
    var $contact_second_name;
    var $contact_email;
    var $city;
    private $db;

    function __construct() {
        $this->db = new Database();
         $this->contact_email = $_SESSION['employer'];
        $this->employer_id = $this->getEmployerID($this->contact_email);
    }

   public function create_employer_account($tax_id,$company_name,$password,$contact_first_name,$contact_second_name,$contact_email,$city){
   }

    public function getEmployerID($contact_email) {
        $query = "SELECT employer_id FROM employers WHERE contact_email='$contact_email'";
        $result = $this->db->execute_query($query);
        $row = $result->fetch_array();
        return $row['employer_id'];
    }

     public function getTaxID($contact_email) {
        $query = "SELECT tax_id FROM employers WHERE contact_email='$contact_email'";
        $result = $this->db->execute_query($query);
        $row = $result->fetch_array();
        return $row['tax_id'];
    }

     public function getContactEmail($contact_email) {
        $query = "SELECT contact_email FROM employers WHERE contact_email='$contact_email'";
        $result = $this->db->execute_query($query);
        $row = $result->fetch_array();
        return $row['contact_email'];
    }

     public function getContactFirstName($contact_email) {
        $query = "SELECT contact_first_name FROM employers WHERE contact_email='$contact_email'";
        $result = $this->db->execute_query($query);
        $row = $result->fetch_array();
        return $row['contact_first_name'];
    }

     public function getContactSecondName($contact_email) {
        $query = "SELECT contact_second_name FROM employers WHERE contact_email='$contact_email'";
        $result = $this->db->execute_query($query);
        $row = $result->fetch_array();
        return $row['contact_second_name'];
    }

     public function getCity($contact_email) {
        $query = "SELECT city FROM employers WHERE contact_email='$contact_email'";
        $result = $this->db->execute_query($query);
        $row = $result->fetch_array();
        return $row['city'];
}
      function getApplications($pid) {
    $query = "SELECT a.application_id as 'Application ID',a.posting_id as 'Posting ID', concat(b.first_name, ' ', b.second_name) as 'Candidate', b.email as 'Contact email', b.cv_file as 'Download CV' FROM applications a LEFT OUTER JOIN users b ON a.user_id=b.user_id WHERE a.posting_id=$pid";
    $result = $this->db->execute_query($query);
    return $result;
}

    function getPostings() {
            $query = "SELECT p.posting_id as 'ID', p.title as 'Job Title', count(a.user_id) as 'Applications' FROM postings p
 				LEFT OUTER JOIN applications a ON p.posting_id  = a.posting_id
               	INNER JOIN employers e on e.employer_id = p.employer_id
                WHERE e.contact_email='$this->contact_email'
                group by ID";
    $result = $this->db->execute_query($query);
    return $result;
    }

    function reviewApp($pid,$status,$appid) {
        $query = "UPDATE applications SET status='$status' WHERE application_id='$appid'";
        $result = $this->db->execute_query($query);
        return $result;
    }

     public function removeEmployer() {
        $query = "DELETE FROM employers WHERE contact_email='$this->contact_email'";
        $result = $this->db->execute_query($query);
        if ($result) echo "Employer account removed";
    }
}

