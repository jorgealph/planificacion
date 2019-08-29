<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url();?>assets/images/favicon.png">
    <title>Índice de Planificación</title>
    <!-- This page plugin CSS -->
    <link href="<?=base_url();?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?=base_url();?>dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php include('nav-bar.php'); ?>

        
        <!-- ============================================================== -->
        <div id="contenedor" class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h4 class="page-title">Calificar cuestionario</h4>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- basic table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">                                
                                <h6 class="card-subtitle" align="right"><a href="<?=base_url();?>agregar_usuario" class="btn waves-effect waves-light btn-info">Agregar usuario</a></h6>
                                <div class="table-responsive">                                 
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre usuario</th>
                                                <th>Correo</th>
                                                <th>Procedencia</th>
                                                <th>Encuesta respondida</th>
                                                <th>Calificación</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //print_r($usuarios);                                            

                                            if($usuarios!=false)
                                            {
                                                foreach ($usuarios as $vus) {
                                                    switch ($vus->iTipo) {
                                                        case 1:                                                            
                                                            $proced = $vus->vEntidad;
                                                            break;
                                                        case 2:                                                            
                                                            $proced = $vus->vMunicipio;
                                                            break;
                                                    }

                                                    if($vus->calif > 0) { $calif = $vus->calif; $icono = 'fas fa-check'; }
                                                    else { $calif = 'Pendiente'; $icono = 'fas fa-pencil-alt'; }

                                                    $resp = (!empty($vus->resp) && $vus->resp > 0) ? 'Si' : 'No';


                                                    echo '<tr id="us_'.$vus->iIdUsuario.'"><td>'.$vus->iIdUsuario.'</td>
                                                        <td>'.$vus->vNombreUsuario.'</td>
                                                        <td>'.$vus->vCorreo.'</td>
                                                        <td>'.$proced.'</td>
                                                        <td>'.$resp.'</td>
                                                        <td>'.$calif.'</td>
                                                        <td>';
                                                            if($_SESSION['usuario']['tipo']==1 || $_SESSION['usuario']['tipo']==2) 
                                                            {
                                                                if($resp==='Si')
                                                                {
                                                                    echo '<a href="javascript:" title="Calificar" onclick="calif_cuest('.$vus->iIdUsuario.');"><i class="'.$icono.'"></i></a>&nbsp&nbsp&nbsp';
                                                                }
                                                            } 

                                                        echo '<i class=""></i></td>
                                                    </tr>';
                                            /*
                                            */
                                                }
                                            }
                                            ?>
                                        </tbody>                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- order table -->
                                
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                All Rights Reserved by Nice admin. Designed and Developed by
                <a href="https://wrappixel.com">WrapPixel</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->


    <script src="<?=base_url();?>assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?=base_url();?>assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?=base_url();?>assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="<?=base_url();?>dist/js/app.min.js"></script>
    <script src="<?=base_url();?>dist/js/app.init.horizontal.js"></script>
    <script src="<?=base_url();?>dist/js/app-style-switcher.horizontal.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?=base_url();?>assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="<?=base_url();?>dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?=base_url();?>dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="<?=base_url();?>dist/js/custom.js"></script>

    <!--Wave Effects -->
    <!--Menu sidebar -->
    <!--Custom JavaScript -->
    <!--This page plugins -->
    <script src="<?=base_url();?>assets/extra-libs/DataTables/datatables.min.js"></script>
    <script src="<?=base_url();?>dist/js/pages/datatable/datatable-basic.init.js"></script>
    <script type="text/javascript">
        

        function calif_cuest(usid) {
            /*$.post('<?=base_url();?>califica_us', {usid:usid}, function(resp){
                //console.log(resp);
                if(resp==1) { alert('Usuario eliminado con éxito'); $('#us_'+usid).remove(); }
            });*/

            location.href = "<?=base_url();?>califica_us?usid="+usid;
        }
    </script>

</body>

</html>