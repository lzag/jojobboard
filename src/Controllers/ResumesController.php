<?php
namespace App\Controllers;

use User;
use finfo;
use PDO;
use stdClass;

class ResumesController extends Controller {
    public function index() {
        $this->view('resume.index');
    }

    public function upload() {
        global $db;
        if (isset($_SESSION['user'])) {
            $user = new User;
            if (isset($_FILES['CV'])) {
                $query = "SELECT user_id FROM users WHERE email= ?" ;
                $stmt = $db->con->prepare($query);
                $stmt->execute(array($_SESSION['user']));

                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $user_id = $row['user_id'];

                    $allowed = [
                        'application/msword' => 'doc',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
                        'application/pdf' => 'pdf'
                               ];
                    $finfo = new finfo();
                    $mime = $finfo->file($_FILES['CV']['tmp_name'], FILEINFO_MIME_TYPE);

                    if (key_exists($mime, $allowed)) {
                        $ext = $allowed[$mime];
                        $filename = $user->getProperty('first_name') . "_" . $user->getProperty('second_name') . "_CV." . $ext;
                        $filepath = UPLOADS_DIR . '/' . "$filename";
                        if (!move_uploaded_file($_FILES['CV']['tmp_name'], $filepath)) {

                            show_alert("Couldn't upload the file", "danger");

                        } else {

                            $query = "UPDATE users SET cv_file= ? WHERE email= ?";
                            $stmt = $db->con->prepare($query);

                            if ($stmt->execute(array($filename, $_SESSION['user']))) {
                                $alert = new stdClass;
                                $alert->type = 'success';
                                $alert->message = "File <a href='/resume/load'>" . $filename . "</a> uploaded successfully";
                                $this->view('resume.index', ['alert' => $alert]);
                            }
                        }
                    } else {
                        show_alert("Document type not allowed", "danger");
                    }
                }
            }
        } else {
            show_alert("You are not logged in.", "danger");
            die();
        }
    }

    function show() {
        global $db;
        $user = new User;
        $file = UPLOADS_DIR . '/' . $user->getProperty('cv_file');
        if (file_exists($file)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }

    }
}