<?php namespace Model;
use ORM\ORM;
class Usuario extends ORM
{
    public $id,$email,$nombre,$fechaNacimiento,$pass,$permiso;

    protected static $table = 'usuarios';

    public function __construct($data){
        parent::__construct();
        if ($data && sizeof($data)) { $this->populateFromRow($data); }
    }

    public function populateFromRow($data){
        $this->id = isset($data['id']) ? $data['id'] : null;
        $this->email = isset($data['email']) ? $data['email'] : null;
        $this->nombre = isset($data['nombre']) ? $data['nombre'] : null;
        $this->fechaNacimiento = isset($data['fechaNacimiento']) ? $data['fechaNacimiento'] : null;
        $this->pass = isset($data['pass']) ? $data['pass'] : null;
        $this->permiso = isset($data['permiso']) ? $data['permiso'] : 0;
    }
}

