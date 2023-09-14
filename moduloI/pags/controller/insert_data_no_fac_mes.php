<?php
/** INSERTAR LA INFORMACION EN LA TABLA FAC DETALLE FACTURA */
/* VAMOS A INCLUIR LA CLASE CONEXION */
/*
http://192.168.6.55/moduloI/pags/controller/insert_data_no_fac_mes.php
http://192.168.1.115/moduloI/pags/controller/insert_data_no_fac_mes.php
*/

// include( '../../nuevo_sia_v2/conection/conexion_sql.php' );
// include( '../../nuevo_sia_v2/conection/conexion_ibs.php' );
include( 'general_funciones.php' );

$ibs_conn_act = new con_ibs('','','');


$fecha_de_hoy = date( 'Ymd' );
$fecha_de_hoy_menos_1_meses = date( 'Ymd', strtotime( $fecha_de_hoy.'- 1 month' ) );
$arreglo_insert_table = '';
/* fechas formato aaammdd */
$fechaActual = date( 'Ymd' );
$ini_corte   = date( 'Ym', strtotime( $fechaActual.'- 1 month' ) ).'16';
$fin_corte   = date( 'Ym', strtotime( $fechaActual ) ).'15';
$periodo_anterior   = date( 'Ym', strtotime( $fechaActual.'- 1 month' ) );
$where_fechas ='';

/*ESTA VARIABLE SE USA PARA SABER SI SE DEBE ACTUALZIAR LA TABLA O NO */
// $ini_corte   =  '20221015';

$actualiza_tabla = 0;
$periodo 		= $_POST['lsPeriodo'] ;
$area_qry 		= $_POST['area'] ;
$usuario_qry	= $_SESSION['usuARioS'] ;
$metodo_consulta = 0;

if($periodo =='Por_Fechas'){
	$fecha_desde_con = str_replace("-","",$_POST['desde']);
	$fecha_hasta_con = str_replace("-","",$_POST['hasta']);
	$periodo ='Por_Fechas';
	$metodo_consulta = 1;
	
	if(($fechaActual >= $fecha_desde_con) && ($fechaActual <= $fecha_hasta_con )) {
		// echo  "<br> Actual <br> ";
		$ini_corte = $fecha_desde_con;
		$fin_corte = $fecha_hasta_con;
		$where_fechas ="FECHA_ORDEN between'$ini_corte' and '$fin_corte'";
		$where_fechas_sia ="FECHAORDEN between'$ini_corte' and '$fin_corte'";
		$actualiza_tabla  = 1;
	}else{
		// echo  "<br> Anterior <br> ";
	}
	/*█████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████ */
}else{
	$metodo_consulta = 2;
	// echo "consulta por periodo => $periodo <br>";
	$rango_ini ='';
	$rango_fin ='';
	
	$fechas_rangos_per = mssql_query("select fechaini,fechafin from agrPeriodo where codigo = '$periodo'");
	while ($row= mssql_fetch_array($fechas_rangos_per)) {
		$rango_ini =$row[0];
		$rango_fin =$row[1];
	}
	
	if(($fechaActual >= $rango_ini) && ($fechaActual <= $rango_fin )) {
		// echo  "<br> Actual <br> ";
		$ini_corte = $rango_ini;
		$where_fechas ="FECHA_ORDEN >='$ini_corte'";
		$actualiza_tabla  = 1;
		$where_fechas_sia ="FECHAORDEN between'$ini_corte' and '$fin_corte'";
	}else{
		// echo  "<br> Anterior <br> ";
	}
	/*█████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████ */
}

/* se valida su se debe agrear al genera o indiviaul o por area */

if($actualiza_tabla===1){
	/* 1 admin -> 2 lider -> 3 vendedor */
	switch ($nivel_usuario){
		case 1:
			$where_fechas .=" ";
			break;
		case 2:
				$where_fechas .=" AND sector ='$area_qry '";
				$where_fechas_qry ="AND 
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
				END) ='$area_qry'";
				break;
		case 3:
				$where_fechas     .= " and VENDEDOR ='$nombre_usuario'";
				$where_fechas_sia .= " and VENDEDOR ='$nombre_usuario'";
				$where_fechas_qry  = " and VENDEDOR ='$nombre_usuario'";
				break;
	}
