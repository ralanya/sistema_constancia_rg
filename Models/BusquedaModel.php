<?php
class BusquedaModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getDocumentoContancias()
    {
        $sql = "SELECT id as id_documento, nombre, estado FROM documento_constancias WHERE estado = 1";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function buscarEstudiante(string $documento, string $busqueda) 
    {
        $sql = "SELECT * FROM estudiantes WHERE documento = '$documento' AND numero = '$busqueda' AND estado = 1";
        $data = $this->select($sql);
        return $data;
    }

    public function buscarPersonal(string $documento, string $busqueda) 
    {
        $sql = "SELECT * FROM personales WHERE documento = '$documento' AND numero = '$busqueda' AND estado = 1";
        $data = $this->select($sql);
        return $data;
    }

    public function buscarPersona(string $documento, string $busqueda) 
    {
        $sql = "SELECT * FROM personas WHERE documento = '$documento' AND numero = '$busqueda' AND estado = 1";
        $data = $this->select($sql);
        return $data;
    }
    public function buscarFamilia(string $documento, string $busqueda) 
    {
        $sql = "SELECT * FROM familias WHERE documento = '$documento' AND numero = '$busqueda' AND estado = 1";
        $data = $this->select($sql);
        return $data;
    }

    public function buscarCodigo(string $busqueda)
    {
        $sql = "SELECT * FROM emision_constancias WHERE codigo = '$busqueda' AND estado = 1";
        $data = $this->select($sql);
        return $data;
    }

    public function getConstanciaDocumento(string $tabla, string $documento, string $busqueda) 
    {
        $sql = "SELECT ec.documento, ec.codigo, ec.numero, t.nombres FROM emision_constancias ec INNER JOIN $tabla t ON t.numero = ec.numero WHERE ec.documento = '$documento' AND ec.numero = '$busqueda' AND ec.estado = 1";
        $data = $this->select($sql);
        return $data;
    }

    public function getConstanciaCodigo(string $tabla, string $busqueda) 
    {
        $sql = "SELECT ec.documento, ec.codigo, ec.numero, t.nombres FROM emision_constancias ec INNER JOIN $tabla t ON t.numero = ec.numero WHERE ec.codigo = '$busqueda' AND ec.estado = 1";
        $data = $this->select($sql);
        return $data;
    }

    //EMISIONES
    public function getEmisionesDocumento(string $busqueda) 
    {
        $sql = "SELECT ec.id, ec.documento, ec.codigo, ec.fecha, ec.numero, ec.estado, c.nombre, dc.nombre AS tipo FROM emision_constancias ec 
                INNER JOIN constancias c ON ec.id_constancia = c.id 
                INNER JOIN documento_constancias dc ON dc.id = c.id_documento
                WHERE ec.numero = '$busqueda' AND ec.estado = 1";
        $data = $this->selectAll($sql);
        return $data;
    }
    
    public function getEmisionesCodigo(string $busqueda) 
    {
        $sql = "SELECT ec.id, ec.documento, ec.codigo, ec.fecha, ec.numero, ec.estado, c.nombre, dc.nombre AS tipo FROM emision_constancias ec 
                INNER JOIN constancias c ON ec.id_constancia = c.id 
                INNER JOIN documento_constancias dc ON dc.id = c.id_documento
                WHERE ec.codigo = '$busqueda' AND ec.estado = 1";
        $data = $this->selectAll($sql);
        return $data;
    }

    //DETALLE CONSTANCIA
    public function detalleCons(int $id) 
    {
        $sql = "SELECT ec.*, c.id as id_constancia, c.nombre, c.id_documento, c.horas, c.descripcion, c.imagen FROM emision_constancias ec INNER JOIN constancias c ON ec.id_constancia = c.id WHERE ec.id = '$id' AND ec.estado = 1";
        $data = $this->select($sql);
        return $data;
    }
    public function actualizaVista(int $id)
    {
        $vista = 1;
        $sql = "UPDATE emision_constancias SET vista = ? WHERE id = ?";
        $datos = array($vista, $id);
        $data = $this->save($sql,$datos);
    }
}
?>