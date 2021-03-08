<?php 
require_once "../models/Empleado.php";

$empleado=new Empleado();
$id_empleado=isset($_POST["id_empleado"])? $empleado->limpiar($_POST["id_empleado"]):"";
$nombre=isset($_POST["nombre"])? $empleado->limpiar($_POST["nombre"]):"";
$apellidos=isset($_POST["apellidos"])? $empleado->limpiar($_POST["apellidos"]):"";
$fechaNac=isset($_POST["fechaNac"])? $empleado->limpiar($_POST["fechaNac"]):"";
$telefono=isset($_POST["telefono"])? $empleado->limpiar($_POST["telefono"]):"";
$direccion=isset($_POST["direccion"])? $empleado->limpiar($_POST["direccion"]):"";
$id_tipoEmpleado=isset($_POST["id_tipoEmpleado"])? $empleado->limpiar($_POST["id_tipoEmpleado"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_empleado)){
			$empleado->setNombre($nombre);
            $empleado->setApellidos($apellidos);
            $empleado->setFechaNac($fechaNac);
            $empleado->setTelefono($telefono);
            $empleado->setDireccion($direccion);
            $empleado->setIdTipoEmpleado($id_tipoEmpleado);
			$rspta = $empleado->guardar();
			echo $rspta ? "Empleado registrado" : "Empleado no se pudo registrar";			
		}
		else {
			$empleado->setIdEmpleado($id_empleado);
            $empleado->setNombre($nombre);
            $empleado->setApellidos($apellidos);
            $empleado->setFechaNac($fechaNac);
            $empleado->setTelefono($telefono);
            $empleado->setDireccion($direccion);
            $empleado->setIdTipoEmpleado($id_tipoEmpleado);
			$empleado->setNombre($nombre);
			$rspta = $empleado->modificar();
			echo $rspta ? "Empleado modificado" : "Empleado no se pudo modificar";			
		}
	break;

	case 'eliminar':
		$empleado->setIdEmpleado($id_empleado);
        $rspta = $empleado->eliminar();
		echo $rspta ? "Empleado eliminado" : "Empleado no se pudo eliminar";
	break;

	case 'editar':
		$rspta=$empleado->editar($id_empleado);
 		echo json_encode($rspta);
	break;

	case 'listar':
		$registros = $empleado->listar();
        $data= Array();

 		while ($reg=$registros->fetch_object()){
 			$data[]=array(
				"0"=>$reg->nombre,
				"1"=>$reg->apellidos,
                "2"=>$reg->fechaNac,
                "3"=>$reg->telefono,
                "4"=>$reg->direccion,
                "5"=>$reg->tipoEmpleado,
 				"6"=>'<button class="btn btn-warning" onclick="editar('.$reg->id_empleado.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="eliminar('.$reg->id_empleado.')"><i class="fa fa-trash"></i></button>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case "selectEmpleado":
        $rspta = $empleado->selectEmpleado();
        echo '<option value="" selected>Seleccione</option>';
        while (($reg = $rspta->fetch_object())) {
            echo '<option value=' . $reg->id_empleado . '>' . $reg->nombre .' '. $reg->apellidos .'</option>';
        }
	break;
}
?>