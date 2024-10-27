<?php 
$nombres = $_SESSION['nombres'];
$documento = $_SESSION['documento'];
$numero = $_SESSION['numero'];
?>
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
                        <!-- <div class="col-lg-2 d-none d-lg-block bg-login-image"></div> -->
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">CONSULTA TU CONSTANCIA <br> Resultados de la búsqueda</h1>
                                </div>
                                <form class="user">
                                    <div class="form-group">
                                        <label class="smmall mb-1" for="txtusuario"><i class="fas fa-user"></i> Bienvenido(a): <?php echo $nombres." | ".$documento.": ".$numero.""; ?></label>
                                        <input type="hidden" id="txtnumero" name="txtnumero" value="<?php echo $numero; ?>">
                                    </div>
                                    <table id="tblResultados" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="thead-dark">
                                            <tr>                                                
                                                <th>Nombre</th>
                                                <th>Código</th>
                                                <th>Documento</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        </tbody>
                                    </table>                                
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a href="<?php echo base_url; ?>Busqueda/salir" class="btn btn-success">
                                        <i class="fa fa-backward"></i> Regresar
                                    </a>
                                    | <a class="small" href="https://wa.link/84pdf5" target="_blank">¿Necesitas ayuda? Escribenos al Whatsapp</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL DETALLE CONSTANCIA -->
        <div id="detalle_constancia" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="title"></h5>
                        <button class="close" onclick="cerrar_detalle(event);">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <input id="txtid" class="form-control" type="hidden" name="txtid">
                        <div class="row">
                            <div class="col md 4">
                                <div class="form-group">
                                    <label for="cbodocumento">Documento</label>
                                    <select id="cbodocumento" class="form-control" name="cbodocumento" disabled>                                                                
                                        <option value="null">Seleccione una opción</option>
                                        <option value="DNI">DNI</option>     
                                        <option value="CI">Cédula de Identidad</option>    
                                        <option value="P">Pasaporte</option>     
                                        <option value="CE">Carnet de Extranjería</option>                                                    
                                    </select>
                                </div>                                                            
                            </div>
                            <div class="col md 4">
                                <div class="form-group">
                                    <label for="txtnumerodetalle">Número</label>
                                    <input id="txtnumerodetalle" class="form-control" type="text" name="txtnumerodetalle" placeholder="Número del documento" disabled>
                                </div>
                            </div>
                            <div class="col md 4">
                                <div class="form-group">
                                    <label for="cbosituacion">Situación</label>
                                    <select id="cbosituacion" class="form-control" name="cbosituacion" disabled>                                                                
                                        <option value="null">No aplica</option>
                                        <option value="E">Estudiante</option>     
                                        <option value="P">Personal</option>     
                                        <option value="FA">Familia</option>   
                                        <option value="PE">Otro</option>                                                    
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col md 12">
                                <div class="form-group">
                                    <label for="txtnombreconcurso">Nombre de la Constancia</label>
                                    <input id="txtnombreconcurso" class="form-control" type="text" name="txtnombreconcurso" placeholder="Nombre del concurso" disabled>
                                </div>                                                            
                            </div>
                        </div> 

                        <div class="row">
                            <div class="col md 4">
                                <div class="form-group">
                                    <label for="txtcodigo">Código</label>
                                    <input id="txtcodigo" class="form-control" type="text" name="txtcodigo" placeholder="Código" disabled>
                                </div>                                                            
                            </div>
                            <div class="col md 4">
                                <div class="form-group">
                                    <label for="txtfechaemision">Fecha</label>
                                    <input id="txtfechaemision" class="form-control" type="date" name="txtfechaemision" disabled>
                                </div>
                            </div>
                            <div class="col md 4">
                                <div class="form-group">
                                    <label for="cbotipoconstancia">Documento</label>
                                    <select id="cbotipoconstancia" class="form-control" name="cbotipoconstancia" disabled>                                                                
                                        
                                        <?php foreach ($data as $row) {
                                            echo "<option value=".$row['id_documento'].">".$row['nombre']."</option>";
                                        }?>                                                   
                                    </select>
                                    
                                </div>
                            </div>
                        </div> 
                        
                        <div class="row">
                            <div class="col md 4">
                                <div class="form-group">
                                    <label for="cbopuesto">Puesto</label>
                                    <select id="cbopuesto" class="form-control" name="cbopuesto" disabled>                                                                
                                        <option value="0">No aplica</option>
                                        <option value="1">Primero</option>     
                                        <option value="2">Segundo</option>   
                                        <option value="3">Tercero</option>   
                                        <option value="4">Cuarto</option>   
                                        <option value="5">Quinto</option>                                                   
                                    </select>
                                </div>                                                            
                            </div>
                            <div class="col md 4">
                                <div class="form-group">
                                    <label for="txtnota">Nota</label>
                                    <input id="txtnota" class="form-control" type="text" name="txtnota" placeholder="No aplica" disabled>
                                </div>
                            </div>
                            <div class="col md 4">
                                <div class="form-group">
                                    <label for="txthora">Horas</label>
                                    <input id="txthora" class="form-control" type="text" name="txthora" placeholder="No aplica" disabled>                                    
                                </div>
                            </div>
                        </div> 
                        
                        <div class="row">
                            <div class="col md 4">
                                <div class="form-group">
                                    <label for="txtdescripcion">Descripción</label>
                                    <input id="txtdescripcion" class="form-control" type="text" name="txtdescripcion" placeholder="No aplica" disabled>
                                </div>                                                            
                            </div>
                            <div class="col md 4">
                                <div class="form-group">
                                    <label for="txtfechainicio">Fecha Inicio</label>
                                    <input id="txtfechainicio" class="form-control" type="date" name="txtfechainicio" placeholder="No aplica" disabled>
                                </div>
                            </div>
                            <div class="col md 4">
                                <div class="form-group">
                                    <label for="txtfechafin">Fecha Fin</label>
                                    <input id="txtfechafin" class="form-control" type="date" name="txtfechafin" placeholder="No aplica" disabled>                                    
                                </div>
                            </div>
                        </div> 
                        <button class="btn btn-primary" type="button" onclick="btnDescargaConstancia(event);" id="btnAccion">Guardar</button>
                        <button class="btn btn-danger" type="button" onclick="cerrar_detalle(event);">Cancelar</button>                                                        
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL DESCARGAR CONSTANCIA -->
        <div id="descarga_constancia" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="titleDescarga"></h5>
                        <button class="close" onclick="cerrar_descarga(event);">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col md 12"> 
                                <!-- <embed id="embedPDF" src="documentos/reciboluz.pdf" type="application/pdf" width="100%" height="600px" /> -->
                                <!-- <iframe id="iframePDF" frameborder="0" scrolling="no" width="100%" height="auto"></iframe> -->
                            </div>
                            
                        </div>    
                        <button class="btn btn-danger" type="button" onclick="cerrar_descarga(event);">Cancelar</button>                                                        
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

    <script src="<?php echo base_url; ?>Assets/DataTables/datatables.min.js"></script>
    
    <script>
        const base_url = "<?php echo base_url; ?>";
    </script>
    
    <script src="<?php echo base_url; ?>Assets/js/sistema/busqueda.js"></script>   

</body>

</html>