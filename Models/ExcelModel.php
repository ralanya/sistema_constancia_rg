<?php
class ExcelModel extends Query
{    
    public function __construct()
    {
        parent::__construct();
    }
    public function RegistrarConstancia(string $nombre, string $descripcion, int $horas, string $fecha_formato_1, string $fecha_formato_2, int $id_documento)
    {      
        $imagen = "default.png";
        $verificar = "SELECT * FROM constancias WHERE nombre = '$nombre'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO constancias(nombre,imagen,descripcion,horas,fecha_inicio,fecha_fin,id_documento) VALUES(?,?,?,?,?,?,?)";
            $datos = array($nombre,$imagen,$descripcion,$horas,$fecha_formato_1,$fecha_formato_2,$id_documento);
            $data = $this->save($sql,$datos);
            if ($data == 1) {
                $res = "1";
            }            
        }else{
            $sql = "UPDATE constancias SET imagen = ?, descripcion = ?, horas = ?, fecha_inicio = ?, fecha_fin = ?, id_documento = ? WHERE nombre = ?";
            $datos = array($imagen,$descripcion,$horas,$fecha_formato_1,$fecha_formato_2,$id_documento,$nombre);
            $data = $this->save($sql,$datos);
            if ($data == 1) {
                $res = "2";
            }          
        }
        return $res;
    }

    public function getConstancia(int $id_documento)
    {
        $sql = "SELECT * FROM documento_constancias WHERE id = '$id_documento'";
        $data = $this->select($sql);
        return $data;
    }  
    
    public function buscarPersona($tabla, $documento, $numero)
    {
        $sql = "SELECT * FROM $tabla WHERE documento = '$documento' AND numero = '$numero' AND estado = '1'";
        $data = $this->select($sql);
        return $data;
    }

    public function RegistrarEmision(string $codigo, string $fecha, string $archivo, int $puesto, int $nota, string $documento, string $numero, string $situacion,int $id_constancia)
    {    
        $verificar = "SELECT * FROM emision_constancias WHERE codigo = '$codigo'";
        $existe = $this->select($verificar);
        
        if (empty($existe)) {
            if($archivo != "GEN"){
                $url = "default.pdf";
            }else{
                $url = "";
            }
            
            $sql = "INSERT INTO emision_constancias(codigo,fecha,archivo,url,puesto,nota,documento,numero,situacion,id_constancia) VALUES(?,?,?,?,?,?,?,?,?,?)";
            $datos = array($codigo,$fecha,$archivo,$url,$puesto,$nota,$documento,$numero,$situacion,$id_constancia);
            $data = $this->save($sql,$datos);
            if ($data == 1) {
                $res = "1";
            }            
        }else{
            $sql = "UPDATE emision_constancias SET fecha = ?, archivo = ?, url = ?, puesto = ?, nota = ?, documento = ?, numero = ?, situacion = ?, id_constancia = ? WHERE codigo = ?";
            $datos = array($codigo,$fecha,$archivo,$url,$puesto,$nota,$documento,$numero,$situacion,$id_constancia);
            $data = $this->save($sql,$datos);
            if ($data == 1) {
                $res = "2";
            }          
        }
        return $res;
    }
}
?>