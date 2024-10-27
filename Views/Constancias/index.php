<?php include "Views/Templates/header.php"; 
$id_rol = $_SESSION['id_rol'];
?>
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Constancias</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Listado</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php if($id_rol == 1 || $id_rol == 2){ ?>
                                    <button class="btn btn-primary mb-2" type="button" onclick="frmConstancia();">Nuevo <i class="fas fa-plus"></i></button>
                                <?php }else{}?> 
                                <button class="btn btn-danger mb-2" type="button" onclick="generarPDFConstancia();">Generar PDF <i class="far fa-file-pdf"></i></button>                                                    
                                <table id="tblConstancias" class="table table-bordered" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th width="10%">Imagen</th> 
                                            <th>Documento</th>                                          
                                            <th>Estado</th>
                                            <th width="12%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="thead-dark">
                                    <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th width="10%">Imagen</th>    
                                            <th>Documento</th>                                       
                                            <th>Estado</th>
                                            <th width="12%">Acciones</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                                <div id="nueva_constancia" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title text-white" id="title"></h5>
                                                <button class="close" onclick="cerrar_constancia(event);">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="frmConstancia" method="post">
                                                    <input id="txtid" class="form-control" type="hidden" name="txtid">                                                                                                        
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="txtnombre">Nombre de la Constancia <span style="color:red">(*)</span></label>
                                                                <input id="txtnombre" class="form-control" type="text" name="txtnombre" placeholder="Nombre de la Constancia">
                                                            </div>
                                                        </div>                                                        
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="txthoras">Horas</label>
                                                                <input id="txthoras" class="form-control" type="text" name="txthoras" placeholder="Horas">
                                                            </div>                                                                                                                                                                              
                                                        </div>
                                                        <div class="col-md-4">                                                            
                                                            <div class="form-group">
                                                                <label for="txtfechainicio">Fecha Inicio</label>
                                                                <input id="txtfechainicio" class="form-control" type="date" name="txtfechainicio">
                                                            </div>                                                            
                                                        </div>
                                                        <div class="col-md-4">                                                            
                                                            <div class="form-group">
                                                                <label for="txtfechafin">Fecha Fin</label>
                                                                <input id="txtfechafin" class="form-control" type="date" name="txtfechafin">
                                                            </div>                                                            
                                                        </div>
                                                    </div>    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="txtdescripcion">Descripción</label>
                                                                <input id="txtdescripcion" class="form-control" type="text" name="txtdescripcion" placeholder="Descripción">
                                                            </div>  
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="cbodocumento">Documento <span style="color:red">(*)</span></label>
                                                                <select id="cbodocumento" class="form-control" name="cbodocumento">
                                                                <option value="NA">Seleccione una opción</option>
                                                                <?php
                                                                foreach ($data as $row) {
                                                                    echo "<option value=".$row['id'].">".$row['nombre']."</option>";
                                                                }
                                                                ?>                                                            
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Archivo</label>
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <label for="imagen" id="icon-image" class="btn btn-primary"><i class="fas fa-file"></i></label>
                                                                        <span id="icon-cerrar"></span>
                                                                        <input id="imagen" class="d-none" type="file" name="imagen" onchange="preview(event);">
                                                                        <input type="hidden" id="foto-actual" name="foto-actual">
                                                                        <img class="img-thumbnail" id="img-preview">
                                                                    </div>
                                                                </div>
                                                                <span style="color:red; font-size:0.8em;">Campos obligatorios (*)</span>  
                                                            </div>
                                                        </div>
                                                    </div>                                              
                                                    <button class="btn btn-primary" type="button" onclick="registrarConst(event);" id="btnAccion">Guardar</button>
                                                    <button class="btn btn-danger" type="button" onclick="cerrar_constancia(event);">Cancelar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<?php include "Views/Templates/footer.php"; ?>