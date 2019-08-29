<header class="topbar">
    <?php $tipo = $_SESSION['usuario']['tipo']; ?>
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                        <i class="ti-menu ti-close"></i>
                    </a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <div class="navbar-brand">
                        <a href="<?=base_url();?>" class="logo">
                            <!-- Logo icon -->
                            <b class="logo-icon">
                                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                                <!-- Dark Logo icon -->
                                <img src="<?=base_url();?>assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                                <!-- Light Logo icon -->
                                <img src="<?=base_url();?>assets/images/logo-light-icon.png" alt="homepage" class="light-logo" />
                            </b>
                            <!--End Logo icon -->
                            <!-- Logo text -->
                            <span class="logo-text">
                                <!-- dark Logo text -->
                                <img src="<?=base_url();?>assets/images/logo-text.png" alt="homepage" class="dark-logo" />
                                <!-- Light Logo text -->
                                <img src="<?=base_url();?>assets/images/logo-light-text.png" class="light-logo" alt="homepage" />
                            </span>
                        </a>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti-more"></i>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto">
                        <!-- <li class="nav-item d-none d-md-block">
                            <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar">
                                <i class="mdi mdi-menu font-24"></i>
                            </a>
                        </li> -->                        
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        
                        <!-- ============================================================== -->
                        
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="<?=base_url();?>assets/images/users/2.jpg" alt="user" class="rounded-circle" width="40">
                                <span class="m-l-5 font-medium d-none d-sm-inline-block"><?php echo $_SESSION['usuario']['nom']; ?> <i class="mdi mdi-chevron-down"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow">
                                    <span class="bg-primary"></span>
                                </span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                    <div class="">
                                        <img src="<?=base_url();?>assets/images/users/2.jpg" alt="user" class="rounded-circle" width="60">
                                    </div>
                                    <div class="m-l-10">
                                        <h4 class="m-b-0"><?php echo $_SESSION['usuario']['nom']; ?></h4>
                                        <!--<p class=" m-b-0">jon@gmail.com</p>-->
                                    </div>
                                </div>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="cerrar_sesion();">
                                    <i class="fa fa-power-off m-r-5 m-l-5"></i> Cerrar sesión</a>
                                <div class="dropdown-divider"></div>                                
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <!-- User Profile-->
                        <?php 
                        if($tipo==1)
                        {
                            echo '
                                <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span class="hide-menu">Usuarios</span></li>
                                <li class="sidebar-item"> <a class="sidebar-link" href="'.base_url().'usuarios" aria-expanded="false"><i class="mdi mdi-av-timer"></i><span class="hide-menu">Usuarios </span></a></li>

                                <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span class="hide-menu">Preguntas</span></li>
                                <li class="sidebar-item"> <a class="sidebar-link" href="'.base_url().'preguntas" aria-expanded="false"><i class="mdi mdi-inbox-arrow-down"></i><span class="hide-menu">Preguntas </span></a></li>

                                <li class="sidebar-item"> <a class="sidebar-link" href="'.base_url().'listado-respuestas" aria-expanded="false"><i class="mdi mdi-arrange-send-to-back"></i><span class="hide-menu">Respuestas </span></a></li>

                                <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span class="hide-menu">Cuestionario</span></li>
                                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-collage"></i><span class="hide-menu">Cuestionario</span></a>
                                    <ul aria-expanded="false" class="collapse first-level">                               
                                                                                                                                        
                                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.base_url().'cuestionario" aria-expanded="false"><i class="mdi mdi-cube-send"></i><span class="hide-menu">Responder cuestionario</span></a></li>

                                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.base_url().'calificar" aria-expanded="false"><i class="mdi mdi-creation"></i><span class="hide-menu">Calificar cuestionario</span></a></li>

                                        <!--<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.base_url().'preguntas" aria-expanded="false"><i class="mdi mdi-inbox-arrow-down"></i><span class="hide-menu">Administrar preguntas</span></a></li>

                                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.base_url().'preguntas" aria-expanded="false"><i class="mdi mdi-arrange-send-to-back"></i><span class="hide-menu">Administrar respuestas</span></a></li>-->

                                        
                                    </ul>
                                </li>
                            ';
                        }
                        elseif($tipo==2)
                        {
                            echo '
                                <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span class="hide-menu">Preguntas</span></li>
                                <li class="sidebar-item"> <a class="sidebar-link" href="'.base_url().'preguntas" aria-expanded="false"><i class="mdi mdi-inbox-arrow-down"></i><span class="hide-menu">Preguntas </span></a></li>

                                <li class="sidebar-item"> <a class="sidebar-link" href="'.base_url().'listado-respuestas" aria-expanded="false"><i class="mdi mdi-arrange-send-to-back"></i><span class="hide-menu">Respuestas </span></a></li>

                                <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span class="hide-menu">Cuestionario</span></li>
                                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-collage"></i><span class="hide-menu">Cuestionario</span></a>
                                    <ul aria-expanded="false" class="collapse first-level">                               
                                                                                                                                        
                                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.base_url().'cuestionario" aria-expanded="false"><i class="mdi mdi-cube-send"></i><span class="hide-menu">Responder cuestionario</span></a></li>

                                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.base_url().'calificar" aria-expanded="false"><i class="mdi mdi-creation"></i><span class="hide-menu">Calificar cuestionario</span></a></li>

                                        <!--<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.base_url().'preguntas" aria-expanded="false"><i class="mdi mdi-inbox-arrow-down"></i><span class="hide-menu">Administrar preguntas</span></a></li>

                                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.base_url().'preguntas" aria-expanded="false"><i class="mdi mdi-arrange-send-to-back"></i><span class="hide-menu">Administrar respuestas</span></a></li>-->

                                        
                                    </ul>
                                </li>
                            ';
                        }
                        elseif($tipo==3)
                        {
                            echo '
                                <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span class="hide-menu">Cuestionario</span></li>
                                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-collage"></i><span class="hide-menu">Cuestionario</span></a>
                                    <ul aria-expanded="false" class="collapse first-level">                               
                                                                                                                                        
                                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.base_url().'cuestionario" aria-expanded="false"><i class="mdi mdi-cube-send"></i><span class="hide-menu">Responder cuestionario</span></a></li>                                    
                                    </ul>
                                </li>
                            ';
                        }
                        ?>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        


        <script type="text/javascript">
            function cerrar_sesion()
            {
                $.post('<?=base_url();?>salir', function(resp){
                    if(resp==1) location.reload();
                    else alert('Error al cerrar la sesión');
                });
            }
        </script>