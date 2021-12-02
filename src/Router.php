<?php

namespace App;

use App\Route as Route;
use Exception;

class Router
{
    // /**
    //  * Holds an array of Routes available in the app
    //  */
    // private $endpoints = [];

    private $routes_flle_path = __DIR__ . '/../includes/routes.php';

    public $request_uri;
    public $request_method;
    public $controller;
    public $controller_method;
    public $params;
    public $request_file;
    public $routes;

    public function __construct()
    {
        $routes = require_once $this->routes_flle_path;
        if ($this->isRequestForLegacyFile()) {
            $this->request_file = filter_var($_GET['request_file'], FILTER_SANITIZE_STRING);
        } else {
            $this->setRoutes($routes);
            $this->setRequestMethod();
            $this->setRequestUri();
            $this->setController();
            $this->setControllerMethod();
            $this->setRequestParams();
        }
        $this->registerRoutes($routes);
    }

    public function setRoutes($routes)
    {
        if (!$routes) {
            throw new Exception('No routes available, you must register at least one route');
        }

        foreach ($routes as $route) {
            $this->routes[$route->getUri()][$route->getMethod()] = $route;
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
        if (!$routes) {
            throw new Exception('No routes available, you must register at least one route');
        }

        foreach ($routes as $route) {
            $this->addRoute($route);
        }
    }

    public function getRouteAction()
    {
    }

    public function isRequestForLegacyFile()
    {
        // temporary measure to keep the app working, require necessary files
        return !empty($_GET['request_file']) && file_exists(__DIR__ . '/../' . filter_var($_GET['request_file'], FILTER_SANITIZE_STRING));
    }

    public function isRouteAllowed()
    {
        return isset($this->endpoints[$this->request_uri]);
    }

    public function isRequestMethodAllowed()
    {
        return in_array($this->request_method, $this->endpoints[$this->request_uri]);
    }

    // /**
    //  * Fetches the route based on request parameters
    //  *
    //  * @return App/Route;
    //  */
    // public function getRoute()
    // {
    //     return new Route($this->controller, $this->request_method, $this->params);
    // }

    public function setRequestMethod()
    {
        $allowed_methods = ['GET', 'POST', 'PUT', 'DELETE'];
        if (in_array(strtoupper($_SERVER['REQUEST_METHOD']), $allowed_methods)) {
            $this->request_method = strtoupper($_SERVER['REQUEST_METHOD']);
        } else {
            throw new Exception('Unknown request method');
        }
    }

    public function getRequestMethod()
    {
        return $this->request_method;
    }

    public function setRequestUri()
    {
        preg_match('%^/[^\?]*%', $_SERVER['REQUEST_URI'], $uri);
        // $this->request_uri = $_SERVER['REQUEST_URI'];
        $this->request_uri = $uri[0];
    }

    public function getRequestUri()
    {
        return $this->request_uri;
    }

    public function setController()
    {
        if (!empty($this->routes[$this->request_uri][$this->request_method]->getAction())) {
            $this->controller = explode('@', $this->routes[$this->request_uri][$this->request_method]->getAction())[1];
            $this->controller = preg_replace('/Controller$/', '', $this->controller);
        } elseif (!empty($_GET['controller'])) {
            $this->controller = filter_var($_GET['controller'], FILTER_SANITIZE_STRING);
        } else {
            $this->controller = 'main';
        }
    }

    public function getController()
    {
        return $this->controller;
    }

    public function setControllerMethod()
    {
        if (!empty($this->routes[$this->request_uri][$this->request_method]->getAction())) {
            $this->controller_method = explode('@', $this->routes[$this->request_uri][$this->request_method]->getAction())[0];
        } elseif (!empty($_GET['method'])) {
            $this->controller_method = filter_var($_GET['method'], FILTER_SANITIZE_STRING);
        } else {
            $this->controller_method = 'index';
        }
    }

    public function getControllerMethod()
    {
        return $this->controller_method;
    }

    public function setRequestParams()
    {
        if (!empty($_GET['params'])) {
            $this->params = filter_var($_GET['params'], FILTER_SANITIZE_STRING);
        } else {
            $this->params = '';
        }
    }

    public function getRequestParams()
    {
        return $this->params;
    }

    public function getRoutesFile()
    {
        return require_once $this->routes_flle_path;
    }

    public function addRoute(Route $route): void
    {
        if (! isset($this->endpoints[$route->getUri()])) {
            $this->endpoints[$route->getUri()] = [$route->getMethod()];
        } else {
            $this->endpoints[$route->getUri()][] =  $route->getMethod();
        }
    }
}
