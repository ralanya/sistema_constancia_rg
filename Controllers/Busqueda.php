<?php
class Busqueda extends Controller
{
    public function __construct() {
        session_start();        
        parent::__construct();
    }
    public function index() 
    {     
        if(empty($_SESSION['activobusqueda'])){
            header("location: ".base_url);
        }   
        $data = $this->model->getDocumentoContancias();
        $this->views->getView($this, "index", $data);
    }    

    public function validar()
    {
        if (empty($_POST['rdopcion'])) {
            $msg = "Seleccione una opción";
        }
        else if ($_POST['rdopcion'] == "TD" && $_POST['cbodocumento'] == "NA") {
            $msg = "Seleccione una tipo de documento";
        }
        else{
            $busqueda = $_POST['txtBusqueda'];   
            $documento = $_POST['cbodocumento'];   
            $opcion = $_POST['rdopcion'];

            if($opcion == "CC"){
                $codigo = $this->model->buscarCodigo($busqueda);  
                if($codigo){
                    $documento = $codigo['documento'];
                    $busqueda = $codigo['numero'];  
                    $cod = $codigo['codigo'];  
                }else{
                    $msg = "Lo sentimos, no hay resultados";
                }    
            }

            //buscando tabla
            $verificaEst = $this->model->buscarEstudiante($documento,$busqueda);
            $verificaPersl = $this->model->buscarPersonal($documento,$busqueda);
            $verificaPerso = $this->model->buscarPersona($documento,$busqueda);
            $verificaFam = $this->model->buscarFamilia($documento,$busqueda);
            if($verificaEst){
                $tabla = "estudiantes";
            }else if ($verificaPersl){
                $tabla = "personales";
            }else if ($verificaPerso){
                $tabla = "personas";
            }else if ($verificaFam){
                $tabla = "familias";
            }     

            //buscando constancia
            if(!empty($tabla)){
                if($opcion == "TD"){                
                    $data = $this->model->getConstanciaDocumento($tabla,$documento,$busqueda);
                }
                else if($opcion == "CC"){
                    $data = $this->model->getConstanciaCodigo($tabla,$cod);
                } 
                else{
                    $data = "";
                }
            }else{
                $msg = "Lo sentimos, no hay resultados";
            }    
            //retornando datos
            if(!empty($data)){
                $_SESSION['documento'] = $data['documento'];
                $_SESSION['numero'] = $data['numero'];
                $_SESSION['codigo'] = $data['codigo'];
               
                $_SESSION['opcion'] = $opcion;
                $_SESSION['nombres'] = $data['nombres'];
                $_SESSION['activobusqueda'] = true;
                $msg = "ok";
            }else{
                $msg = "Lo sentimos, no hay resultados";
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function salir()
    {
        unset( $_SESSION["activobusqueda"]);  
        header("location:./");
    }

    public function listados()
    {        
        $opcion = $_SESSION['opcion'];
        if($opcion == "TD"){
            $busqueda = $_SESSION['numero'];
            $data = $this->model->getEmisionesDocumento($busqueda); 
        }
        else{
            $busqueda = $_SESSION['codigo'];
            $data = $this->model->getEmisionesCodigo($busqueda); 
        }
        
        for ($i=0; $i < count($data); $i++) { 
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';  
                    $data[$i]['acciones'] = '<center><div> 
                    <button class="btn btn-primary p-1 center-block" type="button" onclick="btnDescargaCons('.$data[$i]['id'].');" title="Descargar"><i class="fas fa-download"></i></button>  
                    <button class="btn btn-success p-1 center-block" type="button" onclick="btnDetalleCons('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>                  
                    </div></center>';                             
            }else{
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';                
            }             
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function detalle(int $id)
    {
        $data = $this->model->detalleCons($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function generarPDF($url)
    {
        if(strlen($url) >= 20){
            list($codigo,$archivo,$id) = explode("-",$url);
            $constancia = $this->model->detalleCons($id);
            $this->model->actualizaVista($id);
            if($archivo == "GEN"){                
                $situacion = $constancia['situacion'];
                $documento = $constancia['documento'];
                $numero = $constancia['numero'];
                if($situacion == "E"){
                    $datos = $this->model->buscarEstudiante($documento,$numero);
                    $apenom = $datos['apellido_paterno']." ".$datos['apellido_materno'].", ".$datos["nombres"];
                }
                else if($situacion == "P"){
                    $datos = $this->model->buscarPersonal($documento,$numero);
                    $apenom = $datos['apellidos'].", ".$datos["nombres"];
                }
                else if($situacion == "PE"){
                    $datos = $this->model->buscarPersona($documento,$numero);
                    $apenom = $datos['apellidos'].", ".$datos["nombres"];
                }
                else if($situacion == "FA"){
                    $datos = $this->model->buscarFamilia($documento,$numero);
                    $apenom = $datos['apellidos'].", ".$datos["nombres"];
                }
        
                $puesto = $constancia["puesto"];
                if(!empty($puesto)){
                    if($puesto == 1){
                        $puesto = "PRIMER PUESTO";
                    }else if ($puesto == 2){
                        $puesto = "SEGUNDO PUESTO";
                    }else{
                        $puesto = "TERCER PUESTO";
                    }            
                }else{
                    $puesto = "";
                }
                require('Libraries/fpdf/fpdf.php');
                $pdf=new FPDF('L', 'mm', 'A4'); 
                $pdf->AddPage('L', 'A4');
                $pdf->Image(base_url.'Assets/documentos/images/'.$constancia["imagen"],-5,0,302);
                //$pdf->SetMargins(5, 0, 0);
                $pdf->SetTitle('Constancia-'.$constancia["codigo"]);
                $pdf->SetFont('Arial','B',16);
                $pdf->Cell(450,90,utf8_decode('Código: '.$constancia['codigo']), 0, 1, 'C');
                $pdf->SetFont('Arial','B',20);
                $pdf->Cell(355,-45,utf8_decode($apenom), 0, 1, 'C');
                $pdf->SetFont('Arial','B',18);
                $pdf->Cell(410,118,$puesto, 0, 1, 'C'); 
                
                //Agregamos la libreria para genera códigos QR
                require 'Libraries/phpqrcode/qrlib.php';    
                
                //Declaramos una carpeta temporal para guardar la imagenes generadas
                $dir = 'temp/';    
                
                //Si no existe la carpeta la creamos
                if (!file_exists($dir))
                mkdir($dir);

                //Declaramos la ruta y nombre del archivo a generar
                $filename = $dir.'test.png';

                //Parametros de Condiguración
                $tamanio = 3; //Tamaño de Pixel
                $level = 'H'; //Precisión Baja
                $framSize = 1; //Tamaño en blanco
                $contenido = "CODIGO: ".$constancia["codigo"]."\n"."APELLIDOS Y NOMBRES: ".utf8_decode($apenom); //Texto

                //Enviamos los parametros a la Función para generar código QR 
                QRcode::png($contenido, $filename, $level, $tamanio, $framSize); 

                //Mostramos la imagen generada
                $pdf->Image($dir.basename($filename),8,165);
                //echo '<img src="'.$dir.basename($filename).'" /><hr/>'; 

                $modo="I";
                $pdf->Output('Constancia-'.$constancia["codigo"],$modo);
            }
            else if($archivo == "PDF"){
                $enlace = $constancia['url'];
                header("Content-type: application/pdf");
                header("Content-Disposition: inline; filename=Constancia-".$constancia["codigo"]);
                readfile(base_url."/Assets/documentos/PDF/".$enlace);
            }
        }        
        else{
            
        }
        
    }
}
?>