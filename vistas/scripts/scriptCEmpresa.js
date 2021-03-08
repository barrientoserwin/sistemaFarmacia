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
	$("#razonSocial").val("");
	$("#mail").val("");
	$("#telefono").val("");
	$("#nit").val("");
	$("#creditoMax").val("");
	$("#direccion").val("");
	$("#id_cliente").val("");
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
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../app/controllers/ctrCEmpresa.php?op=listar',
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
		url: "../app/controllers/ctrCEmpresa.php?op=guardaryeditar",
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

function editar(id_cliente){
	$.post("../app/controllers/ctrCEmpresa.php?op=editar",{id_cliente : id_cliente}, function(data, status){
		data = JSON.parse(data);		
		mostrarform(true);

		$("#razonSocial").val(data.razonSocial);
		$("#mail").val(data.mail);
		$("#telefono").val(data.telefono);
		$("#nit").val(data.nit);
		$("#creditoMax").val(data.creditoMax);
		$("#direccion").val(data.direccion);
 		$("#id_cliente").val(data.id_cliente);
 	})
}

//Función para eliminar registros
function eliminar(id_cliente){
	bootbox.confirm("¿Está Seguro de eliminar el cliente empresa?", function(result){
		if(result){
        	$.post("../app/controllers/ctrCEmpresa.php?op=eliminar", {id_cliente : id_cliente}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

init();