<?php
// The App class serve as a basic implementation of a Dependency Injection (DI) container or a service locator in the PHP application.

namespace Core;

class App
{
    // An associative array to store bound objects or values.
    protected static $registry = [];

    // Binds a key to a specific value in the registry.
    public static function bind($key, $value)
    {
        static::$registry[$key] = $value;
    }

    // Retrieves a value from the registry based on the provided key.
    public static function get($key)
    {
        // Check if the key exists in the registry.
        if (!array_key_exists($key, static::$registry)) {
            // Throw an exception if the key is not found.
            throw new \Exception("No {$key} is bound in the container");
        } else {
            // Return the value associated with the provided key.
            return static::$registry[$key];
        }
    }
}