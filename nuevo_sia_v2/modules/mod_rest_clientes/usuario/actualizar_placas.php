<?php
require('../../../conection/conexion_sql.php');

$con_sql            =new con_sql('SQLFACTURAS');
    
$anio = date("Y");
$mes  = date("m");
$dia  = date("d");

$id      = strtoupper(trim($_GET["id_key"])); 
$cedula  = strtoupper(trim($_GET["num_ced"])); 
$nombre  = strtoupper(trim($_GET["nombre"])); 
$placa   = strtoupper(trim($_GET["num_placa"])); 
$empresa = strtoupper(trim($_GET["empresa"])); 

echo "
Parametros enviados:
<br> id      : $id     
<br> cedula  : $cedula 
<br> placa   : $placa  
<br> empresa : $empresa
<br> nombre  : $nombre 
";

if( $id!='sin datos' && $placa!='SIN PLA'  ){
    echo "1";
    //  $act_placa="UPDATE API_REPARTIDORES set PLACA ='$placa' where id=$id  and cedula='$cedula' and year(HORA_INGRESO) = '$anio'  and month(HORA_INGRESO)  ='$mes' and empresa='$empresa' and estado='ESPERA'";
    $act_placa="UPDATE API_REPARTIDORES set PLACA ='$placa' where id=$id  and empresa='$empresa' and estado in ('ESPERA','CARGA')";
    // echo"<br> $act_placa <br>";
    $con_sql ->insertar($act_placa);
    $page = $_SERVER['PHP_SELF'];
    $sec = "1";
    echo '<meta http-equiv="refresh" content="3;url=crud_us.php">';
    echo  ' <br> !ACTUALIZADO CON EXITO <br>';
}
else{
    // echo "2";
    return "<br>No se puede hacer el cambio, datos incompletos<br> ";
}

?>