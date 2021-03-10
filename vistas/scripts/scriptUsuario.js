var tabla;

function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	});

	$("#imagenmuestra").hide();
	$.post("../app/controllers/ctrUsuario.php?op=permisos&id=",function(r){
	    $("#permisos").html(r);
	});

    $.post("../app/controllers/ctrEmpleado.php?op=selectEmpleado", function(r){
        $("#id_empleado").html(r);
        $('#id_empleado').selectpicker('refresh');
    });
}

//Función limpiar
function limpiar(){
	$("#login").val("");
	$("#password").val("");
	$("#rolUsuario").val("");
	$("#id_empleado").val("");
	$("#imagenmuestra").attr("src","");
	$("#imagen_actual").val("");
	$("#id_usuario").val("");
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
					url: '../app/controllers/ctrUsuario.php?op=listar',
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

function guardaryeditar(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../app/controllers/ctrUsuario.php?op=guardaryeditar",
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

function editar(id_usuario){
	$.post("../app/controllers/ctrUsuario.php?op=editar",{id_usuario : id_usuario}, function(data, status){
		data = JSON.parse(data);		
		mostrarform(true);

		$("#login").val(data.login);
        $("#password").val(data.password);
        $("#rolUsuario").val(data.rolUsuario);
		$("#id_empleado").val(data.id_empleado);
		$("#id_empleado").selectpicker('refresh');		
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/users/"+data.foto);
		$("#imagen_actual").val(data.foto);
		$("#id_usuario").val(data.id_usuario);

 	});

 	$.post("../app/controllers/ctrUsuario.php?op=permisos&id="+id_usuario,function(r){
	    $("#permisos").html(r);
	});
}

//Función para desactivar registros
function desactivar(id_usuario){
	bootbox.confirm("¿Está Seguro de desactivar el usuario?", function(result){
		if(result){
        	$.post("../app/controllers/ctrUsuario.php?op=desactivar", {id_usuario : id_usuario}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(id_usuario){
	bootbox.confirm("¿Está Seguro de activar el Usuario?", function(result){
		if(result){
        	$.post("../app/controllers/ctrUsuario.php?op=activar", {id_usuario : id_usuario}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

init();