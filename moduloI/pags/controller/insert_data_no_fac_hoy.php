<?php
//192.168.6.55/moduloI/pags/controller/insert_data_no_fac_mes.php
// ECHO "<center>TODO LO QUE NO ESTA FACTURADO</center>";
/** INSERTAR LA INFORMACION EN LA TABLA FAC DETALLE FACTURA NO FAC */
/*

http://192.168.6.55/moduloI/pags/controller/insert_data_no_fac_hoy.php
*/
require( '../../../nuevo_sia_v2/conection/conexion_ibs.php' );
require( '../../../nuevo_sia_v2/conection/conexion_sql.php' );
require( '../../../general_funciones.php' );






/*████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████ */
/*████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████ */
/*████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████ */


$time_pre = microtime( true );

$db2conp = new con_ibs( 'IBM-AGROCAMPO-P',odbc, odbc );
echo ( !$db2conp )?'<br> ERROR CONEXION A IBS<br>' :'';

$sqlcon = new con_sql( 'SQLFACTURAS' );
echo ( !$sqlcon )?'<br> ERROR CONEXION A SQLSERVER<br>' :'';
mssql_select_db( 'SQLFACTURAS' );

$fecha_de_hoy = date( 'Ymd' );
$fecha_de_hoy_menos_1_meses = date( 'Ymd', strtotime( $fecha_de_hoy.'- 1 month' ) );

$arreglo_insert_table = '';
/* fechas formato aaammdd */
$fechaActual = date( 'Ymd' );
$ini_corte   =  date( 'Ym', strtotime( $fechaActual.'- 1 month' ) ).'16';
$fin_corte   =  date( 'Ym', strtotime( $fechaActual ) ).'15';
// $ini_corte   =  '20221015';

/** ELIMIAR REGISTRO DE 2 MESES HACIA ATRAS !POR FAVOR NO DESOCUPAR LA TABLA¡ */
// echo "delete from dbo.FACDETALLEFACTURA_NOFAC where fecha >= '$ini_corte'";


mssql_query( "delete from dbo.FACDETALLEFACTURAHOY_NOFAC where fecha >= '$ini_corte'" );

$ejecutar_consulta = 0;
$insert_detalle_fac = (
    "INSERT INTO [dbo].[FACDETALLEFACTURAHOY_NOFAC]([Tipo],[Factura],[Fecha],[FechaOrden],[Cedula],[NombreCliente],[Bodega],[Vendedor],[DesVendedor],[Call],[Manejador],[Linea],[Item],[Descripcion],[FOC],[Grupo],[Segmento],[Familia],[Cantidad],[ValorSinIVA],[ValorIVA],[Valor],[Planeador],[Sector])VALUES " );
    /** RECORREMOS PRIMERO LAS  FECHAS PARA LIMITAR LA CONSULTA */
    // $sql_rondas = ( "SELECT distinct(FECHA_ORDEN) FECHA_ORDEN FROM AGR620CFAG.VISVENTASORDEN1 WHERE FECHA_ORDEN >='$ini_corte' order by fecha_orden" );
	// echo $sql_rondas;
	// $rta_sql_ibs_f = $db2conp->conectar( $sql_rondas );
	// $rta_sql_ibs_f = periodos_comerciales($fechaActual);
$fechaActual = explode(" ",$fechaActual);

