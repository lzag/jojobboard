<?php

namespace App\Controllers;

use App\Controllers\Controller;
use PDO;
use Employer;
use Exception;

class ApplicationsController extends Controller
{
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

    public function create()
    {
        // put the application in the database

        // redirect to the main page or echo json response
    }

    public function show()
    {
        $this->view('applications.show', []);
    }

    public function edit()
    {
        $this->view('applications.edit', []);
    }

    public function update()
    {
        // update the model with relevant data

        // echo ajax response or redirect to the main show page
    }

    public function delete()
    {
        // delete the application from database

        // echo ajax response
    }

    public function review()
    {
        $employer = new Employer();
        $pid=$_GET['posting'];
        if (isset($_GET['review']) && isset($_GET['appid'])) {
            $status = $_GET['review'];
            $appid= $_GET['appid'];
            $employer->reviewApp($pid, $status, $appid);
            echo "Application reviewed. Status: {$_GET['review']}<br>";
            echo "<a href='/reviewapplications?posting=$pid'> Go back</a>";
        } else {
            $result = $employer->getApplications($pid);
            for ($i = 0 ; $i < $result->rowCount(); $i++) {
                $items = $result->fetchAll();
                foreach ($items as $arr) {
                    foreach ($arr as $key => $v) {
                        if ($key == 'Download CV') {
                            echo "$key : <a href='$v'> Link</a> <br>";
                        } else {
                            echo "$key : $v <br>";
                        }
                    }
                    $appid=$arr['Application ID'];
                    echo "Review: <a href='/reviewapplications?posting=$pid&appid=$appid&review=IN%20PROCESS' style='color:green'>APPROVE</a> | <a href='/reviewapplications?posting=$pid&appid=$appid&review=DENIED' style='color:red'>DENY</a>";
                    echo "<br><br>";
                }
            }
        }
    }

    public function withdraw(): void
    {
        global $db;
        $email = $_SESSION['user'];
        $query = "SELECT user_id FROM users WHERE email= ?";
        $stmt = $db->con->prepare($query);
        $stmt->execute(array($email));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_id = $result['user_id'];

        $query = "DELETE FROM applications WHERE user_id= ? AND application_id= ?";
        $stmt = $db->con->prepare($query);
        $stmt->execute(array($user_id, $_GET['id']));

        if (!$stmt->rowCount()) {
            echo "Was not possible to delete";
        } else {
            echo "Application withdrawn";
        }
    }

    public function applied()
    {
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
