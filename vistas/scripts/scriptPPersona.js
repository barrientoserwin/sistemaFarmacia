var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	})
}

//Función limpiar
function limpiar(){
	$("#nombre").val("");
	$("#apellidos").val("");
	$("#mail").val("");
	$("#telefono").val("");
	$("#direccion").val("");
	$("#id_proveedor").val("");
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
					url: '../app/controllers/ctrPPersona.php?op=listar',
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
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../app/controllers/ctrPPersona.php?op=guardaryeditar",
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

function editar(id_proveedor){
	$.post("../app/controllers/ctrPPersona.php?op=editar",{id_proveedor : id_proveedor}, function(data, status){
		data = JSON.parse(data);		
		mostrarform(true);

		$("#nombre").val(data.nombre);
		$("#apellidos").val(data.apellidos);
		$("#mail").val(data.mail);
		$("#telefono").val(data.telefono);
		$("#direccion").val(data.direccion);
 		$("#id_proveedor").val(data.id_proveedor);
 	})
}

//Función para eliminar registros
function eliminar(id_proveedor){
	bootbox.confirm("¿Está Seguro de eliminar el proveedor?", function(result){
		if(result){
        	$.post("../app/controllers/ctrPPersona.php?op=eliminar", {id_proveedor : id_proveedor}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

init();