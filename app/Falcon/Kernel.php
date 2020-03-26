<?php

namespace Falcon;

class Kernel 
{
    private $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function run()
    {
        $dispatcher = $this->router->setRoutes();
        
        $this->router->runRoute($dispatcher);
    }

    public function getApp() 
    {
        return $this->app;
    }
}

