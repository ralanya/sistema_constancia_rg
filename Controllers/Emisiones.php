<?php
class Emisiones extends Controller
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
        $data['constancias'] = $this->model->getConstancias(); 
        $data['documentos'] = $this->model->getDocumentos(); 
        $this->views->getView($this, "index",$data);
    }
    
    public function listar()
    {
        $id_rol = $_SESSION['id_rol'];
        $data = $this->model->getEmisiones();
        for ($i=0; $i < count($data); $i++) {             
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';                
                if($id_rol == 1){
                    $data[$i]['acciones'] = '<div> 
                    <button class="btn btn-warning p-1 center-block" type="button" onclick="btnDetalleEmi('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    <button class="btn btn-primary p-1" type="button" onclick="btnEditarEmi('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger p-1" type="button" onclick="btnEliminarEmi('.$data[$i]['id'].');" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                    </div>';
                }else if($id_rol == 2){
                    $data[$i]['acciones'] = '<div> 
                    <button class="btn btn-warning p-1 center-block" type="button" onclick="btnDetalleEmi('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    <button class="btn btn-primary p-1" type="button" onclick="btnEditarEmi('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>
                    </div>';
                }else{
                    $data[$i]['acciones'] = '<div> 
                    <button class="btn btn-warning p-1" type="button" onclick="btnDetalleEmi('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    </div>';
                }             
            }else{
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                if($id_rol == 1){
                    $data[$i]['acciones'] = '<div>
                    <button class="btn btn-warning p-1" type="button" onclick="btnDetalleEmi('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    <button class="btn btn-success p-1" type="button" onclick="btnReingresarEmi('.$data[$i]['id'].');" title="Reingresar"><i class="fas fa-sign-in-alt"></i></button>
                    </div>';
                }else{
                    $data[$i]['acciones'] = '<div>
                    <button class="btn btn-warning p-1" type="button" onclick="btnDetalleEmi('.$data[$i]['id'].');" title="Detalles"><i class="fas fa-eye"></i></button>          
                    </div>';
                }
            }             
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function buscaConstancia(int $id)
    {        
        $data = $this->model->searchConstancia($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function buscaRemitente()
    {     
        $documento = $_POST["cbodocumentopersona"];
        $numero = $_POST["txtnumero"];

        if($documento == "NA" || $numero == ""){
            $data = array('msg' => 'Campos obligatorios (*) ', 'icono' => 'warning');
        }else{
            $verifica1 = $this->model->buscarPersona("estudiantes",$documento,$numero);
            $verifica2 = $this->model->buscarPersona("personales",$documento,$numero);
            $verifica3 = $this->model->buscarPersona("personas",$documento,$numero);
            $verifica4 = $this->model->buscarPersona("familias",$documento,$numero);

            if($verifica1){
                $estudiante = $this->model->buscarPersona("estudiantes",$documento,$numero);
                $data = array('numero' => $estudiante["numero"],'apellidos' => $estudiante["apellido_paterno"]." ".$estudiante["apellido_materno"], 'nombres' => $estudiante["nombres"], 'sexo' => $estudiante["sexo"], 'situacion' => "E");
            }else if($verifica2){
                $personal = $this->model->buscarPersona("personales",$documento,$numero);
                $data = array('numero' => $personal["numero"],'apellidos' => $personal["apellidos"], 'nombres' => $personal["nombres"], 'sexo' => $personal["sexo"], 'situacion' => "P");
            }else if($verifica3){
                $persona = $this->model->buscarPersona("personas",$documento,$numero);
                $data = array('numero' => $persona["numero"],'apellidos' => $persona["apellidos"], 'nombres' => $persona["nombres"], 'sexo' => $persona["sexo"], 'situacion' => "PE");
            }else if($verifica4){
                $familia = $this->model->buscarPersona("familias",$documento,$numero);
                $data = array('numero' => $familia["numero"],'apellidos' => $familia["apellidos"], 'nombres' => $familia["nombres"], 'sexo' => $familia["sexo"], 'situacion' => "FA");
            }else{
                $data = array('msg' => 'No se encontro resultados', 'icono' => 'warning');
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {        
        //emision
        $id = $_POST['txtid']; 
        $fecha = $_POST['txtfecha'];
        $archivo = $_POST['cboarchivo'];
        $nota = $_POST['txtnota'];
        $puesto = $_POST['cbopuesto'];

        $img = $_FILES['imagen'];
        $name = $img['name'];
        $tmpname = $img['tmp_name'];
        $fecha_archivo = date("YmdHis");
        //constancia
        $id_constancia = $_POST['txtidconstancia'];
        //remitente
        $documentopersona = $_POST['cbodocumentopersona'];
        $numero = $_POST['txtnumero']; 
        $verificanumero = $_POST['txtverificanumero'];    
        $situacion = $_POST['txtsituacion'];   
        
        list($anio,$mes,$dia) = explode("-",$fecha);
        $codigo = $anio.$mes.$dia.$numero;

        $verifica1 = $this->model->buscarPersona("estudiantes",$documentopersona,$numero);
        $verifica2 = $this->model->buscarPersona("personales",$documentopersona,$numero);
        $verifica3 = $this->model->buscarPersona("personas",$documentopersona,$numero);
        $verifica4 = $this->model->buscarPersona("familias",$documentopersona,$numero);
        
        if($verifica1 && $verifica1["numero"] != $verificanumero){
            $msg = array('msg' => 'No ha buscado el remitente', 'icono' => 'warning');
        }else if($verifica2 && $verifica2["numero"] != $verificanumero){
            $msg = array('msg' => 'No ha buscado el remitente', 'icono' => 'warning');
        }else if($verifica3 && $verifica3["numero"] != $verificanumero){
            $msg = array('msg' => 'No ha buscado el remitente', 'icono' => 'warning');
        }else if($verifica4 && $verifica4["numero"] != $verificanumero){
            $msg = array('msg' => 'No ha buscado el remitente', 'icono' => 'warning');
        }else if(empty($verifica1) && empty($verifica2) && empty($verifica3) && empty($verifica4)){
            $msg = array('msg' => 'No ha buscado el remitente', 'icono' => 'warning');
        }        
        else{
            if (!empty($name)) {
                $imgNombre = $fecha_archivo.".pdf";
                $destino = "Assets/documentos/PDF/".$imgNombre;
            }else if(!empty($_POST['foto-actual']) && empty($name)){
                $imgNombre = $_POST['foto-actual'];
            }else{
                $imgNombre = "default.pdf";
            } 

            if ($id == "") {            
                $data = $this->model->registrarEmision($codigo, $fecha, $archivo, $imgNombre, $puesto, $nota, $documentopersona, $numero, $situacion, $id_constancia);
                                   
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
                $imgDelete = $this->model->editarEmi($id);
                $imgCompara = $_POST["foto-actual"];
                
                if ($imgDelete['url'] != 'default.pdf') {
                    if($imgDelete['url'] != $imgCompara){
                        if (file_exists("Assets/documentos/PDF/".$imgDelete['url'])) {
                            unlink("Assets/documentos/PDF/".$imgDelete['url']);
                        }
                    }else{

                    }                    
                }          
                $data = $this->model->modificarEmision($codigo, $fecha, $archivo, $imgNombre, $puesto, $nota, $documentopersona, $numero, $situacion, $id_constancia,$id);
                if ($data == "modificado") {
                    if (!empty($name)) {
                        move_uploaded_file($tmpname, $destino);
                    }
                    $msg = array('msg' => 'Constancia actualizado con éxito', 'icono' => 'success');
                }else if($data == "existe"){
                    $msg = array('msg' => 'La constancia ya existe', 'icono' => 'warning');
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
        $data = $this->model->editarEmi($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionEmi(0,$id);
        if ($data == 1) {
            $msg = array('msg' => 'Emisión eliminado con éxito', 'icono' => 'success');
        }else{
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresar(int $id)
    {
        $data = $this->model->accionEmi(1,$id);
        if ($data == 1) {
            $msg = array('msg' => 'Emisión reingresado con éxito', 'icono' => 'success');
        }else{
            $msg = array('msg' => 'Error al reingresar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }     
    
    //GENERAR PDF
    public function generarPDF()
    {
        $empresa = $this->model->getEmpresa();
        $emisiones = $this->model->getEmisiones();
        
        require('Libraries/fpdf/fpdf.php');
        $pdf = new FPDF('L','mm','A4');
        $pdf->AddPage();

        $pdf->SetMargins(5, 0, 0);
        $pdf->SetTitle('Reporte Emisiones');
        $pdf->SetFont('Arial','B',16);
        $pdf->Image(base_url.'Assets/img/logo/'.$empresa['logo'], 260, 5, 14, 15);
        $pdf->Cell(280,10,'REPORTE EMISIONES DE LA '.utf8_decode($empresa['nombre']), 0, 1, 'C');
        
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(58, 5, utf8_decode('Fecha y hora de impresión: '), 0, 0, 'L');
        $pdf->SetFont('Arial','',12);
        date_default_timezone_set('America/Lima'); 
        $DateAndTime = date('m/d/Y h:i:s a', time()); 
        $pdf->Cell(5, 5, $DateAndTime, 0, 1, 'L');    
               
        //Encabezado de personal
        $pdf->SetFillColor(0,0,0);
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(40,5, utf8_decode('CÓDIGO'), 0, 0, 'L', true);
        $pdf->Cell(25,5, 'FECHA', 0, 0, 'L', true);
        $pdf->Cell(30,5, 'DOCUMENTO', 0, 0, 'L', true);
        $pdf->Cell(30,5, utf8_decode('NÚMERO'), 0, 0, 'L', true);
        $pdf->Cell(160,5, 'CONSTANCIA', 0, 1, 'L', true);
        
        $pdf->SetTextColor(0,0,0);
        foreach ($emisiones as $row) {
            $pdf->Cell(40,5, $row['codigo'], 0, 0, 'L');
            $pdf->Cell(25,5, $row['FEmision'], 0, 0, 'L');
            $pdf->Cell(30,5, $row['documento'], 0, 0, 'L');
            $pdf->Cell(30,5, $row['numero'], 0, 0, 'L');
            $pdf->Cell(160,5, utf8_decode($row['nombre']), 0, 1, 'L');         
        }

        $pdf->Output();
    } 
}
?>