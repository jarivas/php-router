<?php

namespace PhpRouter;

use Exception;

class Router
{
    private static array $routes;

    public static function get(string $route, callable $callback)
    {

    }

    public static function post(string $route, callable $callback)
    {

    }

    public static function put(string $route, callable $callback)
    {

    }

    public static function delete(string $route, callable $callback)
    {

    }

    public static function options(string $route, callable $callback)
    {

    }

    public static function patch(string $route, callable $callback)
    {

    }

    public static function route()
    {
        $method = HttpMethodEnum::tryFrom($_SERVER['REQUEST_METHOD']);

        if (!$method) {
            throw new Exception(RouterErrorEnum::INVALID_HTTP_METHOD);
        }

        if (empty(self::$routes[$method])) {
            throw new Exception(RouterErrorEnum::NO_MATCH);
        }
    }
}