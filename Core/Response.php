<?php
/* The Response class is a PHP class that handles HTTP responses by setting the response code, content
type, and encoding the data as JSON. */

namespace Core;

class Response
{
    public static function get($responseCode, $data)
    {
        http_response_code($responseCode);
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($data);
        exit();
    }
}