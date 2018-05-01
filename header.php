<?php
session_start();
# require_once 'includes/dblogin.php';
require_once 'includes/database.php';
require_once 'includes/employer.php';
require_once 'includes/user.php';
require_once 'includes/blogpost.php';

$userstr = ' (Guest)';

if (isset($_SESSION['user']))
{
    $user = $_SESSION['user'];
    $loggedinasuser = TRUE;
    $userstr = " ($user)";

} elseif (isset($_SESSION['employer']))
    {
    $user = $_SESSION['employer'];
    $loggedinasuser = FALSE;
    $loggedinasemployer = TRUE;
    $userstr = " ($user)";
    } else {
    $loggedinasuser = FALSE;
    $loggedinasemployer = FALSE;
    }

if (isset($_COOKIE['visit']))
        {
        $welcome = "Welcome back to JoJobBoard";
        $last_visit = $_COOKIE['visit_time'];

        setcookie('visit_time',time(),time()+1000000,"/");
        }
     else {
        setcookie('visit','ok',time()+1000000,"/");
        setcookie('visit_time',time(),time()+1000000,"/");
        $welcome = "Welcome to our site";
    }
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>JoJobboard - $sitename</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<?php if ($loggedinasuser) : ?>

<body>
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <a class="navbar-brand" href="#">JoJobBoard</a>
    <ul class="navbar-nav">
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
    </ul>
</nav>


<?php elseif ($loggedinasemployer) : ?>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <a class="navbar-brand" href="#">JoJobBoard</a>
    <ul class="navbar-nav">
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
    </ul>
</nav>

<?php else : ?>

<body>
 <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <a class="navbar-brand" href="#">JoJobBoard</a>
    <ul class="navbar-nav">
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
    </ul>
</nav>

<?php endif; ?>
