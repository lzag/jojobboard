<?php

namespace App\Controllers;

use User;
use Employer;
use App\Alert;
use Exception;
use App\Database;

class ProfileController extends Controller
{
    public function show(): void
    {
        if (isset($_SESSION['employer'])) {
            $employer = new Employer();
            $this->view('employerprofile', ['employer' => $employer]);
        } elseif (isset($_SESSION['user'])) {
            $user = new User();
            $this->view('userprofile', ['user' => $user]);
        }
    }

    public function store(): void
    {
    }

    public function destroy(): void
    {
        if (isset($_SESSION['user'])) {
            $user = new User();
            $result = $user->removeUser();
            if ($result) {
                $alert = new Alert("User removed", "success");
            } else {
                $alert = new Alert("Error removing user", "danger");
            }
        } elseif ($_SESSION['employer']) {
            $employer = new Employer();
            $result = $employer->removeEmployer();
            if ($result) {
                $alert = new Alert("Employer account removed", "success");
            } else {
                $alert = new Alert("Error removing employer account", "danger");
            }
        } else {
            $alert = new Alert("You are not logged in", "danger");
        }
        session_destroy();
        $this->view('login.index', ['alert' => $alert]);
    }

    public function edit(): void
    {
        $user = new User();
        $this->view('profile.edit', ['user' => new User()]);
    }

    public function update(): void
    {
        try {
            $db = Database::getInstance();
            $user = new User();
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
                if ($_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
                    throw new Exception('There has been an error uploading photo file');
                }

                if (!getimagesize($_FILES['photo']['tmp_name'])) {
                    throw new Exception('The uploaded file is not an image, please upload a jpg/gif/png file.');
                }

                $final_path = "users/images/photo_" . $user->getProperty('user_id');

                if (!move_uploaded_file($_FILES['photo']['tmp_name'], $final_path)) {
                    throw new Exception('Error uploading photo file');
                };

                show_alert("Photo uploaded successfully", "success");
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
                if (!intval($_POST['user_id'])) {
                    throw new Exception('User id missing');
                }

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
        } catch (Exception $e) {
            $this->view(
                'profile.edit',
                ['user' => $user, 'alert' => new Alert($e->getMessage(), 'danger')]
            );
        }
    }
}
