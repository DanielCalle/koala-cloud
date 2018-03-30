<?php
use Model\Fichero;
use Tools\Remove;

class DataController
{
    public function uploadAction()
    {
        session_start();
        $idContenedor=$_POST['direccion'];
        if( $idContenedor=='null' || Fichero::find($idContenedor)->propietario==$_SESSION['usuario']->id ) {
            $direccion='/';
            $fichero=null;
            $aux=$idContenedor;
            while($aux!==null)
            {

                $fichero = Fichero::find($aux);
                $direccion='/'.$fichero->nombre.$direccion;
                $aux=$fichero->contenedor;
            }
            $target_dir = '../data/'.$_SESSION['usuario']->id.$direccion;
            $target_file = $target_dir . basename($_FILES['fileToUpload']['name']);
            $path_parts = pathinfo($_FILES['fileToUpload']['name']);
            $data['nombre']=$path_parts['filename'];
            $data['tipo']=$path_parts['extension'];

            if($idContenedor!="null")
                $data['contenedor']=$idContenedor;

            $data['fechaModificacion']=date("y/m/d");
            $data['propietario']=$_SESSION['usuario']->id;
            $fichero = new Fichero($data);
            $fichero->save();
            move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file);
            return ["data"=>"save"];
        }
        else{
            header("HTTP/1.0 403 Forbidden");
            exit();
        }
    }



    public function createFolderAction(){
        session_start();
        $idContenedor=$_POST['direccion'];
        if( $idContenedor=='null' || Fichero::find($idContenedor)->propietario==$_SESSION['usuario']->id ) {
            if(isset($_POST['direccion'])&&isset($_POST['nameFolder'])&&
                !empty($_POST['direccion'])&&!empty($_POST['nameFolder']))
            {
                $direccion='/';
                $fichero=null;
                $aux=$idContenedor;
                while($aux!==null)
                    {

                        $fichero = Fichero::find($aux);
                        $direccion='/'.$fichero->nombre.$direccion;
                        $aux=$fichero->contenedor;
                    }
                $target_dir = '../data/'.$_SESSION['usuario']->id.$direccion;
                $nameFolder = $_POST['nameFolder'];
                $data['nombre']=$nameFolder;
                $data['tipo']='folder';

                if($idContenedor!="null")
                    $data['contenedor']=$idContenedor;

                $data['fechaModificacion']=date("y/m/d");
                $data['propietario']=$_SESSION['usuario']->id;
                $fichero = new Fichero($data);
                $fichero->save();
                if(!file_exists($target_dir.$nameFolder))
                    mkdir($target_dir.$nameFolder);
            }
            else{
                header("HTTP/1.0 403 Forbidden");
                exit();
            }
        }
    }



    public function viewAction($params)
    {
        session_start();
        $idContenedor=$params[0];
        if( $idContenedor=='null' ) {
            $ficheros = Fichero::where('propietario',$_SESSION['usuario']->id);
            foreach($ficheros as $fichero)
                if($fichero->contenedor!=null)
                    unset($fichero);
            return $ficheros;
        }
        else if( Fichero::find($idContenedor)->propietario==$_SESSION['usuario']->id ){
            $ficheros = Fichero::where('contenedor',$idContenedor);
            return $ficheros;
        }
        else{
            header("HTTP/1.0 403 Forbidden");
            exit();
        }
    }



    public function removeAction($params)
    {
        session_start();
        $idContenedor=$params[0];
        if( Fichero::find($idContenedor)->propietario==$_SESSION['usuario']->id ) {
            $direccion='';
            $fichero=null;
            $auxContenedor=$idContenedor;

            if($auxContenedor!="null")
                do
                {
                    $fichero = Fichero::find($auxContenedor);
                    $direccion='/'.$fichero->nombre.$direccion;
                    $auxContenedor=$fichero->contenedor;
                }
                while($auxContenedor!==null);

            $fichero = Fichero::find($idContenedor);
            if($fichero->tipo=='folder')
                Remove::eliminarDir($target_dir = '../data/'.$_SESSION['usuario']->id.$direccion);
            else {
                $target_dir = '../data/' . $_SESSION['usuario']->id . $direccion . '.' . $fichero->tipo;
                unlink($target_dir);
            }
            $fichero->rm();
            }
        else{
        header("HTTP/1.0 403 Forbidden");
        exit();
        }
    }

    public function downloadAction($params){
        session_start();
        $idContenedor=$params[0];
        if( Fichero::find($idContenedor)->propietario==$_SESSION['usuario']->id ) {
            $direccion = '';
            $fichero = null;
            $auxContenedor = $idContenedor;

            if ($auxContenedor != "null")
                do {
                    $fichero = Fichero::find($auxContenedor);
                    $direccion = '/' . $fichero->nombre . $direccion;
                    $auxContenedor = $fichero->contenedor;
                } while ($auxContenedor !== null);
            $direccion = '../data/' . $_SESSION['usuario']->id . $direccion . '.' . Fichero::find($idContenedor)->tipo;
            if (file_exists($direccion)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . basename($direccion));
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($direccion));
                readfile($direccion);
                exit;
            }
        }
        else{
            header("HTTP/1.0 403 Forbidden");
            exit();
        }
    }
    public function contenedorAction($params){
        session_start();
        $idContenedor=$params[0];
        if( Fichero::find($idContenedor)->propietario==$_SESSION['usuario']->id ) {
            return array( "contenedor" => Fichero::find($idContenedor)->contenedor);
        }
        else{
            header("HTTP/1.0 403 Forbidden");
            exit();
        }
    }
}
