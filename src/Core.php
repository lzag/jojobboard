<?php
namespace App;

use App\Router;
use App\Route;
use App\Helpers\AppUser;
use User;

class Core {

    private $router;

    public function __construct() {
        $file = basename($_SERVER['REQUEST_URI'], ".php");
        if (!in_array($file, ['login', 'registeruser', 'registeremployer'])) {
            if (AppUser::hasRememberMeCookieSet()) {
                AppUser::logInRememberedUser();
            } else if (AppUser::isLoginStillValid()){
                $_SESSION['last_login'] = time();
            } else {
                session_destroy();
                header("Location: /login");
                $_SESSION['msg'] = "Your session expired, please log in again";
                exit();
            }

            if (isset($_COOKIE['visit'])) {
                $welcome = "Welcome back to JoJobBoard";
                setcookie('visit',time(),time()+1000000,"/");
            } else {
                $welcome = "Welcome to JoJobBoard";
                setcookie('visit',time(),time()+1000000,"/");
            }
        }

        $this->router = new Router;
    }

    public function respond()
    {
        // send the appropriate response
        if ($this->router->isRequestForLegacyFile()) {
            require_once APP_DIR . '/' . $this->router->request_file;
        } else if (!$this->router->isRouteAllowed()) {
            http_response_code(404);
            echo "Route not allowed";
            // if(! ($route)->validateParams()) {
            //     // if necessary params missing return return 400 bad request
            //     // validating only number of params required
            //     exit('wrong params');
            // };
        } else if (!$this->router->isRequestMethodAllowed()){
            http_response_code(405);
            echo "Method not allowed";
        } else {
            $this->sendResponse();
        }

    }
    public function shutdown()
    {
        // shutdown the database connection etc, do any cleanups
        return;
    }

    public function sendResponse()
    {
        // find controller and then send the response
        $controller = '\\App\\Controllers\\' . ucfirst($this->router->controller) . 'Controller';
        $method = $this->router->controller_method;
        if (!method_exists($controller, $method)) {
            echo "404, sorry";
            die;
        } else {
            parse_str($this->router->params, $params);
            (new $controller)->$method(...$params);
        }
    }
}
