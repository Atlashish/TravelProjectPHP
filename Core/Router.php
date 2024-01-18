<?php

namespace Core;

class Router
{
    // Array to store defined routes
    protected $routes = [];

    // Static method to build a router by including route definitions from a file
    public static function build($file)
    {
        $router = new static; // Create a new instance of the Router class
        require $file; // Include the file containing route definitions
        return $router; // Return the created router instance
    }

    // Method to define a route for a specific HTTP method, URI, and controller
    public function route($uri, $method)
    {
        $key = $this->generateRouteKey($method, $uri);

        // Check if the key (combination of method and URI) exists in the routes array
        if (isset($this->routes[$key])) {
            $route = $this->routes[$key];
            $_GET['id'] = $this->extractRouteParams($uri, $route['uri']);
            return $this->activateController(...explode('::', $route['controller']));
        }

        // If no matching route is found, throw an exception
        throw new \Exception("Route not defined for this URI");
    }

    // Method to activate the specified controller and function/method
    public function activateController($route, $function)
    {
        $controllerClass = "App\\Controllers\\{$route}";
        $controller = new $controllerClass();

        // Check if the specified function/method exists in the controller
        if (!method_exists($controller, $function)) {
            throw new \Exception("$function not defined for the controller $controllerClass");
        }

        $routeParams = $_GET['id'] ?? [];

        // Invoke the specified function/method within the controller and return its result
        call_user_func_array([$controller, $function], $routeParams);
    }

    // Method to extract route parameters from the requested URI based on the route definition
    private function extractRouteParams($requestUri, $routeUri)
    {
        $pattern = preg_replace('/\/:([^\/]+)/', '/(?P<$1>[^/]+)', $routeUri);
        $pattern = "#^$pattern$#";

        // Use regex to match and extract parameters from the request URI
        if (preg_match($pattern, $requestUri, $matches)) {
            unset($matches[0]);
            return array_values($matches);
        }

        return [];
    }

    // Method to generate a unique key for a route based on its HTTP method and URI
    private function generateRouteKey($method, $uri)
    {
        return "{$method}_{$uri}";
    }

    // Method to define a route for a specific HTTP method, URI, and controller
    public function router($method, $uri, $controller)
    {
        $key = $this->generateRouteKey($method, $uri);
        $this->routes[$key] = [
            'method'        => $method,
            'uri'           => $uri,
            'controller'    => $controller
        ];

        return $this;
    }

    // Convenience methods to define routes for different HTTP methods (GET, POST, PATCH, DELETE)
    public function get($uri, $controller)
    {
        return $this->router('GET', $uri, $controller);
    }

    public function post($uri, $controller)
    {
        return $this->router('POST', $uri, $controller);
    }

    public function patch($uri, $controller)
    {
        return $this->router('PATCH', $uri, $controller);
    }

    public function delete($uri, $controller)
    {
        return $this->router('DELETE', $uri, $controller);
    }
}
