<?php namespace Model;
use ORM\ORM;

class Fichero extends ORM
{
    public $id,$nombre,$tipo,$contenedor,$fechaModificacion,$propietario;

    protected static $table = 'ficheros';
 
    public function __construct($data){
        parent::__construct();
        if ($data && sizeof($data)) { $this->populateFromRow($data); }
    }
 
    public function populateFromRow($data){
        $this->id = isset($data['id']) ? intval($data['id']) : null;
        $this->nombre = isset($data['nombre']) ? $data['nombre'] : null;
        $this->tipo = isset($data['tipo']) ? $data['tipo']: null;
        $this->contenedor = isset($data['contenedor']) ? intval($data['contenedor']) : null;
        $this->fechaModificacion = isset($data['fechaModificacion']) ? date($data['fechaModificacion']) : null;
        $this->propietario = isset($data['propietario']) ? $data['propietario'] : null;
    }
}