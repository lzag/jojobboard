<?php
namespace App\Controllers;

use User;
use Employer;
use App\Helpers\AppUser;
use App\Controllers\Controller;

class Home extends Controller {
    
    public function index() {
        if (AppUser::isUser()) {
            $user = new User;
            $employer = false;
        } else if (AppUser::isEmployer()) {
            $user = false;
            $employer = new Employer;
        } else {
            $user = $employer = false;
        }
        $this->view('index', ['user' => $user, 'employer' => $employer]);
    }
}
