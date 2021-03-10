<?php 
require_once "../models/Almacen.php";

$almacen=new Almacen();
$id_almacen=isset($_POST["id_almacen"])? $almacen->limpiar($_POST["id_almacen"]):"";
$nombre=isset($_POST["nombre"])? $almacen->limpiar($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? $almacen->limpiar($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_almacen)){
			$almacen->setNombre($nombre);
            $almacen->setDescripcion($descripcion);
			$rspta = $almacen->guardar();
			echo $rspta ? "Almacen registrado" : "Almacen no se pudo registrar";			
		}
		else {
			$almacen->setIdAlmacen($id_almacen);
			$almacen->setNombre($nombre);
            $almacen->setDescripcion($descripcion);
			$rspta = $almacen->modificar();
			echo $rspta ? "Almacen modificado" : "Almacen no se pudo modificar";			
		}
	break;

	case 'eliminar':
		$almacen->setIdAlmacen($id_almacen);
        $rspta = $almacen->eliminar();
		echo $rspta ? "Almacen eliminado" : "Almacen no se pudo eliminar";
	break;

	case 'editar':
		$rspta=$almacen->editar($id_almacen);
 		echo json_encode($rspta);
	break;

	case 'listar':
		$registros = $almacen->listar();
        $data= Array();

 		while ($reg=$registros->fetch_object()){
 			$data[]=array(
				"0"=>$reg->id_almacen,
				"1"=>$reg->nombre,
                "2"=>$reg->descripcion,
 				"3"=>'<button class="btn btn-warning" onclick="editar('.$reg->id_almacen.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="eliminar('.$reg->id_almacen.')"><i class="fa fa-trash"></i></button>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;

	case "selectAlmacen":
        $rspta = $almacen->selectAlmacen();

        echo '<option value="" selected>Seleccione</option>';
        while (($reg = $rspta->fetch_object())) {
            echo '<option value=' . $reg->id_almacen . '>' . $reg->nombre . '</option>';
        }
	break;
}
?>