<?php

use FastRoute\RouteCollector;
 
return function(RouteCollector $router) {
  
    $router->get('/', 'App\Controller\Home::print');
 
};
