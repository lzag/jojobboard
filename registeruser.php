<?php

$sitename = "Register a new user";

require_once 'header.php';

if (isset($_POST['first_name']) &&
    isset($_POST['second_name']) &&
    isset($_POST['email']) &&
    $_POST['first_name'] != "" &&
    $_POST['second_name'] != "" &&
    $_POST['email'] != "")
{
echo "<div align='center'>Data OK <br>";
    $fn = $_POST['first_name'];
    $sn = $_POST['second_name'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $conn = new Database;
    # if ($conn->connect_error) die("Couldn't connect to the database");
    $query_add_user = "INSERT INTO jjb_users(first_name,second_name,email,password) VALUES('$fn','$sn','$email','pass')";
    $result_add = $conn->execute_query($query_add_user);
    # if ($conn->error) die("error".$conn->error);
    echo "User created, please <a href='login.php'>log in</a><br></div>";
    $conn->close();
} else {
    echo<<<_END
<div align="center">
<h3>Please provide us with your data to register a new user: </h3><br> <br>
<form method="post" action='registeruser.php'>
Name:   <input type="text" name="first_name"><br><br>
Surname: <input type="text" name="second_name"><br><br>
Email: <input type="email" name="email"><br><br>
Password: <input type="password" name="pass"><br><br>
<input type='submit' value="Create User">
</form>
</div>
_END;
}
?>

<?php
require_once 'footer.php';

?>
