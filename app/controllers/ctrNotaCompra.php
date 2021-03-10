<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../models/NotaCompra.php";
$notacompra=new NotaCompra();

$id_compra=isset($_POST["id_compra"])? $notacompra->limpiar($_POST["id_compra"]):"";
$fecha=isset($_POST["fecha"])? $notacompra->limpiar($_POST["fecha"]):"";
$glosa=isset($_POST["glosa"])? $notacompra->limpiar($_POST["glosa"]):"";
$monto=isset($_POST["monto"])? $notacompra->limpiar($_POST["monto"]):"";
$id_proveedor=isset($_POST["id_proveedor"])? $notacompra->limpiar($_POST["id_proveedor"]):"";
$id_usuario=$_SESSION["id_usuario"];

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_compra)){
            $notacompra->setFecha($fecha);
            $notacompra->setGlosa($glosa);
            $notacompra->setMonto($monto);
            $notacompra->setEstado("Registrado");
            $notacompra->setIdProveedor($id_proveedor);
            $notacompra->setIdUsuario($id_usuario);
			$rspta=$notacompra->guardar($_POST["id_medicamentoAlmacen"],$_POST["cantidad"],$_POST["precioc"]);
			echo $rspta ? "Compra registrada" : "No se pudieron registrar todos los datos de la compra";
		}
		else {

		}
	break;

	case 'anular':
        $notacompra->setIdNotaCompra($id_compra);
		$rspta=$notacompra->anular();
 		echo $rspta ? "Compra Anulada" : "Compra no se puede anular";
	break;

	case 'verDetalleCompra':
        $notacompra->setIdNotaCompra($id_compra);
		$rspta=$notacompra->verDetalleCompra();
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		$id_compra=$_GET['id'];
		$rspta = $notacompra->listarDetalle($id_compra);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
				<th>Opcion</th>
				<th>Medicamentos</th>
				<th>Precio Medicamento</th>
				<th>Cantidad</th> 
				<th>Precio Compra</th>                                    
				<th>Subtotal</th>
            </thead>';

		while ($reg = $rspta->fetch_object()){
            echo '<tr class="filas">
                <td></td>
                <td>'.$reg->nombre.'</td>
                <td>'.$reg->precio.'</td>
                <td>'.$reg->cantidad.'</td>
                <td>'.$reg->precioc.'</td>
				<td>'.($reg->cantidad)*($reg->precioc).'</td>
            </tr>';
            $total= $total + ($reg->cantidad*$reg->precioc);
        }
		echo '<tfoot>
                <th>TOTAL</th>
                <th></th>
                <th></th>
                <th></th>
				<th></th>
                <th><h4 id="total">S/.'.$total.'</h4><input type="hidden" name="monto" id="monto"></th> 
            </tfoot>';
	break;

	case 'listar':
		$rspta=$notacompra->listar();
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array( 		 				
 				"0"=>($reg->tipo=='persona')?$reg->ppersona:$reg->pempresa,
                "1"=>$reg->fecha,
 				"2"=>$reg->usuario,
 				"3"=>$reg->glosa,
 				"4"=>$reg->monto,
 				"5"=>($reg->estado=='Registrado')?'<span class="label bg-green">Registrado</span>':
 				'<span class="label bg-red">Anulado</span>',
                "6"=>($reg->estado=='Registrado')?'<button class="btn btn-success" onclick="verDetalleCompra('.$reg->id_compra.')"><i class="fa fa-eye"></i></button>'.
                '<button class="btn btn-danger" onclick="anular('.$reg->id_compra.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-success" onclick="verDetalleCompra('.$reg->id_compra.')"><i class="fa fa-eye"></i></button>',
 			);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'selectProveedor':
		$rspta = $notacompra->selectProveedor();
		echo '<option value="" selected>Seleccione</option>';
		while ($reg = $rspta->fetch_object()){
			if($reg->tipo=='persona'){
				echo '<option value=' . $reg->id_proveedor . '>' . $reg->nombre . '</option>';
			}
			else{
				echo '<option value=' . $reg->id_proveedor . '>' . $reg->razonSocial . '</option>';
			}
            // echo '<option value=' . $reg->id_proveedor . '>' . ($reg->tipo=='persona')?$reg->nombre:$reg->razonSocial . '</option>';
        }
	break;
}
?>