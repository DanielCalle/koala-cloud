<?php
use Tools\View;
use Model\Usuario;

class HomeController
{
    public function indexAction()
    {
        session_start();
        $titulo = 'KoalaFramework';
        $message = 'Hello World!';
        return new View('home', compact('titulo','message'));   
    }

}




