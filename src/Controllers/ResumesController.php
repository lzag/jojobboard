<?php

namespace App\Controllers;

use User;
use finfo;
use PDO;
use stdClass;
use App\Database;
use App\Alert;
use Exception;

class ResumesController extends Controller
{
    public function index(): void
    {
        $this->view('resume.index');
    }

    public function upload(): void
    {
        try {
            if (!isset($_SESSION['user'])) {
                throw new Exception('You are not logged in');
            }

            if (!isset($_FILES['CV']) || $_FILES['CV']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception('File missing');
            }

            $allowed = [
                'application/msword' => 'doc',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
                'application/pdf' => 'pdf'
            ];

            $finfo = new finfo();
            $mime = $finfo->file($_FILES['CV']['tmp_name'], FILEINFO_MIME_TYPE);

            if ($mime === false) {
                throw new Exception('Error analysing the file');
            }

            if (!key_exists($mime, $allowed)) {
                throw new Exception('Document type not allowed');
            }

            $ext = $allowed[$mime];

            $user = new User();
            $filename = $user->getProperty('first_name') . "_" . $user->getProperty('second_name') . "_CV." . $ext;
            $filepath = UPLOADS_DIR . '/' . $filename;

            if (!move_uploaded_file($_FILES['CV']['tmp_name'], $filepath)) {
                throw new Exception("Couldn't upload the file");
            }

            $db = Database::getInstance();

            $stmt = $db->con->prepare("UPDATE users SET cv_file= ? WHERE email= ?");

            if (!($stmt->execute([$filename, $_SESSION['user']]) === true)) {
                throw new Exception('Error uploading file, please try again');
            }

            $this->view(
                'resume.index',
                ['alert' => new Alert("File <a href='/resume/load'>" . $filename . "</a> uploaded successfully")]
            );
        } catch (Exception $e) {
            $this->view('resume.index', ['alert' => new Alert($e->getMessage(), 'danger')]);
        }
    }

    public function show(): void
    {
        $user = new User();
        $file = UPLOADS_DIR . '/' . $user->getProperty('cv_file');
        if (file_exists($file)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . basename($file) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }
}
