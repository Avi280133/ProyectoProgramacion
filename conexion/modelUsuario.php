<?php
require_once('ClaseConexion.php');
session_start();

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

        $st->bind_param("ssssssi",$this->cedula,$this->nombre,$this->apellido,$this->username,
            $this->email,$this->contrasena,$this->edad);
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

        
        $cx->close(); return $n;
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
        $st=$cx->prepare("DELETE FROM usuario WHERE cedula=?"); $st->bind_param("s",$cedula);
        $st->execute(); $n=$st->affected_rows; $cx->close(); return $n;
    }


  public function login($email, $contrasena) {
    $cx = (new ClaseConexion())->getConexion();

    $sql = "SELECT cedula, nombre, apellido, username, email, fotoperfil, edad 
            FROM usuario 
            WHERE email = ? AND contrasena = ?";

    $st = $cx->prepare($sql);
    if (!$st) {
        die("Error en prepare: " . $cx->error);
    }

    // Usar los parámetros recibidos, no las propiedades vacías
    $st->bind_param("ss", $email, $contrasena);
    $st->execute();

    $res = $st->get_result();
    $usuario = $res->fetch_assoc();

    $st->close();
    $cx->close();

    if ($usuario) {
       
        $_SESSION['cedula'] = $usuario['cedula'];
    }
    return $usuario ? $usuario : null;
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

}

