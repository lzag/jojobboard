<?php

class Employer
{
    public $employer_id;
    private $tax_id;
    private $company_name;
    private $password;
    private $contact_first_name;
    private $contact_second_name;
    private $contact_email;
    private $city;
    private $db;

    public function __construct()
    {
        $this->db = new App\Database();
        $this->contact_email = $_SESSION['employer'];
        $this->getEmployerDetails();
    }

    private function getEmployerDetails()
    {
        global $db;
        $sql  = "SELECT * ";
        $sql .= " FROM employers ";
        $sql .= " WHERE contact_email= ?";
        $stmt = $db->con->prepare($sql);
        $stmt->execute(array($this->contact_email));
        if ($user_details = $stmt->fetch(PDO::FETCH_ASSOC)) {
            foreach ($user_details as $k => $p) {
                if (property_exists('Employer', $k)) {
                    $this->$k = $p;
                }
            }
        }
    }

    public function getProperty($prop)
    {
        if ($prop && $this->$prop) {
            return $this->$prop;
        } else {
            return "Empty";
        }
    }

    public function getApplications($pid)
    {
        $query = "SELECT a.application_id as 'Application ID', a.posting_id as 'Posting ID'";
        $query .= ", concat(b.first_name, ' ', b.second_name) as 'Candidate'";
        $query .= ", b.email as 'Contact email', b.cv_file as 'Download CV'";
        $query .= " FROM applications a";
        $query .= " LEFT OUTER JOIN users b ON a.user_id=b.user_id";
        $query .= "  WHERE a.posting_id=$pid";
        $result = $this->db->con->query($query);
        return $result;
    }

    public function getPostings()
    {
        $query  = "SELECT p.posting_id as 'ID', p.title as 'Job Title', count(a.user_id) as 'Applications'";
        $query .= " FROM postings p ";
        $query .= " LEFT OUTER JOIN applications a ON p.posting_id=a.posting_id ";
        $query .= " INNER JOIN employers e on e.employer_id=p.employer_id";
        $query .= " WHERE e.contact_email='$this->contact_email'";
        $query .= " GROUP_BY ID";
        $result = $this->db->con->query($query);
        return $result;
    }

    public function reviewApp($pid, $status, $appid)
    {
        $query = "UPDATE applications SET status='$status' WHERE application_id='$appid'";
        $result = $this->db->con->query($query);
        return $result;
    }

    public function removeEmployer()
    {
        $query = "DELETE FROM employers WHERE contact_email='$this->contact_email'";
        $result = $this->db->con->query($query);
        if ($result) {
            echo "Employer account removed";
        }
    }
}
