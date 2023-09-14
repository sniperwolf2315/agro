<?php
// echo 'ESTE ES EL ARCHIVO DE DESARROLLO<br>';
//ESTO NO SE DEBE BORRAR PARA IDENTIFICAR QUE ES EL ARCHIVO DE DESARROLLO

include_once ('../../../nuevo_sia_v2/conection/conexion_sql.php');
include_once ('../../../nuevo_sia_v2/conection/conexion_ibs.php');
// include_once( './conection/conexion_db.php' );
/* Cada media hora: Extrae la informacion de IBS y guarda en tabla MySql la infor a ser morstrada en el control de dias de despacho A las 8pm gurada los dpatos para el indicador en dia 3  */

$con_ibs = new con_ibs();
$con_sql = new con_sql('sqlFacturas');


$hoy    = date( 'Ymd' );
$hoy_1  = date( 'Ymd', strtotime( "$hoy - 1 day" ) );
$hoy_2  = date( 'Ymd', strtotime( "$hoy - 2 day" ) );
$hoy_3  = date( 'Ymd', strtotime( "$hoy - 3 day" ) );
$hoy_4  = date( 'Ymd', strtotime( "$hoy - 4 day" ) );
$hoy_10 = date( 'Ymd', strtotime( "$hoy - 10 day" ) );

$n       = 1;
$hoy_n   = date( 'Ymd', strtotime( "$hoy - $n day" ) );
$ahora   = date( 'M-d. H:i' );
$ahoraHM = date( 'H:i' );
$ahora   = str_replace( 'Jan', 'Ene', $ahora );
$area    = 'Moto';


if( $area == 'Portos' ) {
}else if ( $area == 'Calle73' ) {
}else if ( $area == 'Moto' ) {
    $farea = "and SROORSHE.OHDEST IN ('1','2','3') ";
}

$cuantoantes = $hoy_10;

// inserta encabezados sql local
if(!$con_sql->consultar("TRUNCATE TABLE TableroDiasVentas")){
  echo "Error al vaciar tabla TableroDiasVentas";
}



/* DESEAMOS SABER CUANTAS RONDAS DEBEN HACERCE */
$sql_rondas = ( "select distinct (OHODAT) from agr620cfag.sroorshe where  OHORDT in( '01', '03', '04', '06','D3','D5','S1','S2', 'S3', 'S5' ) and ohodat >= '$cuantoantes' and ohstat <> 'D' and ohords <> 0 order by ohodat" );

// $rondas_grupos_fechas = odbc_exec( $con_ibs,  $sql_rondas );
$rondas_grupos_fechas = $con_ibs->conectar($sql_rondas);
$contador_insert = 0;

/*
    $insertar_consulta = "INSERT INTO TableroDiasVentas (ORDEN,TIPO,CC,ESTADO_OV,ESTADO,MIN_ESTADO,MAX_ESTADO,FECHA,DIA,DESTINO,ACTUALIZADO,DEST) VALUES";
    $cuerpo_consulta   = "";
*/


