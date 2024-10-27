<?php
class Usuarios extends Controller{
    public function __construct() {
        session_start();        
        parent::__construct();
    }
    public function index() 
    {
        if(empty($_SESSION['activoadmin'])){
            header("location: ".base_url);
        }
        else if($_SESSION['id_rol'] == 1){
            $data['roles'] = $this->model->getRoles();
            $this->views->getView($this, "index", $data);
        }else{
            header("location: ".base_url."Dashboard");
        }
    }

    public function listar()
    {
        $data = $this->model->getUsuarios();
        for ($i=0; $i < count($data); $i++) { 
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarUser('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarUser('.$data[$i]['id'].');" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                </div>';
            }else{
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarUser('.$data[$i]['id'].');" title="Reingresar"><i class="fas fa-sign-in-alt"></i></button>
                </div>';
            }
            
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function validar()
    {
        if (empty($_POST['txtusuario']) || empty($_POST['txtpassword'])) {
            $msg = "Los campos están vacios";
        }
        else{
            $usuario = $_POST['txtusuario'];
            $password = $_POST['txtpassword'];
            $hash = hash("SHA256",$password);
            $data = $this->model->getUsuario($usuario,$hash);
            $dataempresa = $this->model->getEmpresa();
            if($data){
                $_SESSION['id_usuario'] = $data['id'];
                $_SESSION['usuario'] = $data['usuario'];
                $_SESSION['nombre'] = $data['nombres'];
                $_SESSION['id_rol'] = $data['id_rol'];
                $_SESSION['nombre_rol'] = $data['nombre'];
                $_SESSION['logo'] = $dataempresa['logo'];
                $_SESSION['institucion'] = $dataempresa['nombre'];
                $_SESSION['activoadmin'] = true;
                $msg = "ok";
            }else{
                $msg = "Usuario o contraseña incorrecta";
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $usuario = $_POST['txtusuario'];
        $apellido = $_POST['txtapellido'];
        $nombre = $_POST['txtnombre'];
        $password = $_POST['txtclave'];
        $confirmar = $_POST['txtconfirmar'];
        $rol = $_POST['cborol'];
        $id = $_POST['txtid'];
        $hash = hash("SHA256", $password);
        if (empty($usuario) || empty($apellido) || empty($nombre) || empty($rol)) {
            $msg = "Todos los campos son obligatorios";
        }else{
            if ($id == "") {
                if($password != $confirmar){
                    $msg = "Las contraseñas no coinciden";
                }else{
                    $data = $this->model->registrarUsuario($usuario,$apellido,$nombre,$hash,$rol);
                    if ($data == "ok") {
                        $msg = "si";
                    }else if($data == "existe"){
                        $msg = "El usuario ya existe";
                    }else{
                        $msg = "Error al guardar";
                    }
                }                
            }else{
                $data = $this->model->modificarUsuario($usuario,$apellido,$nombre,$rol,$id);
                if ($data == "modificado") {
                    $msg = "modificado";
                }else{
                    $msg = "Error al actualizar";
                }
            }            
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar(int $id)
    {
        $data = $this->model->editarUser($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionUser(0,$id);
        if ($data == 1) {
            $msg = "ok";
        }else{
            $msg = "Error al eliminar";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresar(int $id)
    {
        $data = $this->model->accionUser(1,$id);
        if ($data == 1) {
            $msg = "ok";
        }else{
            $msg = "Error al reingresar";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function salir()
    {
        //session_destroy();
        unset( $_SESSION["activoadmin"]);  
        header("location:../Usuarios/login");
    }

    public function perfil()
    {
        $id_usuario = $_SESSION["id_usuario"];
        $data = $this->model->getPerfilUsuario($id_usuario);   
        $this->views->getView($this, "perfil", $data);
    }
    public function modificaPerfil()
    {
        $apellidos = $_POST['apellidos'];
        $nombres = $_POST['nombres'];
        $password = $_POST['clave'];
        $claveoculta = $_POST['claveoculta'];
        $confirmar = $_POST['repitaclave'];
        
        $id = $_POST['id'];
        
        if (empty($apellidos) || empty($nombres)) {
            $msg = "(*) Campos obligatorios";
        }
        else{
            if(empty($password)){
                $hash=$claveoculta;
                $data = $this->model->modificarPerfil($apellidos,$nombres,$hash,$id);
                if($data == 'ok'){
                    $msg = 'ok';
                }else{
                    $msg = 'error';
                }
            }
            else{
                if(empty($confirmar)){
                    $msg = "Confirme la contraseña";
                }
                else if($password != $confirmar){
                    $msg = "Las contraseñas no coinciden";
                }
                else{
                    $hash = hash("SHA256", $password);
                    $data = $this->model->modificarPerfil($apellidos,$nombres,$hash,$id);
                    if($data == 'ok'){
                        $msg = 'ok';
                    }else{
                        $msg = 'error';
                    } 
                }
            }                          
        }
        echo json_encode($msg);
        die();
    }

    public function login()
    {
        //$id_usuario = $_SESSION["id_usuario"];
        //$data = $this->model->getPerfilUsuario($id_usuario);   
        $this->views->getView($this, "login");
    }
}
?>
