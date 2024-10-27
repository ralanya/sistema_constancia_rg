<?php include "Views/Templates/header.php"; ?>
<div class="card">
    <div class="card-header bg-dark text-white">
        Perfil de usuario
        <?php //print_r($data); ?>
    </div>
    <div class="card-body">
        <form id="frmPerfil">
            <div class="row">
            <div class="col-md-6">
                    <div class="form-group">
                        <input id="id" class="form-control" type="hidden" name="id" value="<?php echo $data['id']; ?>">
                        <input id="claveoculta" class="form-control" type="hidden" name="claveoculta" value="<?php echo $data['clave']; ?>">
                        <label for="nombre">Usuario</label>
                        <input id="usuario" class="form-control" type="text" name="usuario" placeholder="Usuario" value="<?php echo $data['usuario']; ?>" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="rol">Rol</label>
                        <input id="rol" class="form-control" type="text" name="rol" placeholder="Rol" value="<?php echo $data['nombre']; ?>" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="apellidos">Apellidos (*)</label>
                        <input id="apellidos" class="form-control" type="text" name="apellidos" placeholder="Apellidos" value="<?php echo $data['apellidos']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nombres">Nombres (*)</label>
                        <input id="nombres" class="form-control" type="text" name="nombres" placeholder="Nombres" value="<?php echo $data['nombres']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="clave">Contraseña nueva</label>
                        <input id="clave" class="form-control" type="password" name="clave" placeholder="Contraseña" value="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="repitaclave">Confirme contraseña</label>
                        <input id="repitaclave" class="form-control" type="password" name="repitaclave" placeholder="Repita contraseña" value="">
                    </div>
                </div>                
            </div>  
            <button class="btn btn-primary" type="button" onclick="modificarPerfil(event)">Modificar</button>
        </form>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>