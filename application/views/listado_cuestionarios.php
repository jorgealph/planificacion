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
    <link href="<?=base_url();?>dist/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>

</head>

<body>
    
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    
    <div id="main-wrapper">
        
        <?php include('nav-bar.php'); ?>

        
        <!-- ============================================================== -->
        <div class="page-wrapper">
            
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h4 class="page-title">Listado de cuestionarios</h4>
                    </div>                    
                </div>
            </div>
            
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                        <div class="card-body" id="contenido">

                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <a class="btn btn-primary" href="javascript:" title="Editar" onclick="capturarCuestionario(0);"><i class="fas fa-plus"></i></>&nbsp;Nuevo cuestionario</a>
                                </div>
                            </div>
                            <br>

                            <?=$tabla?>
                        </div>
                        </div>
                    </div>
                </div>
                    
        </div>

             
                                
            </div>
            
            <footer class="footer text-center">
                All Rights Reserved by Nice admin. Designed and Developed by
                <a href="https://wrappixel.com">WrapPixel</a>.
            </footer>
            
        </div>
        
    </div>
       
    <div class="chat-windows"></div>
    


    <script src="<?=base_url();?>assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?=base_url();?>assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?=base_url();?>assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="<?=base_url();?>dist/js/app.min.js"></script>
    <script src="<?=base_url();?>dist/js/app.init.horizontal.js"></script>
    <!--<script src="<?=base_url();?>dist/js/app-style-switcher.horizontal.js"></script>-->
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?=base_url();?>assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="<?=base_url();?>dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?=base_url();?>dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="<?=base_url();?>dist/js/custom.js"></script>

    
    <!--This page plugins -->
    <script src="<?=base_url();?>assets/extra-libs/DataTables/datatables.min.js"></script>
    <script src="<?=base_url();?>dist/js/pages/datatable/datatable-basic.init.js"></script>

    <script src="<?=base_url();?>assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>    
    <script src="<?=base_url();?>assets/libs/jquery-validation/dist/additional-methods.js"></script>  

    <script src="<?=base_url();?>dist/js/fileinput.js" type="text/javascript"></script>
    <script src="<?=base_url();?>dist/js/es.js" type="text/javascript"></script>

    <script src="<?=base_url();?>assets/libs/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="<?=base_url();?>assets/libs/sweetalert2/sweet-alert.init.js"></script>

    <script type="text/javascript">
        function capturarCuestionario(id){
            window.location.href = '<?=base_url()?>capturar_cuest?cuestid='+id;
        }

        function eliminarCuestionario(id){
            //var arch = $('#archivo').val();
            if(confirm('¿Realmente desea eliminar este cuestionario?')){
                $.post('<?=base_url();?>C_cuestionario/eliminar_cuestionario', 'id='+id, function(resp){
                    if(resp == 1){
                        location.reload();
                    } else {
                        Swal.fire({
                          type: 'error',
                          title: 'Error',
                          text: resp
                        });
                    }
                });
            }
        }

    </script>
</body>

</html>