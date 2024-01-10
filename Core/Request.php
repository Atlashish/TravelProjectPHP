<?php
/* The Request class in the Core namespace provides methods to retrieve the HTTP method and URI of the
current request. */

namespace Core;

class Request
{
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function uri()
    {
        return trim(parse_url($_SERVER['REQUEST_URI'])['path'], '/');
    }
}