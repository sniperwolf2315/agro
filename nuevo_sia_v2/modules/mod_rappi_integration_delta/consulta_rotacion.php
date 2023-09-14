<?php
include ('../../conection/conexion_sql.php');
$token= $_GET['t'];
/* SI LA VARAIBLE TOKEN ES DIFERENTE YA NO PASA */
if($token != 'szZDSqLjmOVajG/Z3Z5esfpUmWictS2QbWZKBzeGFnU'){
    echo "no tiene permiso";   
    return;
}






?>