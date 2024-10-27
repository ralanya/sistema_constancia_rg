<?php
class Roles extends Controller{
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
            $this->views->getView($this, "index");
        }else{
            header("location: ".base_url."Dashboard");
        }        
    }

    public function listar()
    {
        $data = $this->model->getRoles();
        for ($i=0; $i < count($data); $i++) { 
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarRo('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarRo('.$data[$i]['id'].');" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                </div>';
            }else{
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarRo('.$data[$i]['id'].');" title="Reingresar"><i class="fas fa-sign-in-alt"></i></button>
                </div>';
            }
            
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {        
        $nombre = $_POST['txtnombre'];
        $id = $_POST['txtid'];
        
        if (empty($nombre)) {
            $msg = "Todos los campos son obligatorios";
        }else{
            if ($id == "") {
                $data = $this->model->registrarRol($nombre);
                if ($data == "ok") {
                    $msg = "si";
                }else if($data == "existe"){
                    $msg = "El rol ya existe";
                }else{
                    $msg = "Error al guardar";
                }                              
            }else{
                $data = $this->model->modificarRol($nombre,$id);
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
        $data = $this->model->editarRo($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionRo(0,$id);
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
        $data = $this->model->accionRo(1,$id);
        if ($data == 1) {
            $msg = "ok";
        }else{
            $msg = "Error al reingresar";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }    
}
?>
