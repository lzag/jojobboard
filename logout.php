<?php
session_start();
if (isset($_SESSION['user']) || isset($_SESSION['employer'])) {
    session_destroy();
    setcookie('rememberMe','',time() - 100 * 30 * 24 * 60 * 60);
    session_start();
    $_SESSION['msg'] = "You have been logged out";
}
header("Location: login.php");
exit();
?>
