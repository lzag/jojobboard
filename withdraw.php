<?php

require_once 'header.php';

$email = $_SESSION['user'];
$conn = new Database();
$query = "SELECT user_id FROM jjb_users WHERE email='$email'";
$result = $conn->execute_query($query);
$user_id= $result->fetch_array(MYSQL_ASSOC)['user_id'];
$query = "DELETE FROM jjb_applications WHERE user_id=$user_id AND posting_id='{$_GET['posting_id']}'";
$result = $conn->execute_query($query);

if (!$result) echo "Was not possible to delete";
else echo "Application withdrawn";


require_once 'footer.php';

?>
