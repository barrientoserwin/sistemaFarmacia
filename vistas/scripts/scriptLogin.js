$("#frmAcceso").on('submit',function(e){
	e.preventDefault();
    login_a=$("#login_a").val();
    clave_a=$("#clave_a").val();

    $.post("../app/controllers/ctrUsuario.php?op=verificar",{"login_a":login_a,"clave_a":clave_a},
        function(data){
        if (data!="null"){
            $(location).attr("href","frmCategoria.php");            
        }
        else{
            bootbox.alert("Usuario y/o Password incorrectos");
        }
    });
})