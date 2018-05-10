<?php
const DEV_URL = "http://localhost/jojobboard/";
const PROD_URL = "";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function show_alert($msg, $type) {

// types = primary, success, danger

if ($msg) {
echo <<<_END
<div class="alert alert-$type alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>$msg</strong>
</div>
_END;

}
}

function send_email($email,$subject,$msg,$headers) {

    $mail = new PHPMailer(true);     // Passing `true` enables exceptions
try {
    //Server settings
//    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.mailtrap.io';                      // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'e9dc9895e339f1';                 // SMTP username
    $mail->Password = '16484b53627e27';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 2525;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('noreply@jojobboad.ga', 'JoJobBoard');
    $mail->addAddress($email);     // Add a recipient
//    $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('contact@jojobboard.ga');
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');

    //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $msg;
    $mail->AltBody = $msg;

    $mail->send();

//    echo 'Message has been sent';

} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
}

function randKey($email) {

     return sha1(mt_rand(10000,99999).time().$email);

}

function login() {

    global $db;
    if (isset($_POST['email']) &&
    isset($_POST['pass'])){

    // Sanitize the user input //
    $user = $db->sanitize($_POST['email']);
    $pass = $db->sanitize($_POST['pass']);

    $query_login = "SELECT email, password, active FROM jjb_users WHERE email='$user'";
    $result = $db->execute_query($query_login);
    if ($result->num_rows == 1) {

        $row = $result->fetch_assoc();

        if($row['active'] == 1) {

        $passdb = $row['password'];

        if (password_verify($pass, $passdb)){

        $_SESSION['user'] = $user;
        show_alert("You have been logged in","success");
        header('Location: index.php');

        } else {

            $msg = "Password invalid. Please try again:";
            show_alert($msg,"danger");

        }

        } else {

            $msg = "Your account has not been activated yet. Please check your email for the activation link.";
            show_alert($msg,"danger");

        }


    } else {

        $query_login = "SELECT contact_email, password, active FROM jjb_employers WHERE contact_email='$user'";
        $result = $db->execute_query($query_login);
        $row = $result->fetch_assoc();

        if ($result->num_rows == 1) {

        if($row['active'] == 1) {

        $passdb = $row['password'];

        if (password_verify($pass, $passdb)){

        $_SESSION['employer'] = $user;
        show_alert("You have been logged in","success");
        header('Location: index.php');

        } else {

            $msg = "Password invalid. Please try again:";
            show_alert($msg,"danger");

        }

        } else {

            $msg = "Your account has not been activated yet. Please check your email for the activation link.";
            show_alert($msg,"danger");

        }
}
}
}

    }
?>
