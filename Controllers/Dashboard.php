<?php
class Dashboard extends Controller{
    public function __construct() {
        session_start();        
        parent::__construct();
    }
    public function index() 
    {     
        if(empty($_SESSION['activoadmin'])){
            header("location: ".base_url);
        }   
        $data['Emisiones'] = $this->model->getTotales('emision_constancias');
        $data['Constancias'] = $this->model->getTotales('constancias');
        $data['Usuarios'] = $this->model->getTotales('usuarios');
        $data['Descargas'] = $this->model->getTotalDescargas();
        $data['RankingConstancias'] = $this->model->getRankingConstancias();
        $this->views->getView($this, "index", $data);
    }

    //GRAFICO
    public function reporteArchivoConstancia()
    {
        $data = $this->model->getArchivoConstancia();
        echo json_encode($data);
        die();
    }
}