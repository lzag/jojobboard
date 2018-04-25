<?php

$sitename = 'Account Removal';

require_once 'header.php';
if (isset($_SESSION['user'])){
    $user = new User();
$user->removeUser();
} elseif ($_SESSION['employer']) {
    $employer = new Employer();
    $employer->removeEmployer();
} else echo "You are not logged in";

session_destroy();



require_once 'footer.php';

?>
