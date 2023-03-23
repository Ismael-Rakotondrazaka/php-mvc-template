<?php

namespace App\Core\Routes;

use App\Core\Requests\Request;
use App\Core\Responses\Response;
use FastRoute\RouteCollector;
use FastRoute\Dispatcher;

use function FastRoute\simpleDispatcher;

class Router
{
    private $routes = [];

    public function __construct()
    {
    }

    public function get(string $path, callable $callback)
    {
        $this->routes[] = ["GET", $path, $callback];
    }

    public function post(string $path, callable $callback)
    {
        $this->routes[] = ["POST", $path, $callback];
    }

    public function put(string $path, callable $callback)
    {
        $this->routes[] = ["PUT", $path, $callback];
    }

    public function patch(string $path, callable $callback)
    {
        $this->routes[] = ["PATCH", $path, $callback];
    }

    public function delete(string $path, callable $callback)
    {
        $this->routes[] = ["DELETE", $path, $callback];
    }

    public function resolve(Request $request, Response $response)
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {
            foreach ($this->routes as $route) {
                $routeCollector->addRoute($route[0], $route[1], $route[2]);
            }
        });
        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPath());

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                // 404 Not Found
                $response->setStatusCode(404);
                $response->renderView("_404");
                exit;
            case Dispatcher::METHOD_NOT_ALLOWED:
                // 405 Method Not Allowed but we consider as not found
                $response->setStatusCode(404);
                $response->renderView("_404");
                exit;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $request->params = $routeInfo[2];
                call_user_func($handler, $request, $response);
                exit;
        }
    }
}