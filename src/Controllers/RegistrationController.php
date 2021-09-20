<?php
namespace App\Controllers;

use App\Database;
use Alert;
use User;

class RegistrationController extends Controller {

    public function employer() {
        if (!empty($_POST['tax_id']) &&
            !empty($_POST['company_name']) &&
            !empty($_POST['contact_first_name']) &&
            !empty($_POST['contact_second_name']) &&
            !empty($_POST['contact_email']) &&
            !empty($_POST['pass']) &&
            !empty($_POST['city'])
           )
        {
            $tid = $_POST['tax_id'];
            $cn = $_POST['company_name'];
            $cfn = $_POST['contact_first_name'];
            $csn = $_POST['contact_second_name'];
            $email = $_POST['contact_email'];
            $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
            $city = $_POST['city'];
            $connect = new Database;
            $query_add_user = "INSERT INTO employers(tax_id,company_name,contact_first_name,contact_second_name,contact_email,password, city) VALUES('$tid','$cn','$cfn','$csn','$email','$pass','$city')";
            $result_add = $connect->con->query($query_add_user);
            if ($result_add) {
                $alert = new Alert("Employer account created, please log in", "success");
                // header('Location: /login');
                $this->view('login.index');
            } else {
                $alert = new Alert("Error creating employer account", "danger");
                $this->view('register.employer');
            }

        } else {
            $this->view('register.employer');
        }
    }

    public function showemployer() {
        $this->view('register.employer');
    }

    public function showuser() {
        $this->view('register.user');
    }

    public function user() {
        global $db;
        if (isset($_POST['first_name'], $_POST['second_name'], $_POST['email']) &&
        $_POST['first_name'] != "" &&
        $_POST['second_name'] != "" &&
        $_POST['email'] != "") {

            $fn = $db->sanitize($_POST['first_name']);
            $sn = $db->sanitize($_POST['second_name']);
            $email = $db->sanitize($_POST['email']);
            $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
            $ip = $_POST['IP'];
            $code = randKey($email);
            $query = "INSERT INTO users(first_name, second_name, email, password, ip_address, valid_code)";
            $query .= " VALUES(?, ?, ?, ?, ?, ?)";
            $stmt = $db->con->prepare($query);
            $result = $stmt->execute(array($fn, $sn, $email, $pass, $ip, $code));
            var_dump($stmt->errorInfo());

            if($stmt->errorInfo()[1] == 1062) {

                $msg = "The email you're trying to use is already in our database";
                show_alert($msg,"danger");

            } elseif ($stmt->errorCode() != 0) {

                $msg = var_export($stmt->errorInfo(), true);
                // $msg = "There has been an error in the registration, pleae try again";
                show_alert($msg,"danger");

            } else {

                $body = "Please click the following link to activate the account: <a href=\"".DEV_URL."/register/user?valid_code=$code&email=$email\">Activate</a>";
                send_email($email,"Activate your JoJobBoard account",$body,"");
                $msg = "An email with the activation link has been sent to your email. Please check your inbox and click on the link to activate your account";
                show_alert($msg,"success");
                $this->view('login.index');

            }
        } else {
            $this->view('register.user');
        }
       User::activate_user();
    }

   public function show_password_reset() {
       $this->view('recover');
   }

   public function password_reset() {
        User::recover_password();
   }
}
