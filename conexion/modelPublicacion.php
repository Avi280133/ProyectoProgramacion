<?php
require_once('ClaseConexion.php');

class Servicio {
    private $idservicio,$titulo,$ubicacion,$precio,$descripcion,$imagen,$categoria;


    public function __construct($idservicio,$titulo,$ubicacion,$precio,$descripcion,$imagen,$categoria){
        $this->idservicio=$idservicio; $this->titulo=$titulo; $this->ubicacion=$ubicacion; $this->precio=$precio;
        $this->descripcion=$descripcion;  $this->imagen=$imagen; $this->categoria=$categoria;
    }
    public function getIdServicio(){return $this->idservicio;} 
    public function getTitulo(){return $this->titulo;}
    public function getUbicacion(){return $this->ubicacion;} 
    public function getPrecio(){return $this->precio;}
    public function getDescripcion(){return $this->descripcion;} 
    public function getImagen(){return $this->imagen;} 
    public function getCategoria(){return $this->categoria;} 

    public function setTitulo($v){$this->titulo=$v;} 
    public function setUbicacion($v){$this->ubicacion=$v;}
    public function setPrecio($v){$this->precio=$v;}
    public function setDescrpcion($v){$this->descripcion=$v;}
    public function setImagen($v){$this->imagen=$v;} 
    public function setCategoria($v){$this->categoria=$v;}
    
     public function publicarServicio(){
        if (!isset($_SESSION['cedula'])) {
            echo "Error: no hay proveedor logueado.";
            return 0;
        }
        $cx=(new ClaseConexion())->getConexion();

        $sql="INSERT INTO servicio(titulo,ubicacion,precio,descripcion,imagen,categoria)
              VALUES(?,?,?,?,?,?)";
        $st=$cx->prepare($sql);
        if(!$st){ $cx->close(); return 0; }

        $precioNum = (float)$this->precio;
        $st->bind_param("ssdsss",$this->titulo,$this->ubicacion,$precioNum,$this->descripcion, $this->imagen, $this->categoria);
        $st->execute();
        $ok = $st->affected_rows > 0;
        $newId = $cx->insert_id;
        $st->close();

        if ($ok) {
            $sql2 = "INSERT INTO ofrece (idservicio, idproveedor) VALUES (?, ?)";
            if ($st2 = $cx->prepare($sql2)) {
                $idProveedor = $_SESSION['cedula'];
                $st2->bind_param("is", $newId, $idProveedor);
                $st2->execute();
                $st2->close();
            }
        }
        $cx->close();
        return $ok ? 1 : 0;
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



    /* =======================================
       LISTAR SERVICIOS DE UN PROVEEDOR (panel)
       ======================================= */
    public static function serviciosDeProveedor(string $idProveedor) : array {
        $cx = (new ClaseConexion())->getConexion();
        $sql = "SELECT s.idservicio, s.titulo, s.ubicacion, s.precio, s.descripcion
                FROM servicio s
                INNER JOIN ofrece o ON o.idservicio = s.idservicio
                WHERE o.idproveedor = ?
                ORDER BY s.idservicio DESC";
        $st = $cx->prepare($sql);
        if (!$st) { $cx->close(); return []; }

        $st->bind_param("s", $idProveedor);
        $st->execute();
        $res = $st->get_result();

        $rows = [];
        while ($row = $res->fetch_assoc()) $rows[] = $row;

        $res->free(); $st->close(); $cx->close();
        return $rows;
    }

  public static function eliminarSiEsDelProveedor(int $idservicio, string $idProveedor) : int {
        $cx = (new ClaseConexion())->getConexion();
        try {
            // Verificar pertenencia
            $sqlChk = "SELECT 1 FROM ofrece WHERE idservicio=? AND idproveedor=? LIMIT 1";
            $st = $cx->prepare($sqlChk);
            $st->bind_param("is", $idservicio, $idProveedor);
            $st->execute();
            $ok = (bool)$st->get_result()->fetch_assoc();
            $st->close();

            if (!$ok) { $cx->close(); return 0; }

            // Borrar relación y servicio
            $cx->begin_transaction();
            if ($st = $cx->prepare("DELETE FROM ofrece WHERE idservicio=?")) {
                $st->bind_param("i", $idservicio);
                $st->execute();
                $st->close();
            }
            if ($st2 = $cx->prepare("DELETE FROM servicio WHERE idservicio=?")) {
                $st2->bind_param("i", $idservicio);
                $st2->execute();
                $st2->close();
            }
            $cx->commit();
            $cx->close();
            return 1;
        } catch (\Throwable $e) {
            @$cx->rollback();
            $cx->close();
            return 0;
        }
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



 public static function statsProveedor(string $idProveedor) : array {
        $cx = (new ClaseConexion())->getConexion();

        // 1) Servicios activos
        $activos = 0;
        try {
            $sqlA = "SELECT COUNT(*) AS c
                     FROM servicio s
                     INNER JOIN ofrece o ON o.idservicio = s.idservicio
                     WHERE o.idproveedor = ?";
            $st = $cx->prepare($sqlA);
            $st->bind_param("s", $idProveedor);
            $st->execute();
            $r = $st->get_result()->fetch_assoc();
            $activos = (int)($r['c'] ?? 0);
            $st->close();
        } catch (\Throwable $e) { $activos = 0; }

        // 2) Vistas (tabla opcional metricas_servicio)
        $vistas = 0;
        try {
            $sqlV = "SELECT SUM(m.vistas) AS v
                     FROM metricas_servicio m
                     INNER JOIN ofrece o ON o.idservicio = m.idservicio
                     WHERE o.idproveedor = ?";
            $st = $cx->prepare($sqlV);
            $st->bind_param("s", $idProveedor);
            $st->execute();
            $r = $st->get_result()->fetch_assoc();
            $vistas = (int)($r['v'] ?? 0);
            $st->close();
        } catch (\Throwable $e) { $vistas = 0; }

        // 3) Calificación (tabla opcional resena)
        $calificacion = 0.0;
        try {
            $sqlC = "SELECT AVG(r.puntuacion) AS p
                     FROM resena r
                     WHERE r.idproveedor = ?";
            $st = $cx->prepare($sqlC);
            $st->bind_param("s", $idProveedor);
            $st->execute();
            $r = $st->get_result()->fetch_assoc();
            $calificacion = round((float)($r['p'] ?? 0), 1);
            $st->close();
        } catch (\Throwable $e) { $calificacion = 0.0; }

        // 4) Mensajes (tabla opcional mensaje)
        $mensajes = 0;
        try {
            $sqlM = "SELECT COUNT(*) AS m
                     FROM mensaje
                     WHERE idproveedor = ? AND COALESCE(leido,0)=0";
            $st = $cx->prepare($sqlM);
            $st->bind_param("s", $idProveedor);
            $st->execute();
            $r = $st->get_result()->fetch_assoc();
            $mensajes = (int)($r['m'] ?? 0);
            $st->close();
        } catch (\Throwable $e) { $mensajes = 0; }

        $cx->close();
        return [
            'activos'      => $activos,
            'vistas'       => $vistas,
            'calificacion' => $calificacion,
            'mensajes'     => $mensajes,
        ];
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

