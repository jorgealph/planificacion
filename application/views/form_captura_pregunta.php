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
    <title>Nice admin Template - The Ultimate Multipurpose admin template</title>
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
                        <!--<h4 class="page-title"><?=$pagina=1;?></h4>-->
                    </div>
                </div>
            </div>
       
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body wizard-content">
                                <h4 class="card-title">Captura de cuestionario</h4>
                                <!--<h6 class="card-subtitle">You can us the validation like what we did</h6>-->
                                <form id="form-cuestionario" action="#" class="validation-wizard wizard-circle m-t-40">
                                    <!-- Step 1 -->
                                    <section>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="hidden" name="iIdCuestionario" id="iIdCuestionario" value="<?=$iIdCuestionario?>">
                                                    <label for="wfirstName2"> Nombre del cuestionario: <span class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control required" id="vCuestionario" name="vCuestionario" value="<?=$vCuestionario?>"> </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="iTipo"> Tipo: <span class="text-danger">*</span> </label>
                                                    <select name="iTipo" id="iTipo" class="form-control">
                                                        <option value="1" <?=($iTipo == 1)? 'selected':''?>>Entidad federativa</option>
                                                        <option value="2" <?=($iTipo == 2)? 'selected':''?>>Municipio</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                       
                                       <div class="row">                                            
                                            <div class="col-md-12 text-center"><button type="submit" class="btn btn-success">Guardar</button></div>
                                       </div>
                                    </section>
                                  
                                  
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
     
            <!--<footer class="footer text-center">
                All Rights Reserved by Nice admin. Designed and Developed by
                <a href="https://wrappixel.com">WrapPixel</a>.
            </footer>-->
     
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
        var valida_form = $('#form-cuestionario').validate({
      //ignore: [],
          rules: {
            vCuestionario: "required",            
            iTipo:  "required"            
          },
          messages: {
            vCuestionario: "Este campo es obligatorio",
            iTipo: 'Debe seleccionar una opción'
          },
          submitHandler: function(form) {
            guardarCuestionario();
          }
        }); 

        function guardarCuestionario() {
            $.post('<?=base_url();?>C_cuestionario/guardar_cuestionario', $('#form-cuestionario').serialize(), function(resp){
                if(resp==1) { 
                    Swal.fire({
                      type: 'success',
                      title: 'Correcto',
                      text: 'Usuario insertado'
                    });
                }
                else {
                    Swal.fire({
                      type: 'error',
                      title: 'Error',
                      text: resp
                    });
                }
            });
        }

        function modificar() {
            $.post('<?=base_url();?>modificar', $('#form_modus').serialize(), function(resp){
                if(resp==1) {                     
                    Swal.fire({
                      type: 'success',
                      title: 'Correcto',
                      text: 'Usuario modificado'
                    });
                }
                else {
                    Swal.fire({
                      type: 'error',
                      title: 'Error',
                      text: 'El usuario no pudo ser modificado'
                    });
                }
            });
        }

        function proc(op) {
            if(op==1) {
                $('#cont-municipio').css('display','none');
                $('#cont-entidad').css('display','block');
            } 
            else if(op==2) {
                $('#cont-municipio').css('display','block');
                $('#cont-entidad').css('display','none');
            }
        }
    </script> 

</body>

</html>