<?php
 
namespace App\Controller;
 
use Falcon\AbstractController;
 
class Home extends AbstractController
{
    public function print() 
    {
        return $this->render('base');
    }
}
