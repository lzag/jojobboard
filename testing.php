<?php
$sitename = "testing";
require_once 'header.php';

/*
$database = new Database();

$result = $database->execute_query("SELECT * FROM jjb_users WHERE user_id=12");

if(!$result) echo "Sth is wrong";
print_r($result->fetch_array()['first_name']);
*/

$user = new User();
echo $user->getFirstName('12');
echo $user->getSecondName('12');
echo $user->getEmail('12');
?>
