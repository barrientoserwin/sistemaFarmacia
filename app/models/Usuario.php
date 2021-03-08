<?php 
require "../../config/Conexion.php";
class Usuario extends Conexion{
	private $id_usuario;
	private $login;
	private $password;
    private $foto;
	private $rolUsuario;
	private $estado;
	private $id_empleado;

	public function Usuario(){
		parent::Conexion();
		$this->id_usuario=0;
		$this->login="";
		$this->password="";
        $this->foto="";
		$this->rolUsuario="";
		$this->estado=0;
		$this->id_empleado=0;
	}

	public function setIdUsuario($valor){ $this->id_usuario=$valor; }
	public function getIdUsuario(){ return $this->id_usuario; }
	public function setLogin($valor){ $this->login=$valor; }
	public function getLogin(){ return $this->login; }
	public function setPassword($valor){ $this->password=$valor; }
	public function getPassword(){ return $this->password; }
    public function setFoto($valor){ $this->foto=$valor; }
	public function getFoto(){ return $this->foto; }
	public function setRolUsuario($valor){ $this->rolUsuario=$valor; }
	public function getRolUsuario(){ return $this->rolUsuario; }
	public function setEstado($valor){ $this->estado=$valor; }
	public function getEstado(){ return $this->estado; }
	public function setIdEmpleado($valor){ $this->id_empleado=$valor; }
	public function getIdEmpleado(){ return $this->id_empleado; }

    public function limpiar($str){
        return parent::limpiarCadena($str);
    }

    public function listar(){
		$sql="SELECT u.id_usuario, e.nombre, e.apellidos, e.telefono, u.login, u.rolUsuario, u.foto, u.estado
        FROM usuario u INNER JOIN empleado e ON e.id_empleado=u.id_empleado";
		return parent::ejecutar($sql);
	}

    public function selectPermiso(){
		$sql="SELECT id_permiso,nombre FROM permiso";
		return parent::ejecutar($sql);
	}

	public function editar($id_usuario){
		$sql="SELECT * FROM usuario where id_usuario='$id_usuario'";
		return parent::ejecutarConsultaSimpleFila($sql);
	}

	public function guardar($permisos){
        $sql="INSERT INTO usuario(login,password,foto,rolUsuario,id_empleado) VALUES('$this->login','$this->password','$this->foto','$this->rolUsuario','$this->id_empleado')";
        $idUsuarioNew=parent::ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;
		while ($num_elementos < count($permisos)){
			$sql_detalle = "INSERT INTO usuario_permiso(id_usuario, id_permiso) VALUES('$idUsuarioNew', '$permisos[$num_elementos]')";
			parent::ejecutar($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}
		return $sw;
	}

	public function modificar($permisos){
        $sql="UPDATE usuario SET login='$this->login', password='$this->password', foto='$this->foto', rolUsuario='$this->rolUsuario', id_empleado='$this->id_empleado'	WHERE id_usuario='$this->id_usuario'";
        parent::ejecutar($sql);

        //Eliminamos todos los permisos asignados para volverlos a registrar
		$sqlDelet="DELETE FROM usuario_permiso WHERE id_usuario='$this->id_usuario'";
		parent::ejecutar($sqlDelet);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($permisos)){
			$sql_detalle = "INSERT INTO usuario_permiso(id_usuario, id_permiso) VALUES('$this->id_usuario', '$permisos[$num_elementos]')";
			parent::ejecutar($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}
		return $sw;
	}

	public function desactivar($id_usuario){
		$sql="UPDATE usuario SET estado='0' WHERE id_usuario='$id_usuario'";
		return parent::ejecutar($sql);
	}

	public function activar($id_usuario){
		$sql="UPDATE usuario SET estado='1' WHERE id_usuario='$id_usuario'";
		return parent::ejecutar($sql);
	}

    public function listarMarcados($id_usuario){
		$sql="SELECT * FROM usuario_permiso WHERE id_usuario='$id_usuario'";
		return parent::ejecutar($sql);
	}

	//Función para verificar el acceso al sistema
	public function verificar($login,$password){
    	//$sql="SELECT id_usuario,login,password,foto,rolUsuario,id_empleado FROM usuario WHERE login='$login' AND password='$password' AND estado='1'"; 
		$sql="SELECT u.id_usuario,u.login,u.password,u.foto,u.rolUsuario,e.nombre as nombreEmpleado 
		FROM usuario u INNER JOIN empleado e ON e.id_empleado=u.id_empleado WHERE login='$login' AND password='$password' AND estado='1'";
    	return parent::ejecutar($sql);  
    }
}
?>