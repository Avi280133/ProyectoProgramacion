<?php
require_once('ClaseConexion.php');

class Usuario {
    private $cedula,$nombre,$apellido,$username,$calle,$numeropuerta,$email,$contrasena,$fotoperfil,$edad;

    public function __construct($cedula,$nombre,$apellido,$username,$calle,$numeropuerta,$email,$contrasena,$fotoperfil,$edad){
        $this->cedula=$cedula; $this->nombre=$nombre; $this->apellido=$apellido; $this->username=$username;
        $this->calle=$calle; $this->numeropuerta=$numeropuerta; $this->email=$email; $this->contrasena=$contrasena;
        $this->fotoperfil=$fotoperfil; $this->edad=$edad;
    }
    public function getCedula(){return $this->cedula;} public function getNombre(){return $this->nombre;}
    public function getApellido(){return $this->apellido;} public function getUsername(){return $this->username;}
    public function getCalle(){return $this->calle;} public function getNumeropuerta(){return $this->numeropuerta;}
    public function getEmail(){return $this->email;} public function getContrasena(){return $this->contrasena;}
    public function getFotoperfil(){return $this->fotoperfil;} public function getEdad(){return $this->edad;}

    public function setNombre($v){$this->nombre=$v;} public function setApellido($v){$this->apellido=$v;}
    public function setUsername($v){$this->username=$v;} public function setCalle($v){$this->calle=$v;}
    public function setNumeropuerta($v){$this->numeropuerta=$v;} public function setEmail($v){$this->email=$v;}
    public function setContrasena($v){$this->contrasena=$v;} public function setFotoperfil($v){$this->fotoperfil=$v;}
    public function setEdad($v){$this->edad=$v;}

    public function registrar(){
        $cx=(new ClaseConexion())->getConexion();
        $sql="INSERT INTO usuario(cedula,nombre,apellido,username,email,contrasena,edad)
              VALUES(?,?,?,?,?,?,?)";
        $st=$cx->prepare($sql);
        $st->bind_param("ssssssi",$this->cedula,$this->nombre,$this->apellido,$this->username,
            $this->email,$this->contrasena,$this->edad);
        $st->execute(); $n=$st->affected_rows; $cx->close(); return $n;
    }

	public function modificar(){
        $cx=(new ClaseConexion())->getConexion();
        $sql= "UPDATE usuario 
		SET nombre = ?, apellido = ?, username = ?, calle = ?, numeropuerta = ?, email = ?, contrasena = ?, fotoperfil = ?, edad = ?
		WHERE cedula = ?";
        $st=$cx->prepare($sql);
        $st->bind_param("sssssisssi",$this->cedula,$this->nombre,$this->apellido,$this->username,$this->calle,
            $this->numeropuerta,$this->email,$this->contrasena,$this->fotoperfil,$this->edad);
        $st->execute(); $n=$st->affected_rows; $cx->close(); return $n;
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
}