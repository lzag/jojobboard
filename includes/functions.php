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

function generate_token() {

    return sha1(mt_rand(10000,99999).time());

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

function pagination($total_results = 100, $per_page = 10) {

        $total_pages = ceil($total_results / $per_page);
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $url = $_SERVER['REQUEST_URI'];
        $curr = isset($_GET['page']) ? $_GET['page'] : 1;
        $prev = ($curr > 1) ? $curr - 1 : false;
        $next = ($curr < $total_pages) ? $curr + 1 : false;

// PREVIOUS PART OF PAGINATION
if ($prev) {

$link = preg_replace("/(\?page=)(\d+)/","?page=$prev",$url);
echo <<<HTML
<nav aria-label="...">
  <ul class="pagination">
    <li class="page-item">
      <a class="page-link" href="$link" tabindex="-1">Previous</a>
    </li>
HTML;

} else {

echo <<<HTML
<nav aria-label="...">
  <ul class="pagination">
    <li class="page-item disabled">
      <a class="page-link" href="#" tabindex="-1">Previous</a>
    </li>
HTML;

}

// MIDDLE PART OF THE PAGINATION
    for($i = 1; $i <= $total_pages; $i++){

        $link = preg_replace("/(\?page=)(\d+)/","?page=$i",$url);

        if ($i === $curr) {

            echo <<<HTML
            <li class="page-item active"><a class="page-link" href="$link">{$i}<span class="sr-only">(current)</span></a></li>
HTML;

        } else {

        echo <<<HTML
            <li class="page-item"><a class="page-link" href="$link">{$i}</a></li>
HTML;
        }
    }

// END PART OF PAGINATION
if ($next) {

$link = preg_replace("/(\?page=)(\d+)/","?page=$next",$url);
echo <<<HTML
    <li class="page-item">
      <a class="page-link" href="$link">Next</a>
    </li>
  </ul>
</nav>
HTML;
} else {

echo <<<HTML
    <li class="page-item disabled">
      <a class="page-link" href="#">Next</a>
    </li>
  </ul>
</nav>
HTML;

}
}
?>
