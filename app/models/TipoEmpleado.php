<?php 
require "../../config/Conexion.php";
class TipoEmpleado extends Conexion{
	private $id_tipoEmpleado;
    private $nombre;

	public function TipoEmpleado(){
		parent::Conexion();
		$this->id_tipoEmpleado=0;
        $this->nombre="";
	}

	public function setIdTipoEmpleado($valor){ $this->id_tipoEmpleado=$valor; }
	public function getIdTipoEmpleado(){ return $this->id_tipoEmpleado; }
	public function setNombre($valor){ $this->nombre=$valor; }
	public function getNombre(){ return $this->nombre; }

	public function limpiar($str){
		return parent::limpiarCadena($str);
	}

	public function editar($id_tipo){
		$sql="SELECT id_tipoEmpleado,nombre FROM tipoEmpleado where id_tipoEmpleado='$id_tipoEmpleado'";
		return parent::ejecutarConsultaSimpleFila($sql);
    }

    public function listar(){
		$sql="SELECT id_tipoEmpleado,nombre FROM tipoEmpleado";
		return parent::ejecutar($sql);
	}

	public function selectTipoEmpleado(){
		$sql="SELECT id_tipoEmpleado,nombre FROM tipoEmpleado";
		return parent::ejecutar($sql);
	}

	public function guardar(){
        $sql="INSERT INTO tipoEmpleado(nombre) VALUES('$this->nombre')";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}

	public function modificar(){
        $sql="UPDATE tipoEmpleado SET nombre='$this->nombre'	WHERE id_tipo='$this->id_tipoEmpleado'";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}

	public function eliminar(){
        $sql="DELETE FROM tipoEmpleado WHERE id_tipoEmpleado='$this->id_tipoEmpleado'";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}
}
?>