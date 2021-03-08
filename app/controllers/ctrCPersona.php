<?php 
require_once "../models/Cliente.php";

$cliente=new Cliente();
$id_cliente=isset($_POST["id_cliente"])? $cliente->limpiar($_POST["id_cliente"]):"";
$telefono=isset($_POST["telefono"])? $cliente->limpiar($_POST["telefono"]):"";
$direccion=isset($_POST["direccion"])? $cliente->limpiar($_POST["direccion"]):"";
$creditoMax=isset($_POST["creditoMax"])? $cliente->limpiar($_POST["creditoMax"]):"";
$nit=isset($_POST["nit"])? $cliente->limpiar($_POST["nit"]):"";
$mail=isset($_POST["mail"])? $cliente->limpiar($_POST["mail"]):"";
$nombre=isset($_POST["nombre"])? $cliente->limpiar($_POST["nombre"]):"";
$apellidos=isset($_POST["apellidos"])? $cliente->limpiar($_POST["apellidos"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_cliente)){
			$cliente->setTelefono($telefono);
			$cliente->setDireccion($direccion);
			$cliente->setCreditoMax($creditoMax);
			$cliente->setNit($nit);
			$cliente->setMail($mail);
			$cliente->setTipo("persona");
			$cliente->setNombre($nombre);
			$cliente->setApellidos($apellidos);
			$rspta = $cliente->guardarCPersona();
			echo $rspta ? "Cliente persona registrado" : "Cliente no se pudo registrar";			
		}
		else {
			$cliente->setIdCliente($id_cliente);
			$cliente->setTelefono($telefono);
			$cliente->setDireccion($direccion);
			$cliente->setCreditoMax($creditoMax);
			$cliente->setNit($nit);
			$cliente->setMail($mail);
			$cliente->setTipo("persona");
			$cliente->setNombre($nombre);
			$cliente->setApellidos($apellidos);
			$rspta = $cliente->modificarCPersona();
			echo $rspta ? "Cliente persona modificado" : "Cliente no se pudo modificar";			
		}
	break;

	case 'eliminar':
		$cliente->setIdCliente($id_cliente);
        $rspta = $cliente->eliminarCliente();
		echo $rspta ? "Cliente eliminado" : "Cliente no se pudo eliminar";
	break;

	case 'editar':
		$rspta=$cliente->editarPersona($id_cliente);
 		echo json_encode($rspta);
	break;

	case 'listar':
		$registros = $cliente->listarCPersona();
        $data= Array();

 		while ($reg=$registros->fetch_object()){
 			$data[]=array(
				"0"=>$reg->nombre,
				"1"=>$reg->apellidos,
                "2"=>$reg->mail,
                "3"=>$reg->telefono,
                "4"=>$reg->nit,
                "5"=>$reg->creditoMax,
                "6"=>$reg->direccion,
 				"7"=>'<button class="btn btn-warning" onclick="editar('.$reg->id_cliente.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="eliminar('.$reg->id_cliente.')"><i class="fa fa-trash"></i></button>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
}
?>