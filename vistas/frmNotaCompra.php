<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombreEmpleado"])){
  header("Location: login.html");
}
else{
require 'header.php';

if ($_SESSION['compras']==1){
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
                          <h1 class="box-title">Compra <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Nuevo</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Proveedor</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Descripcion</th>
                            <th>Monto</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                          </thead>
                          <tbody> 

                          </tbody>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Proveedor(*):</label>
                            <input type="hidden" name="id_compra" id="id_compra">
                            <select id="id_proveedor" name="id_proveedor" class="form-control selectpicker" data-live-search="false" required>
                              
                            </select>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Almacen(*):</label>
                            <input type="hidden" name="id_compra" id="id_compra">
                            <select id="id_almacen" name="id_almacen" class="form-control selectpicker" data-live-search="false" required>
                              
                            </select>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha(*):</label>
                            <input type="date" class="form-control" name="fecha" id="fecha" required="">
                          </div>
                          <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <label>Glosa:</label>
                            <input type="text" class="form-control" name="glosa" id="glosa" maxlength="50" placeholder="Glosa">
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <i class="fa fa-shopping-cart"></i><br>
                            <a data-toggle="modal" href="#myModal">           
                              <button id="btnAgregarMed" type="button" onclick="parametroAlmacen()" class="btn btn-primary"> <span class="fa fa-plus"></span> Agregar Medicamentos</button>
                            </a>
                          </div>

                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                  <th>Opcion</th>
                                  <th>Medicamentos</th>
                                  <th>Precio Medicamento</th>
                                  <th>Cantidad</th> 
                                  <th>Precio Compra</th>                                    
                                  <th>Subtotal</th>
                              </thead>
                              <tfoot>
                                  <th>TOTAL</th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th><h4 id="total">Bs/. 0.00</h4><input type="hidden" name="monto" id="monto"></th> 
                              </tfoot>
                              <tbody>
                                
                              </tbody>
                            </table>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 65% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione uno o varios Medicamentos</h4>
        </div>
        <div class="modal-body">
          <table id="tbl_medicamentos" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Laboratorio</th>
                <th>Precio</th>
                <th>Fecha Vencimiento</th>
                <th>Imagen</th>
                <th>Opción</th>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Laboratorio</th>
                <th>Precio</th>
                <th>Fecha Vencimiento</th>
                <th>Imagen</th>
                <th>Opción</th>
            </tfoot>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>  
  <!-- Fin modal -->
<?php
}
else{
  require 'notAccess.php';
}
require 'footer.php';
?>
<script type="text/javascript" src="scripts/scriptNotaCompra.js"></script>

<?php 
}
ob_end_flush();
?>


