<?php
class DocumentosModel extends Query{
    private $nombre, $id, $estado;
    public function __construct()
    {
        parent::__construct();
    }  

    public function getDocumentos() 
    {
        $sql = "SELECT * FROM documento_constancias";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function registrarDocumento(string $nombre)
    {        
        $this->nombre = $nombre;        
        $verificar = "SELECT * FROM documento_constancias WHERE nombre = '$this->nombre'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO documento_constancias(nombre) VALUES(?)";
            $datos = array($this->nombre);
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

    public function modificarDocumento(string $nombre, int $id)
    {
        $this->nombre = $nombre;
        $this->id = $id;
        
        $sql = "UPDATE documento_constancias SET nombre = ? WHERE id = ?";
        $datos = array($this->nombre, $this->id);
        $data = $this->save($sql,$datos);
        if ($data == 1) {
            $res = "modificado";
        }else{
            $res = "error";
        }           
        return $res;
    }

    public function editarDoc(int $id)
    {
        $sql = "SELECT * FROM documento_constancias WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionDoc(int $estado, int $id)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE documento_constancias SET estado = ? WHERE id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql,$datos);
        return $data;
    }
}
?>