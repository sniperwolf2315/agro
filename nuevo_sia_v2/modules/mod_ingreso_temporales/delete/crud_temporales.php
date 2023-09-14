<?php

include_once('../../../conection/conexion_sql.php');
$conn =new con_sql();

$id_doc = trim($_GET['id_doc']);
$nom_act= trim($_GET['nom_act']);
$doc_act= trim($_GET['doc_act']);
$are_act= trim($_GET['are_act']);
$jef_act= trim($_GET['jef_act']);
$jor_act= trim($_GET['jor_act']);
$acd_act= trim($_GET['acd_act']);
$are_car= trim($_GET['are_car']);

$consulta_update="delete from agenda_VISITANTES  where Id=$id_doc and  Cedula=$doc_act ";

if($conn->consultar($consulta_update)){
    echo "DATO ELIMINADO CORRECTAMENTE DE LA AGENDA";
    echo "<meta http-equiv="."refresh"." content="."1;url=delete_temporales.php".">";
}else{
    echo "No se pueden borrar los datos";
}

?>