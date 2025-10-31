<?php
require_once('ClaseConexion.php');
session_start();
//Comentario agregado
class Usuario {
    private $cedula,$nombre,$apellido,$username,$email,$contrasena,$fotoperfil,$edad,$localidad,$tipo;

    public function __construct($cedula,$nombre,$apellido,$username,$email,$contrasena,$fotoperfil,$edad,$localidad,$tipo){
        $this->cedula=$cedula; $this->nombre=$nombre; $this->apellido=$apellido; $this->username=$username;
        $this->email=$email; $this->contrasena=$contrasena;
        $this->fotoperfil=$fotoperfil; $this->edad=$edad; $this->localidad=$localidad; $this->tipo = $tipo;
    }
    public function getCedula(){return $this->cedula;} public function getNombre(){return $this->nombre;}
    public function getApellido(){return $this->apellido;} public function getUsername(){return $this->username;}
    public function getEmail(){return $this->email;} public function getContrasena(){return $this->contrasena;}
    public function getFotoperfil(){return $this->fotoperfil;} public function getEdad(){return $this->edad;}
    public function getLocalidad(){return $this->localidad;}

    public function setNombre($v){$this->nombre=$v;} public function setApellido($v){$this->apellido=$v;}
    public function setUsername($v){$this->username=$v;} public function setEmail($v){$this->email=$v;}
    public function setContrasena($v){$this->contrasena=$v;} public function setFotoperfil($v){$this->fotoperfil=$v;}
    public function setEdad($v){$this->edad=$v;} public function setLocalidad($v){$this->localidad=$v;}

   public function registrar(){
    $cx=(new ClaseConexion())->getConexion();
    $sql="INSERT INTO usuario(cedula,nombre,apellido,username,email,contrasena,edad)
          VALUES(?,?,?,?,?,?,?)";
    $st=$cx->prepare($sql);

    // Joaquin Perez aca esta el hash, no est adentro de un controlador
    $hash = password_hash($this->contrasena, PASSWORD_DEFAULT);



    $st->bind_param(
        "ssssssi",
        $this->cedula,
        $this->nombre,
        $this->apellido,
        $this->username,
        $this->email,
        $hash,                
        $this->edad
    );
    $st->execute(); 
    $n=$st->affected_rows; 

    if ($this->tipo === 'cliente') {
        $st2 = $cx->prepare("INSERT INTO cliente (idcliente) VALUES (?)");
        $st2->bind_param("s", $this->cedula);
        $st2->execute();
        include('../vistas/vistas-cliente.php');
    } elseif ($this->tipo === 'proveedor') {
        $st2 = $cx->prepare("INSERT INTO proveedor (idproveedor) VALUES (?)");
        $st2->bind_param("s", $this->cedula);
        $st2->execute();
        include('../vistas/vistas-prov.php');
    }

    $cx->close(); 
    return $n;
}




	public function modificarUsuario(){
        $cx=(new ClaseConexion())->getConexion();
        $sql= "UPDATE usuario 
		SET username = ?, fotoperfil = ?, localidad = ?
		WHERE cedula = ?";

        if (session_status() === PHP_SESSION_NONE) session_start();
        $cedula = $_SESSION['cedula'] ?? null;
        if (!$cedula) {
            // No hay sesión con cédula, no se puede actualizar
            $cx->close();
            return 0;
        }

        $st=$cx->prepare($sql);
        if (!$st) {
            $cx->close();
            return 0;
        }

        $st->bind_param("ssss", $this->username, $this->fotoperfil, $this->localidad, $cedula);
        $st->execute(); 
        $n=$st->affected_rows;
        $st->close();
        $cx->close();
        return $n;
    }

    public static function buscarPorCedula($cedula){
        $cx=(new ClaseConexion())->getConexion();
        $st=$cx->prepare("SELECT * FROM usuario WHERE cedula=?"); $st->bind_param("s",$cedula);
        $st->execute(); $r=$st->get_result()->fetch_assoc(); $cx->close(); return $r;
    }


    public static function eliminar($cedula){
        $cx=(new ClaseConexion())->getConexion();
        $st=$cx->prepare("DELETE * FROM usuario WHERE cedula=?"); $st->bind_param("s",$cedula);
        $st->execute(); $n=$st->affected_rows; $cx->close(); return $n;
    }

public function login($email, $contrasena) {
    $cx = (new ClaseConexion())->getConexion();
    $sql = "SELECT cedula, nombre, apellido, username, email, fotoperfil, edad, contrasena
            FROM usuario 
            WHERE email = ? LIMIT 1";
    $st = $cx->prepare($sql);
    if (!$st) { die("Error en prepare: " . $cx->error); }
    $st->bind_param("s", $email);
    $st->execute();
    $res = $st->get_result();
    $usuario = $res ? $res->fetch_assoc() : null;
    $st->close();
    $cx->close();
      if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['cedula'] = $usuario['cedula'];
        unset($usuario['contrasena']); // no exponer hash
        return $usuario;
    }
    }



 





