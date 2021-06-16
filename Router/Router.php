<?php

class Router
{
    // метод принимает на вход url строку $route и массив с доступными строками $routes
    // в случае наличия url запроса в массиве включает файл по значению
    public static function route($route, $routes)
    {
        if (array_key_exists($route, $routes)) {
            include __DIR__ . '/../' . $routes[$route];
        } else {
            echo 'page not found';
        }

    }

}
