<?php
include('user_con.php');

$result = mssql_query("select * from zAgroPremios2019");
$resultArr = mssql_fetch_array($result);
print_r($resultArr);
//DRIVER={SQL Server}
//$conexión = odbc_connect("Driver={SQL Server Native Client 10.0};Server=$server;Database=$database;", $user, $password);
//$conexión = odbc_connect("Driver={SQL Server};Server=$server;Database=$database;", $user, $password);

//$serverName = "serverName\sqlexpress"; //serverName\instanceName
//$connectionInfo = array( "Database"=>"SqlIntegrator", "UID"=>"sa", "PWD"=>"%19Sis60Tem@s17");
//$connection_string = 'DRIVER={SQL Server};SERVER=<192.168.6.15>;DATABASE=<SqlIntegrator>';
//$conn = sqlsrv_connect( $server, $connectionInfo);
//$conn = odbc_connect( $connection_string, $user, $pass );
if( $conn ) {
     echo "Conexión establecida.<br />";
}else{
     echo "Conexión no se pudo establecer.<br />";
     //die( print_r( sqlsrv_errors(), true));
}

//echo $conexión."-";
//if ($conexión==true) {
//    echo "conectado";
//}else{
//    echo "no conectado";
//}
//include('conexionsql.php')
//conectar();
//c=Conexion_2020.conectar();
?>