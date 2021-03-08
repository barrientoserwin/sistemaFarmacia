<?php 
require_once "../models/Proveedor.php";

$proveedor=new Proveedor();
$id_proveedor=isset($_POST["id_proveedor"])? $proveedor->limpiar($_POST["id_proveedor"]):"";
$telefono=isset($_POST["telefono"])? $proveedor->limpiar($_POST["telefono"]):"";
$direccion=isset($_POST["direccion"])? $proveedor->limpiar($_POST["direccion"]):"";
$mail=isset($_POST["mail"])? $proveedor->limpiar($_POST["mail"]):"";
$razonSocial=isset($_POST["razonSocial"])? $proveedor->limpiar($_POST["razonSocial"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_proveedor)){
			$proveedor->setTelefono($telefono);
			$proveedor->setDireccion($direccion);
			$proveedor->setMail($mail);
			$proveedor->setTipo("empresa");
			$proveedor->setRazonSocial($razonSocial);
			$rspta = $proveedor->guardarPEmpresa();
			echo $rspta ? "Proveedor empresa registrado" : "Proveedor no se pudo registrar";			
		}
		else {
			$proveedor->setIdProveedor($id_proveedor);
			$proveedor->setTelefono($telefono);
			$proveedor->setDireccion($direccion);
			$proveedor->setMail($mail);
			$proveedor->setTipo("empresa");
			$proveedor->setRazonSocial($razonSocial);
			$rspta = $proveedor->modificarPEmpresa();
			echo $rspta ? "Proveedor empresa modificado" : "Proveedor no se pudo modificar";			
		}
	break;

	case 'eliminar':
		$proveedor->setIdProveedor($id_proveedor);
        $rspta = $proveedor->eliminarProveedor();
		echo $rspta ? "Proveedor eliminado" : "Proveedor no se pudo eliminar";
	break;

	case 'editar':
		$rspta=$proveedor->editarPPersona($id_proveedor);
 		echo json_encode($rspta);
	break;

	case 'listar':
		$registros = $proveedor->listarPEmpresa();
        $data= Array();

 		while ($reg=$registros->fetch_object()){
 			$data[]=array(
				"0"=>$reg->razonSocial,
                "1"=>$reg->mail,
                "2"=>$reg->telefono,
                "3"=>$reg->direccion,
 				"4"=>'<button class="btn btn-warning" onclick="editar('.$reg->id_proveedor.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="eliminar('.$reg->id_proveedor.')"><i class="fa fa-trash"></i></button>'
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