/*
echo"
<br>Usted $nombre_usuario tiene nivel $nivel_usuario
<BR>$fechaActual  $fecha_desde_con  $fecha_hasta_con
<BR>$actualiza_tabla
<BR>$where_fechas
<br> el area es $area_qry <br>
SELECT distinct(FECHA_ORDEN) FECHA_ORDEN FROM AGR620CFAG.VISVENTASORDEN1 WHERE $where_fechas order by fecha_orden
$where_fechas_qry
";
*/


/* 
	VALIDAMOS SI EL PERIODO QUE ESTOY PASANDO ES IGUAL O MAYOR AL PERIODO ANTERIOR
1. SE PROGRAMA EL SCRIPT DE INSERT_DATA_FAC_DET_FACTURA_PROD.PHP PARA QUE SOLO SE EJCUTE A LAS 12PM
2. SI EL PERIODO ACTUAL ES > QUE EL PERIODO ANTERIORO EJECUTA EL INSERT , CASO CONTRARIO SOLO CONSULTA 
*/
mssql_query( "delete from dbo.FACDETALLEFACTURA_NOFAC where $where_fechas_sia" );


$insert_detalle_fac = ("INSERT INTO [dbo].[FACDETALLEFACTURA_NOFAC]([Tipo],[Factura],[Fecha],[FechaOrden],[Cedula],[NombreCliente],[Bodega],[Vendedor],[DesVendedor],[Call],[Manejador],[Linea],[Item],[Descripcion],[FOC],[Grupo],[Segmento],[Familia],[Cantidad],[ValorSinIVA],[ValorIVA],[Valor],[Planeador],[Sector])VALUES " );
/** RECORREMOS PRIMERO LAS  FECHAS PARA LIMITAR LA CONSULTA */
// $sql_rondas = ( "SELECT distinct(FECHA_ORDEN) FECHA_ORDEN FROM AGR620CFAG.VISVENTASORDEN1 WHERE FECHA_ORDEN >='$ini_corte' order by fecha_orden" );
$sql_rondas = ( "SELECT distinct(FECHA_ORDEN) FECHA_ORDEN FROM AGR620CFAG.VISVENTASORDEN1 WHERE $where_fechas order by fecha_orden" );
// echo "<br> $sql_rondas<br>";
$rta_sql_ibs_f = $ibs_conn_act ->conectar( $sql_rondas );


while( $fechas = odbc_fetch_array( $rta_sql_ibs_f ) ) {
	// echo "<br>".$fechas['FECHA_ORDEN']."<br>";
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
	FROM 
		AGR620CFAG.VISVENTASORDEN1 as V1 LEFT JOIN AGR620CFAG.SROCTLSD SROCTLSD ON SROCTLSD.CTSIGN=V1.CALL AND CTNLVA='CALLCENTER'
	WHERE 
		V1.FECHA_ORDEN = '".$fechas['FECHA_ORDEN']."' 
		AND V1.ESTADO_ORDEN<>60
		$where_fechas_qry
	"
	);
		// echo $sql_ibs_1_meses.'<br><br><br>';
		$rta_sql_ibs = $ibs_conn_act->conectar( $sql_ibs_1_meses );
		while( $datos = odbc_fetch_array( $rta_sql_ibs ) ) {
			$arreglo_insert_table = "('$datos[TIPO]','$datos[FACTURA]','$datos[FECHA_FACTURA]','$datos[FECHA_ORDEN]','$datos[CEDULA]','".str_replace( ',', '', str_replace( '.', '', str_replace( "'", '', remove_characters( $datos[ NOMBRE_CLIENTE ] ) ) ) )."','$datos[BODEGA]','$datos[VENDEDOR]','".str_replace( ',', '', str_replace( '.', '', remove_characters( $datos[ DES_VENDE ] ) ) ) ."','$datos[CALL]','$datos[MANEJADOR]',$datos[LINEA],'$datos[ITEM]','".remove_characters( $dato[ Descripcion ] )."',$datos[FOC],'$datos[GRUPO]','$datos[SEGMENTO]','$datos[FAMILIA]',$datos[CANTIDAD],$datos[VALORSINIVA],$datos[IVA],$datos[VALOR],'-','--')";
			// echo "$insert_detalle_fac $arreglo_insert_table <br><br>";
			// $sqlcon->insertar( $insert_detalle_fac.$arreglo_insert_table );
			mssql_query($insert_detalle_fac.$arreglo_insert_table );
		}
	}
	
	// mssql_close();
	// odbc_close_all();
	mssql_free_result();
	// echo "<center> TODO OK</center>";
}else{
	// echo "<br><center>No debe recargar la tabla </center><br>";
}
?>


