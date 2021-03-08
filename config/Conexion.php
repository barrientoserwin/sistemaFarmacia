<?php 
class Conexion{
	private $servidor;
	private $usuario;
	private $password;
	private $basedatos;

	public function Conexion(){
		$this->servidor="localhost";
		$this->usuario="root";
		$this->password="";
		$this->basedatos="dbfarmacia";
	}

	public function setServidor($valor){ $this->servidor=$valor; }
	public function getServidor(){ return $this->servidor; }
	public function setUsuario($valor){ $this->usuario=$valor; }
	public function getUsuario(){ return $this->usuario; }
	public function setPassword($valor){ $this->password=$valor; }
	public function getPassword(){ return $this->password; }
	public function setBasedatos($valor){ $this->basedatos=$valor; }
	public function getBasedatos(){return $this->basedatos; }

	public function conectar(){
		$bd=mysqli_connect($this->servidor, $this->usuario, $this->password, $this->basedatos);
		if ($bd) {
			return $bd;
		}
		else
			echo "ERROR AL CONECTAR LA BASE DE DATOS";
	}

	public function desconectar($cnx){
		mysqli_close($cnx);
	}

	public function ejecutar($sql){
		$bd= $this->conectar();
		$query= mysqli_query($bd,$sql);
		$this->desconectar($bd);
		return $query;
	}	

	function ejecutarConsultaSimpleFila($sql){
		$bd= $this->conectar();	
		$query= $bd->query($sql);			
		$row = $query->fetch_assoc();
		$this->desconectar($bd);
		return $row;
	}

	function ejecutarConsulta_retornarID($sql){	
		$bd= $this->conectar();	
		$query= mysqli_query($bd,$sql);
		$new_id = mysqli_insert_id($bd);
		$this->desconectar($bd);
		return $new_id;
	}

	function limpiarCadena($str){
		$bd= $this->conectar();	
		$str = mysqli_real_escape_string($bd,trim($str));
		return htmlspecialchars($str);
	}
}
?>