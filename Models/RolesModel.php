<?php
class RolesModel extends Query{
    private $nombre, $id, $estado;
    public function __construct()
    {
        parent::__construct();
    }    

    public function getRoles() 
    {
        $sql = "SELECT * FROM roles";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function registrarRol(string $nombre)
    {        
        $this->nombre = $nombre;        
        $verificar = "SELECT * FROM roles WHERE nombre = '$this->nombre'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO roles(nombre) VALUES(?)";
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

    public function modificarRol(string $nombre, int $id)
    {
        $this->nombre = $nombre;
        $this->id = $id;
        
        $sql = "UPDATE roles SET nombre = ? WHERE id = ?";
        $datos = array($this->nombre, $this->id);
        $data = $this->save($sql,$datos);
        if ($data == 1) {
            $res = "modificado";
        }else{
            $res = "error";
        }           
        return $res;
    }

    public function editarRo(int $id)
    {
        $sql = "SELECT * FROM roles WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionRo(int $estado, int $id)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE roles SET estado = ? WHERE id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql,$datos);
        return $data;
    }
}
?>