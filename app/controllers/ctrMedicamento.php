<?php 
require_once "../models/Medicamento.php";

$medicamento=new Medicamento();

$id_medicamento=isset($_POST["id_medicamento"])? $medicamento->limpiar($_POST["id_medicamento"]):"";
$nombre=isset($_POST["nombre"])? $medicamento->limpiar($_POST["nombre"]):"";
$accionTerapeutica=isset($_POST["accionTerapeutica"])? $medicamento->limpiar($_POST["accionTerapeutica"]):"";
$precio=isset($_POST["precio"])? $medicamento->limpiar($_POST["precio"]):"";
$fechaVcto=isset($_POST["fechaVcto"])? $medicamento->limpiar($_POST["fechaVcto"]):"";
$foto=isset($_POST["foto"])? $medicamento->limpiar($_POST["foto"]):"";
$id_laboratorio=isset($_POST["id_laboratorio"])? $medicamento->limpiar($_POST["id_laboratorio"]):"";
$id_categoria=isset($_POST["id_categoria"])? $medicamento->limpiar($_POST["id_categoria"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (!file_exists($_FILES['foto']['tmp_name']) || !is_uploaded_file($_FILES['foto']['tmp_name'])){
			$foto=$_POST["imagen_actual"];
		} else {
			$ext = explode(".", $_FILES["foto"]["name"]);
			if ($_FILES['foto']['type'] == "image/jpg" || $_FILES['foto']['type'] == "image/jpeg" || $_FILES['foto']['type'] == "image/png"){
				$foto = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["foto"]["tmp_name"], "../../files/medicamentos/" . $foto);
			}
		}
		if (empty($id_medicamento)){
            $medicamento->setNombre($nombre);
			$medicamento->setAccionTerapeutica($accionTerapeutica);
            $medicamento->setPrecio($precio);
            $medicamento->setFechaVcto($fechaVcto);
            if(empty($foto)){ $foto="default.png"; }
            $medicamento->setFoto($foto);
            $medicamento->setIdLaboratorio($id_laboratorio);
            $medicamento->setIdCategoria($id_categoria);
			$rspta=$medicamento->guardar();
			echo $rspta ? "Medicamento registrado" : "Medicamento no se pudo registrar";
		}
		else {
            $medicamento->setIdMedicamento($id_medicamento);
            $medicamento->setNombre($nombre);
            $medicamento->setAccionTerapeutica($accionTerapeutica);
            $medicamento->setPrecio($precio);
            $medicamento->setFechaVcto($fechaVcto);
            $medicamento->setFoto($foto);
            $medicamento->setIdLaboratorio($id_laboratorio);
            $medicamento->setIdCategoria($id_categoria);
			$rspta=$medicamento->modificar();
			echo $rspta ? "Medicamento actualizado" : "Medicamento no se pudo actualizar";
		}
	break;

	case 'eliminar':
        $medicamento->setIdMedicamento($id_medicamento);
		$rspta=$medicamento->eliminar();
 		echo $rspta ? "Medicamento eliminado" : "Medicamento no se pudo eliminar";
	break;

	case 'editar':
		$rspta=$medicamento->editar($id_medicamento);
 		echo json_encode($rspta);
	break;

	case 'listar':
		$registros=$medicamento->listar();
 		$data= Array();

 		while ($reg=$registros->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->nombre,
 				"1"=>$reg->categoria,
 				"2"=>$reg->laboratorio,
 				"3"=>$reg->precio,
                "4"=>$reg->fechaVcto,
                "5"=>$reg->accionTerapeutica,
 				"6"=>"<img src='../files/medicamentos/".$reg->foto."' height='50px' width='50px' >",
 				"7"=>'<button class="btn btn-warning" onclick="editar('.$reg->id_medicamento.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="eliminar('.$reg->id_medicamento.')"><i class="fa fa-trash"></i></button>'
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