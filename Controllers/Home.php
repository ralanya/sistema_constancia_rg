<?php
class Home extends Controller{
    public function __construct() {
        session_start();        
        parent::__construct();
    }
    public function index()
    {
        $this->views->getView($this, "index");
    }
    public function busqueda()
    {
        $this->views->getView($this, "busqueda");
    }
}
?>