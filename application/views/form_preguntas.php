<?php 
if(isset($datos_preg) && count($datos_preg) > 0)
{
    //print_r($datos_preg);
    //print_r($resp_preg);
    
   $pagina = 'Editar pregunta';
   $pregid = $datos_preg[0]->iIdPregunta;
   $preg = $datos_preg[0]->vPregunta;
   $ponderacion = $datos_preg[0]->iPonderacion;
   $tipo_preg = $datos_preg[0]->iTipoPregunta;
   $evid = $datos_preg[0]->iEvidencia;    
   $formid = 'form_modpreg';
   $btn_preg = '<button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button> ';
   $func = 'actualiza_resp();';
}
else
{
    $pregid = 0;
    $preg = '';
    $ponderacion = '';
    $tipo_preg = -1;
    $evid = 0;        
    $formid = 'form_pregunta';
    $pagina = 'Agregar pregunta';
    $btn_preg = '<button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button> ';
    $func = 'guardar_resp();';
}
?>
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
                        <h4 class="page-title"><?=$pagina;?></h4>
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
                    <div class="col-lg-12">
                        <div class="card">                            
                            <form id="<?=$formid;?>">
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <input type="hidden" id="pregid" name="pregid" value="<?=$pregid;?>">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Pregunta</label>
                                                    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Pregunta" value="<?=$preg;?>">     
                                                </div>                                               
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Ponderación</label>
                                                    <input type="text" id="correo" name="correo" class="form-control form-control-danger" placeholder="Ponderación" value="<?=$ponderacion;?>">
                                                </div>                                                    
                                            </div>
                                            <!--/span-->
                                        </div>                                        
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group has-success">
                                                    <label class="control-label">Evidencia</label>
                                                    <select id="sel_tipo" name="sel_tipo" class="form-control custom-select">
                                                        <option value="1" <?=($evid==1) ? 'selected' : '';?>>SI</option>
                                                        <option value="0" <?=($evid==0) ? 'selected' : '';?>>NO</option>
                                                    </select>   
                                                </div>                                                 
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group has-success">
                                                    <label class="control-label">Tipo de pregunta</label>
                                                    <select id="sel_preg" name="sel_preg" class="form-control custom-select" onchange="tipo_resp(this.value);">
                                                        <option value="">Seleccionar</option>
                                                        <option value="0" <?=($tipo_preg==0) ? 'selected' : '';?>>Opción múliple</option>
                                                        <option value="1" <?=($tipo_preg==1) ? 'selected' : '';?>>Pregunta dicotómica</option>
                                                        <option value="2" <?=($tipo_preg==2) ? 'selected' : '';?>>Pregunta abierta</option>
                                                    </select>   
                                                </div>                                                 
                                            </div>                                     
                                            <!--/span-->                                            
                                        </div>
                                        <div class="row">                                            
                                            <h4>Banco de respuestas</h4>
                                            <div id="opciones_resp" class="col-md-12">
                                                <?php
                                                $arr_resp = array();
                                                if(isset($resp_preg) && count($resp_preg) > 0)
                                                {
                                                    //print_r($resp_preg);
                                                    foreach ($resp_preg as $vr) {
                                                        array_push($arr_resp, $vr->iIdOpcion);
                                                    }
                                                    /*echo '<h1>Respuestas seleccionadas</h1>';
                                                    echo '<br><h1>Todas las respuestas</h1>';
                                                    */
                                                    //print_r($arr_resp);
                                                }


                                                if(isset($tot_resp) && count($tot_resp) > 0)
                                                {
                                                    //echo '<pre>'; print_r($tot_resp); echo '</pre>';
                                                    foreach ($tot_resp as $vtot) {                                                        
                                                        if(in_array($vtot->iIdOpcion, $arr_resp)) $check = 'checked';
                                                        else $check = '';
                                                        echo '<div class="col-md-2 custom-control custom-checkbox custom-control-inline">
                                                                <input '.$check.' type="checkbox" id="op_'.$vtot->iIdOpcion.'" name="resp[]" class="custom-control-input" value="'.$vtot->iIdOpcion.'">
                                                                <label class="custom-control-label" for="op_'.$vtot->iIdOpcion.'">'.$vtot->vOpcion.'</label>
                                                            </div>';
                                                    }
                                                }
                                                
                                                ?>
                                            </div>
                                            <!--/span-->                                            
                                        </div>
                                        <!--/row-->
                                        
                                        <!--/row-->
                                    </div>                                    
                                    
                                    <div class="form-actions">
                                        <div class="card-body">
                                            <?=$btn_preg;?>                                         
                                        </div>
                                    </div>
                                </div>
                            </form>
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
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?=base_url();?>assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="<?=base_url();?>dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?=base_url();?>dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="<?=base_url();?>dist/js/custom.js"></script>

    <script src="<?=base_url();?>assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>    
    <script src="<?=base_url();?>assets/libs/jquery-validation/dist/additional-methods.js"></script>

    <script src="<?=base_url();?>assets/libs/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="<?=base_url();?>assets/libs/sweetalert2/sweet-alert.init.js"></script>

    <!--Custom JavaScript -->
    <!--This page plugins -->   

    <script type="text/javascript">    

        var valida_form = $('#<?=$formid;?>').validate({
      //ignore: [],
          rules: {
            nombre: "required",
            sel_tipo: "required",
            sel_preg: "required",
            correo: "required",
            "resp[]": {
                required: true,
                minlength: 1
              }
          },
          messages: {
            nombre: "Ingrese la pregunta",            
            sel_tipo: "Seleccione una opción",
            sel_preg: "Seleccione una opción",
            correo: "Ingrese la ponderación",
            "resp[]": {
                required: 'Seleccione una opción',
                minlength: 'Debe seleccionar al menos una opción'
              }
              

          },
          submitHandler: function(form) {
            <?=$func;?>
          }
        }); 

        function guardar_resp() {            
            $.post('<?=base_url();?>guardar_preg', $('#form_pregunta').serialize(), function(resp){
                if(resp==1) {                     
                    Swal.fire({
                      type: 'success',
                      title: 'Correcto',   
                      text: 'Pregunta insertada correctamente'

                    });
                    $('#form_pregunta').trigger("reset"); 
                    $('#opciones_resp').empty(); 
                }
                else {
                    Swal.fire({
                      type: 'error',
                      title: 'Error',
                      text: 'La pregunta no se pudo insertar'
                    });
                }
            });
        }

        function tipo_resp(op) {
            $.post('<?=base_url();?>carga_r', {op:op}, function(resp){
                $('#opciones_resp').html(resp);
            });
        }

        function actualiza_resp() {
            $.post('<?=base_url();?>actualiza_preg', $('#form_modpreg').serialize(), function(resp){
                console.log(resp);
                if(resp==1) {
                    Swal.fire({
                      type: 'success',
                      title: 'Correcto',
                      text: 'Pregunta actualizada correctamente'                    
                    });
                }else {
                    Swal.fire({
                      type: 'error',
                      title: 'Error',
                      text: 'La pregunta no se pudo actualizar'
                    });
                }
            });
        }
        
    </script> 

</body>

</html>