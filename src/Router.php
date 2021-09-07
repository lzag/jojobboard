<?php
namespace App;

use App\Route as Route;

class Router {
    /**
     * Holds an array of Routes available in the app
     */
    private $endpoints = [];

    private $routes_path = __DIR__ . '/../includes/routes.php';

    public function __construct() 
    {
        $this->registerRoutes($this->getRoutes());
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

    /**
     * Fetches the route based on request parameters
     *
     * @return App/Route;
     */
    public function getRoute()
    {
        $uri = $this->getRequestUri();
        $method = $this->getRequestMethod();
        $params = $this->getRequestParams();

        // temporary measure to keep the app working, require necessary files
        if (file_exists(__DIR__ . '/../' . $uri)) {
            return new Route($method, $uri, $params);
        } else if (! isset($this->endpoints[$uri])) {
            // if endpoint not available return 404
            die('404 not found');
            return false;
        }

        if (! in_array($method, $this->endpoints[$uri])) {
            die('Method not allowed');
            // if method not allowed return 405 method not allowed
            return false;
        }

        $route = new Route($method, $uri, $params);

        if(! ($route)->validateParams()) {
            // if necessary params missing return return 400 bad request
            // validating only number of params required
            return false;
        };

        return $route;
    }

    public function getRequestUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getRequestMethod() 
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getRequestParams()
    {
        return $_SERVER['REDIRECT_QUERY_STRING'] ?? false;
    }

    public function getRoutes()
    {
        return require_once $this->routes_path;
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
