<?php
// session_destroy();
session_start();
include_once( 'ventas_area_AG.php' );
include_once( './lib_ibs/user_conect_ibs.php' );

// echo $sql_10;
//??esta es la query que retorna el estado  IBS
$HORA_ACTUAL   = DATE( 'H' );

$MINUTO_ACTUAL = DATE( 'i' );

// echo "HORA: $HORA_ACTUAL   MINUTO:$MINUTO_ACTUAL";

$LLENAR_TABLA = 0;
if ( $LLENAR_TABLA === 1 ) {
    // if ( ( ( $HORA_ACTUAL >= '11' && $HORA_ACTUAL <= '9' ) ) || $HORA_ACTUAL == '4' || $HORA_ACTUAL == '16'  || $HORA_ACTUAL >= '18' ) {
    if ( ( ( $MINUTO_ACTUAL >= '28' && $MINUTO_ACTUAL <= '28' ) ) ) {
        echo 'H: '.$HORA_ACTUAL.' M:'.$MINUTO_ACTUAL;
        echo hola();

    } else {
        echo '<BR><BR>EL SERVICIO DE CONSULTAS SE HABILITARÁ DE 07:00 A 09:00  Y DE 16:00 - 17:00, GRACIAS POR SU COMPRENSIÓN ';
        DIE;
    }
}

/* $sql_10 = "
SELECT 
		TIPO_ORDEN,
        NUMERO_ORDEN as NUMERO_ORDEN
		, FECHA_ORDEN
		, RAZON_SOCIAL
		, SUM(VLR_EXC_IVA) AS TOTAL_EXC_IVA
		FROM VISVENTASORDEN1
		WHERE 
		  ESTADO_ORDEN = '10'
		  AND FECHA_ORDEN > '$desde10'
		GROUP BY
		  TIPO_ORDEN,NUMERO_ORDEN
		  ,FECHA_ORDEN
		  ,RAZON_SOCIAL
		ORDER BY FECHA_ORDEN, TIPO_ORDEN,NUMERO_ORDEN 
";
*/

/*  ESTAS FECHAS SERVIRÁN COMO FILTRO DEL ULTIMO SEMESTRE APARTIR DE LA FECHA ACTUAL */
$fecha_hasta = str_replace( '-', '', strval( date( 'Y-m-d' ) ) );
$fecha_desde = str_replace( '-', '', strval( date( 'Y-m-01', strtotime( $fecha_actual.'- 6 month' ) ) ) );
$sql_10 = "
SELECT 
    NUMERO_ORDEN, 
    TIPO_ORDEN, 
    '' as FACTURA, 
    FECHA_FACTURA, 
    FECHA_ORDEN, 
    CLIENTE, NOMBRECLIENTE, 
    '' as BODEGA, 
    VENDEDOR, 
    NOMBRE_VENDEDOR, 
    'CALL' as CALLS, 
    MANEJADOR, 
    LINEA_ORDEN, 
    ITEM, 
    ITEM_DESCRIPCION, 
    FOC, 
    GRUPO, 
    SUBSTRING(FAMILIA, 0, 5) as SEGMENTO, 
    FAMILIA, 
    CANTIDAD, 
    VLR_EXC_IVA, 
    VLR_INC_IVA, 
    VLR_INC_IVA as VALOR, 
    PLANEADOR, 
    '' as SECTOR
FROM 
    VISVENTASORDEN1 
WHERE 
    ESTADO_ORDEN = '10'
    AND (FECHA_ORDEN >= '$fecha_desde'  
    AND FECHA_ORDEN <= '$fecha_hasta')
LIMIT 10
";

// echo "$fecha_desde - $fecha_hasta  <br> " ;
// echo $sql_10;

//  odbc_result_all( conectar_ibs_general_query( $sql_10 ) );

$rta =   conectar_ibs_general_query( $sql_10 ) ;
while( $row = odbc_fetch_array( $rta ) ) {
    mssql_query( "INSERT INTO facDetalleOrdenVenta   VALUES(
      ".$row[ 'NUMERO_ORDEN' ] .",'".
        $row[ 'TIPO_ORDEN' ]."','  ". 
        $row[ 'FACTURA' ]           ,
        $row[ 'FECHA_FACTURA' ]     ,
        $row[ 'FECHA_ORDEN' ]       ,
        $row[ 'CLIENTE' ]           ,
        $row[ 'NOMBRECLIENTE' ]     ,
        $row[ 'BODEGA' ]            ,
        $row[ 'VENDEDOR' ]          ,
        $row[ 'NOMBRE_VENDEDOR' ]   ,
        $row[ 'CALLS' ]             ,
        $row[ 'MANEJADOR' ]         ,
        $row[ 'LINEA_ORDEN' ]       ,
        $row[ 'ITEM' ]              ,
        $row[ 'ITEM_DESCRIPCION' ]  ,
        $row[ 'FOC' ]               ,
        $row[ 'GRUPO' ]             ,
        $row[ 'SEGMENTO' ]          ,
        $row[ 'FAMILIA' ]           ,
        $row[ 'CANTIDAD' ]          ,
        $row[ 'VLR_EXC_IVA' ]       ,
        $row[ 'VLR_INC_IVA' ]       ,
        $row[ 'VALOR' ]             ,
        $row[ 'PLANEADOR' ]         ,
        $row[ 'SECTOR' ]            .   "
    )" );




    // echo
    // $row[ 'NUMERO_ORDEN' ].''.$row[ 'TIPO_ORDEN' ] .''.$row[ 'FACTURA' ].''.$row[ 'FECHA_FACTURA' ].''.$row[ 'FECHA_ORDEN' ].''.$row[ 'CLIENTE' ].''.
    // $row[ 'NOMBRECLIENTE' ].''.   $row[ 'BODEGA' ].''. $row[ 'VENDEDOR' ].''.$row[ 'NOMBRE_VENDEDOR' ].''.$row[ 'CALLS' ].''.$row[ 'MANEJADOR' ].''.
    // $row[ 'LINEA_ORDEN' ].''.   $row[ 'ITEM' ] .''.$row[ 'ITEM_DESCRIPCION' ].''.$row[ 'FOC' ].''.$row[ 'GRUPO' ].''.$row[ 'SEGMENTO' ].''.
    // $row[ 'FAMILIA' ].''.   $row[ 'CANTIDAD' ] .''.$row[ 'VLR_EXC_IVA' ].''.$row[ 'VLR_INC_IVA' ].''.$row[ 'VALOR' ].''.$row[ 'PLANEADOR' ].''.
    // $row[ 'SECTOR' ];
}
?>
