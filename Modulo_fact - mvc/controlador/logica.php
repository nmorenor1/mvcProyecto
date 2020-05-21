<?php
require('formato.php');//instanciar la clase creada con el formato de cabezera y footer

//variable del JSon

$ja=$_POST['nombre']; 
$usa = strval($ja); //se transforma en string para ser enviada a la consulta
$ja2=$_POST["Auc"]; // v
$usa2 = strval($ja2); //se transforma en string para ser enviada a la consulta

//la conexion con la base de datos, esta instanciada el en docuemnto de arriba
// se crea un objeto de conexion base de datos
$conex = new DBA();
$conex->conectar();

//Consulta datos de facturación
$consul = "select fac_ref,fec_fact,fac_usr,U_nameUser,U_city,U_email,U_document,U_address,U_sex,U_mobile,Of_price,O.Of_idAuc from bt_factura join bt_users U on bt_factura.fac_usr=U.U_idUser join bt_oferts O on O.U_idUser= U.U_idUser where U.U_idUser=".$usa;
$resultado = $conex->conexion->query($consul);

//consulta datos de usuarios comprador y ofertador
$row1=$resultado->fetch_assoc();
//$ja2=$row1["Of_idAuc"]; // 
//$usa2 = strval($ja2); //se transforma en string para ser enviada a la consulta
$consul2 ="SELECT U.U_nameuser, U.U_city, U.U_email from bt_users U join bt_auctions A on U.U_idUser=A.U_idUser join bt_oferts O ON O.Au_idAuction = A.Au_idAuction where O.Of_idAuc=".$usa2;
$resultado2 = $conex->conexion->query($consul2);

//consulta datos de producto
$consul3="call proyecto3.getProduct(".$usa2.")";
$resultado3 = $conex->conexion->query($consul3);




//variables
    //datos personales subastador:
$row2=$resultado2->fetch_assoc();

$N_subastador= utf8_decode($row2["U_nameuser"]); //nombre
$cuiS= utf8_decode($row2["U_city"]);
$emailS=utf8_decode($row2["U_email"]);

    //datos personales comprador:

$N_comprador= utf8_decode($row1["U_nameUser"]); //nombre
$docu= utf8_decode($row1["U_document"]);
$genere= utf8_decode($row1["U_sex"]);
$cel= $row1["U_mobile"];
$emailC= utf8_decode($row1["U_email"]);
$ciuC= utf8_decode($row1["U_city"]);
$calle= utf8_decode($row1["U_address"]);
    //datos de compra:
$ref=$row1["fac_ref"];
$fecha=$row1["fec_fact"];
$precio=$row1["Of_price"];
$impuesto=2;
$envio=7500;

//creacion del pdf
$pdf = new PDF("L");
$pdf->AddPage();


$pdf->SetLineWidth(1); // grosor de linea
//LINEAS
$pdf->Line(10,30,280,30);//primera
$pdf->Line(30,52,120,52);//comprador
$pdf->Line(30,107,120,107);//subastador
$pdf->Line(30,144,120,144);//compra

// ENCABEZADOS DE INFO COMPRADOR 
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(61,174,233);
$pdf->cell(25);
$pdf->cell(120,5,"Datos Del Comprador",0,1,"L",0);


$pdf->SetTextColor(40,40,40);// color de texto: un gris/negro
$pdf->SetDrawColor(10,10,10);//color de la liena: negro
$pdf->SetLineWidth(0); // grosor de linea
$pdf->cell(0,4,"",0,1);
$pdf->cell(25);
$pdf->SetFont('Arial','B',16);
$pdf->cell(110,6,"Nombre completo: ",0,0,"L",0);
$pdf->SetFont('Arial','',16);
$pdf->cell(100,6,$N_comprador." corredor barrera",0,1,"L",0);
$pdf->cell(25);

$pdf->SetFont('Arial','B',16);
$pdf->cell(110,6,"Documento: ",0,0,"L",0);
$pdf->SetFont('Arial','',16);
$pdf->cell(100,6,$docu,0,1,"L",0);
$pdf->cell(25);
$pdf->SetFont('Arial','B',16);
$pdf->cell(110,6,"Telefono: ",0,0,"L",0);
$pdf->SetFont('Arial','',16);
$pdf->cell(100,6,$cel,0,1,"L",0);
$pdf->cell(25);
$pdf->SetFont('Arial','B',16);
$pdf->cell(110,6,"Email: ",0,0,"L",0);
$pdf->SetFont('Arial','',16);
$pdf->cell(100,6,$emailC,0,1,"L",0);
$pdf->cell(25);
$pdf->SetFont('Arial','B',16);
$pdf->cell(110,6,"Ciudad de residencia: ",0,0,"L",0);
$pdf->SetFont('Arial','',16);
$pdf->cell(100,6,$ciuC,0,1,"L",0);
$pdf->cell(25);
$pdf->SetFont('Arial','B',16);
$pdf->cell(110,6,"Direccion: ",0,0,"L",0);
$pdf->SetFont('Arial','',16);
$pdf->cell(100,6,$calle,0,1,"L",0);
$pdf->cell(0,10,"",0,1);

