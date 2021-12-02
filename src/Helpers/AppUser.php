<?php

namespace App\Helpers;

class AppUser
{
    public static $max_session_time = 20 * 60;

    public static function hasRememberMeCookieSet()
    {
        return isset($_COOKIE['rememberMe']) ? true : false;
    }

    public static function isLoginStillValid()
    {
        if (
            isset($_SESSION['last_login']) &&
            time() - $_SESSION['last_login'] < self::$max_session_time
        ) {
            return true;
        } else {
            return false;
        }
    }

    public static function logInRememberedUser()
    {
        global $db;
        $cookie = explode(".", $_COOKIE['rememberMe']);
        $rememberID = $cookie[0];
        $cookie_token = hash('sha256', $cookie[1]);

        // $db = new Database;
        $stmt = $db->con->prepare("SELECT email, active, sessionToken FROM users WHERE rememberID= ?");
        $stmt->execute(array($rememberID));
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        var_dump($result);

        if (
            $result['db_token'] &&
            (hash_equals($cookie_token, $result['db_token']) &&
            $result['active'] == 1)
        ) {
            $_SESSION['user'] = $result['email'];
        }
    }

    public static function isUser()
    {
        return isset($_SESSION['user']);
    }

    public static function isEmployer()
    {
        return isset($_SESSION['employer']);
    }
}
