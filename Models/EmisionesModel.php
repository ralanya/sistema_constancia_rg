<?php
class EmisionesModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getEmisiones() 
    {
        $sql = "SELECT ec.*, DATE_FORMAT(fecha, '%d%/%m%/%Y') AS FEmision, c.nombre FROM emision_constancias ec INNER JOIN constancias c ON ec.id_constancia = c.id AND ec.estado = '1'";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getConstancias() 
    {
        $sql = "SELECT * FROM constancias WHERE estado = '1'";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getDocumentos() 
    {
        $sql = "SELECT * FROM documento_constancias WHERE estado = '1'";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function searchConstancia($id) 
    {
        $sql = "SELECT * FROM constancias WHERE id = $id AND estado = '1'";
        $data = $this->select($sql);
        return $data;
    }

    public function buscarPersona($tabla, $documento, $numero)
    {
        $sql = "SELECT * FROM $tabla WHERE documento = '$documento' AND numero = '$numero' AND estado = '1'";
        $data = $this->select($sql);
        return $data;
    }

    public function getGrados() 
    {
        $sql = "SELECT DISTINCT grado FROM aulas WHERE estado = '1'";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getSecciones() 
    {
        $sql = "SELECT DISTINCT seccion FROM aulas WHERE estado = '1'";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function registrarEmision(string $codigo, string $fecha, string $archivo, string $imagen, string $puesto, string $nota, string $documento, string $numero, string $situacion, int $id_constancia)
    {        
        $verificar = "SELECT * FROM emision_constancias WHERE codigo = '$codigo'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO emision_constancias(codigo,fecha,archivo,url,puesto,nota,documento,numero,situacion,id_constancia) VALUES(?,?,?,?,?,?,?,?,?,?)";
            $datos = array($codigo,$fecha,$archivo,$imagen,$puesto,$nota,$documento,$numero,$situacion,$id_constancia);
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

    public function registrarPersona(string $documento, string $numero, string $apellidos, string $nombres, string $sexo, string $fecha_nacimiento, string $telefono, string $correo)
    {
        $verificar = "SELECT * FROM personas WHERE numero = '$numero'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO personas(documento,numero,apellidos,nombres,sexo,fecha_nacimiento,telefono,correo) VALUES(?,?,?,?,?,?,?,?)";
            $datos = array($documento,$numero,$apellidos, $nombres, $sexo, $fecha_nacimiento, $telefono, $correo);
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

    public function modificarEmision(string $codigo, string $fecha, string $archivo, string $imagen, string $puesto, string $nota, string $documento, string $numero, string $situacion, int $id_constancia, int $id)
    {       
        
        $sql = "UPDATE emision_constancias SET codigo = ?, fecha = ?, archivo = ?, url = ?, puesto = ?, nota = ?, documento = ?, numero = ?, situacion = ?, id_constancia = ? WHERE id = ?";
        $datos = array($codigo,$fecha,$archivo,$imagen,$puesto,$nota,$documento,$numero,$situacion,$id_constancia,$id);
        $data = $this->save($sql,$datos);
        if ($data == 1) {
            $res = "modificado";
        }else{
            $res = "error";
        }           
        return $res;
    }

    public function editarEmi(int $id)
    {
        $sql = "SELECT * FROM emision_constancias WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    
    public function accionEmi(int $estado, int $id)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE emision_constancias SET estado = ? WHERE id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql,$datos);
        return $data;
    }

    //matricula
    public function getEstuCod(string $numero)
    {
        $sql = "SELECT * FROM estudiantes WHERE numero = '$numero'";
        $data = $this->select($sql);
        return $data;
    }  
    public function getAulaCod(string $nivel, string $grado, string $seccion)
    {
        $sql = "SELECT * FROM aulas WHERE nivel = '$nivel' AND grado = '$grado' AND seccion = '$seccion'";
        $data = $this->select($sql);
        return $data;
    } 
    public function RegistrarMatricula(int $id_estudiante, int $id_aula)
    {      
        $this->id_estudiante = $id_estudiante;
        $this->id_aula = $id_aula;       

        $verificar = "SELECT * FROM matriculas WHERE id_estudiante = '$this->id_estudiante'";
        $existe = $this->select($verificar);
        
        if (empty($existe)) {
            $sql = "INSERT INTO matriculas(id_estudiante,id_aula) VALUES(?,?)";
            $datos = array($this->id_estudiante, $this->id_aula);
            $data = $this->save($sql,$datos);
            if ($data == 1) {
                $res = "1";
            }            
        }else{
            $sql = "UPDATE matriculas SET id_aula = ? WHERE id_estudiante = ?";
            $datos = array($this->id_aula, $this->id_estudiante);
            $data = $this->save($sql,$datos);
            if ($data == 1) {
                $res = "2";
            }          
        }
        return $res;
    }

    //familia
    public function RegistrarFamilia(string $documento, string $numero, string $apellidos, string $nombres, string $sexo, string $telefono, string $correo)
    {        
        $this->documento = $documento;
        $this->numero = $numero;
        $this->apellidos = $apellidos;
        $this->nombres = $nombres;
        $this->sexo = $sexo;
        $this->telefono = $telefono;
        $this->correo = $correo;     
        $verificar = "SELECT * FROM familias WHERE numero = '$this->numero'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO familias(documento,numero,apellidos,nombres,sexo,telefono,correo) VALUES(?,?,?,?,?,?,?)";
            $datos = array($this->documento, $this->numero, $this->apellidos, $this->nombres, $this->sexo, $this->telefono, $this->correo);
            $data = $this->save($sql,$datos);
            if ($data == 1) {
                $res = "1";
            }            
        }else{
            $sql = "UPDATE familias SET documento = ?, apellidos = ?, nombres = ?, sexo = ?, telefono = ?, correo = ? WHERE numero = ?";
            $datos = array($this->documento, $this->apellidos, $this->nombres, $this->sexo, $this->telefono, $this->correo, $this->numero);
            $data = $this->save($sql,$datos);
            if ($data == 1) {
                $res = "2";
            }          
        }
        return $res;
    }

    public function RegistrarDetalleFamilia(string $parentesco, int $id_estudiante, int $id_familia)
    {        
        $this->parentesco = $parentesco;
        $this->id_estudiante = $id_estudiante;
        $this->id_familia = $id_familia;  
        $verificar = "SELECT * FROM detalle_familias WHERE id_familia = '$this->id_familia'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO detalle_familias(parentesco,id_estudiante,id_familia) VALUES(?,?,?)";
            $datos = array($this->parentesco, $this->id_estudiante, $this->id_familia);
            $data = $this->save($sql,$datos);
            if ($data == 1) {
                $res = "1";
            }            
        }else{
            $sql = "UPDATE detalle_familias SET parentesco = ?, id_estudiante = ? WHERE id_familia = ?";
            $datos = array($this->parentesco, $this->id_estudiante, $this->id_familia);
            $data = $this->save($sql,$datos);
            if ($data == 1) {
                $res = "2";
            }          
        }
        return $res;
    }

    public function getFamCod(string $numero)
    {
        $sql = "SELECT * FROM familias WHERE numero = '$numero'";
        $data = $this->select($sql);
        return $data;
    }     
    
    //COMBOX
    public function seachGrados(string $nivel)
    {
        $sql = "SELECT id, grado FROM aulas WHERE nivel = '$nivel' GROUP BY grado ORDER BY id asc";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function seachSecciones(string $nivel, string $grado)
    {
        $sql = "SELECT id, seccion FROM aulas WHERE nivel = '$nivel' AND grado = '$grado' GROUP BY seccion ORDER BY id asc";
        $data = $this->selectAll($sql);
        return $data;
    }    

    //GENERAR PDF
    public function getEmpresa()
    {
        $sql = "SELECT * FROM configuracion";
        $data = $this->select($sql);
        return $data;
    }
}
?>