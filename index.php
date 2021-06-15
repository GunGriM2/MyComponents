<?php

include __DIR__ . '/../Router.php';

$routes = [
    '/' => 'functions/homepage.php',
    '/about' => 'functions/about.php',
];

$route = $_SERVER['REQUEST_URI'];

Router::route($route, $routes);
