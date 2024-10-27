<?php
class Constancias extends Controller
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
        $data = $this->model->getDocumentos();
        $this->views->getView($this, "index",$data);
    }    
    public function listar()
    {
        $id_rol = $_SESSION['id_rol'];
        $data = $this->model->getConstancias();
        for ($i=0; $i < count($data); $i++) {  
            $data[$i]['imagen'] = '<img class="img-thumbnail" src="'.base_url."Assets/documentos/images/".$data[$i]['imagen'].'">';           
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';                
                if($id_rol == 1){
                    $data[$i]['acciones'] = '<div> 
                    <button class="btn btn-warning p-1 center-block" type="button" onclick="btnDetalleCons('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    <button class="btn btn-primary p-1" type="button" onclick="btnEditarCons('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger p-1" type="button" onclick="btnEliminarCons('.$data[$i]['id'].');" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                    </div>';
                }else if($id_rol == 2){
                    $data[$i]['acciones'] = '<div> 
                    <button class="btn btn-warning p-1 center-block" type="button" onclick="btnDetalleCons('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    <button class="btn btn-primary p-1" type="button" onclick="btnEditarCons('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>
                    </div>';
                }else{
                    $data[$i]['acciones'] = '<div> 
                    <button class="btn btn-warning p-1" type="button" onclick="btnDetalleCons('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    </div>';
                }             
            }else{
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                if($id_rol == 1){
                    $data[$i]['acciones'] = '<div>
                    <button class="btn btn-warning p-1" type="button" onclick="btnDetalleCons('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    <button class="btn btn-success p-1" type="button" onclick="btnReingresarCons('.$data[$i]['id'].');" title="Reingresar"><i class="fas fa-sign-in-alt"></i></button>
                    </div>';
                }else{
                    $data[$i]['acciones'] = '<div>
                    <button class="btn btn-warning p-1" type="button" onclick="btnDetalleCons('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    </div>';
                }
            }                      
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {              
        $nombre = $_POST['txtnombre'];
        $horas = $_POST['txthoras'];

        
        $fecha_inicio = $_POST['txtfechainicio'];
        $fecha_fin = $_POST['txtfechafin'];
        $descripcion = $_POST['txtdescripcion'];
        $id_documento = $_POST['cbodocumento'];
        $id = $_POST['txtid'];
        $img = $_FILES['imagen'];
        $name = $img['name'];
        $tmpname = $img['tmp_name'];
        
        if(empty($horas)){
            $horas = 0;
        }

        $fecha = date("YmdHis");
        if (empty($nombre) || $id_documento == "NA") {
            $msg = array('msg' => '(*) Los campos son obligatorios', 'icono' => 'warning');
        }else{    
            if (!empty($name)) {
                $imgNombre = $fecha.".png";
                $destino = "Assets/documentos/images/".$imgNombre;
            }else if(!empty($_POST['foto-actual']) && empty($name)){
                $imgNombre = $_POST['foto-actual'];
            }else{
                $imgNombre = "default.png";
            }      
            if ($id == "") {
                $data = $this->model->registrarConstancia($nombre, $imgNombre, $descripcion, $horas, $fecha_inicio, $fecha_fin, $id_documento);
                if ($data == "ok") {
                    if (!empty($name)) {
                        move_uploaded_file($tmpname, $destino);
                    }
                    $msg = array('msg' => 'Constancia registrado con éxito', 'icono' => 'success');                    
                }else if($data == "existe"){
                    $msg = array('msg' => 'La constancia ya existe', 'icono' => 'warning');
                }else{
                    $msg = array('msg' => 'Error al guardar', 'icono' => 'error');
                }                                
            }else{
                $imgDelete = $this->model->editarCons($id);
                $imgCompara = $_POST["foto-actual"];
                
                if ($imgDelete['imagen'] != 'default.png') {
                    if($imgDelete['imagen'] != $imgCompara){
                        if (file_exists("Assets/documentos/images/".$imgDelete['imagen'])) {
                            unlink("Assets/documentos/images/".$imgDelete['imagen']);
                        }
                    }else{

                    }
                    
                }
                $data = $this->model->modificarConstancia($nombre, $imgNombre, $descripcion, $horas, $fecha_inicio, $fecha_fin, $id_documento, $id);
                if ($data == "modificado") {
                    if (!empty($name)) {
                        move_uploaded_file($tmpname, $destino);
                    }
                    $msg = array('msg' => 'Constancia modificada con éxito', 'icono' => 'success'); 
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
        $data = $this->model->editarCons($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionCons(0,$id);
        if ($data == 1) {
            $msg = array('msg' => 'Constancia eliminado con éxito', 'icono' => 'success');
        }else{
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id)
    {
        $data = $this->model->accionCons(1,$id);
        if ($data == 1) {
            $msg = array('msg' => 'Personal reingresado con éxito', 'icono' => 'success');
        }else{
            $msg = array('msg' => 'Error al reingresar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    } 
    public function generarPDF()
    {
        $empresa = $this->model->getEmpresa();
        $constancias = $this->model->getConstancias();
        
        require('Libraries/fpdf/fpdf.php');
        $pdf = new FPDF('L','mm','A4');
        $pdf->AddPage();
        $pdf->SetMargins(5, 0, 0);
        $pdf->SetTitle('Reporte Constancias');
        $pdf->SetFont('Arial','B',16);
        $pdf->Image(base_url.'Assets/img/logo/'.$empresa['logo'], 260, 5, 14, 15);
        $pdf->Cell(280,10,'REPORTE CONSTANCIAS DE LA '.utf8_decode($empresa['nombre']), 0, 1, 'C');
        
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(58, 5, utf8_decode('Fecha y hora de impresión: '), 0, 0, 'L');
        $pdf->SetFont('Arial','',12);
        date_default_timezone_set('America/Lima'); 
        $DateAndTime = date('m/d/Y h:i:s a', time()); 
        $pdf->Cell(5, 5, $DateAndTime, 0, 1, 'L');    
               
        //Encabezado de personal
        $pdf->SetFont('Arial','',12);
        $pdf->SetFillColor(0,0,0);
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(160,5, 'NOMBRE', 0, 0, 'L', true);
        $pdf->Cell(60,5, 'IMAGEN', 0, 0, 'L', true);
        $pdf->Cell(65,5, 'DOCUMENTO', 0, 1, 'L', true);        
        
        $pdf->SetTextColor(0,0,0);
        foreach ($constancias as $row) {
            $pdf->Cell(160,5, utf8_decode($row['nombre']), 0, 0, 'L');
            $pdf->Cell(60,5, $row['imagen'], 0, 0, 'L');
            $pdf->Cell(65,5, utf8_decode($row['nombre_documento']), 0, 1, 'L');         
        }
        $pdf->Output();
    } 
}
?>