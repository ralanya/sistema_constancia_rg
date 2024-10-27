<?php
class Documentos extends Controller{
    public function __construct() {
        session_start();        
        parent::__construct();
    }
    public function index() 
    {     
        if(empty($_SESSION['activoadmin'])){
            header("location: ".base_url);
        }   
        $this->views->getView($this, "index");
    }

    public function listar()
    {
        $id_rol = $_SESSION['id_rol'];
        $data = $this->model->getDocumentos();
        for ($i=0; $i < count($data); $i++) { 
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                if($id_rol == 1){
                    $data[$i]['acciones'] = '<div>
                    <button class="btn btn-primary" type="button" onclick="btnEditarDoc('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger" type="button" onclick="btnEliminarDoc('.$data[$i]['id'].');" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                    </div>';
                }else if($id_rol == 2){
                    $data[$i]['acciones'] = '<div>
                    <button class="btn btn-primary" type="button" onclick="btnEditarDoc('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>
                    </div>';
                }else{
                    $data[$i]['acciones'] = '<div>
                    No disponible
                    </div>';
                }
            }else{
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarDoc('.$data[$i]['id'].');" title="Reingresar"><i class="fas fa-sign-in-alt"></i></button>
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
            $msg = array('msg' => 'Todos los campos son obligatorios', 'icono' => 'warning');
        }else{
            if ($id == "") {
                $data = $this->model->registrarDocumento($nombre);
                if ($data == "ok") {
                    $msg = array('msg' => 'Documento registrado con éxito', 'icono' => 'success');
                }else if($data == "existe"){
                    $msg = array('msg' => 'El documento ya existe', 'icono' => 'warning');
                }else{
                    $msg = array('msg' => 'Error al guardar', 'icono' => 'error');
                }                              
            }else{
                $data = $this->model->modificarDocumento($nombre,$id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Documento actualizado con éxito', 'icono' => 'success');
                }else{
                    $msg = array('msg' => 'Error al actualizar', 'icono' => 'error');
                }
            }            
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar(int $id)
    {
        $data = $this->model->editarDoc($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionDoc(0,$id);
        if ($data == 1) {
            $msg = array('msg' => 'Documento eliminado con éxito', 'icono' => 'success');
        }else{
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresar(int $id)
    {
        $data = $this->model->accionDoc(1,$id);
        if ($data == 1) {
            $msg = array('msg' => 'Documento reingresado con éxito', 'icono' => 'success');
        }else{
            $msg = array('msg' => 'Error al reingresar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    } 
}
?>