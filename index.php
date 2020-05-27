<?php
require 'config.php';
require SYSTEM . 'Startup.php';

use Router\Router;

$request = new Http\Request();
$response = new Http\Response();

$pagination = new Pagination\Pagination();

$response->setHeader('Access-Control-Allow-Origin: http://localhost:3000');
$response->setHeader("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
$response->setHeader('Content-Type: application/json; charset=UTF-8');


$router = new Router('/' . $request->getUrl(), $request->getMethod());
//$router = new Router('/' . strtolower($request->validToken() ? $request->getUrl() : ""), $request->getMethod());
//$router = new Router('/' . strtolower($request->getUrl()), $request->getMethod());

require 'Router/Router.php';

$router->run();

$response->render();
