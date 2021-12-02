<?php

namespace App\Controllers;

use User;
use Employer;
use Alert;

class ProfileController extends Controller
{
    public function show()
    {
        if (isset($_SESSION['employer'])) {
            $employer = new Employer();
            $this->view('employerprofile', ['employer' => $employer]);
        } elseif (isset($_SESSION['user'])) {
            $user = new User();
            $this->view('userprofile', ['user' => $user]);
        }
    }

    public function store()
    {
    }

    public function destroy()
    {
        if (isset($_SESSION['user'])) {
            $user = new User();
            $result = $user->removeUser();
            if ($result) {
                $alert = new Alert("User removed", "success");
            }
        } elseif ($_SESSION['employer']) {
            $employer = new Employer();
            $result = $employer->removeEmployer();
            if ($result) {
                $alert = new Alert("Employer account removed", "success");
            }
        } else {
            $alert = new Alert("You are not logged in", "danger");
        }
        session_destroy();
        $this->view('login.index', ['alert' => $alert]);
    }

    public function edit()
    {
        $this->view('profile.edit', ['user' => new User()]);
    }

    public function update()
    {
        global $db;

        $user = new User();
        if (isset($_FILES['photo'])) {
            if ($_FILES['photo']['error'] == 0) {
                if (getimagesize($_FILES['photo']['tmp_name'])) {
                    $final_path = "users/images/photo_" . $user->getProperty('user_id');
                    move_uploaded_file($_FILES['photo']['tmp_name'], $final_path);
                    show_alert("Photo uploaded successfully", "success");
                } else {
                    show_alert("The uploaded file is not an image, please upload a jpg/gif/png file.", "danger");
                }
            } elseif ($_FILES['photo']['error'] != 4) {
                show_alert("There has been an error uploading the file", "danger");
            }
        }


        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
            $query = "UPDATE users SET first_name= ?, second_name= ?, title= ?, bio= ?, email= ?";
            $query .= " WHERE user_id = ?";
            $stmt = $db->con->prepare($query);
            $stmt->execute(array(
                $_POST['first_name'],
                $_POST['last_name'],
                $_POST['title'],
                $_POST['bio'],
                $_POST['email'],
                $_POST['user_id']
                ));
            if ($stmt->rowCount()) {
                show_alert("Details updated", "success");
            }
        }

        $this->view('profile.edit', ['user' => new User()]);
    }
}
