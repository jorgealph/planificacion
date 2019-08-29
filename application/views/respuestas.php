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
                        <h4 class="page-title">Administrar Respuestas</h4>
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
                                <h6 class="card-subtitle" align="right"><a href="javascript:" class="btn waves-effect waves-light btn-info" data-toggle="modal" data-target="#responsive-modal">Agregar una respuesta</a></h6>
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Respuesta</th>
                                                <th>Tipo</th>
                                                <th>Requiere campo</th>
                                                <th>Opción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                                if($opciones!=false)
                                                {

                                                    foreach ($opciones as $vop) {                                 

                                                        switch ($vop->iTipoR) {
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

                                                        switch ($vop->iOtro) {
                                                            case 0:
                                                                $otro = 'No';
                                                                break;
                                                            case 1:
                                                                $otro = 'Si';
                                                                break;
                                                        }

                                                        echo '
                                                        <tr id="resp_'.$vop->iIdOpcion.'">
                                                            <td>'.$vop->vOpcion.'</td>
                                                            <td>'.$tipo.'</td>
                                                            <td>'.$otro.'</td>
                                                            <td><a href="javascript:" data-toggle="modal" data-target="#responsive-modal" onclick="mod_resp('.$vop->iIdOpcion.');"><i class="fas fa-pencil-alt"></i></a>&nbsp&nbsp&nbsp <a href="javascript:" onclick="elim_resp('.$vop->iIdOpcion.');"><i class="fas fa-times"></i></a></td>
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
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Responsive model</h4>
                                <!-- sample modal content -->
                                <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Agregar respuesta</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form_op">
                                                    <input type="hidden" id="respid" name="respid" value="0">
                                                    <div class="form-group">
                                                        <label for="resp" class="control-label">Respuesta:</label>
                                                        <input type="text" class="form-control" id="resp" name="resp">
                                                    </div>
                                                    <div class="form-group">                                                        
                                                        <select id="tipo_resp" name="tipo_resp" class="form-control custom-select">
                                                            <option value="">Tipo</option>
                                                            <option value="0">Opción múltiple</option>
                                                            <option value="1">Dicotómica</option>
                                                            <option value="2">Pregunta abierta</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <select id="otro_resp" name="otro_resp" class="form-control custom-select">
                                                            <option value="">¿La pregunta requiere un campo para captura?</option>
                                                            <option value="0">NO</option>
                                                            <option value="1">SI</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-danger waves-effect waves-light">Guardar</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.modal -->                                
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

    <script src="<?=base_url();?>assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>    
    <script src="<?=base_url();?>assets/libs/jquery-validation/dist/additional-methods.js"></script>

    <script src="<?=base_url();?>assets/libs/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="<?=base_url();?>assets/libs/sweetalert2/sweet-alert.init.js"></script>

    <script type="text/javascript">

    var valida_form = $('#form_op').validate({
      //ignore: [],
          rules: {
            resp: "required",
            tipo_resp: "required",
            otro_resp: "required",
          },
          messages: {
            resp: "Ingrese la respuesta",            
            tipo_resp: "Seleccione una opción",
            otro_resp: "Seleccione una opción"
          },
          submitHandler: function(form) {
            guarda_op();
          }
        });

        function mod_resp(respid) {
            var op  = document.getElementById('resp_'+respid).getElementsByTagName('td');
            var opcion = op[0].textContent; 
            var tipo = op[1].textContent;
            var campo = op[2].textContent;

            $('#resp').val(opcion);
            $('#respid').val(respid);

            switch(tipo) {
                case 'Opción múltiple': $('#tipo_resp').val(0); break;
                case 'Dicotómica': $('#tipo_resp').val(1); break;
                case 'Pregunta abierta': $('#tipo_resp').val(2); break;
            }

            switch(campo) {
                case 'No': $('#otro_resp').val(0); break;
                case 'Si': $('#otro_resp').val(1); break;
            }

        }
                

        function guarda_op() {
            $.post('<?=base_url();?>guarda_op', $('#form_op').serialize(), function(resp){                
                if(resp==1) {                     
                    Swal.fire({
                      type: 'success',
                      title: 'Correcto'
                    });
                    $('#form_op').trigger("reset"); $('#respid').val(0); $('#responsive-modal').modal('hide'); 
                }
                else {
                    Swal.fire({
                      type: 'error',
                      title: 'Error',
                      text: 'La respuesta no pudo ser insertada'
                    });
                }
            });
        }

        function elim_resp(respid) {
            $.post('<?=base_url();?>elimina_resp', {respid:respid}, function(resp){
                if(resp==1) {  
                    Swal.fire({
                      type: 'success',
                      title: 'Respuesta eliminada con éxito'                      
                    });
                    $('#resp_'+respid).remove(); 
                }
            });
        }

    </script>
</body>

</html>