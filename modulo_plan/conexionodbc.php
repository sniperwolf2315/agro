<?php
//debe ser de usuario no de sistema
$usuario = "sa";
$clave="%19Sis60Tem@s17";
//$server="10.10.0.5"; implicita en el odbc
//$database="SqlIntegrator"; //implicita en el odbc
$dsn = "planeta"; 
//realizamos la conexion mediante odbc
$connection=odbc_connect($dsn, $usuario, $clave);
//$connection = odbc_connect($dsn;Server=$server;Database=$database;", $user, $password);
if (!$connection){
	die("<strong>Ha ocurrido un error tratando de conectarse con el origen de datos.</strong>");
}
?>