<?php 
require "../../config/Conexion.php";
class Categoria extends Conexion{
	private $id_categoria;
    private $nombre;
    private $idCatMayor;

	public function Categoria(){
		parent::Conexion();
		$this->id_almacen=0;
        $this->nombre="";
        $this->idCatMayor=0;
	}

	public function setIdCategoria($valor){ $this->id_categoria=$valor; }
	public function getIdCategoria(){ return $this->id_categoria; }
	public function setNombre($valor){ $this->nombre=$valor; }
	public function getNombre(){ return $this->nombre; }
    public function setIdCatMayor($valor){ $this->idCatMayor=$valor; }
	public function getIdCatMayor(){ return $this->idCatMayor; }

	public function limpiar($str){
		return parent::limpiarCadena($str);
	}

	public function editar($id_categoria){
		$sql="SELECT id_categoria,nombre,idCatMayor FROM categoria where id_categoria='$id_categoria'";
		return parent::ejecutarConsultaSimpleFila($sql);
    }

    public function listar(){
		$sql="SELECT c1.id_categoria,c1.nombre,c2.nombre as categoriaMayor FROM categoria c1 LEFT JOIN categoria c2 ON c1.idCatMayor=c2.id_categoria";
		return parent::ejecutar($sql);
	}

	public function selectCatMayor(){
		$sql="SELECT categoria.id_categoria,categoria.nombre FROM categoria WHERE categoria.idCatMayor IS NULL";
		return parent::ejecutar($sql);
	}

	public function selectCategoria(){
		$sql="SELECT categoria.id_categoria,categoria.nombre FROM categoria WHERE categoria.idCatMayor IS NOT NULL";
		return parent::ejecutar($sql);
	}

	public function guardar(){
        $sql="INSERT INTO categoria(nombre,idCatMayor) VALUES('$this->nombre','$this->idCatMayor')";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}

	public function guardarCatMayor(){
        $sql="INSERT INTO categoria(nombre) VALUES('$this->nombre')";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}

	public function modificar(){
        $sql="UPDATE categoria SET nombre='$this->nombre',idCatMayor='$this->idCatMayor' WHERE id_categoria='$this->id_categoria'";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}

	public function modificarCatMayor(){
        $sql="UPDATE categoria SET nombre='$this->nombre' WHERE id_categoria='$this->id_categoria'";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}

	public function eliminar(){
        $sql="DELETE FROM categoria WHERE id_categoria='$this->id_categoria'";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}
}
?>