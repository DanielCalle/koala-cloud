<?php
use Tools\View;
use Tools\Remove;
use Model\Usuario;
use Model\Fichero;

class UserController
{
    function indexAction(){
        session_start();
        if(isset($_SESSION['usuario'])&&$_SESSION['usuario']->permiso==1){
            $titulo = 'Koala Kloud';
            $message = '';
            $users = $this->viewAction();
            return new View('users', compact('titulo','message','users'));
        }
        else{
            return new View('forbidden', array());
        }

    }
    function viewAction(){
        if(!isset($_SESSION['usuario']))
            session_start();
        return Usuario::all();

    }
    function removeAction($params){
        session_start();
        if(isset($_SESSION['usuario'])&&$_SESSION['usuario']->permiso==1){
            $ficheros = Fichero::where("propietario",$params[0]);
            foreach($ficheros as $fichero)
                $fichero->rm();
            Usuario::find($params[0])->rm();
            Remove::eliminarDir('../data/'.$params[0]);
        }

    }
    function changeRoleAction($params){
        session_start();
        if(isset($_SESSION['usuario'])&&$_SESSION['usuario']->permiso==1) {
            $user = Usuario::find($params[0]);
            if ($user->permiso)
                $user->permiso = 0;
            else
                $user->permiso = 1;
            $user->save();
        }
    }
}