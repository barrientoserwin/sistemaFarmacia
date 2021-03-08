<?php 
require "../../config/Conexion.php";
class Empleado extends Conexion{
	private $id_empleado;
	private $nombre;
	private $apellidos;
	private $fechaNac;
	private $telefono;
	private $direccion;
	private $id_tipoEmpleado;

	public function Empleado(){
		parent::Conexion();
		$this->id_empleado=0;
		$this->nombre="";
		$this->apellidos="";
		$this->fechaNac="";
		$this->telefono="";
		$this->direccion="";
		$this->id_tipoEmpleado=0;
	}

	public function setIdEmpleado($valor){ $this->id_empleado=$valor; }
	public function getIdEmpleado(){ return $this->id_empleado; }
	public function setNombre($valor){ $this->nombre=$valor; }
	public function getNombre(){ return $this->nombre; }
	public function setApellidos($valor){ $this->apellidos=$valor; }
	public function getApellidos(){ return $this->apellidos; }
	public function setFechaNac($valor){ $this->fechaNac=$valor; }
	public function getFechaNac(){ return $this->fechaNac; }
	public function setTelefono($valor){ $this->telefono=$valor; }
	public function getTelefono(){ return $this->telefono; }
	public function setDireccion($valor){ $this->direccion=$valor; }
	public function getDireccion(){ return $this->direccion; }
	public function setIdTipoEmpleado($valor){ $this->id_tipoEmpleado=$valor; }
	public function getIdTipoEmpleado(){ return $this->id_tipoEmpleado; }

    public function limpiar($str){
        return parent::limpiarCadena($str);
    }

    public function listar(){
		$sql="SELECT e.id_empleado, e.nombre, e.apellidos, e.fechaNac, e.telefono, e.direccion, t.nombre as tipoEmpleado 
        FROM empleado e INNER JOIN tipoEmpleado t ON t.id_tipoEmpleado=e.id_tipoEmpleado";
		return parent::ejecutar($sql);
	}

    public function selectEmpleado(){
		$sql="SELECT id_empleado, nombre, apellidos 
        FROM empleado";
		return parent::ejecutar($sql);
	}

	public function editar($id_empleado){
		$sql="SELECT * FROM empleado where id_empleado='$id_empleado'";
		return parent::ejecutarConsultaSimpleFila($sql);
	}

	public function guardar(){
        $sql="INSERT INTO empleado(nombre,apellidos,fechaNac,telefono,direccion,id_tipoEmpleado) 
		VALUES(
			'$this->nombre',
			'$this->apellidos',
			'$this->fechaNac',
			'$this->telefono',
			'$this->direccion',
			'$this->id_tipoEmpleado'
			)";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}

	public function modificar(){
        $sql="UPDATE empleado SET nombre='$this->nombre',
		apellidos='$this->apellidos',
		fechaNac='$this->fechaNac',
		telefono='$this->telefono',
		direccion='$this->direccion',
		id_tipoEmpleado='$this->id_tipoEmpleado'
		WHERE id_empleado='$this->id_empleado'";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}

	public function eliminar(){
        $sql="DELETE FROM empleado WHERE id_empleado=$this->id_empleado";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}

}
?>