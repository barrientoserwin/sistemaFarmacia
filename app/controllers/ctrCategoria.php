<?php 
require_once "../models/Categoria.php";

$categoria=new Categoria();
$id_categoria=isset($_POST["id_categoria"])? $categoria->limpiar($_POST["id_categoria"]):"";
$nombre=isset($_POST["nombre"])? $categoria->limpiar($_POST["nombre"]):"";
$idCatMayor=isset($_POST["idCatMayor"])? $categoria->limpiar($_POST["idCatMayor"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_categoria)){
			$categoria->setNombre($nombre);
            $categoria->setIdCatMayor($idCatMayor);
			if(empty($idCatMayor)){	$rspta = $categoria->guardarCatMayor();
			}else{ $rspta = $categoria->guardar(); }			
			echo $rspta ? "Categoria registrado" : "Categoria no se pudo registrar";			
		}
		else {
			$categoria->setIdCategoria($id_categoria);
			$categoria->setNombre($nombre);
            $categoria->setIdCatMayor($idCatMayor);
			if(empty($idCatMayor)){	$rspta = $categoria->modificarCatMayor(); }
			else{ $rspta = $categoria->modificar(); }
			echo $rspta ? "Categoria modificado" : "Categoria no se pudo modificar";			
		}
	break;

	case 'eliminar':
		$categoria->setIdCategoria($id_categoria);
        $rspta = $categoria->eliminar();
		echo $rspta ? "Categoria eliminado" : "Categoria no se pudo eliminar";
	break;

	case 'editar':
		$rspta=$categoria->editar($id_categoria);
 		echo json_encode($rspta);
	break;

	case 'listar':
		$registros = $categoria->listar();
        $data= Array();

 		while ($reg=$registros->fetch_object()){
 			$data[]=array(
				"0"=>$reg->id_categoria,
				"1"=>$reg->nombre,
                "2"=>$reg->categoriaMayor,
 				"3"=>'<button class="btn btn-warning" onclick="editar('.$reg->id_categoria.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="eliminar('.$reg->id_categoria.')"><i class="fa fa-trash"></i></button>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

    case "selectCatMayor":
		$rspta = $categoria->selectCatMayor();
		
        echo '<option value="" selected>Seleccionar</option>';
        while (($reg = $rspta->fetch_object())) {
			echo '<option value=' . $reg->id_categoria . '>' . $reg->nombre . '</option>';
        }
	break;

	case "selectCategoria":
        $rspta = $categoria->selectCategoria();

        echo '<option value="" selected>Seleccione</option>';
        while (($reg = $rspta->fetch_object())) {
            echo '<option value=' . $reg->id_categoria . '>' . $reg->nombre . '</option>';
        }
	break;
}
?>