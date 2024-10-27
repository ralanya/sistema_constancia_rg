<?php
class Excel extends Controller
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
    public function registrarCons()
    {        
        if(is_array($_FILES['file-constancia']) && count($_FILES['file-constancia']) > 0){
            //llamamos a la libreria
            require_once 'Assets\PHPExcel\Classes\PHPExcel.php';
            $excel = $_FILES['file-constancia'];
            $name = $excel['name'];
            $tmpname = $excel['tmp_name'];
            //crear el excel
            $leerexcel = PHPExcel_IOFactory::createReaderForFile($tmpname);

            //cargar excel
            $excelobj = $leerexcel->load($tmpname);

            //cargar en que hoja
            $hoja = $excelobj->getSheet(0);
            $filas = $hoja->getHighestRow();
            $contador1 = 0;
            $contador2 = 0;
            $contador3 = 0;
            $contador4 = 0;
            for($row = 2; $row<=$filas;$row++){
                $nombre = trim($hoja->getCell('A'.$row)->getValue());                
                $descripcion = trim($hoja->getCell('B'.$row)->getValue());
                $horas = trim($hoja->getCell('C'.$row)->getValue());
                $fecha_inicio = trim($hoja->getCell('D'.$row)->getValue());
                $fecha_fin = trim($hoja->getCell('E'.$row)->getValue());
                $id_documento = trim($hoja->getCell('F'.$row)->getValue());               
                
                if(empty($nombre) || empty($id_documento)){
                    $contador3++;
                }else{
                    if(!empty($fecha_inicio)){
                        $timestamp1 = PHPExcel_Shared_Date::ExcelToPHP($fecha_inicio);
                        $fecha_formato_1 = date("Y-m-d",$timestamp1);
                    }else{
                        $fecha_formato_1 = "";
                    }
    
                    if(!empty($fecha_fin)){
                        $timestamp2 = PHPExcel_Shared_Date::ExcelToPHP($fecha_fin);
                        $fecha_formato_2 = date("Y-m-d",$timestamp2);  
                    }else{
                        $fecha_formato_2 = "";
                    }
                    
                    if($horas == ""){
                        $horas = 0;
                    }
                     
                    $verifica1 = $this->model->getConstancia($id_documento);
    
                    if($verifica1){
                        $data = $this->model->RegistrarConstancia($nombre,$descripcion,$horas,$fecha_formato_1,$fecha_formato_2,$id_documento);
                        if($data == 1){
                            $contador1++;
                        }
                        else if($data == 2){
                            $contador2++;
                        }                                 
                    }                
                    else{
                        $contador4++;                    
                    }
                }                              
            }   
            $total_error = $contador3 + $contador4;
            $msg = $contador1.",".$contador2.",".$contador3;
        }          
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();  
    }
    public function registrarEmi()
    {
        if(is_array($_FILES['file-emision']) && count($_FILES['file-emision']) > 0){
            //llamamos a la libreria
            require_once 'Assets\PHPExcel\Classes\PHPExcel.php';
            $excel = $_FILES['file-emision'];
            $name = $excel['name'];
            $tmpname = $excel['tmp_name'];
            //crear el excel
            $leerexcel = PHPExcel_IOFactory::createReaderForFile($tmpname);

            //cargar excel
            $excelobj = $leerexcel->load($tmpname);

            //cargar en que hoja
            $hoja = $excelobj->getSheet(0);
            $filas = $hoja->getHighestRow();
            $contador1 = 0;
            $contador2 = 0;
            $contador3 = 0;
            $contador4 = 0;
            $contador5 = 0;

            for($row = 2; $row<=$filas;$row++){
                $fecha = trim($hoja->getCell('A'.$row)->getValue());  
                $archivo = trim($hoja->getCell('B'.$row)->getValue());
                $puesto = trim($hoja->getCell('C'.$row)->getValue());
                $nota = trim($hoja->getCell('D'.$row)->getValue());
                $documento = trim($hoja->getCell('E'.$row)->getValue());
                $numero = trim($hoja->getCell('F'.$row)->getValue());     
                $id_constancia = trim($hoja->getCell('G'.$row)->getValue());

                if(empty($fecha) || empty($archivo) || empty($documento) || empty($numero) || empty($id_constancia)){
                    $contador3++;
                }
                else{                    
                    if(strlen($numero) <= "20"){  
                        $verifica1 = $this->model->buscarPersona("estudiantes",$documento,$numero);
                        $verifica2 = $this->model->buscarPersona("personales",$documento,$numero);
                        $verifica3 = $this->model->buscarPersona("personas",$documento,$numero);
                        $verifica4 = $this->model->buscarPersona("familias",$documento,$numero);   
                                                           
                        if($verifica1 || $verifica2 || $verifica3 || $verifica4){
                            $timestamp = PHPExcel_Shared_Date::ExcelToPHP($fecha);
                            $fecha_formato = date("Y-m-d",$timestamp); 

                            if($verifica1){ $situacion = "E"; } else if($verifica2){ $situacion = "P";}
                            else if($verifica3){ $situacion = "PE";} else if($verifica4){ $situacion = "FA";}

                            if($puesto == ""){ $puesto = 0; }
                            if($nota == ""){ $nota = 0; }

                            list($anio,$mes,$dia) = explode("-",$fecha_formato);
                            $codigo = $anio.$mes.$dia.$numero;

                            $data = $this->model->RegistrarEmision($codigo,$fecha_formato,$archivo,$puesto,$nota,$documento,$numero,$situacion,$id_constancia);
                            if($data == 1){
                                $contador1++;
                            }
                            else if($data == 2){
                                $contador2++;
                            }
                        }                        
                        else{
                            $contador4++;
                        }                       
                    }                
                    else{
                        $contador5++;                    
                    }
                }                                                 
            }              
            $total_error = $contador3 + $contador4 + $contador5;
            $msg = $contador1.",".$contador2.",".$total_error;
        }          
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();  
    }   
}
?>