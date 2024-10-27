<?php include "Views/Templates/header.php"; ?>
<div class="card">
    <div class="card-header bg-dark text-white">
        Datos de la institución
        <?php //print_r($data); ?>
    </div>
    <div class="card-body">
        <form id="frmEmpresa">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input id="id" class="form-control" type="hidden" name="id" value="<?php echo $data['id']; ?>">
                        <label for="nombre">Nombre (*)</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre" value="<?php echo $data['nombre']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ruc">RUC (*)</label>
                        <input id="ruc" class="form-control" type="text" name="ruc" placeholder="RUC" value="<?php echo $data['ruc']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input id="telefono" class="form-control" type="text" name="telefono" placeholder="Teléfono" value="<?php echo $data['telefono']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input id="direccion" class="form-control" type="text" name="direccion" placeholder="Dirección" value="<?php echo $data['direccion']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mensaje">Mensaje</label>
                        <textarea id="mensaje" class="form-control" name="mensaje" rows="3" placeholder="Mensaje"><?php echo $data['mensaje']; ?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Logo</label>
                        <div class="card">
                            <div class="card-body">
                                <label for="imagen" id="icon-image" class="btn btn-primary"><i class="fas fa-image"></i></label>
                                <span id="icon-cerrar"></span>
                                <input id="imagen" class="d-none" type="file" name="imagen" onchange="preview(event);">
                                <input type="hidden" id="foto-actual" name="foto-actual" value="<?php echo $data['logo']; ?>">
                                <img class="img-thumbnail" id="img-preview" src="<?php echo base_url.'Assets/img/logo/'.$data['logo'].'' ?>" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
            <button class="btn btn-primary" type="button" onclick="modificarEmpresa(event)">Modificar</button>
        </form>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>
