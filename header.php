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

if ($loggedinasuser) {

echo <<<_END
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>JoJobboard - $sitename</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
       <div class="col-sm-12 bg-primary text-white text-center">Main Menu</div>
    </div>
    <div class="row">
        <div class="col bg-primary"></div>
       <div class="col-sm-2 ml-auto text-primary border border-primary"><a href="index.php">Main Page</a></div>
       <div class="col-sm-2 text-primary border border-primary"><a href="uploadcv.php">Upload CV</a></div>
       <div class="col-sm-2 text-primary border border-primary"><a href="jobpostings.php">Job postings</a></div>
       <div class="col-sm-2 text-primary border border-primary"><a href="userprofile.php">Your profile</a></div>
       <div class="col-sm-2 mr-auto text-primary border border-primary"><a href="logout.php">Log out</a></div>
       <div class="col bg-primary"></div>
        <br>
    </div>
    <div class="row">
        <div class="col-sm-12">
        <p class="text-center text-secondary">===================================</p>
        <br>
    </div>
        </div>
</div>
_END;

    } elseif ($loggedinasemployer) {

    echo <<<_END
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>JoJobboard - $sitename</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
       <div class="col-sm-12 bg-primary text-white text-center">Main Menu</div>
    </div>
    <div class="row">
        <div class="col bg-primary"></div>
       <div class="col-sm-2 ml-auto text-primary border border-primary"><a href="index.php">Main Page</a></div>
       <div class="col-sm-2 text-primary border border-primary"><a href="postjob.php">Post a job</a> </div>
       <div class="col-sm-2 text-primary border border-primary"><a href="employerprofile.php">See your profile</a></div>
       <div class="col-sm-2 mr-auto text-primary border border-primary"><a href="logout.php">Log out</a></div>
       <div class="col bg-primary"></div>
        <br>
    </div>
    <div class="row">
        <div class="col-sm-12">
        <p class="text-center text-secondary">===================================</p>
        <br>
    </div>
        </div>
</div>
_END;


} else {
    echo <<<_END
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>JoJobboard - $sitename</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
       <div class="col-sm-12 bg-primary text-white text-center">Main Menu</div>
    </div>
    <div class="row">
        <div class="col bg-primary"></div>
       <div class="col-sm-2 ml-auto text-primary border border-primary"><a href="index.php">Main Page</a></div>
       <div class="col-sm-2 text-primary border border-primary"><a href="registeruser.php">Register User</a> </div>
       <div class="col-sm-2 text-primary border border-primary"><a href="registeremployer.php">Register Employer</a></div>
       <div class="col-sm-2 mr-auto text-primary border border-primary"><a href="login.php">Log In</a></div>
       <div class="col bg-primary"></div>
        <br>
    </div>
    <div class="row">
        <div class="col-sm-12">
        <p class="text-center text-secondary">===================================</p>
        <br>
    </div>
        </div>
</div>
_END;
}
?>
