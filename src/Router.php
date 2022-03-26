<?php

namespace PhpRouter;

use Exception;

class Router
{
    private static array $routes = [];
    private static array $preMiddleware;
    private static array $postMiddleware;

    public static function get(string $route, callable $callback)
    {
        self::$routes[HttpMethodEnum::Get] = ['route' => $route, 'callback' => $callback];
    }

    public static function post(string $route, callable $callback)
    {
        self::$routes[HttpMethodEnum::Post] = ['route' => $route, 'callback' => $callback];
    }

    public static function put(string $route, callable $callback)
    {
        self::$routes[HttpMethodEnum::Put] = ['route' => $route, 'callback' => $callback];
    }

    public static function delete(string $route, callable $callback)
    {
        self::$routes[HttpMethodEnum::Delete] = ['route' => $route, 'callback' => $callback];
    }

    public static function options(string $route, callable $callback)
    {
        self::$routes[HttpMethodEnum::Options] = ['route' => $route, 'callback' => $callback];
    }

    public static function patch(string $route, callable $callback)
    {
        self::$routes[HttpMethodEnum::Patch] = ['route' => $route, 'callback' => $callback];
    }

    public static function preMiddleware(callable $callback)
    {
        self::$preMiddleware[] = $callback;
    }

    public static function postMiddleware(callable $callback)
    {
        self::$postMiddleware[] = $callback;
    }

    public static function route(): Response
    {
        list($method, $routes) = self::getRoutes();

        list($callback, $pathParameters) = self::getCallback($routes);

        $headers = getallheaders();

        $body = self::getBody($method, $headers);

        $request = self::processPre(new Request($headers, $pathParameters, $_GET, $body));

        $response = call_user_func($callback, $request);

        return self::processPost($request);
    }

    private static function getRoutes(): array
    {
        $method = HttpMethodEnum::tryFrom($_SERVER['REQUEST_METHOD']);

        if (!$method) {
            throw new Exception(RouterErrorEnum::INVALID_HTTP_METHOD);
        }

        if (empty(self::$routes[$method])) {
            throw new Exception(RouterErrorEnum::NO_MATCH);
        }

        return [$method, self::$routes[$method]];
    }

    private static function getCallback(array $routes): array
    {
        $query = $_SERVER["QUERY_STRING"];

        
    }

    private static function getBody(HttpMethodEnum $method, array &$headers): array
    {
        if (in_array($method, [HttpMethodEnum::Get, HttpMethodEnum::Delete, HttpMethodEnum::Options])) {
            return [];
        }

        $isJson = self::isJson($headers);

        if ($isJson) {
            return json_decode(file_get_contents('php://input'), true);
        }

        return $_POST;
    }

    private static function isJson(array &$headers): bool
    {
        if (empty($headers['Content-Type'])) {
            return false;
        }

        return ($headers['Content-Type'] == 'application/json');
    }

    private static function processPre(Request $request): Request
    {
        if (empty(self::$preMiddleware)) {
            return $request;
        }

        foreach(self::$preMiddleware as $callback) {
            $request = call_user_func($callback, $request);
        }

        return $request;
    }

    private static function processPost(Response $response): Response
    {
        if (empty(self::$postMiddleware)) {
            return $response;
        }

        foreach(self::$postMiddleware as $callback) {
            $response = call_user_func($callback, $response);
        }

        return $response;
    }
}