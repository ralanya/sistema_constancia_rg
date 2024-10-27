<?php
class AdministracionModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    
    //DATOS EMPRESA
    public function getEmpresa()
    {
        $sql = "SELECT * FROM configuracion";
        $data = $this->select($sql);
        return $data;
    }
    public function modificar(string $ruc, string $nombre, string $telefono, string $direccion, string $mensaje, string $img, int $id)
    {
        $sql = "UPDATE configuracion SET ruc = ?, nombre = ?, telefono = ?, direccion = ?, mensaje = ?, logo = ? WHERE id = ?";
        $datos = array($ruc,$nombre,$telefono,$direccion,$mensaje,$img,$id);
        $data = $this->save($sql,$datos);
        if ($data == 1) {
            $res = "ok";
        }else{
            $res = "error";
        }
        return $res;
    }
}
?>