<?php 
// The Router class is used for defining and handling routes in a PHP application. 
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
    public function router($method, $uri, $controller)
    {
        $this->routes[] = [ // Store route details in the routes array
            'method'        => $method,
            'uri'           => $uri,
            'controller'    => $controller
        ];
        return $this;
    }

     // Convenience methods to define routes for different HTTP methods (GET, POST, PATCH, DELETE)
    public function get($uri, $controller)
    {
        $this->router('GET', $uri, $controller);
    }

    public function post($uri, $controller)
    {
        $this->router('POST', $uri, $controller);
    }

    public function patch($uri, $controller)
    {
        $this->router('PATCH', $uri, $controller);
    }

    public function delete($uri, $controller)
    {
        $this->router('DELETE', $uri, $controller);
    }

     // Method to match a requested URI and HTTP method to a defined route
    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            // Convert route URI into a regex pattern for matching
            $pattern = preg_replace('/\/:([^\/]+)/', '/(?P<$1>[^/]+)', $route['uri']);
            $pattern = "#^$pattern$#";

             // Check if the requested URI matches a defined route
            if (preg_match($pattern, $uri, $matches) && $method == $route['method']) {
                $_GET['id'] = $matches['id'] ?? null;

                // Activate the specified controller and function/method
                return $this->activateController(...explode('::', $route['controller']));
            }
        }
        // If no matching route is found, throw an exception
        throw new \Exception("Route not defined for this URI");
    }

    // Method to activate the specified controller and function/method
    public function activateController($route, $function)
    {
        
        $controller = "App\\Controllers\\{$route}";
        $controller = new $controller; 

        // Check if the specified function/method exists in the controller
        if (!method_exists($controller, $function)) {
            throw new \Exception("$function not defined for the controller $controller");
        }
        // Invoke the specified function/method within the controller and return its result
        return $controller->$function();
    }
}