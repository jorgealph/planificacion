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
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">               
                        <h4 class="page-title">Administrar Preguntas</h4>
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
                                <h6 class="card-subtitle" align="right"><a href="<?=base_url();?>agregar_preg" class="btn waves-effect waves-light btn-info">Agregar pregunta</a></h6>
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Pregunta</th>
                                                <th>Ponderación</th>
                                                <th>Evidencia</th>
                                                <th>Tipo</th>
                                                <th>Opción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            //print_r($preg); 
                                                if($preg!=false)
                                                {
                                                    foreach ($preg as $vpreg) {
                                                        $evid = ($vpreg->iEvidencia==1) ? 'SI' : 'NO' ;

                                                        switch ($vpreg->iTipoPregunta) {
                                                            case 0:
                                                                $tipo = 'Opción múltiple';
                                                                break;
                                                            case 1:
                                                                $tipo = 'Dicotómica';
                                                                break;
                                                            case 2:
                                                                $tipo = 'Pregunta abierta';
                                                                break;
                                                        }
                                                                                                                
                                                        echo '
                                                        <tr id="preg_'.$vpreg->iIdPregunta.'">
                                                            <td>'.$vpreg->vPregunta.'</td>
                                                            <td>'.$vpreg->iPonderacion.'</td>
                                                            <td>'.$evid.'</td>
                                                            <td>'.$tipo.'</td>
                                                            <td><a href="javascript:" onclick="mod_preg('.$vpreg->iIdPregunta.');"><i class="fas fa-pencil-alt"></i></a>&nbsp&nbsp&nbsp <a href="javascript:" onclick="elim_preg('.$vpreg->iIdPregunta.');"><i class="fas fa-times"></i></a></td>
                                                        </tr>
                                                        ';
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
    <!-- End Wrapper -->
    <div class="chat-windows"></div>
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

        function mod_preg(pregid) {
            location.href = "<?=base_url();?>modifica_preg?pregid="+pregid;            
        }

        function elim_preg(pregid) {
            $.post('<?=base_url();?>elimina_preg', {pregid:pregid}, function(resp){
                if(resp==1) { 
                    Swal.fire({
                      type: 'success',
                      title: 'Correcto',
                      text: 'Pregunta eliminada'                    
                    });
                    $('#preg_'+pregid).remove(); 
                }
                else {
                    Swal.fire({
                      type: 'error',
                      title: 'Error',
                      text: 'La pregunta no pudo ser eliminada'
                    });

                }
            });
        }

    </script>
</body>

</html>