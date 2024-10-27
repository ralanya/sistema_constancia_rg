<?php
class UsuariosModel extends Query{
    private $usuario, $apellido, $nombre, $clave, $id_rol, $id, $estado;
    public function __construct()
    {
        parent::__construct();
    }
    public function getUsuario(string $usuario, string $password) 
    {
        $sql = "SELECT u.*, r.nombre FROM usuarios u INNER JOIN roles r ON u.id_rol = r.id WHERE u.usuario = '$usuario' AND u.clave = '$password' AND u.estado = 1";
        $data = $this->select($sql);
        return $data;
    }
    public function getEmpresa()
    {
        $sql = "SELECT * FROM configuracion";
        $data = $this->select($sql);
        return $data;
    }
    public function getPerfilUsuario(int $id)
    {
        $sql = "SELECT u.*, r.nombre FROM usuarios u
                INNER JOIN roles r ON u.id_rol = r.id 
                WHERE u.id = '$id' AND u.estado = 1";
        $data = $this->select($sql);
        return $data;
    }
    public function modificarPerfil(string $apellidos, string $nombres, string $clave, int $id)
    {
        $sql = "UPDATE usuarios SET apellidos = ?, nombres = ?, clave = ? WHERE id = ?";
        $datos = array($apellidos,$nombres,$clave,$id);
        $data = $this->save($sql,$datos);
        if ($data == 1) {
            $res = "ok";
        }else{
            $res = "error";
        }
        return $res;
    }

    public function getRoles() 
    {
        $sql = "SELECT * FROM roles WHERE estado = '1'";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getUsuarios() 
    {
        $sql = "SELECT u.*, r.id as id_rol, r.nombre FROM usuarios u INNER JOIN roles r WHERE u.id_rol = r.id";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function registrarUsuario(string $usuario, string $apellido, string $nombre, string $clave, int $id_rol)
    {
        $this->usuario = $usuario;
        $this->apellido = $apellido;
        $this->nombre = $nombre;
        $this->clave = $clave;
        $this->id_rol = $id_rol;
        $verificar = "SELECT * FROM usuarios WHERE usuario = '$this->usuario'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO usuarios(usuario,apellidos,nombres,clave,id_rol) VALUES(?,?,?,?,?)";
            $datos = array($this->usuario, $this->apellido, $this->nombre, $this->clave, $this->id_rol);
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

    public function modificarUsuario(string $usuario, string $apellido, string $nombre, int $id_rol, int $id)
    {
        $this->usuario = $usuario;
        $this->apellido = $apellido;
        $this->nombre = $nombre;
        $this->id = $id;
        $this->id_rol = $id_rol;
        
        $sql = "UPDATE usuarios SET usuario = ?, apellidos = ?, nombres = ?, id_rol = ? WHERE id = ?";
        $datos = array($this->usuario, $this->apellido, $this->nombre, $this->id_rol, $this->id);
        $data = $this->save($sql,$datos);
        if ($data == 1) {
            $res = "modificado";
        }else{
            $res = "error";
        }           
        return $res;
    }

    public function editarUser(int $id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionUser(int $estado, int $id)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE usuarios SET estado = ? WHERE id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql,$datos);
        return $data;
    }
}
?>