while( $rondas = odbc_fetch_array( $rondas_grupos_fechas ) ) {
    $id++;
    $cuantoantes = $rondas[ 'OHODAT' ];

   /*//PREPARAR LA CONSULTA PARA INSERTAR LOS DATOS A SQL*/
    $sql =("SELECT 
	DISTINCT
    ohorno as ORDEN
   ,ohordt as TIPO
   ,replace(ohcuno,'-','') as CC
   ,ohords as ESTADO_OV
   ,case when (select max(olords) as max_estado from sroorspl srbsol where srbsol.olorno = sroorshe.ohorno ) = '10' then '10' when (select max(olords) as max_estado from sroorspl srbsol where srbsol.olorno = sroorshe.ohorno ) = '60' then '60' else ohords end as ESTADO	    
   ,(select min(olords) as min_estado from sroorspl srbsol where srbsol.olorno = sroorshe.ohorno ) as MIN_ESTADO
   ,(select max(olords) as max_estado from sroorspl srbsol where srbsol.olorno = sroorshe.ohorno ) as MAX_ESTADO
   ,substr(ohodat,1,4)||'-'||substr(ohodat,5,2)||'-'||substr(ohodat,7,2) as FECHA
   ,case when ohodat = '$hoy' then '1' when ohodat between '$hoy_2' and '$hoy_1' then '2' when ohodat = '$hoy_3' then '3' when ohodat <= '$hoy_4' then '4 o mas' end as dia
   , ifnull(( select case when substr(sroorshe.ohdest,1,4)= '1100' then 'domi-agro' when substr(sroorshe.ohdest,1,4) < 10 then substr(trim(dtdesc),1,7) else 'rem-'||substr(trim(dtdesc),1,7) end FROM AGR620CFAG.SRODST where dtdest = sroorshe.ohdest limit 1 ),'SIN DEST')  as DESTINO
   ,(CASE 
	WHEN CALL<>CTSIGN OR MANEJADOR='MERCADEO' THEN 'MERCADEO'
	WHEN CALL<>CTSIGN OR CLIENTE IN ('900423563') THEN 'PESTAR'
	WHEN CALL<>CTSIGN OR VENDEDOR='VEND157' OR VENDEDOR ='SUAREZM' OR VENDEDOR ='SUAREZC' OR VENDEDOR = 'VEND217' OR CLIENTE IN ('800159998') THEN 'INSTITUCIONAL' 
	WHEN CALL<>CTSIGN OR CALL='MARTINEZF'   OR CALL ='RODRIGUEZJ' THEN 'TRASLADOS'
	WHEN CALL<>CTSIGN OR CALL ='ALIANZAS'   OR CALL ='NETSTORE' OR CALL ='VEND528' OR CALL ='VEND561' OR VENDEDOR ='VEND417' OR CLIENTE IN ('1056028493','9007487391','900844137','901295969','1020775290','10207752909','901128047','9011280475','900041991','9006676820','79592537','901325040','1098716630','901425454','901333960','52970714','900525765','9008438989','9008438984','9008438981','9008438982','901110407','9011104074', '1056028493','9007487391','900844137','901295969','901128047','1020775290','10207752909','9011280475','900770206','9007702068', '52430443','9006676820','79592537','901325040','1098716630', '901425454','901333960', '900839095', '9008390956') THEN 'CANALES DIGITALES'
	WHEN CALL<>CTSIGN OR CALL LIKE 'VENDWEB%' OR CALL LIKE 'DIGITAL%' OR CALL='INTEGRATOR' OR CALL = 'ESTADISTIC' THEN 'PAGINA WEB'
	WHEN CALL=CTSIGN  AND MANEJADOR ='VANANDELL' AND CALL <> 'VANANDELL' AND VENDEDOR IN ('VEND114', 'VEND214') THEN 'TELEOPERADOR CONSULTORIO'
	WHEN CALL=CTSIGN  AND MANEJADOR ='VANANDELL' AND CALL <> 'VANANDELL' THEN 'TELEOPERADOR EXTERNA'
	WHEN CALL=CTSIGN  OR VENDEDOR ='VENDECOM' THEN 'CALLCENTER'
	WHEN CALL<>CTSIGN OR MANEJADOR='VANANDELL' AND VENDEDOR = 'VENDOTC' THEN 'VENTA EXTERNA LICITACIONES'
	WHEN CALL<>CTSIGN OR MANEJADOR='ADMINISTRA' OR CALL LIKE 'CAJA%' OR CALL='VEND999' THEN 'ALMACEN'
	WHEN CALL<>CTSIGN OR MANEJADOR='VANANDELL' THEN 'VENTA EXTERNA'
	END) AS SECTOR,
    VENDEDOR as VENDEDOR
FROM
   AGR620CFAG.SROORSHE SROORSHE
   LEFT JOIN AGR620CFAG.VISVENTASORDEN1 V1 on V1.NUMERO_ORDEN = SROORSHE.ohorno
   LEFT JOIN AGR620CFAG.SROCTLSD SROCTLSD ON SROCTLSD.CTSIGN=V1.CALL AND CTNLVA='CALLCENTER'
WHERE
   OHORDT in  ( '01', '03', '04', '06','D3','D4','D5','S1','S2', 'S3', 'S5' )
   and ohodat = '$cuantoantes'
   and ohstat <> 'D'
   and ohords <> '0'
");
//    echo $sql.'<br><br>';
 
    $result = $con_ibs->conectar($sql ) ;
    while( $row = odbc_fetch_array( $result ) ) {
        
        $row[ 'ACTUALIZADO' ] = $ahora;
        $dia                  = $row[ 'DIA' ];
        $orden                = $row[ 'ORDEN' ];
        $estado               = $row[ 'ESTADO' ];
        $row[ 'DEST' ]        = SUBSTR( $row[ 'DESTINO' ], 0, 3 );


        if ( $row[ 'MAX_ESTADO' ] == '60' ) {
            $e60 .= ",'$row[ORDEN]'" ;
        }

        $comaC = '';
        $comaV = '';


        foreach ( $row as $campo => $valor ) {
            //datos tablero
            $ti[ "$dia" ][ "$orden" ][ "$campo" ] = utf8_encode( strtoupper( $valor ) );
            
            //construye insert SQL
            $campos .= "$comaC$campo";
            $valores .= "$comaV$valor";
            $comaC = ',';
            $comaV = "','";
        }
        /*
        // echo "INSERT INTO TableroDiasVentas ($campos) VALUES ('$valores'); <br> <br>";
        // $mysqlINSERT[ "$orden" ] = "INSERT INTO TableroDiasVentas ($campos) VALUES ('$valores') ";
        */

        /* CREAR QUERY DE INSERT */
        $insert_data= ("INSERT INTO TableroDiasVentas ($campos) VALUES ('$valores')");
        $con_sql->insertar($insert_data);
   
        $campos = '';
        $valores = '';

      }
}

$e60 = substr( $e60, 1 );

mssql_close();
odbc_close_all();
echo "Todo OK";
?>