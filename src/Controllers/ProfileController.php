<?php

namespace App\Controllers;

use User;
use Employer;
use App\Alert;
use Exception;
use App\Database;
use App\Request\FileUpload;

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
            if ($result > 0) {
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

            if (!$user_id = intval($_POST['user_id'])) {
                throw new Exception('User id missing');
            }

            if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
                $allowed = [
                    'image/jpeg' => '.jpg',
                    'image/gif' => '.gif',
                    'image/png' => '.png',
                ];

                $photo = new FileUpload('photo', UPLOADS_DIR . "/users/images", $allowed);

                if (!$photo->isImage()) {
                    throw new Exception('The uploaded file is not an image, please upload a jpg/gif/png file.');
                }

                $photo->validateType();
                $photo->setFilename("photo_" . $user->getProperty('user_id'))->save();

                $query = "UPDATE users SET profile_image= ? WHERE user_id= ?";
                $stmt = $db->con->prepare($query);
                $stmt->execute([$photo->getFullFilename(), $user_id]);

                show_alert("Photo uploaded successfully", "success");
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
        } catch (Exception $e) {
            $this->view(
                'profile.edit',
                ['user' => $user, 'alert' => new Alert($e->getMessage(), 'danger')]
            );
        }
    }

    public function showPhoto(): void
    {
    }
}
