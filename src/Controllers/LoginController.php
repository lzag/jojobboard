<?php
namespace App\Controllers;

use User;
use Exception;
use stdClass;

class LoginController extends Controller {

    public function index() {
        $msg = "Please input your login data:";
        // User::activate_user();
        $this->view('login.index', ['msg' => $msg]);
    }

    public function login_user() {
        try {
            global $db;
            if (isset($_POST['email']) && isset($_POST['pass'])) {

                // Sanitize the user input //
                $email = $db->sanitize($_POST['email']);
                $pass = $db->sanitize($_POST['pass']);

                $sql = "SELECT email, password, active FROM users WHERE email= ?";
                $stmt = $db->con->prepare($sql);
                $stmt->execute(array($email));
                if ($row = $stmt->fetch()) {
                    if($row['active'] == 1) {
                        $passdb = $row['password'];
                        if (password_verify($pass, $passdb)){
                            $_SESSION['user'] = $email;
                            $_SESSION['last_login'] = time();
                            $_SESSION['msg'] = "You have been logged in";
                            if (!empty($_POST['rememberMe'])) {
                                $rememberID = random_int(10000,99999);
                                $token = sha1(random_int(10000,99999).time().$email);
                                $expires = time() + 30 * 24 * 60 * 60;
                                $query  = "UPDATE users";
                                $query .= " SET rememberID = ?, sessionToken= ?, tokenExpire= ?";
                                $query .= " WHERE email= ?";
                                $stmt = $db->con->prepare($query);
                                $result = $stmt->execute(array($rememberID, hash("sha256", $token), $expires, $_POST['email']));
                                if ($stmt->rowCount()) {
                                    setcookie('rememberMe', $rememberID . '.' . $token, $expires);
                                }
                            } else {
                                setcookie('rememberMe','',time() - 100 * 30 * 24 * 60 * 60);
                            }
                            header('Location: /');
                            exit();
                        } else {
                            throw new Exception('Password invalid. Please try again');
                        }
                    } else {
                        throw new Exception('Your account has not been activated yet. Please check your email for the activation link.');
                    }
                } else {
                    $sql = "SELECT contact_email, password, active FROM employers WHERE contact_email= ?";
                    $stmt = $db->con->prepare($sql);
                    $stmt->execute(array($email));
                    if ($row = $stmt->fetch()) {
                        print_r($row);
                        if($row['active'] == 1) {
                            $passdb = $row['password'];
                            if (password_verify($pass, $passdb)){
                                $_SESSION['employer'] = $email;
                                $_SESSION['last_login'] = time();
                                $_SESSION['msg'] = "You have been logged in";
                                header('Location: /');
                                exit();
                            } else {
                                throw new Exception('Password invalid. Please try again');
                            }
                        } else {
                            throw new Exception('Your account has not been activated yet. Please check your email for the activation link.');
                        }
                    } else {
                        throw new Exception("We haven't found an account with these credential in our system, please register");
                    }
                }
            }
        } catch (Exception $e) {
            $alert = new stdClass;
            $alert->type = 'danger';
            $alert->message = $e->getMessage();
            $this->view('login.index', ['alert' => $alert]);
        }
    }

    public function destroy() {
        if (isset($_SESSION['user']) || isset($_SESSION['employer'])) {
            session_destroy();
            setcookie('rememberMe','',time() - 100 * 30 * 24 * 60 * 60);
            session_start();
        }
        $alert = new stdClass;
        $alert->type = 'success';
        $alert->message = "You have been logged out";
        $this->view('login.index', ['alert' => $alert]);
        // header("Location: /login");
    }
}