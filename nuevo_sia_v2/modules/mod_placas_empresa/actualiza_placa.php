<?php
$id      = $_GET['id_doc'];
$cedula  = $_GET['doc_act'];
$nombre  = $_GET['nom_act'];
$placa   = $_GET['plc_emp'];
$empresa = $_GET['emp_car'];
$activo  = $_GET['activo'];

if(trim($cedula)=='0000000000' && trim($nombre)=='SIN_DATO' && trim($empresa)=='SIN_DATO' ){
    echo  "no se aceptan campo en blanco";
    return;
}

require( '../../conection/conexion_sql.php' );


$con_sql= new con_sql('sqlfacturas');
$consulta="update DBO.PLACAS_DOMICILIOS_AGRO set CEDULA='$cedula',NOMBRE_DOMICILIARIO='$nombre',EMPRESA_PERTENECE='$empresa',NUMERO_PLACA='$placa',ACTIVO=$activo WHERE ID =$id";
echo "$consulta";
$data =  $con_sql->conectar($consulta);

/* sincroniza con las tablas del sia */

$con_sql->conectar("exec [dbo].[SP_003_GESTION_PLACAS_SIA] '$cedula','$placa' ");
if($data){
    echo "<br>Registro actualizado con exito<br>";
    echo "<meta http-equiv="."refresh"." content="."1;url=index.php".">";
}else{
    echo "<br>Registro no se pudo actualizar<br>";
}



?>