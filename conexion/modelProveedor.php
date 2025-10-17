<?php
require_once('ClaseConexion.php');


class Proveedor {
    private $idproveedor,$experiencia,$habilidad;

    public function __construct($idproveedor,$experiencia,$habilidad){
        $this->idproveedor=$idproveedor; $this->experiencia=$experiencia; $this->habilidad=$habilidad; 
    }
    public function getIdproveedor(){return $this->idproveedor;}
    public function getExperiencia(){return $this->experiencia;} 
    public function getHabilidad(){return $this->habilidad;}
  
    public function setExperiencia($v){$this->experiencia=$v;}
    public function setHabilidad($v){$this->habilidad=$v;} 
 


  public function modificarProv(){
        $cx=(new ClaseConexion())->getConexion();
        $sql= "UPDATE proveedor
		SET experiencia = ?, habilidad = ?
		WHERE idproveedor = ?";

        // Determinar id del proveedor: usar la propiedad si fue pasada, si no usar la sesión
        if (empty($this->idproveedor)) {
            if (session_status() === PHP_SESSION_NONE) session_start();
            $idProveedor = $_SESSION['cedula'] ?? null;
        } else {
            $idProveedor = $this->idproveedor;
        }

        if (!$idProveedor) {
            // No hay id para actualizar
            return 0;
        }

        $st=$cx->prepare($sql);
        if (!$st) {
            $cx->close();
            return 0;
        }

        // Usar las propiedades actuales
        $st->bind_param("sss", $this->experiencia, $this->habilidad, $idProveedor);
        $st->execute(); 
        $n=$st->affected_rows;
        $st->close();
        $cx->close();
        return $n;
    }}