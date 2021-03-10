<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../models/NotaVenta.php";
$notaventa=new NotaVenta();

$id_venta=isset($_POST["id_venta"])? $notaventa->limpiar($_POST["id_venta"]):"";
$fecha=isset($_POST["fecha"])? $notaventa->limpiar($_POST["fecha"]):"";
$glosa=isset($_POST["glosa"])? $notaventa->limpiar($_POST["glosa"]):"";
$descuento=isset($_POST["descuento"])? $notaventa->limpiar($_POST["descuento"]):"";
$monto=isset($_POST["monto"])? $notaventa->limpiar($_POST["monto"]):"";
$facturada=isset($_POST["facturada"])? $notaventa->limpiar($_POST["facturada"]):"";
$id_cliente=isset($_POST["id_cliente"])? $notaventa->limpiar($_POST["id_cliente"]):"";
$id_usuario=$_SESSION["id_usuario"];

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_venta)){
            $notaventa->setFecha($fecha);
            $notaventa->setGlosa($glosa);
            $notaventa->setDescuento($descuento);
            $notaventa->setMonto($monto);
            $notaventa->setFacturada($facturada);
            $notaventa->setEstado("Registrado");
            $notaventa->setIdCliente($id_cliente);
            $notaventa->setIdUsuario($id_usuario);
			$rspta=$notaventa->guardar($_POST["id_medicamentoAlmacen"],$_POST["cantidad"],$_POST["preciov"]);
			echo $rspta ? "Venta registrada" : "No se pudieron registrar todos los datos de la venta";
		}
		else {

		}
	break;

	case 'anular':
        $notaventa->setIdNotaVenta($id_venta);
		$rspta=$notaventa->anular();
 		echo $rspta ? "Venta Anulada" : "Venta no se puede anular";
	break;

	case 'verDetalleVenta':
        $notaventa->setIdNotaVenta($id_venta);
		$rspta=$notaventa->verDetalleVenta();
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		$id_venta=$_GET['id'];
		$rspta = $notaventa->listarDetalle($id_venta);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                <th>Opciones</th>
                <th>Medicamentos</th>                                    
                <th>Precio Medicamento</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </thead>';

		while ($reg = $rspta->fetch_object()){
            echo '<tr class="filas">
                <td></td>
                <td>'.$reg->nombre.'</td>
                <td>'.$reg->precio.'</td>
                <td>'.$reg->cantidad.'</td>
                <td>'.$reg->cantidad*$reg->preciov.'</td>
            </tr>';
            $total= $total + ($reg->cantidad*$reg->preciov);
        }
		echo '<tfoot>
                <th>TOTAL</th>
                <th></th>
                <th></th>
                <th></th>
                <th><h4 id="total">S/.'.$total.'</h4><input type="hidden" name="monto" id="monto"></th> 
            </tfoot>';
	break;

	case 'listar':
		$rspta=$notaventa->listar();
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array( 		 				
 				"0"=>($reg->tipo=='persona')?$reg->cpersona:$reg->cempresa,
                "1"=>$reg->fecha,
 				"2"=>$reg->usuario,
 				"3"=>$reg->glosa,
                "4"=>$reg->descuento,
 				"5"=>$reg->monto,
                "6"=>($reg->facturada==1)?'<span class="label bg-green">FACTURADA</span>':
 				'<span class="label bg-red">SIN FACTURA</span>',
 				"7"=>($reg->estado=='Registrado')?'<span class="label bg-green">Registrado</span>':
 				'<span class="label bg-red">Anulado</span>',
                "8"=>($reg->estado=='Registrado')?'<button class="btn btn-success" onclick="verDetalleVenta('.$reg->id_venta.')"><i class="fa fa-eye"></i></button>'.
                '<button class="btn btn-danger" onclick="anular('.$reg->id_venta.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-success" onclick="verDetalleVenta('.$reg->id_venta.')"><i class="fa fa-eye"></i></button>',
 			);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'selectCliente':
		$rspta = $notaventa->selectCliente();
		echo '<option value="" selected>Seleccione</option>';
		while ($reg = $rspta->fetch_object()){
			if($reg->tipo=='persona'){
				echo '<option value=' . $reg->id_cliente . '>' . $reg->nombre . '</option>';
			}
			else{
				echo '<option value=' . $reg->id_cliente . '>' . $reg->razonSocial . '</option>';
			}
        }
	break;
}
?>