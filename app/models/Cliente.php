<?php 
require "../../config/Conexion.php";
class Cliente extends Conexion{
	private $id_cliente;
	private $telefono;
	private $direccion;
	private $creditoMax;
	private $nit;
	private $mail;
	private $tipo;
	private $nombre;
	private $apellidos;
	private $razonSocial;

	public function Cliente(){
		parent::Conexion();
		$this->id_cliente=0;
		$this->telefono="";
		$this->direccion="";
		$this->creditoMax=0;
		$this->nit="";
		$this->mail="";
		$this->tipo="";
		$this->nombre="";
		$this->apellidos="";
		$this->razonSocial="";
	}

	public function setIdCliente($valor){ $this->id_cliente=$valor; }
	public function getIdCliente(){ return $this->id_cliente; }
	public function setTelefono($valor){ $this->telefono=$valor; }
	public function getTelefono(){ return $this->telefono; }
	public function setDireccion($valor){ $this->direccion=$valor; }
	public function getDireccion(){ return $this->direccion; }
	public function setCreditoMax($valor){ $this->creditoMax=$valor; }
	public function getCreditoMax(){ return $this->creditoMax; }
	public function setNit($valor){ $this->nit=$valor; }
	public function getNit(){ return $this->nit; }
	public function setMail($valor){ $this->mail=$valor; }
	public function getMail(){ return $this->mail; }
	public function setTipo($valor){ $this->tipo=$valor; }
	public function getTipo(){ return $this->tipo; }
	public function setNombre($valor){ $this->nombre=$valor; }
	public function getNombre(){ return $this->nombre; }
	public function setApellidos($valor){ $this->apellidos=$valor; }
	public function getApellidos(){ return $this->apellidos; }
	public function setRazonSocial($valor){ $this->razonSocial=$valor; }
	public function getRazonSocial(){ return $this->razonSocial; }

    public function limpiar($str){
        return parent::limpiarCadena($str);
    }

    public function listarCPersona(){
		$sql="SELECT id_cliente, nombre, apellidos, mail, telefono, nit, creditoMax, direccion FROM cliente WHERE tipo='persona'";
		return parent::ejecutar($sql);
	}

	public function editarPersona($id_cliente){
		$sql="SELECT id_cliente, nombre, apellidos, mail, telefono, nit, creditoMax, direccion FROM cliente where id_cliente='$id_cliente'";
		return parent::ejecutarConsultaSimpleFila($sql);
	}

	public function editarEmpresa($id_cliente){
		$sql="SELECT id_cliente, razonSocial, mail, telefono, nit, creditoMax, direccion FROM cliente where id_cliente='$id_cliente'";
		return parent::ejecutarConsultaSimpleFila($sql);
	}

	public function guardarCPersona(){
        $sql="INSERT INTO cliente(telefono,direccion,creditoMax,nit,mail,tipo,nombre,apellidos) 
		VALUES(
			'$this->telefono',
			'$this->direccion',
			'$this->creditoMax',
			'$this->nit',
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

	public function modificarCPersona(){
        $sql="UPDATE cliente SET telefono='$this->telefono',
		direccion='$this->direccion',
		creditoMax='$this->creditoMax',
		nit='$this->nit',
		mail='$this->mail',
		nombre='$this->nombre',
		apellidos='$this->apellidos'
		WHERE id_cliente='$this->id_cliente'";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}

	public function eliminarCliente(){
        $sql="DELETE FROM cliente WHERE id_cliente=$this->id_cliente";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}

	public function listarCEmpresa(){
		$sql="SELECT id_cliente, razonSocial, mail, telefono, nit, creditoMax, direccion FROM cliente where tipo='empresa'";
		return parent::ejecutar($sql);
	}

	public function guardarCEmpresa(){
        $sql="INSERT INTO cliente(telefono,direccion,creditoMax,nit,mail,tipo,razonSocial) 
		VALUES(
			'$this->telefono',
			'$this->direccion',
			'$this->creditoMax',
			'$this->nit',
			'$this->mail',
			'$this->tipo',
			'$this->razonSocial'
			)";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}

	public function modificarCEmpresa(){
        $sql="UPDATE cliente SET telefono='$this->telefono',
		direccion='$this->direccion',
		creditoMax='$this->creditoMax',
		nit='$this->nit',
		mail='$this->mail',
		razonSocial='$this->razonSocial'
		WHERE id_cliente='$this->id_cliente'";
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}
}
?>