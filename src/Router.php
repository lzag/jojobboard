<?php
namespace App;

use App\Route as Route;
use Exception;

class Router {
    /**
     * Holds an array of Routes available in the app
     */
    private $endpoints = [];

    private $routes_flle_path = __DIR__ . '/../includes/routes.php';

    public $uri;
    public $controller;
    public $method;
    public $params;
    public $request_file;

    public function __construct() 
    {
        $this->registerRoutes($this->getRoutesFile());
        $this->uri = $this->getRequestUri();
        $this->controller = $this->getRequestController();
        $this->method = $this->getRequestMethod();
        $this->params = $this->getRequestParams();
        if ($this->isRequestForLegacyFile()) {
            $this->request_file = filter_var($_GET['request_file'], FILTER_SANITIZE_STRING); 
        }
    }

    /**
     * Registers an array of routes for the app
     * 
     * @param array $routes - array or App\Route objects
     *
     * @throws Exception
     */
    public function registerRoutes(array $routes): void
    {
        if (!$routes)
            throw new Exception('Routes empty');

        foreach ($routes as $route) {
            $this->addRoute($route);
        }
    }

    public function isRequestForLegacyFile() 
    {
        // temporary measure to keep the app working, require necessary files
        return !empty($_GET['request_file']) && file_exists(__DIR__ . '/../' . filter_var($_GET['request_file'], FILTER_SANITIZE_STRING));
    }

    public function isRouteAllowed() 
    {
        return isset($this->endpoints[$this->uri]);
    }

    public function isMethodAllowed() 
    {
        return in_array($this->method, $this->endpoints[$this->uri]) || $this->method === 'index';
    }

    /**
     * Fetches the route based on request parameters
     *
     * @return App/Route;
     */
    public function getRoute()
    {
        return new Route($this->controller, $this->method, $this->params);
    }

    public function getRequestUri() {
        preg_match('%^/\w*%', $_SERVER['REQUEST_URI'], $uri);
        return $uri[0];
    }

    public function getRequestController()
    {
        if (!empty($_GET['controller'])) {
            return filter_var($_GET['controller'], FILTER_SANITIZE_STRING);
        } else {
            return 'main';
        }
    }

    public function getRequestMethod() 
    {
        if (!empty($_GET['method'])) {
            return filter_var($_GET['method'], FILTER_SANITIZE_STRING);
        } else {
            return 'index';
        }
    }

    public function getRequestParams()
    {
        if (!empty($_GET['params'])) {
            return filter_var($_GET['params'], FILTER_SANITIZE_STRING);
        } else {
            return false;
        }
        // return $_SERVER['REDIRECT_QUERY_STRING'] ?? false;
    }

    public function getRoutesFile()
    {
        return require_once $this->routes_flle_path;
    }

    public function addRoute(Route $route): void
    {
        if(! isset($this->endpoints[$route->getUri()])) {
            $this->endpoints[$route->getUri()] = [$route->getMethod()];
        } else {
            $this->endpoints[$route->getUri()][] =  $route->getMethod();
        }
    }
}
