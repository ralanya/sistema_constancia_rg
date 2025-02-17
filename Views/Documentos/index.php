<?php include "Views/Templates/header.php"; 
$id_rol = $_SESSION['id_rol'];
?>
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Documentos</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Listado</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php if($id_rol == 1 || $id_rol == 2){ ?>
                                <button class="btn btn-primary mb-2" type="button" onclick="frmDocumento();">Nuevo <i class="fas fa-plus"></i></button>                                
                                <?php }else{}?>
                                <table id="tblDocumentos" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="thead-dark">
                                        <tr>
                                        <th>Id</th>
                                            <th>Nombre</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                                <div id="nuevo_documento" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title text-white" id="title"></h5>
                                                <button class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="frmDocumento" method="post">
                                                    <input id="txtid" class="form-control" type="hidden" name="txtid">                                                    
                                                    <div class="form-group">
                                                        <label for="txtnombre">Nombre</label>
                                                        <input id="txtnombre" class="form-control" type="text" name="txtnombre" placeholder="Nombre del Documento">
                                                    </div>                                                                                             
                                                    <button class="btn btn-primary" type="button" onclick="registrarDocu(event);" id="btnAccion">Guardar</button>
                                                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

<?php include "Views/Templates/footer.php"; ?>