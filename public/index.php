<?php
use App\Core;
use App\Database;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../includes/bootstrap.php';

/**** HEADER FILE ***/

session_start();

require_once '../includes/functions.php';
require_once '../includes/employer.php';
require_once '../includes/user.php';
require_once '../includes/blogpost.php';
require_once '../includes/jobpost.php';

//spl_autoload_register( function ($class) {
//    include 'includes/' . strtolower($class) . '.php';
//});

// $file = basename($_SERVER['REQUEST_URI'], ".php");
// if (!in_array($file, ['login', 'registeruser', 'registeremployer'])) {
//     if (isset($_COOKIE['rememberMe'])) {
//         // log in remembered user
//         // rememberUser();
//     } elseif (isset($_SESSION['user'])) {
//         if(time() - $_SESSION['last_login'] < 20 * 60) {
//             $_SESSION['last_login'] = time();
//         } else {
//         }
//     } elseif (isset($_SESSION['employer'])) {
//         $employer = new Employer();
//         if(time() - $_SESSION['last_login'] < 20 * 60) {
//                 $_SESSION['last_login'] = time();
//             } else {
//                 session_destroy();
//                 header("Location: login.php");
//                 session_start();
//                 $_SESSION['msg'] = "Your session expired, please log in again";
//                 exit();
//             }
//     } else {
//         header("Location: login.php");
//         exit();
//     }
// }

/**** END HEADER FILE ****/


try {
    global $db;
    $db = new Database();
    $core = new Core();
    $core->respond();
} catch (Throwable $e) {
    echo $e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine() . PHP_EOL;
    http_response_code(500);
} finally {
    // $core->shutdown();
}
