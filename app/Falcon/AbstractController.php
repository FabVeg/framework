<?php
 
namespace Falcon;

use Falcon\FlashBag;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
 
abstract class AbstractController
{
    private $templateEngine;

    private $flashbag;
 
    public function __construct() 
    {
        $loader = new \Twig\Loader\FilesystemLoader(dirname(dirname(__DIR__)) . '/templates');
        $this->templateEngine = new \Twig\Environment($loader);
        $this->flashbag;
    }
 
 
    protected function render($view, $vars = [])
    {
        return $this->templateEngine->render($view.'.html.twig', $vars);
    }

    public function flash() {
        return $flashbag = new FlashBag;
    }

    protected function redirectToRoute($url)
    {
        header('location:'.$url);
        exit();
    }

}
