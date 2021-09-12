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

            {if isset($smarty.session.user)}

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

            {elseif isset($smarty.session.employer)}

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

            {else}

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

            {/if}

        </ul>
    </nav>

{block name=alert}{/block}

{block name=content}{/block}

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/main.js"></script>
</body>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 m-auto text-center">
                <br>
                ============================
                <br>
                <p>Copyright: Lukasz Zagroba 2017 - {date("Y",time())}</p>
                <p>Contact: <a href="mailto:contact@jojobboard.com">contact@jojobboard.com</a></p>
            </div>
        </div>
    </div>
</footer>

</html>
