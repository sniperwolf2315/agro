<?php
class Conexion_2020{
 var $tabla = "";
 var $consulta = "";
 var $conn;
 
//Conexión SQL Server
 var $conexion = 'DRIVER={SQL Server};SERVER=192.168.6.15\SQL2017;DATABASE=SqlIntegrator';
 var $user = 'sa'; 
 var $pass = '%19Sis60Tem@s17';
  
// crear conexion con sqlserver
 function conectar(){
  if (!($this->conn = odbc_connect($this->conexion, $this->user, $this->pass))){
   echo 'error al conectarse con la Base de Datos' ;
  }
  else{
    //echo ' Conexion exitosa';
  }
 }
 
// consultar la base de datos
 function ejecutar($query){
 return odbc_exec($this->conn, $query);
 $this->cerrarConexion() ;
 }
 
// cierra una conexion con sqlserver
 function cerrarConexion(){
  odbc_close($this->conn) ;
 }
}
?>