<?php
namespace App;

class Route {

    /**
     * @param string
     */
    private $method;

    /**
     * @param string
     */
    private $uri;

    /**
     * @param string
     */
    private $action;

    /**
     * @param array
     */
    private $params;

    /**
     * @param App\Middleware
     */
    private $middleware;

    public  function __construct(string $method, string $uri, ?string $action = null, ?array $params = null, App\Middleware $middleware = null) {
        $this->method = $method;
        $this->uri = $uri;
        $this->action = $action;
        $this->params = $params;
        $this->middleware = $middleware;
    }

    public static function get($uri, $action = null, $params = null, $middleware = null) {
        return new self('GET', $uri, $action, $params, $middleware);
    }

    public static function post($uri, $action = null, $params = null, $middleware = null) {
        return new self('POST', $uri, $action, $params, $middleware);
    }

    public function getUri(): string {
        return $this->uri;
    }

    public function getMethod(): string {
        return $this->method;
    }

    public function getAction(): string {
        return $this->action;
    }

    /**
     * Validates if correct number of params have been passed to a route
     */
    public function validateParams() {
        return true;
    }
}
?>
