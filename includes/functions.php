<?php
const DEV_URL = "http://jobboard.test";
const PROD_URL = "http://jobboard.lukaszzagroba.com";
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

function show_session_alert() {
    if (!empty($_SESSION['msg'])) {
    $msg = $_SESSION['msg'];
    $type = "success";
    echo <<<_END
    <div class="alert alert-$type alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>$msg</strong>
    </div>
_END;
    unset($_SESSION['msg']);
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

function rememberUser() {
    if (!empty($_COOKIE['rememberMe'])) {
        $cookie = explode(".",$_COOKIE['rememberMe']);
        $rememberID = $cookie[0];
        $cookie_token = hash('sha256', $cookie[1]);
        $db = new App\Database;
        $query = "SELECT sessionToken FROM users WHERE rememberID= ?";
        $stmt = $db->con->prepare($query);
        $stmt->execute(array($rememberID));
        if ($db_token = $stmt->fetch(PDO::FETCH_ASSOC)['sessionToken']) {
            if (hash_equals($cookie_token, $db_token)) {
                $query = "SELECT email, active FROM users WHERE rememberID= ?";
                $stmt = $db->con->prepare($query);
                $stmt->execute(array($rememberID));
                if ($row = $stmt->fetch()) {
                    if($row['active'] == 1) {
                        $_SESSION['user'] = $email;
                    }
                }
            }
        }
    }
}

function login()
{

    global $db;
    if (isset($_POST['email']) && isset($_POST['pass'])) {

        // Sanitize the user input //
        $email = $db->sanitize($_POST['email']);
        $pass = $db->sanitize($_POST['pass']);

        $sql = "SELECT email, password, active FROM users WHERE email= ?";
        $stmt = $db->con->prepare($sql);
        $stmt->execute(array($email));
        if ($row = $stmt->fetch()) {
            if($row['active'] == 1) {
                $passdb = $row['password'];
                if (password_verify($pass, $passdb)){
                    $_SESSION['user'] = $email;
                    $_SESSION['last_login'] = time();
                    $_SESSION['msg'] = "You have been logged in";
                    if (!empty($_POST['rememberMe'])) {
                        $rememberID = random_int(10000,99999);
                        $token = sha1(random_int(10000,99999).time().$email);
                        $expires = time() + 30 * 24 * 60 * 60;
                        $query  = "UPDATE users";
                        $query .= " SET rememberID = ?, sessionToken= ?, tokenExpire= ?";
                        $query .= " WHERE email= ?";
                        $stmt = $db->con->prepare($query);
                        $result = $stmt->execute(array($rememberID, hash("sha256", $token), $expires, $_POST['email']));
                        if ($stmt->rowCount()) {
                            setcookie('rememberMe', $rememberID . '.' . $token, $expires);
                        }
                    } else {
                        setcookie('rememberMe','',time() - 100 * 30 * 24 * 60 * 60);
                    }
                    header('Location: index.php');
                    exit();
                } else {
                    $msg = "Password invalid. Please try again:";
                    show_alert($msg,"danger");
                }
            } else {
                $msg = "Your account has not been activated yet. Please check your email for the activation link.";
                show_alert($msg,"danger");
            }
        } else {
            $sql = "SELECT contact_email, password, active FROM employers WHERE contact_email= ?";
            $stmt = $db->con->prepare($sql);
            $stmt->execute(array($email));
            if ($row = $stmt->fetch()) {
                print_r($row);
                if($row['active'] == 1) {
                    $passdb = $row['password'];
                    if (password_verify($pass, $passdb)){
                        $_SESSION['employer'] = $email;
                        $_SESSION['last_login'] = time();
                        $_SESSION['msg'] = "You have been logged in";
                        header('Location: index.php');
                        exit();
                    } else {
                    $msg = "Password invalid. Please try again:";
                    show_alert($msg,"danger");
                    }
                } else {
                $msg = "Your account has not been activated yet. Please check your email for the activation link.";
                show_alert($msg,"danger");
                }
            } else {
                $msg = "We haven't found an account with these credential in our system, please register";
                show_alert($msg,"danger");
            }
        }
    }
}

function showResults() {
    $offers = [];
    $page_size = (isset($_GET['per_page']) && !empty($_GET['per_page'])) ? (int) $_GET['per_page'] : 5;
    $local_offers = JobPost::get_posts();
    $local_hits = $offers['local_hits'] = count($local_offers);
    $foreign_offers = JobPost::get_backfill();
    $foreign_hits = $offers['foreign_hits'] = $foreign_offers->hits;
    $offers['total_hits'] = $local_hits + $foreign_hits;

    $total_pages = ceil(($local_hits + $foreign_hits) / $page_size);
    $local_pages = ceil($local_hits / $page_size);
    $current_page = (isset($_GET['page']) && !empty($_GET['page'])) ? (int) $_GET['page'] : 1;

    if ($rest = $local_hits % $page_size) {
        $first_foreign = $page_size - $rest;
    } else {
        $first_foreign = 0;
    }

    echo "We found $local_hits local and $foreign_hits foreign offers";

    $offset = ($current_page == 1) ? 0 : (($current_page - 1 ) * $page_size) - 1;
    if ($current_page < $local_pages) {

        $offers['local'] = JobPost::get_posts($page_size, $offset);
        return $offers;

    } elseif ($current_page == $local_pages) {

        $offers['local'] = JobPost::get_posts($page_size, $offset);
        if ($first_foreign) {
            $offers['foreign'] = JobPost::get_backfill($first_foreign)->jobs;
        }
        return $offers;

    } elseif ($current_page > $local_pages) {

        $start_num = ++$first_foreign + (($current_page - $local_pages - 1) * $page_size);
        $offers['foreign'] = JobPost::get_backfill($page_size, $start_num)->jobs;
        return $offers;
    }
}


function pagination($total_results = 100) {

    $per_page = (isset($_GET['per_page']) && !empty($_GET['per_page'])) ? (int) $_GET['per_page'] : 5;
    $total_pages = ceil($total_results / $per_page);
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $url = $_SERVER['REQUEST_URI'];
    $curr = isset($_GET['page']) ? $_GET['page'] : 1;
    $prev = ($curr > 1) ? $curr - 1 : false;
    $next = ($curr < $total_pages) ? $curr + 1 : false;

    if ($total_pages > 1) {
        // PREVIOUS PART OF PAGINATION
        if ($prev) {

            if (!empty($_GET)) {
                if (isset($_GET['page'])) {
                    $link = preg_replace('/([?&])(page=)(\d+)/', '${1}page='.$prev, $url);
                } else {
                    $link = $url . "&page=$prev";
                }
            } else {
                $link = $url . "?page=$prev";
            }

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
        if ($total_pages <= 10) {
            $start = 1;
            $end = $total_pages;
        } else {
            if ($curr > $total_pages - 4) {
                $start = $total_pages - 9;
                $end = $total_pages;
            } else {
                $start = (($curr - 5) > 0) ? $curr - 5 : 1;
                $end = $start + 9;
            }
        }

        for($i = $start; $i <= $end; $i++) {

            if (!empty($_GET)) {
                if (isset($_GET['page'])) {
                    $link = preg_replace('/([?&])(page=)(\d+)/', '${1}page='.$i, $url);
                } else {
                    $link = $url . "&page=$i";
                }
            } else {
                $link = $url . "?page=$i";
            }

            if ($i == $curr) {

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
            if (!empty($_GET)) {
                if (isset($_GET['page'])) {
                    $link = preg_replace('/([?&])(page=)(\d+)/', '${1}page='.$next, $url);
                } else {
                    $link = $url . "&page=$next";
                }
            } else {
                $link = $url . "?page=$next";
            }

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


    }

function echoGet($value) {
    if (isset($_GET[$value])) {
        return $_GET[$value];
    } else {
        return "";
    }
}

function selected($name, $option) {
    if (isset($_GET[$name])) {
        if ($_GET[$name] == $option) {
            return "selected";
        }
    }
}

?>
