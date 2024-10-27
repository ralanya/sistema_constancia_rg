<?php
class ConstanciasModel extends Query
{
    //private $documento, $numero, $apellidos, $nombres, $sexo, $fecha_nacimiento, $telefono, $correo, $especialidad, $id_cargo, $id, $estado;
    
    public function __construct()
    {
        parent::__construct();
    }

    public function getDocumentos() 
    {
        $sql = "SELECT * FROM documento_constancias WHERE estado = '1'";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getConstancias() 
    {
        $sql = "SELECT c.*, dc.nombre AS nombre_documento FROM constancias c INNER JOIN documento_constancias dc ON c.id_documento = dc.id WHERE c.estado = '1'";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function registrarConstancia(string $nombre, string $img, string $descripcion, int $horas, string $fecha_inicio, string $fecha_fin, int $id_documento)
    {        
        $verificar = "SELECT * FROM constancias WHERE nombre = '$nombre'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO constancias(nombre,imagen,descripcion,horas,fecha_inicio,fecha_fin,id_documento) VALUES(?,?,?,?,?,?,?)";
            $datos = array($nombre,$img,$descripcion,$horas,$fecha_inicio,$fecha_fin,$id_documento);
            $data = $this->save($sql,$datos);
            if ($data == 1) {
                $res = "ok";
            }else{
                $res = "error";
            }
        }else{
            $res = "existe";
        }   
        return $res;
    }

    public function modificarConstancia(string $nombre, string $img, string $descripcion, int $horas, string $fecha_inicio, string $fecha_fin, int $id_documento, int $id)
    {        
        $sql = "UPDATE constancias SET nombre = ?, imagen = ?, descripcion = ?, horas = ?, fecha_inicio = ?, fecha_fin = ?, id_documento = ? WHERE id = ?";
        $datos = array($nombre,$img,$descripcion,$horas,$fecha_inicio,$fecha_fin,$id_documento,$id);
        $data = $this->save($sql,$datos);
        if ($data == 1) {
            $res = "modificado";
        }else{
            $res = "error";
        }           
        return $res;
    }

    public function editarCons(int $id)
    {
        $sql = "SELECT * FROM constancias WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionCons(int $estado, int $id)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE constancias SET estado = ? WHERE id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql,$datos);
        return $data;
    }
    public function getEmpresa()
    {
        $sql = "SELECT * FROM configuracion";
        $data = $this->select($sql);
        return $data;
    }    
}
?>