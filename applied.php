<?php

require_once 'header.php';

if (isset($_POST['user_id']) && isset($_POST['posting_id'])) {
    $conn = new Database();
    #if ($conn->connect_error) die("Connection error".$conn->connect_error);
    $user_id = $_POST['user_id'];
    $posting_id = $_POST['posting_id'];
    $query = "INSERT INTO jjb_applications(user_id,posting_id) VALUES('$user_id','$posting_id')";
    $result = $conn->execute_query($query);
    # if ($conn->error) echo $conn->error;
     echo "Your application has been received. Please check out some <a href='jobpostings.php'> other postings </a>";
}

require_once 'footer.php';
?>
