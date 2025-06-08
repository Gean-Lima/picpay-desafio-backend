<?php

namespace Neo\PicpayDesafioBackend\Http\Routing;

use Exception;
use Throwable;

class Routes
{
    private static ?Routes $instance = null;
    private array $list = [];

    private function __construct() {}

    public static function getInstance(): self
    {
        if (self::$instance) {
            return self::$instance;
        }

        self::$instance = new self();

        return self::$instance;
    }

    public static function reset(): void
    {
        self::$instance?->resetList();
        self::$instance = null;
    }

    public static function currentRouteName(): string
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestQuery = $_SERVER['QUERY_STRING'] ?? '';

        $routeName = str_replace("?{$requestQuery}", '', $requestUri);
        $routeName = $requestMethod.'__'.str_replace('/', '_', $routeName);

        return $routeName;
    }

    public function addRoute(Route $route)
    {
        $name = $route->getMethod()->value . '__' . str_replace('/', '_', $route->getPath());

        if (array_key_exists($name, $this->list)) {
            throw new RouteDuplicatedException('The route already exists: ' . $route->getPath());
        }

        $this->list[$name] = $route;
    }

    public function getList(): array
    {
        return $this->list;
    }

    public function resetList(): void
    {
        $this->list = [];
    }
}


class RouteDuplicatedException extends Exception
{
    public function __construct($message, $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
