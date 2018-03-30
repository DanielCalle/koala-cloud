<?php
use Tools\View;
use Model\Usuario;

class RegistroController
{
    public function indexAction()
    {
        $titulo = 'Koala Kloud';
        $message = '';
        if(isset($_POST['email'])&&isset($_POST['nombre'])&&isset($_POST['pass'])&&isset($_POST['fechaNacimiento'])){

            if(Usuario::where("email",$_POST['email'])==null){
                $_POST['pass']=password_hash($_POST['pass'],PASSWORD_BCRYPT);
                $usuario = new Usuario($_POST);
                $usuario->save();
                $usuario = Usuario::where("email",$_POST['email'])[0];
                var_dump('../data/'.$usuario->id);
                mkdir('../data/'.$usuario->id);
                header("Location: ./");
            }
            else{
                $message='El usuario ya esta registrado';
                return new View('registro', compact('titulo','texto','message'));
            }
        }
        else{
            return new View('registro', compact('titulo','texto','message'));
        }
    }
}
