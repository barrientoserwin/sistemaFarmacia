<?php 
require_once "../models/Cliente.php";

$cliente=new Cliente();
$id_cliente=isset($_POST["id_cliente"])? $cliente->limpiar($_POST["id_cliente"]):"";
$telefono=isset($_POST["telefono"])? $cliente->limpiar($_POST["telefono"]):"";
$direccion=isset($_POST["direccion"])? $cliente->limpiar($_POST["direccion"]):"";
$creditoMax=isset($_POST["creditoMax"])? $cliente->limpiar($_POST["creditoMax"]):"";
$nit=isset($_POST["nit"])? $cliente->limpiar($_POST["nit"]):"";
$mail=isset($_POST["mail"])? $cliente->limpiar($_POST["mail"]):"";
$razonSocial=isset($_POST["razonSocial"])? $cliente->limpiar($_POST["razonSocial"]):"";

//Cliente Empresa
switch ($_GET["op"]){
		case 'guardaryeditar':
			if (empty($id_cliente)){
				$cliente->setTelefono($telefono);
				$cliente->setDireccion($direccion);
				$cliente->setCreditoMax($creditoMax);
				$cliente->setNit($nit);
				$cliente->setMail($mail);
				$cliente->setTipo("empresa");
				$cliente->setRazonSocial($razonSocial);
				$rspta = $cliente->guardarCEmpresa();
				echo $rspta ? "Cliente Empresa registrado" : "Cliente Empresa no se pudo registrar";
			}
			else {
				$cliente->setIdCliente($id_cliente);
				$cliente->setTelefono($telefono);
				$cliente->setDireccion($direccion);
				$cliente->setCreditoMax($creditoMax);
				$cliente->setNit($nit);
				$cliente->setMail($mail);
				$cliente->setTipo("empresa");
				$cliente->setRazonSocial($razonSocial);
				$rspta = $cliente->modificarCEmpresa();
				echo $rspta ? "Cliente Empresa modificado" : "Cliente Empresa no se pudo modificar";
			}
		break;

        case 'eliminar':
            $cliente->setIdCliente($id_cliente);
            $rspta = $cliente->eliminarCliente();
            echo $rspta ? "Cliente Empresa eliminado" : "Cliente Empresa no se pudo eliminar";
        break;
    
        case 'editar':
            $rspta=$cliente->editarEmpresa($id_cliente);
             echo json_encode($rspta);
        break;
	
		case 'listar':
			$registros = $cliente->listarCEmpresa();
			$data= Array();
	
			 while ($reg=$registros->fetch_object()){
				 $data[]=array(
					"0"=>$reg->razonSocial,
					"1"=>$reg->mail,
					"2"=>$reg->telefono,
					"3"=>$reg->nit,
					"4"=>$reg->creditoMax,
					"5"=>$reg->direccion,
					"6"=>'<button class="btn btn-warning" onclick="editar('.$reg->id_cliente.')"><i class="fa fa-pencil"></i></button>'.
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