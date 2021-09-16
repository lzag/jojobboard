<?php
namespace App\Controllers;

use User;
use Employer;
use Alert;

class ProfileController extends Controller {
    public function show() {
        if(isset($_SESSION['employer'])) {
            $employer = new Employer;
            $this->view('employerprofile', ['employer' => $employer]);
        } else if (isset($_SESSION['user'])) {
            $user = new User;
            $this->view('userprofile', ['user' => $user]);
        }
    }

    public function store() {

    }

    public function destroy() {
        if (isset($_SESSION['user'])) {
            $user = new User;
            $result = $user->removeUser();
            if ($result)
                $alert = new Alert("User removed", "success");
        } elseif ($_SESSION['employer']) {
            $employer = new Employer;
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
}
