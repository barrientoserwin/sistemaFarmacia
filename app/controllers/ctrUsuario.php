<?php 
session_start();
require_once "../models/Usuario.php";
$usuario=new Usuario();

$id_usuario=isset($_POST["id_usuario"])? $usuario->limpiar($_POST["id_usuario"]):"";
$login=isset($_POST["login"])? $usuario->limpiar($_POST["login"]):"";
$password=isset($_POST["password"])? $usuario->limpiar($_POST["password"]):"";
$foto=isset($_POST["foto"])? $usuario->limpiar($_POST["foto"]):"";
$rolUsuario=isset($_POST["rolUsuario"])? $usuario->limpiar($_POST["rolUsuario"]):"";
$id_empleado=isset($_POST["id_empleado"])? $usuario->limpiar($_POST["id_empleado"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (!file_exists($_FILES['foto']['tmp_name']) || !is_uploaded_file($_FILES['foto']['tmp_name'])){
			$foto=$_POST["imagen_actual"];
		} else {
			$ext = explode(".", $_FILES["foto"]["name"]);
			if ($_FILES['foto']['type'] == "image/jpg" || $_FILES['foto']['type'] == "image/jpeg" || $_FILES['foto']['type'] == "image/png"){
				$foto = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["foto"]["tmp_name"], "../../files/users/" . $foto);
			}
		}

        //Hash SHA256 en la contraseña
		$clavehash=hash("SHA256",$password);

		if (empty($id_usuario)){
            $usuario->setLogin($login);
			$usuario->setPassword($clavehash);
            if(empty($foto)){ $foto="default.png"; }
            $usuario->setFoto($foto);
            $usuario->setRolUsuario($rolUsuario);
            $usuario->setIdEmpleado($id_empleado);
			$rspta=$usuario->guardar($_POST['permiso']);
			echo $rspta ? "Usuario registrado" : "Usuario no se pudieron registrar todos los datos del usuario";
		}else {
            $usuario->setIdUsuario($id_usuario);
            $usuario->setLogin($login);
			$usuario->setPassword($clavehash);
            $usuario->setFoto($foto);
            $usuario->setRolUsuario($rolUsuario);
            $usuario->setIdEmpleado($id_empleado);
			$rspta=$usuario->modificar($_POST['permiso']);
			echo $rspta ? "Usuario actualizado" : "Usuario no se pudieron modificar todos los datos del usuario";
		}
	break;

	case 'desactivar':
		$rspta=$usuario->desactivar($id_usuario);
 		echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
	break;

	case 'activar':
		$rspta=$usuario->activar($id_usuario);
 		echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
	break;

	case 'editar':
		$rspta=$usuario->editar($id_usuario);
 		echo json_encode($rspta);
	break;

	case 'listar':
		$registros=$usuario->listar();
 		$data= Array();

 		while ($reg=$registros->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->nombre,
 				"1"=>$reg->apellidos,
 				"2"=>$reg->telefono,
 				"3"=>$reg->login,
                "4"=>$reg->rolUsuario,
 				"5"=>"<img src='../files/users/".$reg->foto."' height='50px' width='50px' >",
                "6"=>($reg->estado)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>',
                "7"=>($reg->estado)?'<button class="btn btn-warning" onclick="editar('.$reg->id_usuario.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->id_usuario.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="editar('.$reg->id_usuario.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->id_usuario.')"><i class="fa fa-check"></i></button>'
 				);
 		}

 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

    case 'permisos':
		$rspta = $usuario->selectPermiso();

		//Obtener los permisos asignados al usuario
		$id=$_GET['id'];
		$marcados = $usuario->listarMarcados($id);
		//Declaramos el array para almacenar todos los permisos marcados
		$valores=array();

		//Almacenar los permisos asignados al usuario en el array
		while ($per = $marcados->fetch_object()){
			array_push($valores, $per->id_permiso);
		}

		//Mostramos la lista de permisos en la vista y si están o no marcados
		while ($reg = $rspta->fetch_object()){
			$sw=in_array($reg->id_permiso,$valores)?'checked':'';
			echo '<li> <input type="checkbox" '.$sw.'  name="permiso[]" value="'.$reg->id_permiso.'">'.$reg->nombre.'</li>';
		}
	break;

	case 'verificar':
		$login_a=$_POST['login_a'];
	    $clave_a=$_POST['clave_a'];

	    //Hash SHA256 en la contraseña
		$clavehash=hash("SHA256",$clave_a);
		$rspta=$usuario->verificar($login_a, $clavehash);

		$fetch=$rspta->fetch_object();

		if (isset($fetch)){
	        //Declaramos las variables de sesión
	        $_SESSION['id_usuario']=$fetch->id_usuario;
	        $_SESSION['nombreEmpleado']=$fetch->nombreEmpleado;
	        $_SESSION['foto']=$fetch->foto;
	        $_SESSION['login']=$fetch->login;

	        //Obtenemos los permisos del usuario
	    	$marcados = $usuario->listarMarcados($fetch->id_usuario);
	    	//Declaramos el array para almacenar todos los permisos marcados
			$valores=array();

			//Almacenamos los permisos marcados en el array
			while ($per = $marcados->fetch_object()){
				array_push($valores, $per->id_permiso);
			}

			//Determinamos los accesos del usuario
			in_array(1,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
			in_array(2,$valores)?$_SESSION['almacen']=1:$_SESSION['almacen']=0;
			in_array(3,$valores)?$_SESSION['compras']=1:$_SESSION['compras']=0;
			in_array(4,$valores)?$_SESSION['ventas']=1:$_SESSION['ventas']=0;
			in_array(5,$valores)?$_SESSION['delivery']=1:$_SESSION['delivery']=0;
			in_array(6,$valores)?$_SESSION['acceso']=1:$_SESSION['acceso']=0;
			in_array(7,$valores)?$_SESSION['consultac']=1:$_SESSION['consultac']=0;
			in_array(8,$valores)?$_SESSION['consultav']=1:$_SESSION['consultav']=0;
	    }
	    echo json_encode($fetch);
	break;

	case 'salir':
		//Limpiamos las variables de sesión   
        session_unset();
        //Destruìmos la sesión
        session_destroy();
        //Redireccionamos al login
        header("Location: ../../index.php");

	break;
}
?>