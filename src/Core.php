<?php
namespace App;

use App\Router;
use App\Route;

class Core {

    private $router;

    public function __construct() {
        $this->router = new Router;
    }

    public function respond()
    {
        // send the appropriate response
        $this->sendResponse($this->router->getRoute());
    }
    public function shutdown()
    {
        // shutdown the database connection etc, do any cleanups
        return;
    }

    public function sendResponse($route)
    {
        if (preg_match('/.*\.php$/', $route->getUri()))  {
            include __DIR__ . '/..' . $route->getUri();
        }
        http_response_code(200);
    }
}
?>
