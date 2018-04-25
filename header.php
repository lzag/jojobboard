<?php
session_start();
# require_once 'includes/dblogin.php';
require_once 'includes/database.php';
require_once 'includes/employer.php';
require_once 'includes/user.php';

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

if ($loggedinasuser) {

echo <<<_END
<html>
<div align="center">
<head>
<title>JoJobboard - $sitename</title>
Main Menu:<br>
<a href="index.php">Main Page</a> |
<a href="uploadcv.php">Upload CV</a> |
<a href="jobpostings.php">Job postings<a> |
<a href="userprofile.php">Your profile<a> |
<a href="logout.php">Log out<a>
<br>
===================================
<br>
</head>
</div>
<body>
_END;

    } elseif ($loggedinasemployer) {

    echo <<<_END
<html>
<div align="center">
<head>
<title>JoJobboard - $sitename</title>
Main Menu:<br>
<a href="index.php">Main Page</a> |
<a href="postjob.php">Post a job<a> |
<a href="employerprofile.php">See your profile<a>
<a href="logout.php">Log out<a>
<br>
===================================
<br>
</head>
</div>
<body>
_END;


} else {
    echo <<<_END
<html>
<div align="center">
<head>
<title>JoJobboard - $sitename</title>
Main Menu:<br>
<a href="index.php">Main Page</a> |
<a href="registeruser.php">Register User</a> |
<a href="registeremployer.php">Register Employer</a> |
<a href="login.php">Log In</a>
<br>
===================================
<br>
</head>
</div>
<body>
_END;
}
?>
