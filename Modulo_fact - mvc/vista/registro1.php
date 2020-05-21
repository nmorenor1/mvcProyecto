<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <script>
    window.onload=function(){
                // Una vez cargada la página, el formulario se enviara automáticamente.
		document.forms["usuario"].submit();
    }
    </script>
</head>

<body>
    
<?php
require('../modelo/conexion.php');//instanciar la conexion de la base de datos
    /*
$arrContextOptions=array(
        "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    );  

    $response = file_get_contents("https://thomasmti.com/wp-json", false, stream_context_create($arrContextOptions));
    $json = json_decode($response, true);
    $num0= $json["namespaces"]["0"]; //*/
$valor=1; //aqui va el Json
$usu = strval($valor);
$valor2=2; //aqui va el Json
$subasta = strval($valor2);
$cone = new DBA();
$cone->conectar();
if($cone){
    echo "funciono conexion";
}else{
    echo "fallo conexion";
}
$sql = "insert into bt_factura(fac_ref,fec_fact,fac_usr) values (default,NOW(),".$usu.")";

$resultado2 = mysqli_query($cone->conexion,$sql);

echo "<br>";
if($resultado2){
    echo "funciono insercion";
}else{
    echo "fallo insercion";
}

?>

<form name="usuario" action="../controlador/logica.php" method="POST">
	<input type="text" name="nombre" value="<?php echo $usu ?>" >
	<input type="text" name="Auc" value="<?php echo $subasta ?>" >
	
</form>
</body>
</html>



