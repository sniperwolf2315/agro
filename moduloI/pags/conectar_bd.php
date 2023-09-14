<?php
// echo "conectar sql ";
function conectar_Sql($name_db) //CONEXION A LA BD SQL SERVER 2017
{
    $server_name = '192.168.6.15';
    $user_name = 'sa';
    $user_pass = '%19Sis60Tem@s17';
    $cLink = mssql_connect($server_name, $user_name, $user_pass) or die(mssql_get_last_message());
    mssql_select_db($name_db, $cLink);
    if (!$cLink) {
        echo "sin conectar a l server";
    } 
}

?>