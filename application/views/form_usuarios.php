<?php 
if(isset($resp) && count($resp) > 0)
{
   $pagina = 'Editar usuario';
   $usid = $resp[0]->iIdUsuario;
   $nom_us = $resp[0]->vNombreUsuario;
   $correo = $resp[0]->vCorreo;
   $tipo_us = $resp[0]->iTipoUsuario;
   $tipo = $resp[0]->iTipo;
   $ent = $resp[0]->vEntidad;
   $mun = $resp[0]->vMunicipio;
   $formid = 'form_modus';
}
else
{
    $usid = 0;
    $nom_us = '';
    $correo = '';
    $tipo_us = 0;
    $tipo = 2;
    $ent = '';
    $mun = '';
    $formid = 'form_usuario';
    $pagina = 'Agregar usuario';
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
                                            <input type="hidden" id="usuarioid" name="usuarioid" value="<?=$usid;?>">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Nombre de usuario</label>
                                                    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" value="<?=$nom_us;?>">     
                                                </div>                                               
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Correo</label>
                                                    <input type="email" id="correo" name="correo" class="form-control form-control-danger" placeholder="user@gmail.com" value="<?=$correo;?>">
                                                </div>                                                    
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <?php 
                                        if($usid == 0)
                                        {?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group has-danger">
                                                        <label class="control-label">Contraseña</label>
                                                        <input type="password" id="contrasenia" name="contrasenia" class="form-control form-control-danger" placeholder="Contraseña">
                                                    </div>                                                    
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group has-danger">
                                                        <label class="control-label">Repetir contraseña</label>
                                                        <input type="password" id="contrasenia2" name="contrasenia2" class="form-control form-control-danger" placeholder="Repetir contraseña">
                                                    </div>                                                    
                                                </div>                                        
                                                <!--/span-->                                            
                                            </div>

                                        <?php } ?>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group has-success">
                                                    <label class="control-label">Procedencia</label>
                                                    <select onchange="proc(this.value);" id="sel_tipo" name="sel_tipo" class="form-control custom-select">
                                                        <option value="1" <?=($tipo==1) ? 'selected' : '';?>>Entidad</option>
                                                        <option value="2" <?=($tipo==2) ? 'selected' : '';?>>Municipio</option>
                                                    </select>   
                                                </div>                                                 
                                            </div>
                                            <div id="cont-entidad" class="col-md-6" style="<?=($tipo==2) ? 'display: none;' : '';?>">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Entidad federativa</label>
                                                    <input type="text" id="entidad" name="entidad" class="form-control form-control-danger" placeholder="Entidad federativa" value="<?=$ent;?>">
                                                </div>                                                    
                                            </div>
                                            <div id="cont-municipio" class="col-md-6" style="<?=($tipo==1) ? 'display: none;' : '';?>">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Municipio</label>
                                                    <input type="text" id="municipio" name="municipio" class="form-control form-control-danger" placeholder="Municipio" value="<?=$mun;?>">
                                                </div>                                                    
                                            </div>                                        
                                            <!--/span-->                                            
                                        </div>
                                        <div class="row">                                            
                                            <div class="col-md-6">
                                                <div class="form-group has-success">
                                                    <label class="control-label">Tipo de usuario</label>
                                                    <select id="sel_us" name="sel_us" class="form-control custom-select">
                                                        <option value="">Seleccionar</option>
                                                        <option value="1" <?=($tipo_us==1) ? 'selected' : '';?>>Administrador</option>
                                                        <option value="2" <?=($tipo_us==2) ? 'selected' : '';?>>Moderador</option>
                                                        <option value="3" <?=($tipo_us==3) ? 'selected' : '';?>>Usuario</option>
                                                    </select>   
                                                </div>                                                 
                                            </div>
                                            <!--/span-->                                            
                                        </div>
                                        <!--/row-->
                                        
                                        <!--/row-->
                                    </div>                                    
                                    
                                    <div class="form-actions">
                                        <div class="card-body">
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>                                            
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
        var valida_form = $('#form_usuario').validate({
      //ignore: [],
          rules: {
            nombre: "required",            
            contrasenia:  "required",
            contrasenia2: {
              required: true,
              equalTo: '#contrasenia'
            },
            sel_tipo: "required",
            correo: {
              required: true,
              email: true
            }            

          },
          messages: {
            nombre: "Ingrese su nombre",
            contrasenia: 'Ingrese su contraseña',
            contrasenia2: {
                required: 'Repita su contraseña',
                equalTo: "Las contraseñas no coinciden"
            },
            sel_tipo: "Seleccione una opción",
            correo: {
              required: "Ingrese su correo",
              email: "Ingrese un correo válido"
            }

          },
          submitHandler: function(form) {
            //console.log(form);
            guardar();
          }
        }); 

        var mod_form = $('#form_modus').validate({
      //ignore: [],
          rules: {
            nombre: "required",
            sel_tipo: "required",
            correo: {
              required: true,
              email: true
            }            

          },
          messages: {
            nombre: "Ingrese su nombre",            
            sel_tipo: "Seleccione una opción",
            correo: {
              required: "Ingrese su correo",
              email: "Ingrese un correo válido"
            }

          },
          submitHandler: function(form) {
            //console.log(form);
            modificar();
          }
        }); 

        function guardar() {
            $.post('<?=base_url();?>guardar', $('#form_usuario').serialize(), function(resp){
                if(resp==1) { 
                    Swal.fire({
                      type: 'success',
                      title: 'Correcto',
                      text: 'Usuario insertado'
                    });
                    $('#form_usuario').trigger("reset");
                }
                else {
                    Swal.fire({
                      type: 'error',
                      title: 'Error',
                      text: 'El usuario no pudo ser insertado'
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