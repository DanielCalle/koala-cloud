<?php
use Model\Fichero;

class DownloadController
{
    public function indexAction($params){
        session_start();
        $idContenedor=$params[0];
        if( Fichero::find($idContenedor)->propietario==$_SESSION[usuario]->id ) {
            $direccion = '';
            $fichero = null;
            $auxContenedor = $idContenedor;

            if ($auxContenedor != "null")
                do {
                    $fichero = Fichero::find($auxContenedor);
                    $direccion = '/' . $fichero->nombre . $direccion;
                    $auxContenedor = $fichero->contenedor;
                } while ($auxContenedor !== null);
            $direccion = '../data/' . $_SESSION['usuario']->id . $direccion . '.' . $fichero->tipo;
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

}