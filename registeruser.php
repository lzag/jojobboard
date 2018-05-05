<?php

$sitename = "Register a new user";

require_once 'header.php';

if (isset($_POST['first_name']) &&
    isset($_POST['second_name']) &&
    isset($_POST['email']) &&
    $_POST['first_name'] != "" &&
    $_POST['second_name'] != "" &&
    $_POST['email'] != "") :


    $fn = $_POST['first_name'];
    $sn = $_POST['second_name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
    $query_add_user = "INSERT INTO jjb_users(first_name,second_name,email,password) VALUES('$fn','$sn','$email','$pass')";
    $db->execute_query($query_add_user);
    echo "User successfully registered. Please log in.";
    $db->close();

 else : ?>

    <div class="container">
        <div class="col w-50 m-auto">
            <form method="post" action='registeruser.php'>
            <h3 class="form-header">Please provide us with your data to register a new user: </h3>
                <div class="form-group">
                    <label for="first_name">Name:</label>
                    <input type="text" name="first_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="second_name">Surname:</label>
                    <input type="text" name="second_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="pass" class="form-control">
                </div>
                <input type='submit' value="Create User" class="btn btn-primary form-control">
            </form>
        </div>
    </div>

    <?php
    endif;
    require_once 'footer.php';

?>
