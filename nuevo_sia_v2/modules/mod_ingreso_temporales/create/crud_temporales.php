<?php

include_once('../../../conection/conexion_sql.php');
$conn =new con_sql();

$id_doc = trim($_GET['id_doc']);
$nom_act= trim($_GET['nom_act']);
$doc_act= strtoupper(trim($_GET['doc_act']));
$are_act= strtoupper(trim($_GET['are_act']));
$jef_act= strtoupper(trim($_GET['jef_act']));
$jor_act= strtoupper(trim($_GET['jor_act']));
$acd_act= strtoupper(trim($_GET['acd_act']));
$are_car= strtoupper(trim($_GET['are_car']));
$user_cargues= strtoupper(trim($_GET['user_cargue']));




$consulta_insert="INSERT INTO agenda_VISITANTES(Nombre,Cedula,Area,Jefe_inmedato,Jornada_programada,ACTIVIDAD,AREA_CARGUE,USUARIO_CARGUE)values('$nom_act',$doc_act,'$are_act','$jef_act','$jor_act','$acd_act','$are_car','$user_cargues')";

if($conn->consultar($consulta_insert)){
    echo "<br>DATO INSERTADO CORRECTAMENTE DE LA AGENDA<br>";
    echo "<meta http-equiv="."refresh"." content="."1;url=insert_temporales_uno.php".">";
}else{
    echo "<br>No se pueden insertar los datos<br>";
    
}
?>