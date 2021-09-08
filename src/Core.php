<?php
namespace App;

use App\Router;
use App\Route;

class Core {

    private $router;
    private $template_engine;

    public function __construct(ITemplateEngine $template_engine) {
        $this->router = new Router;
        $this->template_engine = $template_engine;
        $this->template_engine->configure();
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
        if (preg_match('/\/?(.*)\.php$/', $route->getUri(), $match))  {
            $this->template_engine->displayView($match[1]);
        }
        http_response_code(200);
    }
}
