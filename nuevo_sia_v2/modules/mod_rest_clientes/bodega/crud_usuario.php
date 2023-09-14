<?php
include( '../../../conection/conexion_sql.php' );

$crud       = $_GET[ 'estatus' ];
$turno      = $_GET[ 'turno' ];
$placa      = $_GET[ 'placa' ];
$bahia      = $_GET[ 'bahia' ];
$comentario = $_GET[ 'comentario' ];

$sql_con = new con_sql( 'sqlFacturas' );
$con_estatus =  $sql_con->consultar( "select ESTADO from API_REPARTIDORES WHERE ESTADO in('ESPERA','CARGA') TURNO = $turno"); /* si se habilitan las 3 bahias en una pantalla */

$status_act;
while( $st = mssql_fetch_array( $con_estatus ) ) {
    $status_act =  $st[ 0 ];
}
/** VALIDAMOS QUE NO SE QUEME EL MISMO ESTADO*/
if($crud == $status_act ){
    echo "X... LO SENTIEMOS NO PUEDE ASIGNARLE EL MISMO ESTADO";
    return ;
}

/** VALIDAMOS QUE ACCION Y CAMPO VAMOS A ACTULIZAR */

if($crud == 'CARGA'){
    // $sql = ("UPDATE  API_REPARTIDORES  SET ESTADO='".$crud ."',HORA_CARGA = GETDATE() where TURNO=$turno and placa='".$placa."' and estado in('ESPERA') ");
    $sql = ("UPDATE  API_REPARTIDORES  SET ESTADO='CARGA',HORA_CARGA = GETDATE() where TURNO=$turno and placa='".$placa."' and estado in('ESPERA') ");
    echo $sql;
    $sql_con->consultar($sql);
}elseif($crud == 'SALIDA'){
    // $sql = ("UPDATE  API_REPARTIDORES  SET ESTADO='".$crud ."',HORA_SALIDA = GETDATE() where TURNO=$turno and placa='".$placa."' and estado in('ESPERA','CARGA')");
    $sql = ("UPDATE  API_REPARTIDORES  SET ESTADO='SALIDA',HORA_SALIDA = GETDATE() where TURNO=$turno and placa='".$placa."' and estado in('ESPERA','CARGA')");
    $sql_con->consultar($sql);
}elseif($crud == 'ESPERA'){
    // $sql = ("UPDATE  API_REPARTIDORES  SET ESTADO='".$crud ."',DESCRIPCION = '$comentario' where TURNO=$turno and placa='".$placa."' and estado in('ESPERA','CARGA')");
    $sql = ("UPDATE  API_REPARTIDORES  SET ESTADO='ESPERA',DESCRIPCION = '$comentario' where TURNO=$turno and placa='".$placa."' and estado in('ESPERA','CARGA')");
   $sql_con->consultar($sql);
}

?>