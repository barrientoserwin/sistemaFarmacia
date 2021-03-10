var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	});
	//Cargamos los items al select proveedor
	$.post("../app/controllers/ctrNotaCompra.php?op=selectProveedor", function(r){
        $("#id_proveedor").html(r);
        $('#id_proveedor').selectpicker('refresh');
	});
	
	$.post("../app/controllers/ctrAlmacen.php?op=selectAlmacen", function(r){
        $("#id_almacen").html(r);
        $('#id_almacen').selectpicker('refresh');
	});	
}

//Función limpiar
function limpiar(){
	$("#id_proveedor").val("");
	$("#proveedor").val("");
	$("#glosa").val("");
	$("#monto").val("");

	$(".filas").remove();
	$("#total").html("0");
	
	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha').val(today);
}

//Función mostrar formulario
function mostrarform(flag){
	limpiar();
	if (flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnagregar").hide();

		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		detalles=0;
		$("#btnAgregarMed").show();
	}
	else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}

}

//Función cancelarform
function cancelarform(){
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar(){
	tabla=$('#tbllistado').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		       
		            'excelHtml5',
		            'pdf'
		        ],
		"ajax":{
				url: '../app/controllers/ctrNotaCompra.php?op=listar',
				type : "get",
				dataType : "json",						
				error: function(e){
					console.log(e.responseText);	
				}
			},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

function parametroAlmacen(){
    var id_almacen = document.getElementById('id_almacen').value;
    listarMedicamento(id_almacen);
}

//Función ListarArticulos
function listarMedicamento(id_almacen){
	tabla=$('#tbl_medicamentos').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            
		        ],
		"ajax":{
				url: '../app/controllers/ctrMedicamentoAlmacen.php?op=listarMedicamentoAlmacen&id_almacen='+id_almacen,
				type : "get",
				dataType : "json",						
				error: function(e){
					console.log(e.responseText);	
				}
			},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../app/controllers/ctrNotaCompra.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos){                    
			bootbox.alert(datos);	          
			mostrarform(false);
			listar();
	    }
	});
	limpiar();
}

function verDetalleCompra(id_compra){
	$.post("../app/controllers/ctrNotaCompra.php?op=verDetalleCompra",{id_compra : id_compra}, function(data, status){
		data = JSON.parse(data);		
		mostrarform(true);

		$("#id_proveedor").val(data.id_proveedor);
		$("#id_proveedor").selectpicker('refresh');
		$("#glosa").val(data.glosa);
		$("#fecha").val(data.fecha);
		$("#id_compra").val(data.id_compra);

		//Ocultar y mostrar los botones
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarMed").hide();
 	});

 	$.post("../app/controllers/ctrNotaCompra.php?op=listarDetalle&id="+id_compra,function(r){
	    $("#detalles").html(r);
	});
}

//Función para anular registros
function anular(id_compra){
	bootbox.confirm("¿Está Seguro de anular esta compra?", function(result){
		if(result){
        	$.post("../app/controllers/ctrNotaCompra.php?op=anular", {id_compra : id_compra}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Declaración de variables necesarias para trabajar con las compras y
//sus detalles
var impuesto=13;
var cont=0;
var detalles=0;
$("#btnGuardar").hide();
function agregarDetalle(id_medicamentoAlmacen,medicamento,precio){
	var cantidad=1;
	var precioc=1;

	if (id_medicamentoAlmacen!=""){
		var subtotal=cantidad*precioc;
		var fila='<tr class="filas" id="fila'+cont+'">'+
		'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
		'<td><input type="hidden" name="id_medicamentoAlmacen[]" value="'+id_medicamentoAlmacen+'">'+medicamento+'</td>'+
		'<td><span name="precio" id="precio">'+precio+'</span></td>'+
		'<td><input type="number" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
		'<td><input type="number" name="precioc[]" id="precioc[]" value="'+precioc+'"></td>'+
		'<td><span name="subtotal" id="subtotal'+cont+'">'+subtotal+'</span></td>'+
		'<td><button type="button" onclick="modificarSubototales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>'+
		'</tr>';
		cont++;
		detalles=detalles+1;
		$('#detalles').append(fila);
		modificarSubototales();
	}
	else{
		alert("Error al ingresar el detalle, revisar los datos del medicamento");
	}
}

function modificarSubototales(){
	var cant = document.getElementsByName("cantidad[]");
	var prec = document.getElementsByName("precioc[]");
	var sub = document.getElementsByName("subtotal");

	for (var i = 0; i <cant.length; i++) {
		var inpC=cant[i];
		var inpP=prec[i];
		var inpS=sub[i];

		inpS.value=inpC.value * inpP.value;
		document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
	}
	calcularTotales();
}

function calcularTotales(){
	var sub = document.getElementsByName("subtotal");
	var total = 0.0;

	for (var i = 0; i <sub.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;
	}
	$("#total").html("Bs/. " + total);
	$("#monto").val(total);
	evaluar();
}

function evaluar(){
	if (detalles>0){
		$("#btnGuardar").show();
	}
	else{
		$("#btnGuardar").hide(); 
		cont=0;
	}
}

function eliminarDetalle(indice){
	$("#fila" + indice).remove();
	calcularTotales();
	detalles=detalles-1;
	evaluar();
}

init();