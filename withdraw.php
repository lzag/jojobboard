<?php

require_once 'header.php';

$email = $_SESSION['user'];
$query = "SELECT user_id FROM users WHERE email= ?";
$stmt = $db->con->prepare($query);
$stmt->execute(array($email));
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$user_id = $result['user_id'];

$query = "DELETE FROM applications WHERE user_id= ? AND application_id= ?";
$stmt = $db->con->prepare($query);
$stmt->execute(array($user_id, $_GET['posting_id']));

if (!$stmt->rowCount()) echo "Was not possible to delete";
else echo "Application withdrawn";

require_once 'footer.php';

?>
