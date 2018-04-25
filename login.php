<?php

$sitename = "Log In";

require_once 'header.php';

if (isset($_POST['email']) &&
        isset($_POST['pass'])){
    $user = $_POST['email'];
    $pass = $_POST['pass'];
    $conn = new Database();
    $query_login = "SELECT email, password FROM jjb_users WHERE email='$user' AND password='$pass'";
    $result_check = $conn->execute_query($query_login);
    if ($result_check->num_rows == 1) {
        $_SESSION['user'] = $user;
        $_SESSION['pass'] = $pass;
         echo "You are now logged in as a user. Please go to the <a href='index.php'>Main Page</a>";
    } else {
        $query_login = "SELECT contact_email, password FROM jjb_employers WHERE contact_email='$user' AND password='$pass'";
        $result_check = $conn->execute_query($query_login);
            if ($result_check->num_rows == 1) {
                $_SESSION['employer'] = $user;
                $_SESSION['pass'] = $pass;
                echo "You are now logged in as a employer. Please go to the <a href='index.php'>Main Page</a>";
            } else echo "Username/password invalid";
    }
}
?>
<div align="center">
<h3>Please input your login data: </h3><br>
<form method="post" action='login.php'>
Email: <input type="email" name="email"><br><br>
Password: <input type="password" name="pass"><br><br>
<input type='submit' value="Log in">
</form>
</div>


<?php
require_once 'footer.php';
?>
