<?php
namespace App\Controllers;

use stdClass;
use Employer;
use App\Database;
use App\Models\JobAd;
use App\Helpers\Pagination;
use App\Careerjet_API;
use User;

class JobadsController extends Controller {
    public function index() {
        echo "<pre>";
        $jobads = JobAd::fetchList(null, null);
        // TODO get back fill
        // $careerjet = new Careerjet_API('en_US');
        // $backfill = $careerjet->search(
        //     [
        //     'keyword' => '',
        //     'affid'      => '0afaf0173305e4b9',
        //     ]
        // );

        $this->view(
            'jobads.index', 
            [
            'user' => new User, 
            'jobads' => $jobads->items,
            // 'backfill' => $backfill,
            ]
        );
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