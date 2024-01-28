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

    if ($_SESSION['escritorio'] == 1) {
        require_once '../modelos/Consultas.php';

        $consulta = new Consultas();

        $rsptac = $consulta->totalCompraHoy();
        $regc = $rsptac->fetch_object();
        $totalc = $regc->total_compra;

        $rsptav = $consulta->totalVentaHoy();
        $regv = $rsptav->fetch_object();
        $totalv = $regv->total_venta;

        //Mostrar graficos 
        $compras10 = $consulta->comprasUlt10dias();
        $fechasc = '';
        $totalesc = '';

        while ($regfechac = $compras10->fetch_object()) {
            $fechasc =  $fechasc . '"' . $regfechac->fecha . '",';
            $totalesc = $totalesc . $regfechac->total . ',';
        }

        //Quitamos la ultima coma
        $fechasc = substr($fechasc, 0, -1);
        $totalesc = substr($totalesc, 0, -1);

        //Graficos Venta
        $compras12 = $consulta->ventas12meses();
        $fechasv = '';
        $totalesv = '';

        while ($regfechav = $compras12->fetch_object()) {
            $fechasv =  $fechasv . '"' . $regfechav->fecha . '",';
            $totalesv = $totalesv . $regfechav->total . ',';
        }

        //Quitamos la ultima coma
        $fechasv = substr($fechasv, 0, -1);
        $totalesv = substr($totalesv, 0, -1);
?>

        <!--Contenido-->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box" style="border-radius: 25px">
                            <div class="box-header with-border" style="margin-left: 20px">
                                <h1 class="h3"><b>Bienvenido al sistema de ventas 🙂</b></h1>
                                <div class="box-tools pull-right">
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <!-- centro -->
                            <div class="panel-body">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="small-box" style="border-radius: 10px; background: #50A1FF">
                                        <div class="inner">
                                            <h4 style="font-size:30px; color: white; padding-left:5px">
                                                <strong>$ <?php echo $totalc; ?></strong>
                                                <p>Compras</p>
                                            </h4>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a href="ingreso.php" class="small-box-footer" style="border-radius: 10px;font-size:25px">
                                            Compras
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="small-box" style="border-radius: 10px; background: #38DBB9">
                                        <div class="inner">
                                            <h4 style="font-size:30px; color: white; padding-left:5px">
                                                <strong>$ <?php echo $totalv; ?></strong>
                                                <p>Ventas</p>
                                            </h4>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a href="venta.php" class="small-box-footer" style="border-radius: 10px;font-size:25px">
                                            Ventas
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="box box-primary">

                                        <div class="box-header with-border">
                                            <h4 style="color: #0B1D31"><b>Compras los ultimos 10 dias</b></h4>
                                        </div>
                                        <div class="box body">
                                            <canvas id="compras" width="400" height="300"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="box box-primary">

                                        <div class="box-header with-border">
                                            <h4 style="color: #0B1D31"><b>Ventas ultimos 12 meses</b></h4>
                                        </div>
                                        <div class="box body">
                                            <canvas id="ventas" width="400" height="300"></canvas>
                                        </div>
                                    </div>
                                </div>
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

    <script src="../public/js/Chart.min.js"></script>
    <script src="../public/js/Chart.bundle.min.js"></script>

    <script>
        var ctx = document.getElementById("compras").getContext('2d');
        var compras = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [<?php echo $fechasc; ?>],
                datasets: [{
                    label: 'Compras en $ de los ultimos 10 dias',
                    data: [<?php echo $totalesc; ?>],
                    backgroundColor: [
                        '#50A1FF',
                        '#4489D9'
                    ]
                   
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });


        var ctx = document.getElementById("ventas").getContext('2d');
        var ventas = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [<?php echo $fechasv; ?>],
                datasets: [{
                    label: '# Ventas en $ de los ultimos 12 dias',
                    data: [<?php echo $totalesv; ?>],
                    backgroundColor: [
                        '#30BA9D'
                    ]
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>

<?php
}
ob_end_flush(); //liberar el espacio del buffer
?>