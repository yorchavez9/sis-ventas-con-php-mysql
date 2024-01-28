<?php
//Activacion de almacenamiento en buffer
ob_start();
//iniciamos las variables de session
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else  //Agrega toda la vista
{
  require 'header.php';

  if ($_SESSION['almacen'] == 1) {
?>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border" style="margin:4px">
                <h1 class="h3" style="color: #0B1D31"><b>Articulo</b>
                  <button class="btn" id="btnagregar" onclick="mostrarform(true)" style="background: #38DBB9; border-radius: 8px">
                    <i class="fa fa-plus-circle"></i>
                    Agregar
                  </button>
                  <a target="_blank" href="../reportes/rptarticulos.php">
                    <button class="btn btn-info" style="border-radius: 8px">Reporte</button>
                  </a>
                </h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Opciones</th>
                    <th>Nombre</th>
                    <th>Categoria</th>
                    <th>Codigo</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>

                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Nombre</th>
                    <th>Categoria</th>
                    <th>Codigo</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Estado</th>
                  </tfoot>
                </table>
              </div>
              <div class="panel-body" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Nombre:</label>
                    <input type="hidden" name="idarticulo" id="idarticulo">
                    <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required style="border-radius: 8px;">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Categoria:</label>
                    <select name="idcategoria" id="idcategoria" data-live-search="true" class="form-control selectpicker" required style="border-radius: 8px;"></select>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Stock:</label>
                    <input type="number" class="form-control" name="stock" id="stock" placeholder="Stock" required style="border-radius: 8px;">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Descripción:</label>
                    <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="256" placeholder="Descripción" style="border-radius: 8px;">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Imagen:</label>
                    <input type="file" class="form-control" name="imagen" id="imagen" style="border-radius: 8px;">
                    <input type="hidden" class="form-control" name="imagenactual" id="imagenactual">
                    <img src="" width="150px" height="120px" id="imagenmuestra">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" >
                    <label>Codigo:</label>
                    <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Codigo de barras" style="border-radius: 8px;">
                    <button class="btn btn-success" type="button" onclick="generarbarcode()" style="border-radius: 8px;">Generar</button>
                    <button class="btn btn-info" type="button" onclick="imprimir()" style="border-radius: 8px;">Imprimir</button>
                    <div id="print">
                      <svg id="barcode"></svg>
                    </div>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar" style="border-radius: 8px;"><i class="fa fa-save"></i> Guardar</button>
                    <button class="btn btn-danger" onclick="cancelarform()" type="button" style="border-radius: 8px;"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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


  } //Llave de la condicion if de la variable de session

  else {
    require 'noacceso.php';
  }


  require 'footer.php';
  ?>
  <script src="../public/js/JsBarcode.all.min.js"></script>
  <script src="../public/js/jquery.PrintArea.js"></script>
  <script src="./scripts/js.articulo.js"></script>

<?php

}
ob_end_flush(); //liberar el espacio del buffer
?>