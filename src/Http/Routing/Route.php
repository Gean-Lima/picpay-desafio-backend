<?php

namespace Neo\PicpayDesafioBackend\Http\Routing;

use Neo\PicpayDesafioBackend\Http\Middleware\InterfaceMiddleware;
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
    private array $middlewares;

    public function __construct(RouteMethod $method, string $path, array|callable $controller, array $middlewares = [])
    {
        $this->method = $method;
        $this->path = $path;
        $this->controller = $controller;
        $this->middlewares = $middlewares;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getMethod(): RouteMethod
    {
        return $this->method;
    }

    public static function get(string $path, array|callable $controller, array $middlewares = [])
    {
        $routes = Routes::getInstance();
        $route = new Route(RouteMethod::GET, $path, $controller, $middlewares);

        $routes->addRoute($route);
    }

    public static function post(string $path, array|callable $controller, array $middlewares = [])
    {
        $routes = Routes::getInstance();
        $route = new Route(RouteMethod::POST, $path, $controller, $middlewares);

        $routes->addRoute($route);
    }

    public function render(): void
    {
        ob_start();

        $response = null;

        foreach ($this->middlewares as $middlewareName) {
            if (!is_subclass_of($middlewareName, InterfaceMiddleware::class)) {
                continue;
            }

            $middleware = new $middlewareName();

            $response = $middleware->handle();
        }

        if ($response instanceof Response) {
            $response->render();

            ob_end_flush();
            exit;
        }

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
