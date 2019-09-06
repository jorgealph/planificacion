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
                        <h4 class="page-title">Responder cuestionario</h4>
                    </div>                    
                </div>
            </div>
            
            <div class="container-fluid">
                

                <div class="row">                   
                    <div class="col-12">
                        <form id="form_cuestionario">                            
                            <div class="card">
                                <div class="card-body">
                                    <input type="hidden" id="cuestid" name="cuestid" value="<?=$cuestid;?>">
                                    
                                    <?php                                     
                                    $resp_us = array();
                                    $resp_us_t = array();
                                    //print_r($respuestas);
                                    if($respuestas!=false)
                                    {
                                        foreach ($respuestas as $vresp) {
                                            array_push($resp_us, $vresp->iIdRespuesta);

                                            $resp_us_t[$vresp->iIdRespuesta] = array(
                                                'respuesta' => $vresp->vRespuesta);
                                        }
                                    }
                                    //print_r($resp_us);
                                    $pregid = 0;                                    
                                    if($preguntas!=false && count($preguntas) > 0)
                                    {
                                        if(count($resp_us) > 0) $dis = 'disabled';
                                        else $dis = '';

                                        //print_r($preguntas);
                                        foreach ($preguntas as $vpreg) {
                                            if($vpreg->iIdPregunta!=$pregid)
                                            {
                                                if($pregid>0) echo '</div></div></div><br><br>';
                                                echo '<div class="row" style="border-bottom: 1px dashed #cacaca; padding-bottom: 2%;">';
                                                echo '<div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-5"><h4 class="card-title">'.$vpreg->iIdPregunta.'.- '.$vpreg->vPregunta.'</h4></div>';

                                                        if($vpreg->iCalificacion >= 0)
                                                        {
                                                            echo '<div class="col-md-4">
                                                                <label for="calif_'.$vpreg->iIdPregunta.'">Calificación</label>
                                                                <input type="text" id="calif_'.$vpreg->iIdPregunta.'" name="calif_'.$vpreg->iIdPregunta.'" value="'.$vpreg->iCalificacion.'" disabled>
                                                            </div>';                                                            
                                                        }
                                                        
                                                        if($vpreg->iEvidencia==1)

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
                                                    echo '</div>
                                                    
                                                </div>';
                                                $pregid = $vpreg->iIdPregunta;
                                                echo '<div class="col-md-12"><div class="preg_'.$pregid.'">';
                                            }                                            

                                            if($vpreg->iTipoPregunta==3) { $tipo_el = 'checkbox'; $ar = '[]'; }
                                            else { $tipo_el = 'radio'; $ar = ''; }

                                            if(in_array($vpreg->iIdRespuesta, $resp_us)) $check = 'checked';
                                            else 
                                            {
                                                if($vpreg->iTipoPregunta==2) $check = 'checked';
                                                else $check = '';
                                            }

                                            

                                            echo '
                                            <div class="custom-control custom-'.$tipo_el.'">
                                                <input '.$check.' '.$dis.' type="'.$tipo_el.'" id="op_'.$vpreg->iIdRespuesta.'" name="preg_'.$vpreg->iIdPregunta.$ar.'" class="custom-control-input" value="'.$vpreg->iIdRespuesta.'">
                                                <label class="custom-control-label" for="op_'.$vpreg->iIdRespuesta.'">'.$vpreg->vOpcion.'</label>';
                                                if($vpreg->iOtro == 1)
                                                {

                                                    if(isset($resp_us_t[$vpreg->iIdRespuesta]['respuesta'])) $r_otro = $resp_us_t[$vpreg->iIdRespuesta]['respuesta'];
                                                    else $r_otro = '';

                                                    echo '<div class="col-sm-5 col-sm-offset-3">
                                                            <input id="re_'.$vpreg->iIdRespuesta.'" name="re_'.$vpreg->iIdRespuesta.'" type="text" class="form-control" value="'.$r_otro.'">                                                            
                                                        </div>';
                                                }                                   
                                            echo '</div>';
                                        }
                                        if(count($resp_us) == 0) echo '<button id="envia_enc" type="submit" style="margin-top: 4%" class="btn btn-primary">Guardar</button>';
                                    }
                                    else echo '<h2>El cuestionario aún no se encuentra disponible</h2>';
                                    ?>                                    
                                    
                                </div>
                            </div>
                        </form>
                    </div>              
                </div>
                <!-- order table -->        
                                
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
    <script src="<?=base_url();?>dist/js/app-style-switcher.horizontal.js"></script>
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


        $(".file").fileinput({
            showUpload: false,
            language: 'es',
            layoutTemplates: {
                actions: '<div class="file-actions">\n' +
                '    <div class="file-footer-buttons">\n' +
                '        {delete} {zoom}' +
                '    </div>\n' +
                '    {drag}\n' +
                '    <div class="clearfix"></div>\n' +
                '</div>',
            },
            uploadUrl: '<?=base_url();?>archivo',
            maxFileCount: 1,
            allowedFileExtensions: ["pdf", "xls"],
            maxFileSize: 10240,            
            uploadAsync: false,           
        });    

        (function() {
            $("#form_cuestionario").validate({
                ignore: [],
                errorPlacement: function(error, element) {
                    error.appendTo( element.parent("div"));
                },
                submitHandler: function(form) {
                  envia_form();
                }
            });

            var arr = [];
            var arr2 = [];

            $("input[name^='preg']").each(function(index){
                if(this.type=='radio' || this.type=='text') {
                    if(!arr.includes(this.name)) {
                        arr.push(this.name);
                        $("[name='"+this.name+"']").rules("add", {
                            required: true,
                            messages: {
                                required: 'Seleccione una opción'
                            }
                        });                        
                    }
                }
            }); 

            $("input[name^='re']").each(function(index){
                if(this.type=='radio' || this.type=='text') {
                    if(!arr2.includes(this.name)) {
                        arr2.push(this.name);
                        
                        var id = this.name.split('_');
                        $("[name='"+this.name+"']").rules("add", {
                            required: function(element) {
                                return $("#op_"+id[1]).is(":checked");
                            },
                            messages: {
                                required: 'Seleccionar la opción'
                            }
                        });
                    }
                }
            });

        })();

        function envia_form() {                     
            var form = $('#form_cuestionario').serialize();
            $.ajax({
                type: 'POST',
                url: '<?=base_url();?>respuestas',
                data: form,
                async: false,                        
                success: function(data) {

                    Swal.fire({
                      type: 'success',
                      title: 'Correcto',
                      text: 'Información guardada correctamente'
                    });
                    
                    if(data==1) {
                        $("input[type='radio']").each(function(i) {
                            $(this).attr('disabled', 'disabled');
                        });

                        $("input[type='checkbox']").each(function(i) {
                            $(this).attr('disabled', 'disabled');
                        });

                        $("input[name^='input']").each(function(index){                
                            var filesCount = $('#'+this.name).fileinput('getFilesCount');
                            if(filesCount>0) $('#'+this.name).fileinput('upload');
                        });

                        document.getElementById("envia_enc").remove();
                        //location.reload();

                    }
                },
                fail: function() {
                    Swal.fire({
                      type: 'error',
                      title: 'Error',
                      text: 'No se pudo guardar la información'
                    });
                 }

            });
        }

        function envia_archivo() {
            //var arch = $('#archivo').val();
            var form = $('#form_archivo_dos').serialize();
            console.log(form);
            $.post('<?=base_url();?>archivo', $('#form_archivo_dos').serialize(), function(resp){
                console.log(resp);
            });
        }

    </script>
</body>

</html>