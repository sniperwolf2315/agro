<?php
$cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); //AZURE10.10.0.5
mssql_select_db('SqlIntegrator',$cLink);

if($cLink){
    echo"se establecio conexion.";
}else{
    echo"no se pudo conectar";
    die(print_r( sqlsrv_errors(),true));
}
?>