foreach ( $fechaActual  as $fechas ){
// while( $fechas = odbc_fetch_array( $rta_sql_ibs_f ) ) {
		
        $arreglo_insert_table = '';
		$sql_ibs_1_meses = ( "
					SELECT 
					V1.TIPO_ORDEN as TIPO,
					(SELECT SRBISH.IHINVN FROM AGR620CFAG.SROISH SRBISH  WHERE IHINVN =V1.CLIENTE LIMIT 1) AS FACTURA,
					V1.FECHA_ORDEN AS FECHA_FACTURA,
					V1.FECHA_FACTURA AS FECHA_ORDEN,
					V1.CLIENTE AS CEDULA,
					V1.NOMBRECLIENTE  AS NOMBRE_CLIENTE,
					(select distinct IDSROM from AGR620CFAG.SROISDPL where IDORNO=V1.NUMERO_ORDEN  limit 1) AS  BODEGA,
					V1.VENDEDOR AS VENDEDOR,
					V1.NOMBRE_VENDEDOR AS DES_VENDE,
					V1.CALL, 
					V1.MANEJADOR,
					V1.LINEA_ORDEN AS  LINEA,
					V1.ITEM,
					V1.ITEM_DESCRIPCION,
					(CASE WHEN V1.FOC = 'N' THEN  '0' ELSE '1' END ) AS FOC,
					V1.GRUPO,
					(select distinct TB2.PGISET from AGR620CFAG.SROISDPL TB1 JOIN AGR620CFAG.SROPRG AS TB2  ON TB1.IDPRDC = TB2.PGPRDC where IDORNO=V1.NUMERO_ORDEN  limit 1) AS SEGMENTO,
					V1.FAMILIA,
					V1.CANTIDAD,
					V1.VLR_EXC_IVA AS VALORSINIVA,
					'0' AS IVA,
					V1.VLR_INC_IVA AS  VALOR,
					(CASE 
					WHEN CALL<>CTSIGN OR  MANEJADOR='MERCADEO' THEN 'MERCADEO'
					WHEN CALL<>CTSIGN OR  CLIENTE IN ('900423563') THEN 'PESTAR'
					WHEN CALL<>CTSIGN OR  VENDEDOR='VEND157' OR VENDEDOR ='SUAREZM' OR VENDEDOR ='SUAREZC' OR VENDEDOR = 'VEND217' OR CLIENTE IN ('800159998') THEN 'INSTITUCIONAL' 
					WHEN CALL<>CTSIGN OR  CALL='MARTINEZF' OR CALL ='RODRIGUEZJ' THEN 'TRASLADOS'
					WHEN CALL<>CTSIGN OR  CALL ='ALIANZAS' OR CALL ='NETSTORE' OR CALL ='VEND528' OR CALL ='VEND561' OR VENDEDOR ='VEND417' OR CLIENTE IN ('1056028493','9007487391','900844137','901295969', '1020775290','10207752909','901128047','9011280475','900041991','9006676820','79592537','901325040','1098716630', '901425454','901333960','52970714','900525765','9008438989','9008438984','9008438981','9008438982','901110407','9011104074','1056028493','9007487391', '900844137','901295969','901128047','1020775290', '10207752909','9011280475', '900770206','9007702068','52430443','9006676820','79592537','901325040','1098716630', '901425454','901333960','900839095','9008390956') THEN 'CANALES DIGITALES'
					WHEN CALL<>CTSIGN OR  CALL LIKE 'VENDWEB%' OR CALL LIKE 'DIGITAL%' OR CALL='INTEGRATOR' OR CALL = 'ESTADISTIC' THEN 'PAGINA WEB'
					WHEN CALL=CTSIGN  AND MANEJADOR ='VANANDELL' AND CALL <> 'VANANDELL' AND VENDEDOR IN ('VEND114', 'VEND214') THEN 'TELEOPERADOR CONSULTORIO'
					WHEN CALL=CTSIGN  AND MANEJADOR ='VANANDELL' AND CALL <> 'VANANDELL' THEN 'TELEOPERADOR EXTERNA'
					WHEN CALL=CTSIGN  OR  VENDEDOR ='VENDECOM' THEN 'CALLCENTER'
					WHEN CALL<>CTSIGN OR  MANEJADOR='VANANDELL' AND VENDEDOR = 'VENDOTC' THEN 'VENTA EXTERNA LICITACIONES'
					WHEN CALL<>CTSIGN OR  MANEJADOR='ADMINISTRA' OR CALL LIKE 'CAJA%' OR CALL='VEND999' THEN 'ALMACEN'
					WHEN CALL<>CTSIGN OR  MANEJADOR='VANANDELL' THEN 'VENTA EXTERNA'
					END) AS SECTOR
				FROM AGR620CFAG.VISVENTASORDEN1 as V1 LEFT JOIN AGR620CFAG.SROCTLSD SROCTLSD ON SROCTLSD.CTSIGN=V1.CALL AND CTNLVA='CALLCENTER'
				WHERE 
				V1.FECHA_ORDEN = '".$fechas."' 
				AND V1.ESTADO_ORDEN<>60
				");

    $rta_sql_ibs = $db2conp->conectar( $sql_ibs_1_meses );
	while( $datos = odbc_fetch_array( $rta_sql_ibs ) ) {

		$nombre_cliente 		= str_replace( ',', '', str_replace( '.', '', str_replace( "'", '', remove_characters( $datos[ NOMBRE_CLIENTE ] ) ) ) );
		$descripcion_vendedor 	= str_replace( ',', '', str_replace( '.', '', remove_characters( $datos[ DES_VENDE ] ) ) );
        $descripcion_item 		= remove_characters( $dato[ ITEM_DESCRIPCION ] );
		$cantidad 				= ROUND($datos[CANTIDAD],1);
		$valor_iva 				= str_replace('','0',$datos[IVA]);
		
		$arreglo_insert_table = "('$datos[TIPO]','$datos[FACTURA]','$datos[FECHA_FACTURA]','$datos[FECHA_ORDEN]','$datos[CEDULA]','$nombre_cliente','$datos[BODEGA]','$datos[VENDEDOR]','$descripcion_vendedor','$datos[CALL]','$datos[MANEJADOR]',$datos[LINEA],'$datos[ITEM]','$descripcion_item',$datos[FOC],'$datos[GRUPO]','$datos[SEGMENTO]','$datos[FAMILIA]','$cantidad','$datos[VALORSINIVA]','$valor_iva','$datos[VALOR]','-','$datos[SECTOR]')";
        // echo "$insert_detalle_fac $arreglo_insert_table <br><br>";
        $sqlcon->insertar( $insert_detalle_fac.$arreglo_insert_table );
    }
	
}

$time_post = microtime( true );
$exec_time = $time_post - $time_pre;
// echo( $exec_time/60 ).'<br> Terminó...';

mssql_close();
mssql_free_result();
odbc_close_all();

echo "<center> TODO OK</center>";
?>
