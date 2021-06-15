<?php

class Router
{

    public static function route($route, $routes)
    {
        if (array_key_exists($route, $routes)) {
            include __DIR__ . '/../' . $routes[$route];
        } else {
            echo 'page not found';
        }

    }

}
