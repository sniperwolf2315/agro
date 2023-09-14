<?php
$id      = strtoupper($_GET['id_doc']);
$cedula  = strtoupper($_GET['doc_act']);
$nombre  = strtoupper($_GET['nom_act']);
$placa   = strtoupper($_GET['plc_emp']);
$empresa = strtoupper($_GET['emp_car']);

if(trim($cedula)=='' && trim($nombre)=='' && trim($empresa)=='' ){
    echo  "no se aceptan campos en blanco";
    return;
}

require( '../../conection/conexion_sql.php' );


$con_sql= new con_sql('sqlfacturas');
$consulta="INSERT INTO DBO.PLACAS_DOMICILIOS_AGRO (CEDULA,NOMBRE_DOMICILIARIO,NUMERO_PLACA,EMPRESA_PERTENECE) VALUES('$cedula','$nombre','$placa','$empresa')";
// echo "$consulta";
$data =  $con_sql->conectar($consulta);

/* sincroniza con las tablas del sia */


 $con_sql->conectar("exec [dbo].[SP_003_GESTION_PLACAS_SIA] '$cedula','$placa' ");




if($data){
    echo "<br>Registro Insertado con exito<br>";
      echo "<meta http-equiv="."refresh"." content="."1;url=index.php".">";
    header("index.php");
}else{
    echo "<br>Registro no se pudo insertar<br>";
}



?>