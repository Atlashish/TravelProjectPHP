<?php

namespace Core;

class App
{
    protected static $registry = [];

    public static function bind($key, $resolver)
    {
        static::$registry[$key] = $resolver;
    }

    public static function resolver($key)
    {
        if (array_key_exists($key, static::$registry)) {
            return static::$registry[$key];
        } else {
            throw new \Exception("No {$key} is bound in the container");
        }
    }
}