// ENCABEZADOS DE INFO SUBASTADOR
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(61,174,233);
$pdf->cell(25);
$pdf->cell(40,5,"Datos Del Subastador",0,1,"L",0);

$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(40,40,40);// color de texto: un gris/negro
$pdf->SetDrawColor(10,10,10);//color de la liena: negro
$pdf->SetLineWidth(0); // grosor de linea
$pdf->cell(0,4,"",0,1);
$pdf->cell(25);
$pdf->SetFont('Arial','B',16);
$pdf->cell(110,6,"Nombre completo: ",0,0,"L",0);
$pdf->SetFont('Arial','',16);
$pdf->cell(100,6,$N_subastador,0,1,"L",0);
$pdf->cell(25);
$pdf->SetFont('Arial','B',16);
$pdf->cell(110,6,"Email: ",0,0,"L",0);
$pdf->SetFont('Arial','',16);
$pdf->cell(100,6,$emailS,0,1,"L",0);
$pdf->cell(25);
$pdf->SetFont('Arial','B',16);
$pdf->cell(110,6,"Ciudad de residencia: ",0,0,"L",0);
$pdf->SetFont('Arial','',16);
$pdf->cell(100,6,$cuiS,0,1,"L",0);
$pdf->cell(0,10,"",0,1);


//ENCABEZADO DE INFO COMPRA
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(61,174,233);
$pdf->cell(25);
$pdf->cell(40,5,"Resumen De Compra",0,1,"L",0);

$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(40,40,40);// color de texto: un gris/negro
$pdf->SetDrawColor(10,10,10);//color de la liena: negro
$pdf->SetLineWidth(0); // grosor de linea
$pdf->cell(0,4,"",0,1);
$pdf->SetFont('Arial','',16);
$pdf->cell(25);
$pdf->SetFont('Arial','B',16);
$pdf->cell(110,6,"precio ofertado: ",0,0,"L",0);
$pdf->SetFont('Arial','',16);
$pdf->cell(100,6,"$".$precio,0,1,"L",0);
$pdf->cell(25);
$pdf->SetFont('Arial','B',16);
$pdf->cell(110,6,"impuesto pagado: ",0,0,"L",0);
$pdf->SetFont('Arial','',16);
$pdf->cell(40,6,$impuesto."%",0,1,"L",0);
$pdf->cell(25);
$pdf->SetFont('Arial','B',16);
$pdf->cell(110,6,"precio de envio:",0,0,"L",0);
$pdf->SetFont('Arial','',16);
$pdf->cell(40,6,"$".$envio,0,1,"L",0);
$pdf->cell(0,18,"",0,1);


//PRODUCTOS COMPRADOS
$pdf->SetFillColor(18, 126, 200);//color de fondo de la celda: azul oscuro
$pdf->SetFont('Arial','B',16);
$pdf->cell(10);
$pdf->Cell(50,10,"Nombre",0,0,"C",1);
$pdf->Cell(50,10,"Modelo",0,0,"C",1);
$pdf->Cell(25,10,"Bateria",0,0,"C",1);
$pdf->Cell(15,10,"Ram",0,0,"C",1);
$pdf->Cell(30,10,"Color",0,0,"C",1);
$pdf->Cell(40,10,"IMEI1",0,0,"C",1);
$pdf->Cell(40,10,"IMEI2",0,1,"C",1);

$pdf->SetFillColor(205, 216, 218);//color de fondo de la celda: blanco
$pdf->SetDrawColor(255,255,255);//color de la liena: negro
$pdf->SetLineWidth(1); // grosor de linea

if($resultado3->num_rows > 0){ 
    while($row3 = $resultado3->fetch_assoc()) {
    $pdf->SetFont('Arial','',14);
    $pdf->cell(10);
    $pdf->Cell(50,10,$row3["Pr_nameItem"],1,0,"C",1);
    $pdf->Cell(50,10,$row3["Ve_Model"],1,0,"C",1);
    $pdf->Cell(25,10,$row3["b_capBatery"],1,0,"C",1);
    $pdf->Cell(15,10,$row3["R_capRAM"],1,0,"C",1);
    $pdf->Cell(30,10,$row3["pr_colorItem"],1,0,"C",1);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(40,10,$row3["pr_IMEI1"],1,0,"C",1);
    $pdf->cell(40,10,$row3["pr_IMEI2"],1,1,"C",1);
    
    }
}
else {
    $pdf->SetFont('Arial','',14);
    $pdf->cell(10);
    $pdf->Cell(50,10,"Null",0,0,"C",1);
    $pdf->Cell(50,10,"Null",0,0,"C",1);
    $pdf->Cell(25,10,"Null",0,0,"C",1);
    $pdf->Cell(15,10,"Null",0,0,"C",1);
    $pdf->Cell(30,10,"Null",0,0,"C",1);
    $pdf->Cell(40,10,"Null",0,0,"C",1);
    $pdf->Cell(40,10,"Null",0,1,"C",1);
};


//
$resultado->free();



$pdf->Output(); // muestra el archivo pdf no lo descarga
$pdf->Output("facturas/#".$ref."_".$fecha.".pdf","F"); //guarda el archivo pdf sin mostrarlo al usuario

?>
