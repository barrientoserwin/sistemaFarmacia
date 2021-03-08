<?php 
require_once "../models/TipoEmpleado.php";

$tipoEmpleado=new TipoEmpleado();

switch ($_GET["op"]){
	case "selectTipoEmpleado":
        $rspta = $tipoEmpleado->selectTipoEmpleado();

        echo '<option value="" selected>Seleccione</option>';
        while (($reg = $rspta->fetch_object())) {
            echo '<option value=' . $reg->id_tipoEmpleado . '>' . $reg->nombre . '</option>';
        }
	break;
}
?>