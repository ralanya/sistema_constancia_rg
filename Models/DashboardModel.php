<?php
class DashboardModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    
    //DATOS EMPRESA
    public function getTotales(string $table)
    {
        $sql = "SELECT COUNT(id) as Total FROM $table WHERE estado = 1";
        $data = $this->select($sql);
        return $data;
    }

    public function getTotalDescargas()
    {
        $sql = "SELECT COUNT(id) as Total FROM emision_constancias WHERE vista = 1 AND estado = 1";
        $data = $this->select($sql);
        return $data;
    }
    
    public function getArchivoConstancia()
    {
        $sql = "SELECT archivo, COUNT(archivo) as total FROM emision_constancias WHERE archivo = 'GEN' UNION
                SELECT archivo, COUNT(archivo) as total FROM emision_constancias WHERE archivo = 'PDF'";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getRankingConstancias()
    {        
        $sql = "SELECT c.id, dc.nombre, COUNT(ec.id_constancia) AS total FROM emision_constancias ec
        INNER JOIN constancias c ON c.id = ec.id_constancia
        INNER JOIN documento_constancias dc ON c.id_documento = dc.id
        GROUP BY ec.id_constancia ORDER BY total DESC LIMIT 0,5";
        $data = $this->selectAll($sql);
        return $data;
    }  
}
?>