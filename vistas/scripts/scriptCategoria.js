var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	});

    $.post("../app/controllers/ctrCategoria.php?op=selectCatMayor", function(r){
        $("#idCatMayor").html(r);
        $('#idCatMayor').selectpicker('refresh');
    });
}

//Función limpiar
function limpiar(){
	$("#nombre").val("");
	$("#idCatMayor").val("");
	$("#id_categoria").val("");
}

//Función mostrar formulario
function mostrarform(flag){
	limpiar();
	if (flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
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
		"ajax":
				{
					url: '../app/controllers/ctrCategoria.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "asc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

//Función para guardar o editar
function guardaryeditar(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../app/controllers/ctrCategoria.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos){                    
			bootbox.alert(datos);	          
			mostrarform(false);
			tabla.ajax.reload();
	    }
	});
	limpiar();
}

function editar(id_categoria){
	$.post("../app/controllers/ctrCategoria.php?op=editar",{id_categoria : id_categoria}, function(data, status){
		data = JSON.parse(data);		
		mostrarform(true);

		$("#nombre").val(data.nombre);
		$("#idCatMayor").val(data.idCatMayor);
		$("#idCatMayor").selectpicker('refresh');
 		$("#id_categoria").val(data.id_categoria);
 	})
}

//Función para eliminar registros
function eliminar(id_categoria){
	bootbox.confirm("¿Está Seguro de eliminar la categoria?", function(result){
		if(result){
        	$.post("../app/controllers/ctrCategoria.php?op=eliminar", {id_categoria : id_categoria}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

init();