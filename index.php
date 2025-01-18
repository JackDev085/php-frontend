<?php

require __DIR__ . '/vendor/autoload.php';

use App\Http\Router;
use App\Http\Response;
use App\Controller\Pages\Home;

define('URL', 'http://localhost:8000');
$router = new Router(URL);

$router->get("/",[
  function(){
    return new Response(200, Home::getHome());
  }
]);



$router->run()->sendResponse();