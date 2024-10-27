<?php
class Administracion extends Controller{
    public function __construct() {
        session_start();        
        parent::__construct();
    }
    public function index() 
    {       
        if(empty($_SESSION['activoadmin'])){
            header("location: ".base_url);
        } 
        $data = $this->model->getEmpresa();   
        $this->views->getView($this, "index", $data);
    }
    public function modificar()
    {
        $ruc = $_POST['ruc'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $mensaje = $_POST['mensaje'];
        $id = $_POST['id'];

        $img = $_FILES['imagen'];
        $name = $img['name'];
        $tmpname = $img['tmp_name'];
        $fecha = date("YmdHis");
        if (empty($ruc) || empty($nombre)) {
            $msg = "(*) Campos obligatorios";
        }else{
            if (!empty($name)) {
                $imgNombre = $fecha.".jpg";
                $destino = "Assets/img/logo/".$imgNombre;
            }else if(!empty($_POST['foto-actual']) && empty($name)){
                $imgNombre = $_POST['foto-actual'];
            }else{
                $imgNombre = "default.png";
            }
            $data = $this->model->modificar($ruc,$nombre,$telefono,$direccion,$mensaje,$imgNombre,$id);
            $dataempresa = $this->model->getEmpresa();
            $_SESSION['logo'] = $dataempresa['logo'];
            $_SESSION['institucion'] = $dataempresa['nombre'];
            if($data == 'ok'){
                if (!empty($name)) {
                    move_uploaded_file($tmpname, $destino);
                }
                $msg = 'ok';
            }else{
                $msg = 'error';
            }
        }
        echo json_encode($msg);
        die();
    }
}
?>