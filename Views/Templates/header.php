<!DOCTYPE html>
<html lang="en">
<?php $id_rol = $_SESSION['id_rol']; $logo = $_SESSION['logo']; $institucion = $_SESSION['institucion']; ?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Módulo Constancia | <?php echo $institucion; ?></title>
    <link rel="icon" type="image/png" href="<?php echo base_url."Assets/img/logo/".$logo.""; ?>" />
    
    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url; ?>Assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url; ?>Assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for datatable -->
    <!-- <link href="<?php echo base_url; ?>Assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
    <link href="<?php echo base_url; ?>Assets/DataTables/datatables.min.css" rel="stylesheet">

    <!-- select -->
    <link href="<?php echo base_url; ?>Assets/css/select2.min.css" rel="stylesheet">

</head>

<body id="page-top">        
    <!-- Page Wrapper -->
    <div id="wrapper">    
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">            
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url; ?>Dashboard">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Constancia <sup>v1</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                Panel Principal
            </div>

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url; ?>Dashboard">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Listados
            </div>

            <!-- Nav Item - Pages Collapse Menu -->            
            <!-- Nav Item - Tables -->            
            <li class="nav-item">                
                <a class="nav-link" href="<?php echo base_url; ?>Constancias">
                    <i class="fa fa-table"></i>
                    <span>Constancias</span>
                </a>
                <a class="nav-link" href="<?php echo base_url; ?>Emisiones">
                    <i class="fa fa-table"></i>
                    <span>Emisiones</span>
                </a> 
                <a class="nav-link" href="<?php echo base_url; ?>Documentos">
                    <i class="fa fa-table"></i>
                    <span>Documentos</span>
                </a>  
                <a class="nav-link" href="<?php echo base_url; ?>Boletas">
                    <i class="fa fa-table"></i>
                    <span>Boletas</span>
                </a>                             
            </li> 
            
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Configuración
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            
            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <?php if($id_rol == 1){ ?>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Administración</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">                        
                            <a class="collapse-item" href="<?php echo base_url; ?>Usuarios"><i class="fas fa-user"></i> Usuarios</a>
                            <a class="collapse-item" href="<?php echo base_url; ?>Roles"><i class="fas fa-child"></i> Roles</a>
                            <a class="collapse-item" href="<?php echo base_url; ?>Excel"><i class="fas fa-upload"></i> Importar</a>
                            <a class="collapse-item" href="<?php echo base_url; ?>Administracion"><i class="fas fa-tools"></i> Configuración</a>
                        </div>
                    </div>
                <?php }else if($id_rol == 2){ ?>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Administración</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">                        
                            <a class="collapse-item" href="<?php echo base_url; ?>Excel"><i class="fas fa-upload"></i> Importar</a>                            
                        </div>
                    </div>
                <?php }else{}?>
                
                
                <a class="nav-link" href="<?php echo base_url; ?>Usuarios/perfil">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Perfil</span>
                </a>  
                <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Salir</span>
                </a>                                          
            </li>  
            
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>           

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>                   

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                <?php
                                $id_usuario = $_SESSION['nombre'];
                                $rol = $_SESSION['nombre_rol'];
                                echo "Bienvenido(a): ".$id_usuario. " | Rol: ".$rol;
                                ?>
                                </span>
                                <i class="fas fa-user-circle fa-2x"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?php echo base_url; ?>Usuarios/perfil">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>
                                <?php if($id_rol == 1){ ?>
                                <a class="dropdown-item" href="<?php echo base_url; ?>Administracion">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Configuración
                                </a>    
                                <?php }else{}?>                            
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Salir
                                </a>
                            </div>
                        </li>
                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">           