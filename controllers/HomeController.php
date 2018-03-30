<?php
use Tools\View;
use Model\Usuario;

class HomeController
{
    public function indexAction()
    {
        session_start();
        $titulo = 'Koala Kloud';
        $message = '';
        if(isset($_POST['email'])&&isset($_POST['pass']))
        {
            $usuario = Usuario::where("email",$_POST['email'])[0];
            if($usuario && password_verify($_POST['pass'],$usuario->pass))
            {
                $_SESSION['usuario']=$usuario;
            }
        }
        if(isset($_SESSION['usuario']))
        {
            $texto	= 'Bienvenido a Koala Kloud';
            return new View('home', compact('titulo','texto'));
        }
        elseif(isset($_POST['email'])||isset($_POST['pass']))
        {
            $message = 'El usuario o la contraseña son incorrectos';
            return new View('login', compact('titulo','texto','message'));
        }
        else
        {
            return new View('login', compact('titulo','texto','message'));
        }
    }

    public function salirAction()
    {
        session_start();
        session_destroy();
        header("Location: ./");
    }

}




