var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	});

    $.post("../app/controllers/ctrCategoria.php?op=selectCategoria", function(r){
        $("#id_categoria").html(r);
        $('#id_categoria').selectpicker('refresh');
    });

    $.post("../app/controllers/ctrLaboratorio.php?op=selectLaboratorio", function(r){
        $("#id_laboratorio").html(r);
        $('#id_laboratorio').selectpicker('refresh');
    });

    $("#imagenmuestra").hide();
}

//Función limpiar
function limpiar(){
	$("#nombre").val("");
    $("#precio").val("");
    $("#accionTerapeutica").val("");
    $("#fechaVcto").val("");
    $("#foto").val("");
    $("#id_medicamento").val("");
	$("#id_laboratorio").val("");
    $("#id_categoria").val("");

    $("#imagenmuestra").attr("src","");
	$("#imagen_actual").val("");
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
					url: '../app/controllers/ctrMedicamento.php?op=listar',
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
		url: "../app/controllers/ctrMedicamento.php?op=guardaryeditar",
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

function editar(id_medicamento){
	$.post("../app/controllers/ctrMedicamento.php?op=editar",{id_medicamento : id_medicamento}, function(data, status){
		data = JSON.parse(data);		
		mostrarform(true);

		$("#nombre").val(data.nombre);
        $("#accionTerapeutica").val(data.accionTerapeutica);
        $("#precio").val(data.precio);
        $("#fechaVcto").val(data.fechaVcto);
        $("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/medicamentos/"+data.foto);
		$("#imagen_actual").val(data.foto);
 		$("#id_medicamento").val(data.id_medicamento);
         $("#id_laboratorio").val(data.id_laboratorio);
		$('#id_laboratorio').selectpicker('refresh');
        $("#id_categoria").val(data.id_categoria);
		$('#id_categoria').selectpicker('refresh');
 	})
}

//Función para eliminar registros
function eliminar(id_medicamento){
	bootbox.confirm("¿Está Seguro de eliminar el medicamentos?", function(result){
		if(result){
        	$.post("../app/controllers/ctrMedicamento.php?op=eliminar",{id_medicamento : id_medicamento}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

init();