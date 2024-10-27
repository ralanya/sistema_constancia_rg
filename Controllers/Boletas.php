<?php
class Boletas extends Controller
{
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
}
?>