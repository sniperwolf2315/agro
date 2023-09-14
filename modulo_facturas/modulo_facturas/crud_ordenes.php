<?php

include_once('../../nuevo_sia_v2/conection/conexion_sql.php');
$conn =new con_sql();

$num_fac = trim($_GET['num_fac']);
$tipo_fac= trim($_GET['tipo_fac']);
$num_guia= trim($_GET['num_guia']);
$vlr_guia= trim($_GET['vlr_guia']);

/*
$consulta_update="update facRegistroEtiquetaTmp set Guia='$num_guia',ValorGuia=$vlr_guia where Tipo='$tipo_fac' and  Factura='$num_fac' ";
*/
$consulta_update="update facRegistroEtiqueta set Guia='$num_guia',ValorGuia=$vlr_guia where Tipo='$tipo_fac' and  Factura='$num_fac' ";
if($conn->consultar($consulta_update)){
    echo "actualizada la guia OK";
    echo "<meta http-equiv='refresh' content='1'>";
}else{
    echo "No se pueden actualziar los datos";
    
}
?>