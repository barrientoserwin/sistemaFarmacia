<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombreEmpleado"])){
  header("Location: login.html");
}
else{
require 'header.php';
if($_SESSION['almacen']==1){
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
                          <h1 class="box-title">Categoria <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Nuevo</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Cod. Categoria</th>
                            <th>Nombre</th>
                            <th>Categoria Mayor</th>
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
                                <label>Nombre:</label>
                                <input type="hidden" name="id_categoria" id="id_categoria">
                                <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre categoria" required>
                              </div>
                              <div class="form-group">
                                <label>Categoria Mayor:</label>
                                <select id="idCatMayor" name="idCatMayor" class="form-control selectpicker" data-live-search="false">
                                        
                                </select>
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
<script type="text/javascript" src="scripts/scriptCategoria.js"></script>

<?php 
}
ob_end_flush();
?>