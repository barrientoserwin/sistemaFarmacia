<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombreEmpleado"])){
  header("Location: login.html");
}
else{
require 'header.php';
if($_SESSION['ventas']==1){
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Empresa <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Nuevo</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Razon Social</th>
                            <th>Email</th>
                            <th>Telefono</th>
                            <th>NIT</th>
                            <th>Credito Max</th>
                            <th>Dirección</th>
                            <th>Opciones</th>
                          </thead>
                          <tbody>  

                          </tbody>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 600px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-12">
                            
                            <div class="form-group col-lg-6">
                        
                              <div class="form-group">
                                <label>Razon Social:</label>
                                <input type="hidden" name="id_cliente" id="id_cliente">
                                <input type="text" class="form-control" name="razonSocial" id="razonSocial" maxlength="100" placeholder="Nombre de la empresa" required>
                              </div>
                              <div class="form-group">
                                <label>Email:</label>
                                <input type="email" class="form-control" name="mail" id="mail" maxlength="50" placeholder="Email">
                              </div>
                              <div class="form-group">
                                <label>Teléfono:</label>
                                <input type="text" class="form-control" name="telefono" id="telefono" maxlength="10" placeholder="Teléfono">
                              </div>
                              <div class="form-group">
                                <label>Nit:</label>
                                <input type="text" class="form-control" name="nit" id="nit" maxlength="20" placeholder="NIT">
                              </div>    
                              <div class="form-group">
                                <label>Credito Max:</label>
                                <input type="number" class="form-control" name="creditoMax" id="creditoMax">
                              </div>                      
                              <div class="form-group">
                                <label>Dirección:</label>
                                <input type="text" class="form-control" name="direccion" id="direccion" maxlength="70" placeholder="Dirección">
                              </div>
                            </div>

                            <div class="form-group col-lg-6">
                            </div>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
}
else{
  require 'notAccess.php';
}
require 'footer.php';
?>
<script type="text/javascript" src="scripts/scriptCEmpresa.js"></script>

<?php 
}
ob_end_flush();
?>