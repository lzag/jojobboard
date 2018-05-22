<?php
session_start();
if (isset($_SESSION['user']) || isset($_SESSION['employer'])) {
    (session_destroy());

$sitename = "Logged out";
require_once 'header.php';

echo "Logged out";


require_once 'footer.php';
    } else {

$sitename = "Logged out";
require_once 'header.php';

echo "You are not logged in";


require_once 'footer.php';
}
?>
