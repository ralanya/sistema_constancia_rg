<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Consulta de Constancia</title>
    <link rel="icon" type="image/png" href="<?php echo base_url."Assets/img/logo/default.png"; ?>" />

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url; ?>Assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url; ?>Assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-login-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">CONSULTA TU CONSTANCIA <br> Realizar búsqueda</h1>
                            </div>

                            <form name="frmBusquedaConstancia" id="idform" class="user">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label class="smmall mb-1" for="rdopcion"><i class="fa fa-address-card" aria-hidden="true"></i> Opciones:</label><br>                                        
                                        <input type="radio" name="rdopcion" value="TD" onchange="cargarTipoDocumento()"> Tipo de Documento<br>
                                        <input type="radio" name="rdopcion" value="CC" onchange="ocultarTipoDocumento()"> Código de Constancia                                         
                                    </div>
                                    <div class="col-sm-6 d-none" id="inputdocumento">
                                        <label class="smmall mb-1" for="cbodocumento"><i class="fas fa-user"></i> Tipo de documento</label><br>
                                        <select id="cbodocumento" class="form-control" name="cbodocumento">                                                                
                                            <option value="NA">Seleccione una opción</option>
                                            <option value="DNI">DNI</option>     
                                            <option value="CI">Cédula de Identidad</option>    
                                            <option value="P">Pasaporte</option>     
                                            <option value="CE">Carnet de Extranjería</option>                                                    
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="smmall mb-1" for="txtBusqueda"><i class="fas fa-search"></i> Consulta:</label>
                                    <input type="text" class="form-control form-control-user" id="txtBusqueda" name="txtBusqueda" placeholder="Ingrese la búsqueda">
                                </div>
                                <div class="alert alert-danger text-center d-none" id="alerta" role="alert">
                                    Content
                                </div>      
                                <!-- <input type="button" value="Ver radio value" onclick="verradiovalue();" /> -->
                                <button class="btn btn-primary btn-user btn-block" type="submit" onclick="frmBusqueda(event);"><i class="fas fa-search"></i> Buscar</button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="https://wa.link/84pdf5" target="_blank">¿Necesitas ayuda? Escribenos al Whatsapp</a>
                                | <a href="Usuarios/login" class="btn btn-success">
                                    <i class="fa fa-lock"></i> Administrar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url; ?>Assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url; ?>Assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url; ?>Assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url; ?>Assets/js/sb-admin-2.min.js"></script>

    <script>
        const base_url = "<?php echo base_url; ?>";
    </script>
    
    <script src="<?php echo base_url; ?>Assets/js/sistema/busqueda.js"></script>   

</body>

</html>