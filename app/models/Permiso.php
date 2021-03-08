<?php 
require "../../config/Conexion.php";
class Permiso extends Conexion{
	private $id_permiso;
    private $nombre;

	public function Permiso(){
		parent::Conexion();
		$this->id_permiso=0;
        $this->nombre="";
	}

	public function setIdPermiso($valor){ $this->id_permiso=$valor; }
	public function getIdPermiso(){ return $this->id_permiso; }
	public function setNombre($valor){ $this->nombre=$valor; }
	public function getNombre(){ return $this->nombre; }

    public function listar(){
		$sql="SELECT id_permiso,nombre FROM permiso";
		return parent::ejecutar($sql);
	}

	public function selectPermiso(){
		$sql="SELECT id_permiso,nombre FROM permiso";
		return parent::ejecutar($sql);
	}
}
?>