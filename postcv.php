<?php

/** Files that are required to setting the website **/
require_once 'header.php';
?>
<br>
<br>

<div align="center">
Please provide your personal data and upload your CV.<br> An email confirmation will be send to the provided email address.<br> Thank you!<br><br>
<form method="post" action="postcv.php" enctype="multipart/form-data">
    Name: <input type="text" name="first_name"><br><br>
    Surname: <input type="text" name="second_name"><br><br>
    Email: <input type="email" name="email"><br><br>
    Select your CV: <input type="file" name="cv_file"><br><br>
    <input type="checkbox" name="data_agreement"> I agree to have my data processed by JoJobBoard<br>
    <input type="checkbox" name="ad_agreement">I agree to receive advertising information from JoJobBoard<br><br>
    <input type="hidden" name="ip_address" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
    Your IP address:
    <?php echo $_SERVER['REMOTE_ADDR']; ?>
    will be recorded in our database<br><br>
    <input type="submit" value="Submit CV"><br><br>

</form>
</div>

<div align="center">

<?php
    echo "<br>";
    /*print_r($_POST);echo "<br>";
    print_r($_FILES);echo "<br>";*/
    echo "<br>";
    if ($_POST) {
        if (isset($_POST['first_name'],$_POST['second_name'],$_POST['email'],$_POST['ip_address']) &&
            isset($_FILES['cv_file']) &&
            !empty($_POST['first_name'])) {

            $ad_check = isset($_POST['data_agreement']);
            switch ($ad_check) {
                case 0 :
                    echo "Please also check the data agreement before proceeding";
                    break;
                case 1 :
                    echo "You've submitted all your data correctly";
                    $username = $_POST['first_name'].$_POST['second_name'];
                    $filename = $_FILES['cv_file']['name'];
                        if (!move_uploaded_file($_FILES['cv_file']['tmp_name'], "./uploads/$username"."_"."$filename")){
                        echo ", but the upload failed";
                            } else {
                        echo " and file uploaded successfully";


                        $first_name = $_POST['first_name'];
                        $second_name = $_POST['second_name'];
                        $email = $_POST['email'];
                        $ip_address = $_POST['ip_address'];

                        $query = "INSERT INTO users (first_name, second_name, email, ip_address) VALUES (?, ?, ?, ?)";
                        $stmt = $db->con->prepare($query);
                        $stmt->execute(array($first_name, $second_name, $email, $ip_address));

                        if (!$stmt->rowCount()) die("<br>Database update failed :".$conn->error);

                        $to = $_POST['email'];
                        $subject = "You've registered to our service";
                        $msg = "Thank you for registering to JoJobBoard";
                        $headers =  'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'From: Lukasz Zagroba <lukasz.zagroba@gmail.com>' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        if (!mail($to,$subject,$msg,$headers)) die("Couldn't send the email");

                        }
                    break;

            }
        } else {
            echo "Please submit all data";

        } /*else {
        echo "Nothing submitted";
    }*/
    }
require_once 'footer.php';


?>
  </div>
