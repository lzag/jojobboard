<?php

/** Files that are required to setting the website **/

require_once 'header.php';

if (isset($_GET['id']) && $_GET['id'] != "") {
    $query="SELECT * FROM jjb_postings WHERE posting_id=".$_GET['id'];
    $result = $db->execute_query($query);
    $row_post = $result->fetch_assoc();
    echo "<div align='center'>";
    echo '<h2>' . $row_post['title'] . '</h2><br>';
    echo 'Posting ID: ' . $row_post['posting_id'] . '<br>';
    echo 'Job description:<br> ' . $row_post['description'] . '<br>';
    echo 'Posted on: ' . $row_post['time_posted'] . '<br><br>';
    if (isset($_SESSION['user'])){
        $get_user_data = "SELECT user_id,first_name,second_name,email,cv_file FROM jjb_users WHERE email='".$_SESSION['user']."'";
        $result_user_data = $db->execute_query($get_user_data);
        if ($result_user_data->num_rows) {
        $user_data = $result_user_data->fetch_array(MYSQLI_ASSOC);
        $user_id = $user_data['user_id'];
        echo "Your details: <br><br>";
        echo "First name: ". $user_data['first_name'] . "<br>";
        echo "Second name: ". $user_data['second_name'] . "<br>";
        echo "Email: ". $user_data['email'] . "<br>";
            if (!$user_data['cv_file']){
                echo "<span class='text-danger'>Your CV is not uploaded. Please upload it <a href='uploadcv.php'> here</a></span>";
            } else  echo "CV file: ". $user_data['cv_file'];
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
