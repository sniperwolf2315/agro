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

$consulta_update="update agenda_VISITANTES set Nombre='$nom_act',Cedula=$doc_act,Area='$are_act',Jefe_inmedato='$jef_act',Jornada_programada='$jor_act',ACTIVIDAD='$acd_act',AREA_CARGUE='$are_car' where Id=$id_doc ";

if($conn->consultar($consulta_update)){
    echo "todo OK";
}else{
    echo "No se pueden actualziar los datos";
    
}


// echo  "$id_doc  - $nom_act $doc_act $are_act $jef_act $jor_act $acd_act";
?>