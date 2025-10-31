<?php
class ClaseConexion
{
    private $servidor ="localhost";
    private $usuario = "root";
    private $contrasena = "";
    private $baseDeDatos = "SkillMatch";
    private $conexion;

    public function __construct()
    {
        $this->conexion = new mysqli($this->servidor, $this->usuario, $this->contrasena, $this->baseDeDatos);
        if ($this->conexion->connect_error) 
        {
	        exit("Error de conexión: " . $this->conexion->connect_error);
        }
    }
    public function getConexion()
    {
        return $this->conexion;
    }
}
?>