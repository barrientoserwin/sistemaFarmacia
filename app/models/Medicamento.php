<?php 
require "../../config/Conexion.php";
class Medicamento extends Conexion{
	private $id_medicamento;
	private $nombre;
	private $accionTerapeutica;
	private $precio;
	private $fechaVcto;
	private $foto;
    private $id_laboratorio;
    private $id_categoria;

	public function Cliente(){
		parent::Conexion();
		$this->id_medicamento=0;
		$this->nombre="";
		$this->accionTerapeutica="";
		$this->precio=0;
		$this->fechaVcto="";
		$this->foto="";
        $this->id_laboratorio=0;
        $this->id_categoria=0;
	}

	public function setIdMedicamento($valor){ $this->id_medicamento=$valor; }
	public function getIdMedicamento(){ return $this->id_medicamento; }
    public function setNombre($valor){ $this->nombre=$valor; }
	public function getNombre(){ return $this->nombre; }
	public function setAccionTerapeutica($valor){ $this->accionTerapeutica=$valor; }
	public function getAccionTerapeutica(){ return $this->accionTerapeutica; }
	public function setPrecio($valor){ $this->precio=$valor; }
	public function getPrecio(){ return $this->precio; }
	public function setFechaVcto($valor){ $this->fechaVcto=$valor; }
	public function getFechaVcto(){ return $this->fechaVcto; }
	public function setFoto($valor){ $this->foto=$valor; }
	public function getFoto(){ return $this->foto; }
    public function setIdLaboratorio($valor){ $this->id_laboratorio=$valor; }
	public function getIdLaboratorio(){ return $this->id_laboratorio; }
    public function setIdCategoria($valor){ $this->id_categoria=$valor; }
	public function getIdCategoria(){ return $this->id_categoria; }

    public function limpiar($str){
        return parent::limpiarCadena($str);
    }

    public function listar(){
		$sql="SELECT m.id_medicamento, m.nombre, m.accionTerapeutica, m.precio, m.fechaVcto, m.foto, c.nombre as categoria, l.nombre as laboratorio 
        FROM medicamento m INNER JOIN laboratorio l ON l.id_laboratorio=m.id_laboratorio INNER JOIN categoria c ON c.id_categoria=m.id_categoria";
		return parent::ejecutar($sql);
	}

	public function editar($id_medicamento){
		$sql="SELECT *FROM medicamento where id_medicamento='$id_medicamento'";
		return parent::ejecutarConsultaSimpleFila($sql);
	}

	public function guardar(){
        $sql="INSERT INTO medicamento(nombre,accionTerapeutica,precio,fechaVcto,foto,id_laboratorio,id_categoria) 
		VALUES(
			'$this->nombre',
			'$this->accionTerapeutica',
			'$this->precio',
			'$this->fechaVcto',
			'$this->foto',
			'$this->id_laboratorio',
			'$this->id_categoria'
			)";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}

	public function modificar(){
        $sql="UPDATE medicamento SET nombre='$this->nombre',
		accionTerapeutica='$this->accionTerapeutica',
		precio='$this->precio',
		fechaVcto='$this->fechaVcto',
		foto='$this->foto',
		id_laboratorio='$this->id_laboratorio',
        id_categoria='$this->id_categoria'
		WHERE id_medicamento='$this->id_medicamento'";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}

	public function eliminar(){
        $sql="DELETE FROM medicamento WHERE id_medicamento='$this->id_medicamento'";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}
}
?>