<?php 
require_once "../models/MedicamentoAlmacen.php";

$medicamento_almacen=new MedicamentoAlmacen();
// $id_medicamentoAlmacen=isset($_POST["id_medicamentoAlmacen"])? $almacen->limpiar($_POST["id_medicamentoAlmacen"]):"";

switch ($_GET["op"]){
	case 'guardar':
        $medicamento_almacen->setIdAlmacen($_POST["id_almacen"]);
        $rspta = $medicamento_almacen->guardar($_POST["id_medicamento"],$_POST["stock"]);
        echo $rspta ? "Registro exitoso" : "Error al registrar";	
	break;

	case 'listar':
		$registros = $medicamento_almacen->listar();
        $data= Array();

 		while ($reg=$registros->fetch_object()){
 			$data[]=array(
				"0"=>$reg->nombre,
				"1"=>$reg->accionTerapeutica,
                "2"=>$reg->categoria,
                "3"=>$reg->laboratorio,
                "4"=>$reg->precio,
                "5"=>$reg->stock,
                "6"=>$reg->fechaVcto,
                "7"=>$reg->almacen
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;

    case 'listarMedicamentoAl':
        $medicamento_almacen->setIdAlmacen($_GET["id_almacen"]);
		$registros = $medicamento_almacen->listarMedicamentoAl();
        $data= Array();

 		while ($reg=$registros->fetch_object()){
 			$data[]=array(
				"0"=>$reg->nombre,
                "1"=>$reg->categoria,
                "2"=>$reg->laboratorio,
                "3"=>$reg->precio,
                "4"=>$reg->fechaVcto,
                "5"=>"<img src='../files/medicamentos/".$reg->foto."' height='50px' width='50px' >",
                "6"=>'<button class="btn btn-success" onclick="agregarDetalle('.$reg->id_medicamento.',\''.$reg->nombre.'\',\''.$reg->precio.'\',\''.$reg->fechaVcto.'\')"><span class="fa fa-plus"></span></button>',
 			);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;

	case 'listarMedicamentoAlmacen':
        $medicamento_almacen->setIdAlmacen($_GET["id_almacen"]);
		$registros = $medicamento_almacen->listarMedicamentoAlmacen();
        $data= Array();

 		while ($reg=$registros->fetch_object()){
 			$data[]=array(
				"0"=>$reg->nombre,
                "1"=>$reg->categoria,
                "2"=>$reg->laboratorio,
                "3"=>$reg->precio,
                "4"=>$reg->fechaVcto,
                "5"=>"<img src='../files/medicamentos/".$reg->foto."' height='50px' width='50px' >",
                "6"=>'<button class="btn btn-success" onclick="agregarDetalle('.$reg->id_medicamentoAlmacen.',\''.$reg->nombre.'\',\''.$reg->precio.'\')"><span class="fa fa-plus"></span></button>',
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