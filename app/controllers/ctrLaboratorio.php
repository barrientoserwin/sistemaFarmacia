<?php 
require_once "../models/Laboratorio.php";

$laboratorio=new Laboratorio();
$id_laboratorio=isset($_POST["id_laboratorio"])? $laboratorio->limpiar($_POST["id_laboratorio"]):"";
$nombre=isset($_POST["nombre"])? $laboratorio->limpiar($_POST["nombre"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_laboratorio)){
			$laboratorio->setNombre($nombre);
			$rspta = $laboratorio->guardar();
			echo $rspta ? "Laboratorio registrado" : "Laboratorio no se pudo registrar";			
		}
		else {
			$laboratorio->setIdLaboratorio($id_laboratorio);
			$laboratorio->setNombre($nombre);
			$rspta = $laboratorio->modificar();
			echo $rspta ? "Laboratorio modificado" : "Laboratorio no se pudo modificar";			
		}
	break;

	case 'eliminar':
		$laboratorio->setIdLaboratorio($id_laboratorio);
        $rspta = $laboratorio->eliminar();
		echo $rspta ? "Laboratorio eliminado" : "Laboratorio no se pudo eliminar";
	break;

	case 'editar':
		$rspta=$laboratorio->editar($id_laboratorio);
 		echo json_encode($rspta);
	break;

	case 'listar':
		$registros = $laboratorio->listar();
        $data= Array();

 		while ($reg=$registros->fetch_object()){
 			$data[]=array(
				"0"=>$reg->id_laboratorio,
				"1"=>$reg->nombre,
 				"2"=>'<button class="btn btn-warning" onclick="editar('.$reg->id_laboratorio.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="eliminar('.$reg->id_laboratorio.')"><i class="fa fa-trash"></i></button>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case "selectLaboratorio":
        $rspta = $laboratorio->selectLaboratorio();

        echo '<option value="" selected>Seleccione</option>';
        while (($reg = $rspta->fetch_object())) {
            echo '<option value=' . $reg->id_laboratorio . '>' . $reg->nombre . '</option>';
        }
	break;
}
?>