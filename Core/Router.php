<?php

namespace Core;

class Router
{
    protected $routes = [];

    public static function build($file)
    {
        $router = new static;
        require $file;
        return $router;
    }

    public function router($method, $uri, $controller)
    {
        $this->routes[] = [
            'uri'        => $uri,
            'controller' => $controller,
            'method'     => $method
        ];
        return $this;
    }

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

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            $pattern = preg_replace('/\/:([^\/]+)/', '/(?P<$1>[^/]+)', $route['uri']);
            $pattern = "#^$pattern$#";
            if (preg_match($pattern, $uri, $matches) && $method == $route['method']) {
                $_GET['id'] = $matches['id'] ?? null;
                //return $this->activateController($route['controller']);
                return $this->activateController(...explode('::', $route['controller']));
            }
        }
        throw new \Exception("Route not defined for this URI");
    }

    public function activateController($route, $function)
    {
        $controller = "App\\Controllers\\{$route}";
        $controller = new $controller; //ISTANZA COSTRUTTORE CLASSE

        if (!method_exists($controller, $function)) {
            throw new \Exception("$function not defined for the controller $controller");
        }
        return $controller->$function();
    }
}