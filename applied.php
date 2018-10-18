<?php

require_once 'header.php';

if (isset($_POST['user_id']) && isset($_POST['posting_id'])) {
    $user_id = $_POST['user_id'];
    $posting_id = $_POST['posting_id'];
    $query = "INSERT INTO applications(user_id, posting_id) VALUES(?, ?)";
    $stmt = $db->con->prepare($query);
    $stmt->execute(array($user_id, $posting_id));
    if ($stmt->rowCount()) echo "Your application has been received. Please check out some <a href='jobpostings.php'> other postings </a>";
}

require_once 'footer.php';
?>
