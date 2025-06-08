<?php

namespace Neo\PicpayDesafioBackend\Http\Routing;

use Neo\PicpayDesafioBackend\Http\Response;

enum RouteMethod: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case PATCH = 'PATCH';
    case DELETE = 'DELETE';
}

class Route
{
    private RouteMethod $method;
    private string $path;
    private mixed $controller;

    public function __construct(RouteMethod $method, string $path, array|callable $controller)
    {
        $this->method = $method;
        $this->path = $path;
        $this->controller = $controller;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getMethod(): RouteMethod
    {
        return $this->method;
    }

    public static function get(string $path, array|callable $controller)
    {
        $routes = Routes::getInstance();
        $route = new Route(RouteMethod::GET, $path, $controller);

        $routes->addRoute($route);
    }

    public static function post(string $path, array|callable $controller)
    {
        $routes = Routes::getInstance();
        $route = new Route(RouteMethod::POST, $path, $controller);

        $routes->addRoute($route);
    }

    public function render(): void
    {
        ob_start();

        if (gettype($this->controller) === 'array') {
            $instance = new $this->controller[0];

            $response = call_user_func_array([$instance, $this->controller[1]], []);
        }
        else {
            $response = call_user_func_array($this->controller, []);
        }

        if ($response instanceof Response) {
            $response->render();
        }

        ob_end_flush();
    }
}
