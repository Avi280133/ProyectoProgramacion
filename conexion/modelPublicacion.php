<?php
require_once('ClaseConexion.php');
session_start();
class Servicio {
    private $idservicio,$titulo,$ubicacion,$precio,$descripcion;

    public function __construct($idservicio,$titulo,$ubicacion,$precio,$descripcion){
        $this->idservicio=$idservicio; $this->titulo=$titulo; $this->ubicacion=$ubicacion; $this->precio=$precio;
        $this->descripcion=$descripcion;
    }
    public function getIdServicio(){return $this->idservicio;} 
    public function getTitulo(){return $this->titulo;}
    public function getUbicacion(){return $this->ubicacion;} 
    public function getPrecio(){return $this->precio;}
    public function getDescripcion(){return $this->descripcion;} 

    public function setTitulo($v){$this->titulo=$v;} 
    public function setUbicacion($v){$this->ubicacion=$v;}
    public function setPrecio($v){$this->precio=$v;}
    public function setDescrpcion($v){$this->descripcion=$v;}
    
    public function publicarServicio(){
           if (isset($_SESSION['cedula'])) {
        $cx=(new ClaseConexion())->getConexion();
        $sql="INSERT INTO servicio(titulo,ubicacion,precio,descripcion)
              VALUES(?,?,?,?)";
        $st=$cx->prepare($sql);
        $st->bind_param("ssds",$this->titulo,$this->ubicacion,$this->precio,$this->descripcion);
        $st->execute(); 
        $n=$st->affected_rows;
        $idservicio = $cx->insert_id;
        $idProveedor = $_SESSION['cedula'];
        $sql2 = "INSERT INTO ofrece (idservicio, idproveedor) VALUES (?, ?)";
        $st = $cx->prepare($sql2);
        $st->bind_param("is", $idservicio, $idProveedor); // "i" = integer, "s" = string
        $st->execute();
        $n=$st->affected_rows;
} else {
    echo "Error: no hay proveedor logueado.";
}
 
        $cx->close(); return $n;
    }


    public static function buscarPorTitulo($titulo) {
    $cx = (new ClaseConexion())->getConexion();
    $sql = "SELECT * FROM servicio WHERE titulo LIKE ?";
    $st = $cx->prepare($sql);
    $likeTitulo = "%$titulo%";
    $st->bind_param("s", $likeTitulo);
    $st->execute();
    $result = $st->get_result();
    // Puede devolver múltiples filas; recoger todas en un array
    $servicios = [];
    while ($row = $result->fetch_assoc()) {
        $servicios[] = $row;
    }
    // liberar recursos
    $result->free();
    $st->close();
    $cx->close();
    return $servicios; // array (posiblemente vacío) de filas asociativas
}
}