//public function mensaje() {
  //  $cx = (new ClaseConexion())->getConexion();
//print_r($_SESSION);
  //  $sql = "SELECT cedula, nombre, apellido, username, email, fotoperfil, edad 
   //         FROM usuario 
   //         WHERE email = ? AND contrasena = ?";

 //   $st = $cx->prepare($sql);
  //  if (!$st) {
 //       die("Error en prepare: " . $cx->error);
  //  }

    // Usar los parámetros recibidos, no las propiedades vacías
  //  $st->bind_param("ss", $email, $contrasena);
   // $st->execute();

 //   $res = $st->get_result();
 //   $usuario = $res->fetch_assoc();

 //   $st->close();
  //  $cx->close();

  //  if ($usuario) {
       
    //    $_SESSION['cedula'] = $usuario['cedula'];
  //  }
   // return $usuario ? $usuario : null;

 public static function cargarPanelClientes() {
    $cx = (new ClaseConexion())->getConexion();
    $sql = "
        SELECT u.*
        FROM usuario u
        INNER JOIN cliente c ON c.idcliente = u.cedula
        ORDER BY u.nombre, u.apellido
    ";
    $st = $cx->prepare($sql);
    $st->execute();
    $res = $st->get_result();
    $r = $res->fetch_all(MYSQLI_ASSOC);
    $cx->close();
    return $r;
}

 public static function cargarPanelProveedores() {
    $cx = (new ClaseConexion())->getConexion();
    $sql = "
        SELECT u.*
        FROM usuario u
        INNER JOIN proveedor p ON p.idcliente = u.cedula
        ORDER BY u.nombre, u.apellido
    ";
    $st = $cx->prepare($sql);
    $st->execute();
    $res = $st->get_result();
    $r = $res->fetch_all(MYSQLI_ASSOC);
    $cx->close();
    return $r;
}

 public static function cargarPanelServicios() {
    $cx = (new ClaseConexion())->getConexion();
    $sql = "
        SELECT * FROM servicio
    ";
    $st = $cx->prepare($sql);
    $st->execute();
    $res = $st->get_result();
    $r = $res->fetch_all(MYSQLI_ASSOC);
    $cx->close();
    return $r;
}

 public static function cargarPanelCategorias() {
    $cx = (new ClaseConexion())->getConexion();
    $sql = "
        SELECT * FROM categoria
    ";
    $st = $cx->prepare($sql);
    $st->execute();
    $res = $st->get_result();
    $r = $res->fetch_all(MYSQLI_ASSOC);
    $cx->close();
    return $r;
}





public static function cargarChatsProv() {
    $cx = (new ClaseConexion())->getConexion();
        $sql1="SELECT DISTINCT m.idemisor, u.nombre FROM `mensaje` as m join usuario as u on m.idemisor = 
u.cedula WHERE m.idreceptor = ?;";
        $st=$cx->prepare($sql1);
        $st->bind_param("i", $_SESSION['cedula']);
        $st->execute(); 
            $res = $st->get_result();
    $r = $res->fetch_all(MYSQLI_ASSOC);
        //$chats = $res['nombre'] ? $st->get_result()->fetch_all(MYSQLI_ASSOC) : [];
    
    $cx->close();
    return $res;
}





public static function detectarRol($cedula) {
    $cx = (new ClaseConexion())->getConexion();
    $role = null;

    $st = $cx->prepare("SELECT 1 FROM cliente WHERE idcliente = ? LIMIT 1");
    if ($st) {
        $st->bind_param("s", $cedula);
        $st->execute();
        $res = $st->get_result();
        if ($res && $res->fetch_assoc()) { $role = 'cliente'; }
        $st->close();
    }

    if (!$role) {
        $st = $cx->prepare("SELECT 1 FROM proveedor WHERE idproveedor = ? LIMIT 1");
        if ($st) {
            $st->bind_param("s", $cedula);
            $st->execute();
            $res = $st->get_result();
            if ($res && $res->fetch_assoc()) { $role = 'proveedor'; }
            $st->close();
        }
    }

    if (!$role) {
        $st = $cx->prepare("SELECT 1 FROM administrador WHERE idadministrador = ? LIMIT 1");
        if ($st) {
            $st->bind_param("s", $cedula);
            $st->execute();
            $res = $st->get_result();
            if ($res && $res->fetch_assoc()) { $role = 'admin'; }
            $st->close();
        }
    }

    $cx->close();
    return $role; // 'cliente' | 'proveedor' | 'admin' | null
}

public static function obtenerReservas($idproveedor) {
    $cx = (new ClaseConexion())->getConexion();
    $sql = "SELECT r.fecha, r.hora, r.estado 
            FROM reserva r 
            INNER JOIN servicio s ON r.idservicio = s.idservicio 
            INNER JOIN ofrece o ON s.idservicio = o.idservicio 
            WHERE o.idproveedor = ?";
            
    $st = $cx->prepare($sql);
    $st->bind_param("i", $idproveedor);
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

