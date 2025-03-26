<?php

require_once(__DIR__ . '/core/Route.php');
require_once(__DIR__ . '/app/Controllers/UserController.php');
require_once(__DIR__ . '/app/Middleware/AuthMiddleware.php');

Route::add('GET', '/user/{id}', 'UserController@show', ['AuthMiddleware']);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$method = $_SERVER['REQUEST_METHOD'];

Route::handleRequest($method, $uri);
