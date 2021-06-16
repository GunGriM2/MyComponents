<?php

include __DIR__ . '/../Router.php';

$routes = [
    '/' => 'controllers/homepage.php',
    '/about' => 'controllers/about.php',
];

$route = $_SERVER['REQUEST_URI'];

Router::route($route, $routes);
