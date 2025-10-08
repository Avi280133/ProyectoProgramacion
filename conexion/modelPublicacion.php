<?php
require_once('ClaseConexion.php');

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
        $cx=(new ClaseConexion())->getConexion();
        $sql="INSERT INTO servicio(titulo,ubicacion,precio,descripcion)
              VALUES(?,?,?,?)";
        $st=$cx->prepare($sql);
        $st->bind_param("ssds",$this->titulo,$this->ubicacion,$this->precio,$this->descripcion);
        $st->execute(); $n=$st->affected_rows;
        $idservicio = $cx->insert_id;
        
      //  $st2=$cx->prepare($sql2);
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
    $servicios = $result->fetch_all(MYSQLI_ASSOC);
    $cx->close();
    return $servicios;
}
}

