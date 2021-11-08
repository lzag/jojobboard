<?php
namespace App\Controllers;

use App\Controllers\Controller;
use PDO;
use Exception;

class ApplicationsController extends Controller {

    public function index() 
    {
        // show all applications
        global $db;
        if (isset($_GET['id']) && $_GET['id'] != "") {
            $query = "SELECT * FROM postings WHERE posting_id= ?";
            $stmt = $db->con->prepare($query);
            $stmt->execute(array($_GET['id']));
            $row_post = $stmt->fetch(PDO::FETCH_ASSOC);

            if (isset($_SESSION['user'])) {

                $stmt = $db->con->prepare(
                    "SELECT user_id, first_name, second_name, email, cv_file 
                    FROM users 
                    WHERE email= ?"
                );
                $stmt->execute(array($_SESSION['user']));
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        }
        $this->view(
            'applications.index', 
            ['row_post' => $row_post, 'result' => $result]
        );
    }

    public function create() {
        // put the application in the database

        // redirect to the main page or echo json response
    }

    public function show() {
        $this->view('applications.show', []);
    }

    public function edit() {
        $this->view('applications.edit', []);
    }

    public function update() {
        // update the model with relevant data
        
        // echo ajax response or redirect to the main show page
    }

    public function delete() {
        // delete the application from database

        // echo ajax response
    }

    public function applied() {
        
        global $db;
        $params = [];
        if (isset($_POST['user_id']) && isset($_POST['posting_id'])) {
            $user_id = $_POST['user_id'];
            $posting_id = $_POST['posting_id'];
            $query = "INSERT INTO applications(user_id, posting_id) VALUES(?, ?)";
            $stmt = $db->con->prepare($query);
            $stmt->execute(array($user_id, $posting_id));
            $params['stmt'] = $stmt;
        }
        $this->view('applications.applied', $params);
    }
}