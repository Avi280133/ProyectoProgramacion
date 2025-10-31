<?php
require_once('ClaseConexion.php');
session_start();
class Servicio {
    private $idservicio,$titulo,$ubicacion,$precio,$descripcion,$imagen;


    public function __construct($idservicio,$titulo,$ubicacion,$precio,$descripcion,$imagen){
        $this->idservicio=$idservicio; $this->titulo=$titulo; $this->ubicacion=$ubicacion; $this->precio=$precio;
        $this->descripcion=$descripcion;  $this->imagen=$imagen;
    }
    public function getIdServicio(){return $this->idservicio;} 
    public function getTitulo(){return $this->titulo;}
    public function getUbicacion(){return $this->ubicacion;} 
    public function getPrecio(){return $this->precio;}
    public function getDescripcion(){return $this->descripcion;} 
     public function getImagen(){return $this->imagen;} 

    public function setTitulo($v){$this->titulo=$v;} 
    public function setUbicacion($v){$this->ubicacion=$v;}
    public function setPrecio($v){$this->precio=$v;}
    public function setDescrpcion($v){$this->descripcion=$v;}
    public function setImagen($v){$this->imagen=$v;} 
    
    public function publicarServicio(){
           if (isset($_SESSION['cedula'])) {
        $cx=(new ClaseConexion())->getConexion();
        $sql="INSERT INTO servicio(titulo,ubicacion,precio,descripcion,imagen)
              VALUES(?,?,?,?,?)";
        $st=$cx->prepare($sql);
        $st->bind_param("ssdss",$this->titulo,$this->ubicacion,$this->precio,$this->descripcion,$this->imagen);
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

  public static function cargarServicio($idservicio) {
    $cx = (new ClaseConexion())->getConexion();
    $sql = "SELECT s.*, 
                   u.cedula   AS proveedor_cedula,
                   u.nombre   AS proveedor_nombre,
                   u.fotoperfil AS proveedor_fotoperfil,
                   u.localidad AS proveedor_localidad
            FROM servicio s
            INNER JOIN ofrece ps ON s.idservicio = ps.idservicio
            INNER JOIN usuario u ON ps.idproveedor = u.cedula
            WHERE s.idservicio = ?
            LIMIT 1";
    $st = $cx->prepare($sql);
    if (!$st) {
        $cx->close();
        return null;
    }

    $st->bind_param("i", $idservicio);
    $st->execute();
    $result = $st->get_result();
    $servicio = $result ? $result->fetch_assoc() : null;

    if ($result) $result->free();
    if ($servicio) {
       
        $_SESSION['receiver_id'] = $servicio['proveedor_cedula'];
    }
    $st->close();
    $cx->close();
    return $servicio; // ahora contiene 'titulo' y 'descripcion' + campos del proveedor con alias
    
}

    public static function crearReserva($idservicio, $idcliente, $fecha, $hora) {
        $cx = (new ClaseConexion())->getConexion();
        $sql = "INSERT INTO reserva (idservicio, idcliente, fecha, hora, estado) 
                VALUES (?, ?, ?, ?, 'pendiente')";
        
        $st = $cx->prepare($sql);
        $st->bind_param("isss", $idservicio, $idcliente, $fecha, $hora);
        $result = $st->execute();
        
        $st->close();
        $cx->close();
        return $result;
    }

    public static function obtenerReservasServicio($idservicio) {
        $cx = (new ClaseConexion())->getConexion();
        $sql = "SELECT fecha, hora, estado FROM reserva 
                WHERE idservicio = ? AND estado != 'cancelada'";
        
        $st = $cx->prepare($sql);
        $st->bind_param("i", $idservicio);
        $st->execute();
        $result = $st->get_result();
        
        $reservas = [];
        while ($row = $result->fetch_assoc()) {
            $reservas[] = $row;
        }
        
        $st->close();
        $cx->close();
        return $reservas;
    }
}

