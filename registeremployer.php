<?php
$sitename = "Register a new employer account";
require_once 'header.php';

if (isset($_POST['tax_id']) &&
    isset($_POST['company_name']) &&
    isset($_POST['contact_first_name']) &&
    isset($_POST['contact_second_name']) &&
    isset($_POST['contact_email']) &&
    isset($_POST['pass']) &&
    isset($_POST['city']) &&
    $_POST['tax_id'] != "" &&
    $_POST['company_name'] != "" &&
    $_POST['contact_first_name'] != "" &&
    $_POST['contact_second_name'] != "" &&
    $_POST['contact_email'] != "" &&
    $_POST['pass'] != "" &&
    $_POST['city'] != ""
   )
{
echo "<div align='center'>Data OK <br>";
    $tid = $_POST['tax_id'];
    $cn = $_POST['company_name'];
    $cfn = $_POST['contact_first_name'];
    $csn = $_POST['contact_second_name'];
    $email = $_POST['contact_email'];
    $pass = $_POST['pass'];
    $city = $_POST['city'];
    $connect = new Database;
    $query_add_user = "INSERT INTO jjb_employers(tax_id,company_name,contact_first_name,contact_second_name,contact_email,password, city) VALUES('$tid','$cn','$cfn','$csn','$email','$pass','$city')";
    $result_add = $connect->execute_query($query_add_user);
    if ($result_add) echo "Employer account created, please <a href='login.php'>log in</a><br></div>";
    $connect->close();
} else {
    echo<<<_END
<div align="center">
<h3>Please provide us with your data to register a new employer account: </h3><br> <br>
<form method="post" action='registeremployer.php'>
Company Name:   <input type="text" name="company_name"><br><br>
Tax ID: <input type="text" name="tax_id"><br><br>
Contact First Name: <input type="text" name="contact_first_name"><br><br>
Contact Second Name: <input type="text" name="contact_second_name"><br><br>
Contact Email: <input type="email" name="contact_email"><br><br>
Password: <input type="password" name="pass"><br><br>
City: <input type="text" name="city"><br><br>
<input type='submit' value="Create User">
</form>
</div>
_END;
}
?>

<?php
require_once 'footer.php';
?>
