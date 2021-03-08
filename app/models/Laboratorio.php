<?php 
require "../../config/Conexion.php";
class Laboratorio extends Conexion{
	private $id_laboratorio;
    private $nombre;

	public function Laboratorio(){
		parent::Conexion();
		$this->id_laboratorio=0;
        $this->nombre="";
	}

	public function setIdLaboratorio($valor){ $this->id_laboratorio=$valor; }
	public function getIdLaboratorio(){ return $this->id_laboratorio; }
	public function setNombre($valor){ $this->nombre=$valor; }
	public function getNombre(){ return $this->nombre; }

	public function limpiar($str){
		return parent::limpiarCadena($str);
	}

	public function editar($id_laboratorio){
		$sql="SELECT id_laboratorio,nombre FROM laboratorio where id_laboratorio='$id_laboratorio'";
		return parent::ejecutarConsultaSimpleFila($sql);
    }

    public function listar(){
		$sql="SELECT id_laboratorio,nombre FROM laboratorio";
		return parent::ejecutar($sql);
	}

	public function selectLaboratorio(){
		$sql="SELECT id_laboratorio,nombre FROM laboratorio";
		return parent::ejecutar($sql);
	}

	public function guardar(){
        $sql="INSERT INTO laboratorio(nombre) VALUES('$this->nombre')";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}

	public function modificar(){
        $sql="UPDATE laboratorio SET nombre='$this->nombre'	WHERE id_laboratorio='$this->id_laboratorio'";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}

	public function eliminar(){
        $sql="DELETE FROM laboratorio WHERE id_laboratorio='$this->id_laboratorio'";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}
}
?>