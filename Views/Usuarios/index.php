<?php include "Views/Templates/header.php"; ?>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Usuarios</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Listado</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <button class="btn btn-primary mb-2" type="button" onclick="frmUsuario();">Nuevo <i class="fas fa-plus"></i></button>                                
                                <table id="tblUsuarios" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Id</th>
                                            <th>Usuario</th>
                                            <th>Apellidos</th>
                                            <th>Nombres</th>
                                            <th>Rol</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="thead-dark">
                                        <tr>
                                            <th>Id</th>
                                            <th>Usuario</th>
                                            <th>Apellidos</th>
                                            <th>Nombres</th>
                                            <th>Rol</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                                <div id="nuevo_usuario" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title text-white" id="title"></h5>
                                                <button class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="frmUsuario" method="post">
                                                    <input id="txtid" class="form-control" type="hidden" name="txtid">
                                                    <div class="form-group">
                                                        <label for="txtusuario">Usuario</label>
                                                        <input id="txtusuario" class="form-control" type="text" name="txtusuario" placeholder="Usuario">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col md 6">
                                                            <div class="form-group">
                                                                <label for="txtapellido">Apellidos</label>
                                                                <input id="txtapellido" class="form-control" type="text" name="txtapellido" placeholder="Apellidos">
                                                            </div>
                                                        </div>
                                                        <div class="col md 6">
                                                            <div class="form-group">
                                                                <label for="txtnombre">Nombres</label>
                                                                <input id="txtnombre" class="form-control" type="text" name="txtnombre" placeholder="Nombres">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row" id="claves">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="txtclave">Contraseña</label>
                                                                <input id="txtclave" class="form-control" type="password" name="txtclave" placeholder="Contraseña">
                                                            </div>                                                                                                                        
                                                        </div>
                                                        <div class="col-md-6">                                                            
                                                            <div class="form-group">
                                                                <label for="txtconfirmar">Confirmar Contraseña</label>
                                                                <input id="txtconfirmar" class="form-control" type="password" name="txtconfirmar" placeholder="Confirmar contraseña">
                                                            </div>                                                            
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="cborol">Rol</label>
                                                        <select id="cborol" class="form-control" name="cborol">
                                                        <?php
                                                        foreach ($data['roles'] as $row) {
                                                            echo "<option value=".$row['id'].">".$row['nombre']."</option>";
                                                        }
                                                        ?>
                                                            
                                                        </select>
                                                    </div>
                                                    <button class="btn btn-primary" type="button" onclick="registrarUser(event);" id="btnAccion">Guardar</button>
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