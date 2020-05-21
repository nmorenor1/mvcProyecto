<?php
require('../librerias/fpdf/fpdf.php');//instanciar la libreria
require('../modelo/conexion.php');//instanciar la conexion de la base de datos


//creacion de la clase y el formato del PDF
class PDF extends FPDF
{

// Cabecera de página
function Header()
{   
    //variables
    $conexi = new DBA();
    $valor=1; //aqui va el Json
    $usu = strval($valor);// tranforma a string
    $Num_fac = "select fac_ref,fec_fact from bt_factura join bt_users on bt_factura.fac_usr=bt_users.U_idUser where U_idUser = ".$usu;
    
    $conexi->conectar();
    $resultado = $conexi->conexion->query($Num_fac);  
    
    // Logo
    $this->Image('../vista/img/logo.png',10,10,50);
    // Arial bold 18
    $this->SetFont('Arial','B',12);
    // Movernos a la derecha
    
    
    if ($row = $resultado->fetch_assoc()) {
        // Título
        $this->Cell(180);
        $this->Cell(60,6,'numero de referencia:',0,0,'L');
        
        $this->Cell(60,6,'#2457-'.$row["fac_ref"],0,1,'L');
        $this->Cell(0,3,'',0,1);
        $this->Cell(180);
        $this->Cell(60,6,'fecha de factura: ',0,0,'L');
        
        $this->Cell(60,6,$row["fec_fact"],0,1,'L');
    }
    $resultado->free();
    // Salto de línea
    $this->Ln(20);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->AliasNbPages();
    $this->Cell(0,10,utf8_decode('Pagina ').$this->PageNo().'/{nb}',0,0,'C');
}
}

?>