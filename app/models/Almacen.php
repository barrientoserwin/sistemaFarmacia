<?php 
require "../../config/Conexion.php";
class Almacen extends Conexion{
	private $id_almacen;
    private $nombre;
    private $descripcion;

	public function Almacen(){
		parent::Conexion();
		$this->id_almacen=0;
        $this->nombre="";
        $this->descripcion="";
	}

	public function setIdAlmacen($valor){ $this->id_almacen=$valor; }
	public function getIdAlmacen(){ return $this->id_almacen; }
	public function setNombre($valor){ $this->nombre=$valor; }
	public function getNombre(){ return $this->nombre; }
    public function setDescripcion($valor){ $this->descripcion=$valor; }
	public function getDescripcion(){ return $this->descripcion; }

	public function limpiar($str){
		return parent::limpiarCadena($str);
	}

	public function editar($id_almacen){
		$sql="SELECT id_almacen,nombre,descripcion FROM almacen where id_almacen='$id_almacen'";
		return parent::ejecutarConsultaSimpleFila($sql);
    }

    public function listar(){
		$sql="SELECT id_almacen,nombre,descripcion FROM almacen";
		return parent::ejecutar($sql);
	}

	public function guardar(){
        $sql="INSERT INTO almacen(nombre,descripcion) VALUES('$this->nombre','$this->descripcion')";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}

	public function modificar(){
        $sql="UPDATE almacen SET nombre='$this->nombre',descripcion='$this->descripcion'	WHERE id_almacen='$this->id_almacen'";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}

	public function eliminar(){
        $sql="DELETE FROM almacen WHERE id_almacen='$this->id_almacen'";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}
}
?>