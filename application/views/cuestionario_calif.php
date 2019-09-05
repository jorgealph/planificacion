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
                        <h4 class="page-title">Responder cuestionario</h4>
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
                        <form id="form_cuestionario">
                            <div class="card">
                                <div class="card-body">
                                	<input type="hidden" id="usid" name="usid" value="<?=$usid;?>">                                	
                                    
                                    <?php 
                                    $resp_us = array();
                                    $resp_us_t = array();
                                    if($respuestas!=false)
                                    {
                                        foreach ($respuestas as $vresp) {
                                            array_push($resp_us, $vresp->iIdRespuesta);
                                            
                                            $resp_us_t[$vresp->iIdRespuesta] = array(
                                            	'respuesta' => $vresp->vRespuesta);
                                        }
                                    }
                                    /*echo '<pre>';
                                    print_r($resp_us_t);
                                    echo '</pre>';*/

                                    $pregid = 0;                                    
                                    if($preguntas!=false && count($preguntas) > 0)
                                    {
                                        if(count($resp_us) > 0) $dis = 'disabled';
                                        else $dis = '';

                                        //print_r($preguntas);
                                        foreach ($preguntas as $vpreg) {
                                            if($vpreg->iIdPregunta!=$pregid)
                                            {
                                                if($pregid>0) echo '</div></div><br><br>';
                                                echo '<div class="row" style="border-bottom: 1px dashed #cacaca; padding-bottom: 2%;">';
                                                echo '<div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-5"><h4 class="card-title">'.$vpreg->iIdPregunta.'.- '.$vpreg->vPregunta.'</h4></div>
                                                        <div class="col-md-4">
                                                            <label for="pond_1">Calificación</label>
                                                            <input type="text" id="calif_'.$vpreg->iIdPregunta.'" name="calif_'.$vpreg->iIdPregunta.'" value="'.$vpreg->iCalificacion.'" disabled>
                                                        </div>';
                                                        
                                                        if($vpreg->iEvidencia==1)
                                                        {
                                                        	if($vpreg->vArchivo!="")
                                                            {
                                                                echo '<div class="col-md-3"><a class="btn waves-effect waves-light btn-info" target="_blank" href="'.base_url().'uploads/'.$vpreg->vArchivo.'">Descargar evidencia</a></div>';
                                                            }
                                                            else
                                                            {
                                                                /*echo '<div class="col-md-3">
                                                                    <label for="ev_1">Evidencia</label>
                                                                    <input type="text" id="ev_'.$vpreg->iIdPregunta.'" name="ev_'.$vpreg->iIdPregunta.'" value="'.$vpreg->vArchivo.'">
                                                                    <input id="input_'.$vpreg->iIdPregunta.'" name="input_'.$vpreg->iIdPregunta.'" type="file" class="file" data-show-preview="false">
                                                                </div>';*/

                                                                echo '<div class="col-md-3">
                                                                    <label for="ev_1">Evidencia</label>                                                                    
                                                                    <input id="input_'.$vpreg->iIdPregunta.'" name="input_'.$vpreg->iIdPregunta.'" type="file" class="file" data-show-preview="false">
                                                                </div>';

                                                            }
                                                            /*echo '<div class="col-md-3">
                                                                <label for="ev_1">Evidencia</label>
                                                                <input type="text" id="ev_'.$vpreg->iIdPregunta.'" name="ev_'.$vpreg->iIdPregunta.'" value="'.$vpreg->vArchivo.'" disabled>
                                                            </div>'; */                                                       	
                                                        }
                                                    echo '</div>
                                                    
                                                </div>';
                                                $pregid = $vpreg->iIdPregunta;
                                                echo '<div class="col-md-12">';
                                            }

                                            if(in_array($vpreg->iIdRespuesta, $resp_us)) $check = 'checked';
                                            else 
                                            {
                                                if($vpreg->iTipoPregunta==2) $check = 'checked';
                                                else $check = '';
                                            }

                                            

                                            echo '
                                            <div class="custom-control custom-radio">
                                                <input '.$check.' '.$dis.' type="radio" id="op_'.$vpreg->iIdRespuesta.'" name="preg_'.$vpreg->iIdPregunta.'" class="custom-control-input" value="'.$vpreg->iIdRespuesta.'">
                                                <label class="custom-control-label" for="op_'.$vpreg->iIdRespuesta.'">'.$vpreg->vOpcion.'</label>';
                                                if($vpreg->iOtro == 1)
                                                {

				                                    
				                                    if(isset($resp_us_t[$vpreg->iIdRespuesta]['respuesta'])) $r_otro = $resp_us_t[$vpreg->iIdRespuesta]['respuesta'];
				                                    else $r_otro = '';
                                                    

                                                    echo '<div class="col-sm-5 col-sm-offset-3">
                                                            <input id="re_'.$vpreg->iIdRespuesta.'" name="re_'.$vpreg->iIdRespuesta.'" type="text" class="form-control" value="'.$r_otro.'" disabled>
                                                        </div>';
                                                }                                   
                                            echo '</div>';
                                        }
                                    }                                    
                                    ?>
                                    <!--<button type="submit" style="margin-top: 4%" class="btn btn-primary">Guardar</button>-->
                                </div>
                            </div>
                        </form>
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
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- customizer Panel -->
    <!-- ============================================================== -->    
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


        
        /*var valida_form = $('#form_cuestionario').validate({
          submitHandler: function(form) {
            console.log(form);          
          }
        });
        (function() {
            $("#form_cuestionario").validate({
                submitHandler: function(form) {
                  // do other things for a valid form
                  envia_calif();
                }
            });

            var arr = [];
            $("input[name^='calif']").each(function(index){
                if(this.type=='radio' || this.type=='text') {
                    if(!arr.includes(this.name)) {
                        arr.push(this.name);
                        $("[name='"+this.name+"']").rules("add", {
                            required: true,
                            messages: {
                                required: 'Ingrese una calificación'
                            }
                        });
                    }
                }
            });        
        })();


        function envia_calif() {
            var form = $('#form_cuestionario').serialize();            
            $.post('<?=base_url();?>envia_calif', $('#form_cuestionario').serialize(), function(resp){
            	if(resp==1) { 
                    Swal.fire({
                      type: 'success',
                      title: 'Correcto',
                      text: 'Calificación enviada'
                    });
                }
                else {
                    Swal.fire({
                      type: 'error',
                      title: 'Error',
                      text: 'La calificación no pudo ser enviada'
                    });
                }
            });
        }
        */
        

    </script>
</body>

</html>