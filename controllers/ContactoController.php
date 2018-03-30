<?php
use Tools\View;

class ContactoController
{
    public function indexAction()
    {
            return new View('contacto', compact('titulo'));
    }

}




