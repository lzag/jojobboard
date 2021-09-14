<?php
namespace App\Controllers;

use stdClass;
use Employer;
use App\Database;
use User;

class JobadsController extends Controller {
    public function index() {
        $this->view('jobads.index', ['user' => new User]);

    }

    public function store() {
        if (!empty($_POST['title']) && !empty($_POST['description'])) {
            $conn = new Database();
            $title = $_POST['title'];
            $description = $_POST['description'];
            $employer = new Employer();
            $employerid = $employer->employer_id;
            $query = "INSERT INTO postings (title,description,employer_id) VALUES ('$title','$description','$employerid')";
            $result = $conn->con->query($query);
            if($result->rowCount()) {
                $msg = "Job offer added";
                $alert = new stdClass;
                $alert->message = 'Job offer added';
                $alert->type = 'success';
                $this->view('jobads.add', ['alert' => $alert]);
            } else {
                die("<br>Database update failed :".$conn->error);
            }
        } else {
            $alert = new stdClass;
            $alert->message = 'Information missing in the post';
            $alert->type = 'danger';
            $this->view('jobads.add', ['alert' => $alert]);
        }
    }

    public function show() {

    }

    public function create() {
        $this->view('jobads.add');
    }
}