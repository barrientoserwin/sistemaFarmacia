<?php 
require "../../config/Conexion.php";
class Proveedor extends Conexion{
	private $id_proveedor;
	private $telefono;
	private $direccion;
    private $mail;
    private $tipo;
    private $nombre;
	private $apellidos;
    private $razonSocial;

	public function Proveedor(){
		parent::Conexion();
		$this->id_proveedor=0;
        $this->telefono="";
        $this->direccion="";
		$this->mail="";
        $this->tipo="";
        $this->nombre="";
		$this->apellidos="";
        $this->razonSocial="";
	}

	public function setIdProveedor($valor){ $this->id_proveedor=$valor; }
	public function getIdProveedor(){ return $this->id_proveedor; }
	public function setTelefono($valor){ $this->telefono=$valor; }
	public function getTelefono(){ return $this->telefono; }
	public function setDireccion($valor){ $this->direccion=$valor; }
	public function getDireccion(){ return $this->direccion; }
	public function setMail($valor){ $this->mail=$valor; }
	public function getMail(){ return $this->mail; }
    public function setTipo($valor){ $this->tipo=$valor; }
	public function getTipo(){ return $this->tipo; }
	public function setNombre($valor){ $this->nombre=$valor; }
	public function getNombre(){ return $this->nombre; }
    public function setApellidos($valor){ $this->apellidos=$valor; }
	public function getApellidos(){ return $this->apellidos; }
    public function setRazonSocial($valor){ $this->razonSocial=$valor; }
	public function getRazonsocial(){ return $this->razonSocial; }

	public function limpiar($str){
		return parent::limpiarCadena($str);
	}

	public function editarPPersona($id_proveedor){
		$sql="SELECT id_proveedor,telefono,direccion,mail,nombre,apellidos FROM proveedor where id_proveedor='$id_proveedor'";
		return parent::ejecutarConsultaSimpleFila($sql);
    }

    public function editarPEmpresa($id_proveedor){
		$sql="SELECT id_proveedor,telefono,direccion,mail,razonSocial FROM proveedor where id_proveedor='$id_proveedor'";
		return parent::ejecutarConsultaSimpleFila($sql);
    }

    public function listarPPersona(){
		$sql="SELECT id_proveedor,telefono,direccion,mail,nombre,apellidos FROM proveedor WHERE tipo='persona'";
		return parent::ejecutar($sql);
	}

    public function listarPEmpresa(){
		$sql="SELECT id_proveedor,telefono,direccion,mail,razonSocial FROM proveedor WHERE tipo='empresa'";
		return parent::ejecutar($sql);
	}


	public function guardarPPersona(){
        $sql="INSERT INTO proveedor(telefono,direccion,mail,tipo,nombre,apellidos) 
		VALUES(
			'$this->telefono',
			'$this->direccion',
			'$this->mail',
			'$this->tipo',
			'$this->nombre',
			'$this->apellidos'
			)";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}

	public function modificarPPersona(){
        $sql="UPDATE proveedor SET telefono='$this->telefono',
		direccion='$this->direccion',
		mail='$this->mail',
		nombre='$this->nombre',
		apellidos='$this->apellidos'
		WHERE id_proveedor='$this->id_proveedor'";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}

	public function eliminarProveedor(){
        $sql="DELETE FROM proveedor WHERE id_proveedor='$this->id_proveedor'";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}

	public function guardarPEmpresa(){
        $sql="INSERT INTO proveedor(telefono,direccion,mail,tipo,razonSocial) 
		VALUES(
			'$this->telefono',
			'$this->direccion',
			'$this->mail',
			'$this->tipo',
			'$this->razonSocial'
			)";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}

	public function modificarPEmpresa(){
        $sql="UPDATE proveedor SET telefono='$this->telefono',
		direccion='$this->direccion',
		mail='$this->mail',
		razonSocial='$this->razonSocial'
		WHERE id_proveedor='$this->id_proveedor'";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}
}
?>