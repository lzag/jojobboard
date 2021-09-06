<?php
use App\Database;
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
    $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
    $city = $_POST['city'];
    $connect = new Database;
    $query_add_user = "INSERT INTO employers(tax_id,company_name,contact_first_name,contact_second_name,contact_email,password, city) VALUES('$tid','$cn','$cfn','$csn','$email','$pass','$city')";
    var_dump($query_add_user);
    $result_add = $connect->con->query($query_add_user);
    var_dump($result_add);
    if ($result_add) echo "Employer account created, please <a href='login.php'>log in</a><br></div>";
    // $connect->close();
} else {
    echo<<<_END
<div class="container">
<div class="col-sm-6 m-auto">
<h3>Please provide us with your data to register a new employer account: </h3><br>
<form method="post" action='registeremployer.php'>
Company Name:   <input type="text" name="company_name" class="form-control"><br>
Tax ID: <input type="text" name="tax_id" class="form-control"><br>
Contact First Name: <input type="text" name="contact_first_name" class="form-control"><br>
Contact Second Name: <input type="text" name="contact_second_name" class="form-control"><br>
Contact Email: <input type="email" name="contact_email" class="form-control"><br>
Password: <input type="password" name="pass" class="form-control"><br>
City: <input type="text" name="city" class="form-control"><br>
<input type='submit' value="Create User" class="btn btn-primary">
</form>
</div>
</div>
_END;
}
?>

<?php
require_once 'footer.php';
?>
