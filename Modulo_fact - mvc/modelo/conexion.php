<?php

class DBA{	
    public $conexion;
    public function Conectar(){
        $this->conexion = new mysqli("localhost:3380","root","nicolas123","proyecto3");
        if($this->conexion){
            echo "";
        }
        else{
            echo "error de conexion";
        }
    }
    
}
?>