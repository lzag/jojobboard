<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// session_start();

// require_once 'includes/database.php';
// require_once 'includes/functions.php';
// require_once 'includes/employer.php';
// require_once 'includes/user.php';
// require_once 'includes/blogpost.php';
// require_once 'includes/jobpost.php';
// require_once 'includes/Careerjet_API.php';

//spl_autoload_register( function ($class) {
//    include 'includes/' . strtolower($class) . '.php';
//});

global $db;
$db = new App\Database;
$file = basename($_SERVER['REQUEST_URI'], ".php");
if (!in_array($file, ['login', 'registeruser', 'registeremployer'])) {
    if (isset($_COOKIE['rememberMe'])) {
        rememberUser();
        $user = new User;
    } elseif (isset($_SESSION['user'])) {
        $user = new User;
        if(time() - $_SESSION['last_login'] < 20 * 60) {
            $_SESSION['last_login'] = time();
        } else {
            session_destroy();
            header("Location: login.php");
            session_start();
            $_SESSION['msg'] = "Your session expired, please log in again";
            exit();
        }
    } elseif (isset($_SESSION['employer'])) {
        $employer = new Employer();
        if(time() - $_SESSION['last_login'] < 20 * 60) {
                $_SESSION['last_login'] = time();
            } else {
                session_destroy();
                header("Location: login.php");
                session_start();
                $_SESSION['msg'] = "Your session expired, please log in again";
                exit();
            }
    } else {
        header("Location: login.php");
        exit();
    }
}

if (isset($_COOKIE['visit'])) {
    $welcome = "Welcome back to JoJobBoard";
    setcookie('visit',time(),time()+1000000,"/");
} else {
    $welcome = "Welcome to JoJobBoard";
    setcookie('visit',time(),time()+1000000,"/");
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>JoJobboard</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>



<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark ">
        <a class="navbar-brand" href="#">JoJobBoard</a>
        <ul class="navbar-nav">

            <?php if (isset($_SESSION['user'])) : ?>

            <li class="nav-item">
                <a class="nav-link" href="index.php">Main Page</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="uploadcv.php">Upload CV</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="jobpostings.php">Job postings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="userprofile.php">Your profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Log out</a>
            </li>

            <?php elseif (isset($_SESSION['employer'])) : ?>

            <li class="nav-item">
                <a class="nav-link" href="index.php">Main Page</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="postjob.php">Post a job</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="employerprofile.php">See your profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Log out</a>
            </li>

            <?php else : ?>

            <li class="nav-item">
                <a class="nav-link" href="index.php">Main Page</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="registeruser.php">Register User</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="registeremployer.php">Register Employer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Log In</a>
            </li>

            <?php  endif; ?>

        </ul>
    </nav>
