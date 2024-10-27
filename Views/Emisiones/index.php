<?php include "Views/Templates/header.php"; 
$id_rol = $_SESSION['id_rol'];
?>
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Emisiones</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Listado</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php if($id_rol == 1 || $id_rol == 2){ ?>
                                    <button class="btn btn-primary mb-2" type="button" onclick="frmEmision();">Nuevo <i class="fas fa-plus"></i></button>                                
                                <?php }else{}?>
                                <button class="btn btn-danger mb-2" type="button" onclick="generarPDFEmision();">Generar PDF <i class="far fa-file-pdf"></i></button>                                                    
                                <table id="tblEmisiones" class="table table-bordered" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Id</th>
                                            <th>Código</th>
                                            <th width="12%">F. Emisión</th>
                                            <th>Documento</th>
                                            <th>Número</th>
                                            <th>Nombre de Constancia</th>
                                            <th>Estado</th>
                                            <th width="12%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="thead-dark">
                                        <tr>
                                            <th>Id</th>
                                            <th>Código</th>
                                            <th width="12%">F. Emisión</th>
                                            <th>Documento</th>
                                            <th>Número</th>
                                            <th>Nombre de Constancia</th>
                                            <th>Estado</th>
                                            <th width="12%">Acciones</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                                <div id="nueva_emision" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title text-white" id="title"></h5>
                                                <button class="close" onclick="cerrar_emision(event);">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="frmEmision" method="post">
                                                    <input id="txtid" class="form-control" type="hidden" name="txtid">
                                                    <!-- TAB NAVS -->
                                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Emisión</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Constancia</a>
                                                        </li>                                                        
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Remitente</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="archivo-tab" data-toggle="tab" href="#archivo" role="tab" aria-controls="archivo" aria-selected="false">Archivo</a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content" id="myTabContent">
                                                        <div class="tab-pane fade show active mt-2" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                            <div class="row">
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="txtfecha">Fecha Emisión <span style="color:red">(*)</span></label>
                                                                        <input id="txtfecha" class="form-control" type="date" name="txtfecha" maxlength="20" onkeypress="return solonumeros(event);">
                                                                    </div>
                                                                </div>
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="cboarchivo">Archivo <span style="color:red">(*)</span></label>
                                                                        <select id="cboarchivo" class="form-control" name="cboarchivo">                                                                
                                                                            <option value="NA" onclick="ocultarArchivo()">Seleccione una opción</option>
                                                                            <option value="GEN" onclick="ocultarArchivo()">GENERADO</option>     
                                                                            <option value="PDF" onclick="cargarArchivo()">PDF</option>                                                   
                                                                        </select>
                                                                    </div>                                                            
                                                                </div>                                                                
                                                            </div>
                                                            <div class="row">
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="cbopuesto">Puesto</label>
                                                                        <select id="cbopuesto" class="form-control" name="cbopuesto">                                                                
                                                                            <option value="NA">Seleccione una opción</option>
                                                                            <option value="1">PRIMERO</option>     
                                                                            <option value="2">SEGUNDO</option>
                                                                            <option value="3">TERCERO</option>                                                   
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="txtnota">Nota</label>
                                                                        <input id="txtnota" class="form-control" type="text" name="txtnota" placeholder="Nota" maxlength="2" onkeypress="return solonumeros(event);">
                                                                    </div>
                                                                </div>                                                                
                                                            </div>  
                                                            <span style="color:red; font-size:0.8em;">Campos obligatorios (*)</span>                                                         
                                                            <div class="row">
                                                                <div class="col">
                                                                    <span class="float-right"><button type="button" class="btn btn-light btn-sm ml-1" onclick="$('#profile-tab').trigger('click')"><i class="fas fa-arrow-right"></i> Siguiente</button></span>
                                                                </div>                                                            
                                                            </div>                                                            
                                                        </div>
                                                        <div class="tab-pane fade mt-2" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                                            <div class="row">
                                                                <div class="col md 12">
                                                                    <div class="form-group">
                                                                        <input id="txtidconstancia" class="form-control" type="hidden" name="txtidconstancia">  
                                                                        <label for="cboconstancias">Nombre de la Constancia <span style="color:red">(*)</span></label><br>
                                                                        <select id="cboconstancias" class="form-control" name="cboconstancias" onchange="cargarConstancia()"> 
                                                                            <option value="NA">Seleccione una opción</option>
                                                                        <?php foreach ($data['constancias'] as $row) { ?>
                                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                                                        <?php } ?>                                                     
                                                                        </select>
                                                                    </div>
                                                                </div>                                                                
                                                            </div>
                                                            <div class="row">                                                                
                                                                <div class="col md 6">
                                                                    <div class="form-group">                                                                       
                                                                        <label for="cbodocumento">Documento</label>
                                                                        <select id="cbodocumento" class="form-control" name="cbodocumento" disabled>   
                                                                        <option value="NA">Seleccione una opción</option>                                                               
                                                                        <?php foreach ($data['documentos'] as $row) { ?>
                                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                                                        <?php } ?>                                                       
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="txtdescripcion">Descripción</label>
                                                                        <input id="txtdescripcion" class="form-control" type="text" name="txtdescripcion" placeholder="Descripción" disabled>                                                                                                                                  
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">                                                                
                                                                <div class="col md 4">
                                                                    <div class="form-group">                                                                       
                                                                        <label for="txthoras">Horas</label>
                                                                        <input id="txthoras" class="form-control" type="text" name="txthoras" placeholder="Horas" disabled>                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="col md 4">
                                                                    <div class="form-group">
                                                                        <label for="txtfechainicio">Fecha Inicio</label>
                                                                        <input id="txtfechainicio" class="form-control" type="date" name="txtfechainicio" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="col md 4">
                                                                    <div class="form-group">
                                                                        <label for="txtfechafin">Fecha Fin</label>
                                                                        <input id="txtfechafin" class="form-control" type="date" name="txtfechafin" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <span style="color:red; font-size:0.8em;">Campos obligatorios (*)</span> 
                                                            <div class="row">
                                                                <div class="col">
                                                                    <span class="float-right"><button type="button" class="btn btn-light btn-sm ml-1" onclick="$('#contact-tab').trigger('click')"><i class="fas fa-arrow-right"></i> Siguiente</button></span>
                                                                    <span class="float-right"><button type="button" class="btn btn-light btn-sm ml-1" onclick="$('#home-tab').trigger('click')"><i class="fas fa-arrow-left"></i> Anterior</button></span>
                                                                </div>                                                            
                                                            </div>                                                             
                                                        </div>                                                        
                                                        <div class="tab-pane fade mt-2" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                                            <div class="row">
                                                                <div class="col md 4">
                                                                    <div class="form-group">
                                                                        <label for="cbodocumentopersona">Documento <span style="color:red">(*)</span></label>
                                                                        <select id="cbodocumentopersona" class="form-control" name="cbodocumentopersona">                                                                
                                                                            <option value="NA">Seleccione una opción</option>
                                                                            <option value="DNI">DNI</option>     
                                                                            <option value="CI">Cédula de Identidad</option>
                                                                            <option value="S">Secundaria</option>                                                   
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col md 4">
                                                                    <div class="form-group">
                                                                        <input id="txtverificanumero" type="hidden" name="txtverificanumero" />
                                                                        <label for="txtnumero">Número <span style="color:red">(*)</span></label>
                                                                        <input id="txtnumero" class="form-control" type="text" name="txtnumero" placeholder="Número" onkeypress="return solonumeros(event)">
                                                                    </div>
                                                                </div>
                                                                <div class="col md 4">
                                                                    <div class="form-group">
                                                                        <label for="">Acción</label>
                                                                        <button id="btnBuscar" name="btnBuscar" class="btn btn-primary btn-block" type="button" onclick="cargarRemitente(event);">Buscar</button>
                                                                    </div>
                                                                </div>
                                                            </div>                                                            
                                                            <div class="row">                                                                
                                                                <div class="col md 6">
                                                                    <div class="form-group">   
                                                                        <label for="txtapellidos">Apellidos <span style="color:red">(*)</span></label>
                                                                        <input id="txtapellidos" class="form-control" type="text" name="txtapellidos" placeholder="Apellidos" disabled>                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="txtnombres">Nombres <span style="color:red">(*)</span></label>
                                                                        <input id="txtnombres" class="form-control" type="text" name="txtnombres" placeholder="Nombres" disabled>                                                                                                                                  
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">                                                                
                                                                <div class="col md 6">
                                                                    <div class="form-group">                                                                       
                                                                        <label for="cbosexo">Sexo <span style="color:red">(*)</span></label>
                                                                        <select id="cbosexo" class="form-control" name="cbosexo" disabled>                                                                
                                                                            <option value="NA">Seleccione una opción</option>
                                                                            <option value="H">Hombre</option>     
                                                                            <option value="M">Mujer</option>                                                 
                                                                        </select>                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="cbosituacion">Situación</label>
                                                                        <input type="hidden" name="txtsituacion" id="txtsituacion" />
                                                                        <select id="cbosituacion" class="form-control" name="cbosituacion" disabled>                                                                
                                                                            <option value="NA">Seleccione una opción</option>
                                                                            <option value="E">Estudiante</option>     
                                                                            <option value="P">Personal</option>
                                                                            <option value="FA">Familia</option>
                                                                            <option value="PE">Otro</option>                                                   
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <span style="color:red; font-size:0.8em;">Campos obligatorios (*)</span> 
                                                            <div class="row">
                                                                <div class="col">          
                                                                    <span class="float-right"><button type="button" class="btn btn-light btn-sm ml-1" onclick="$('#archivo-tab').trigger('click')"><i class="fas fa-arrow-right"></i> Siguiente</button></span>
                                                                    <span class="float-right"><button type="button" class="btn btn-light btn-sm ml-1" onclick="$('#profile-tab').trigger('click')"><i class="fas fa-arrow-left"></i> Anterior</button></span>                                                          
                                                                </div>                                                            
                                                            </div>
                                                        </div>

                                                        <div class="tab-pane fade mt-2" id="archivo" role="tabpanel" aria-labelledby="archivo-tab">
                                                            <span id="txtmensajearchivo"><b>Mensaje:</b> Se habilita solo con la opción PDF</span>
                                                            <div class="row">
                                                                <div class="col-md-12" id="grupoarchivo">
                                                                    <div class="form-group">
                                                                        <label>Cargar Archivo</label>
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <label for="imagen" id="icon-image" class="btn btn-primary"><i class="fas fa-file"></i></label>
                                                                                <span id="icon-cerrar"></span>
                                                                                <input id="imagen" class="d-none" type="file" name="imagen" onchange="preview(event);">
                                                                                <input type="hidden" id="foto-actual" name="foto-actual">
                                                                                <iframe id="iframePDF-preview" title="Inline Frame Example" width="100%"  height="270"></iframe>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>                                                                                                                      
                                                             
                                                            <div class="row">
                                                                <div class="col">                                                                    
                                                                    <span class="float-right"><button type="button" class="btn btn-light btn-sm ml-1" onclick="$('#contact-tab').trigger('click')"><i class="fas fa-arrow-left"></i> Anterior</button></span>
                                                                </div>                                                            
                                                            </div>
                                                        </div>
                                                                                                              
                                                    </div>
                                                    <!-- FIN TABS -->   
                                                    <button class="btn btn-primary" type="button" onclick="registrarEmi(event);" id="btnAccion">Guardar</button>
                                                    <button class="btn btn-danger" type="button" onclick="cerrar_emision(event);">Cancelar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<?php include "Views/Templates/footer.php"; ?>