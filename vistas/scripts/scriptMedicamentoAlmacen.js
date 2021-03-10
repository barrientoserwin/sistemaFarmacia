var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e){
		guardar(e);	
	});

	$.post("../app/controllers/ctrAlmacen.php?op=selectAlmacen", function(r){
        $("#id_almacen").html(r);
        $('#id_almacen').selectpicker('refresh');
	});	
}

//Función limpiar
function limpiar(){
	$("#id_almacen").val("");
    $(".filas").remove();
}

//Función mostrar formulario
function mostrarform(flag){
	limpiar();
	if (flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnagregar").hide();

		$("#btnAgregarMed").show();
		detalles=0;
	}
	else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

function parametroAlmacen(){
    var id_almacen = document.getElementById('id_almacen').value;
    listarMedicamento(id_almacen);
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
		"ajax": {
                url: '../app/controllers/ctrMedicamentoAlmacen.php?op=listar',
                type : "get",
                dataType : "json",						
                error: function(e){
                    console.log(e.responseText);	
                }
            },
		"bDestroy": true,
		"iDisplayLength": 20,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
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
                url: '../app/controllers/ctrMedicamentoAlmacen.php?op=listarMedicamentoAl&id_almacen='+id_almacen,
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

function guardar(e){
	e.preventDefault();
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../app/controllers/ctrMedicamentoAlmacen.php?op=guardar",
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

var cont=0;
var detalles=0;
function agregarDetalle(id_medicamento,medicamento,precio,fechaVcto){
  	var stock=1;
    if (id_medicamento!=""){
    	var fila='<tr class="filas" id="fila'+cont+'">'+    
        '<td><span name="precio" id="precio">'+id_medicamento+'</span></td>'+	
    	'<td><input type="hidden" name="id_medicamento[]" value="'+id_medicamento+'">'+medicamento+'</td>'+        
        '<td><span name="precio" id="precio">'+precio+'</span></td>'+
        '<td><span name="precio" id="precio">'+fechaVcto+'</span></td>'+
    	'<td><input type="number" name="stock[]" id="stock[]" value="'+stock+'"></td>'+ 
        '<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
    	'</tr>';
    	cont++;
    	detalles=detalles+1;
    	$('#detalles').append(fila);
    }
    else{
    	alert("Error al ingresar el detalle, revisar los datos del medicamento");
    }
  }

  function eliminarDetalle(indice){
  	$("#fila" + indice).remove();
  	detalles=detalles-1;
  }

init();