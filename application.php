<?php

/** Files that are required to setting the website **/

require_once 'header.php';

if (isset($_GET['id']) && $_GET['id'] != "") {
    $query = "SELECT * FROM postings WHERE posting_id= ?";
    $stmt = $db->con->prepare($query);
    $stmt->execute(array($_GET['id']));
    $row_post = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<div align='center'>";
    echo '<h2>' . $row_post['title'] . '</h2><br>';
    echo 'Posting ID: ' . $row_post['posting_id'] . '<br>';
    echo 'Job description:<br> ' . $row_post['description'] . '<br>';
    echo 'Posted on: ' . $row_post['time_posted'] . '<br><br>';

    if (isset($_SESSION['user'])) {

        $query = "SELECT user_id, first_name, second_name, email, cv_file FROM users WHERE email= ?";
        $stmt = $db->con->prepare($query);
        $stmt->execute(array($_SESSION['user']));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (count($result)) {
            $user_id = $result['user_id'];
            echo "Your details: <br><br>";
            echo "First name: ". $result['first_name'] . "<br>";
            echo "Second name: ". $result['second_name'] . "<br>";
            echo "Email: ". $result['email'] . "<br>";
            if (!$result['cv_file']){
                echo "<span class='text-danger'>Your CV is not uploaded. Please upload it <a href='uploadcv.php'> here</a></span>";
            } else  echo "CV file: ". $result['cv_file'];
            echo <<<_END
    <form action="applied.php" method="POST">
    <input type="hidden" name="user_id" value="$user_id">
    <input type="hidden" name="posting_id" value="{$_GET['id']}">
    <input type="submit" value="Finalize application" class="btn btn-primary">
_END;
            require_once 'footer.php';
            die();
            }
        } else echo "Error";
    }


    echo <<<_END
    <form action="application.php" method="GET">
    <input type="hidden" name="posting_id" value="{$_GET['id']}">
    <input type="submit" value="Apply" class="btn btn-primary">
    </form>
_END;

require_once 'footer.php';


?>
