<?php

class User {

    private $user_id;
    private $first_name;
    private $second_name;
    private $title;
    private $bio;
    private $email;
    private $password;
    private $ip_address;
    private $cv_file;
    private $applications = [];
    // Not yet ready
    // private $photo;


    function __construct() {

        global $db;
        $this->email = $db->sanitize($_SESSION['user']);
        $this->getUserDetails();
        $this->fetchApplications();
    }

    public function __get($prop) {
        return "Empty";
    }

    private function getUserDetails() {

        global $db;
        $sql = "SELECT user_id, first_name, second_name, title, bio, email, password, ip_address, cv_file ";
        $sql .= " FROM users ";
        $sql .= " WHERE email= ?";

        $stmt = $db->con->prepare($sql);
        $stmt->execute(array($this->email));


        if ($user_details = $stmt->fetch(PDO::FETCH_ASSOC)) {

            foreach ($user_details as $k => $p) {
                if (property_exists('User',$k)) {
                    $this->$k = $p;
                }
            }
        }

    }

    private function do_query($sql) {

        global $db;
        $result = $db->execute_query($sql);
        return $result;

    }

    public function getProperty($prop) {
      if ($prop && $this->$prop) {
          return $this->$prop;
      } else {
          return "Empty";
      }

    }


    public function removeUser() {

        $this->deleteCV();
        $query = "DELETE FROM users WHERE email='$this->email'";
        $result = $this->do_query($query);
        if ($result) echo "User removed";

    }

    function fetchApplications() {

    global $db;
    $sql = "SELECT p.posting_id, p.title, e.company_name, a.application_time, a.status, a.application_id FROM applications a
 				INNER JOIN postings p ON p.posting_id  = a.posting_id
                INNER JOIN users u ON u.user_id = a.user_id
                INNER JOIN employers e on e.employer_id = p.employer_id
                WHERE u.email= ?";
    $stmt = $db->con->prepare($sql);
    $stmt->execute(array($this->email));

    return $this->applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    function getAppStatus($posting_id) {

        global $db;
        $sql = "SELECT status FROM applications WHERE user_id='$this->user_id' and posting_id='$posting_id'";
        $stmt = $db->con->prepare($sql);
        $stmt->execute(array($this->user_id, $posting_id));
        $status = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$status) {
            return 'Not applied yet';

        }
        return $status['status'];

    }

    function deleteCV() {

        $cv = $this->getProperty('cv_file');
        $cv ? unlink($cv) : "" ;

    }

    function uploadCV()
    {

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
                        $filepath = "./uploads/" . "$filename";
                        if (!move_uploaded_file($_FILES['CV']['tmp_name'], $filepath)) {

                            show_alert("Couldn't upload the file", "danger");

                        } else {

                            $query = "UPDATE users SET cv_file= ? WHERE email= ?";
                            $stmt = $db->con->prepare($query);

                            if ($stmt->execute(array($filepath, $_SESSION['user']))) {
                                show_alert("File <a href='$filepath'>". $filename ."</a> uploaded successfully", "success");
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

    static function register_user()
    {

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

                $body = "Please click the following link to activate the account: <a href=\"".DEV_URL."login.php?valid_code=$code&email=$email\">Activate</a>";
                send_email($email,"Activate your JoJobBoard account",$body,"");
                $msg = "An email with the activation link has been sent to your email. Please check your inbox and click on the link to activate your account";
                show_alert($msg,"success");

            }
        }

    }

    public static function activate_user() {

        global $db;
        if(isset($_GET['email']) && isset($_GET['valid_code'])) {
        $email = $db->sanitize($_GET['email']);
        $code = $db->sanitize($_GET['valid_code']);
        $query = "SELECT valid_code FROM users WHERE email='$email'";
        $result = $db->execute_query($query);
        if ($result->num_rows == 1) {

            $dbcode = $result->fetch_assoc()['valid_code'];

            if ($code === $dbcode) {

                $query = "UPDATE users SET active = 1, valid_code = 0 WHERE email='$email'";
                $result = $db->execute_query($query);

                if ($result) {

                $msg = "Your account has been activated, please log in";
                show_alert($msg,"success");

                    }

            } else {

                $msg = "Sorry, wrong validation code";
                show_alert($msg,"danger");

            }

        } else {

            $msg = "Your email has not been registered yet";
            show_alert($msg,"danger");

        }

    }

    }

    public static function recover_password() {

            global $db;
            if(isset($_POST['reset'])) {

            $email = $db->sanitize($_POST['email']);
            $token = $_POST['token'];
            $code = randKey($email);
            $query = "SELECT email FROM users WHERE email='$email'";
            $result = $db->execute_query($query);
            if ($result->num_rows == 1) {
            setcookie("token","$token",time()+60*5);
            $query = "UPDATE users SET valid_code = '$code', token = '$token' WHERE email='$email'";
            $result = $db->execute_query($query);

            if($result) {

                $body = "Please follow this link to reset your password: <a href=\"".DEV_URL."reset.php?code=$code&email=$email\">Reset password</a>";
                send_email($email, "Your password recovery link", $body,"");
                $msg = "We've just sent you an email with the reset link";
                show_alert($msg,"success");

                    } else {

                    $msg = "There has been a database problem, please try again later";
                    show_alert($msg,"danger");

                }
        }

    }
    }

    public static function reset_password() {

    global $db;

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if(isset($_GET['code']) && isset($_GET['email'])) {

    $email = $_GET['email'];
    $query = "SELECT valid_code, token FROM users WHERE email='$email'";
    $result = $db->execute_query($query);

    if ($result) {


    $row = $result->fetch_array();

        if(isset($_COOKIE['token'])) {

            if($_COOKIE['token'] == $row['token']) {

                if($row['valid_code'] == $_GET['code']) {

                    $msg = "Please introduce your new password";
                    show_alert($msg,"success");
                    return true;

                } else {

                    $msg = "Your validation code is incorrect";
                    show_alert($msg,"danger");
                    return false;

                }

            } else {

                $msg = "Can't verify the reset, please reset again";
                show_alert($msg,"danger");
                return false;

            }

        } else {

                $msg = "Your token has expired, please reset the password again";
                show_alert($msg,"danger");
                return false;

            }

    } else {

        $msg = "Your email was not found in the database";
        show_alert($msg,"danger");
        return false;

        }

    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if(isset($_POST['reset']) && isset($_POST['email'])) {

            $email = $_POST['email'];

            if ($_POST['password'] === $_POST['confirm_password']) {


            $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
            $query = "UPDATE users SET password = '$password', token = 0, valid_code = 0 WHERE email='$email'";
            $result = $db->execute_query($query);

            if($result && !($db->errno())) {

                $msg = "Your password has been updated, you can now log in";
                show_alert($msg,"success");

                } else {

                $msg = "Your password could not be updated, please try again later";
                show_alert($msg,"danger");

            }

            } else {

                $msg = "Your passwords don't match, please introduce them again";
                show_alert($msg,"danger");
                return true;

            }

        } else {

            $msg = "Error while sending form, please try to reset the password again";
            show_alert($msg,"success");

        }

    } else {

        $msg = "Site error, please try again later";
        show_alert($msg,"danger");

    }
}
}
