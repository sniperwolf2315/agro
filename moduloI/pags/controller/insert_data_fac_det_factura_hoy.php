<?php
/** INSERTAR LA INFORMACION EN LA TABLA FAC DETALLE FACTURA */
/* VAMOS A INCLUIR LA CLASE CONEXION */
// echo  htmlspecialchars($_SERVER['PHP_SELF']);
// echo $_SESSION['clAVe'];
// echo 'DATA DEL MES';
@session_start();

require('../../../nuevo_sia_v2/conection/conexion_ibs.php');
require('../../../nuevo_sia_v2/conection/conexion_sql.php');
require('../../../general_funciones.php');

$time_pre = microtime( true );

$db2conp = new con_ibs(odbc,odbc);
echo (!$db2conp)?'<br> ERROR CONEXION A IBS<br>' :'';

$sqlcon = new con_sql('SQLFACTURAS');
echo (!$sqlcon)?'<br> ERROR CONEXION A SQLSERVER<br>' :'';
mssql_select_db('SQLFACTURAS');


$fecha_de_hoy = date('Ymd');
$fecha_de_hoy_menos_1_meses = date("Ymd",strtotime($fecha_de_hoy."- 1 month"));

$arreglo_insert_table='';
$fechaActual = date('Ym');
$ini_corte   =  date("Ym",strtotime($fechaActual."- 1 month")).'16';
$fin_corte   =  $fechaActual.'15';



echo "ya no entro por aca";
return;
echo "ya no entro";

/**
 */
// mssql_query("delete from dbo.FACDETALLEFACTURANEW where FechaOrden >='$ini_corte ' ");
/* ORDENES DEL DIA DE HOY y llena las ventas   */
/* $insert_detalle_no_fac_hoy=(
	"INSERT INTO [dbo].[facDetalleFactura](
		[Tipo]
		,[Factura]
		,[Fecha]
		,[FechaOrden]
		,[Cedula]
		,[NombreCliente]
		,[Bodega]
		,[Vendedor]
		,[DesVendedor]
		,[Call]
		,[Manejador]
		,[Linea]
		,[Item]
		,[Descripcion]
		,[FOC]
		,[Grupo]
		,[Segmento]
		,[Familia]
		,[Cantidad]
		,[ValorSinIVA]
		,[ValorIVA]
		,[Valor]
		,[Planeador]
		,[Sector])
	VALUES ");

$sql_ibs_dias_hoy = ("
SELECT
SRBSOH.OHORDT AS TIPO,
SRBISH.IHINVN AS FACTURA,
SRBISH.IHIDAT AS FECHA_FACTURA,
SRBISH.IHODAT AS FECHA_ORDEN,
SRBISD.IDCUNO AS CEDULA,
'' AS NOMBRECLIENTE,
SRBISD.IDSROM AS BODEGA,
CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END AS VENDEDOR,
CASE SRBISD.IDINUM WHEN 0 THEN SRBCTLSD.CTNAME ELSE SRBCTLSD_1.CTNAME END AS DES_VENDE,
CASE SRBISD.IDINUM WHEN 0 THEN SRBSOH.OHHAND ELSE SRBSOH_1.OHHAND END AS CALL,
CASE SRBISD.IDINUM WHEN 0 THEN SRBCTLSD.CTSMAN ELSE SRBCTLSD_1.CTSMAN END AS MANEJADOR,
LINEA_ORDEN AS LINEA_ORDEN,
SRBPRG.PGPRDC AS ITEM,
SRBPRG.PGDESC AS DESCRIPCION,
CASE WHEN  SRBISD.IDFOCC ='N' THEN 0 ELSE 1 END AS FOC,
SRBPRG.PGPGRP AS GRUPO,
SRBPRG.PGISET AS SEGMENTA,
SRBCTLPB.PBDESC AS FAMILIA,
CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END AS CANTIDAD,
CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END AS VLR_EXC_IVA,
CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDITT ELSE SRBISD.IDITT*-1 END AS VLR_IVA,
CASE SRBISD.IDTYPP WHEN 1 THEN (SRBISD.IDNSVA + SRBISD.IDITT) ELSE ((SRBISD.IDNSVA + SRBISD.IDITT)*-1) END AS VLR_INC_IVA,
'' AS PLANEADOR,
'' AS SECTOR
FROM AGR620CFAG.SROISH SRBISH
LEFT JOIN AGR620CFAG.SROISDPL SRBISD ON SRBISH.IHINVN = SRBISD.IDINVN AND SRBISH.IHORNO = SRBISD.IDORNO
LEFT JOIN AGR620CFAG.SROORSPL SRBSOL ON SRBISD.IDOLIN = SRBSOL.OLLINE AND SRBISD.IDORNO = SRBSOL.OLORNO
LEFT JOIN AGR620CFAG.SROPRG SRBPRG ON SRBISD.IDPRDC = SRBPRG.PGPRDC
LEFT JOIN AGR620CFAG.SROHNH SROHNH ON SRBISD.IDINUM = SROHNH.IHINUM
LEFT JOIN AGR620CFAG.SROISH SRBISH_1 ON SROHNH.IHRFNR = SRBISH_1.IHINVN AND SROHNH.IHCUNO = SRBISH_1.IHCUNO
LEFT JOIN AGR620CFAG.SROORSHE SRBSOH_1 ON SRBISH_1.IHORNO = SRBSOH_1.OHORNO
LEFT JOIN AGR620CFAG.SROORSHE SRBSOH ON SRBISH.IHORNO = SRBSOH.OHORNO
LEFT JOIN AGR620CFAG.SROCTLPB SRBCTLPB ON SRBPRG.PGPRFA = SRBCTLPB.PBPRFA
LEFT JOIN AGR620CFAG.SROCTLSD SRBCTLSD ON SRBISH.IHSALE = SRBCTLSD.CTSIGN
LEFT JOIN AGR620CFAG.SROCTLSD SRBCTLSD_1 ON SRBISH_1.IHSALE = SRBCTLSD_1.CTSIGN
LEFT JOIN AGR620CFAG.VISVENDT VVT ON VVT.FACTURA = SRBISH.IHINVN
WHERE ((CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END )<> 0)
AND SRBISD.IDLINE < 8000
AND SRBISD.IDSTRU <= 1
AND  (SRBISH.IHODAT BETWEEN '$ini_corte' AND '$fin_corte')
"); */

/** DESCOMENTAR */
// $rta_sql_ibs = $db2conp->conectar($sql_ibs_dias_hoy);
/* 
while($datos = odbc_fetch_array($rta_sql_ibs_)){
	$arreglo_insert_table='';
	$arreglo_insert_table = "(".
	"'".$datos[TIPO]
	."','".$datos[FACTURA]."','"
	.$datos[FECHA_FACTURA]."','"
	.$datos[FECHA_ORDEN]."','"
	.$datos[CEDULA]
	."','".$datos[NOMBRE_CLIENTE]
	."','".$datos[BODEGA]
	."','".$datos[VENDEDOR]
	."','".$datos[DES_VENDE]
	."','".$datos[CALL]
	."','".$datos[MANEJADOR]
	."',".$datos[LINEA_ORDEN]
	.",'".$datos[ITEM]
	."','".$datos[DESCRIPCION]
	."','".$datos[FOC]
	."','".$datos[GRUPO]
	."','".$datos[SEGMENTO]
	."','".$datos[FAMILIA]
	."',".$datos[CANTIDAD]
	.",".$datos[VLR_EXC_IVA]
	.",".$datos[VLR_IVA]
	.",".$datos[VLR_INC_IVA]
	.",null,null)";
    // echo $insert_detalle_no_fac_hoy.$arreglo_insert_table."<br><br><br>";
    // $sqlcon->insertar($insert_detalle_no_fac_hoy.$arreglo_insert_table);
//    mssql_query($insert_detalle_no_fac_hoy.$arreglo_insert_table) or mssql_get_last_message();
}
 */




$sql_ibs_1_meses=("
SELECT
TIPO,
FACTURA,
FECHA_FACTURA,
FECHA_ORDEN,
LTRIM(RTRIM(CLIENTE)) AS CEDULA,
LTRIM(RTRIM(NOMBRE_CLIENTE)) AS NOMBRE_CLIENTE,
BODEGA,
LTRIM(RTRIM(VENDEDOR)) AS  VENDEDOR,
LTRIM(RTRIM(DES_VENDE)) AS DES_VENDE,
LTRIM(RTRIM(CALL)) AS CALL,
MANEJADOR,
LINEA_ORDEN AS LINEA,
LTRIM(RTRIM(CODIGO)) AS ITEM,
LTRIM(RTRIM(DESCRIPCION)) AS DESCRIPCION,
(CASE WHEN FOC='N'THEN 0 ELSE 1 END )FOC,
LTRIM(RTRIM(GRUPO)) AS GRUPO,
SEGMENTA AS SEGMENTO,
LTRIM(RTRIM(FAMILIA)) AS FAMILIA,
CANTIDAD,
VLR_EXC_IVA AS VALORSINIVA,
VLR_IVA AS IVA,
VLR_INC_IVA VALOR
FROM
AGR620CFAG.VISVENDT
WHERE FECHA_ORDEN >='$ini_corte'
");
// echo $sql_ibs_1_meses.'<br><br><br><br><br>';
// AND LINEA_ORDEN IN (10,20,30)
/* RECORREMOS TODOS LOS VALORES DE LA CONSULTA IBS ESTADOS 10,20,30 y los GUARDAMOS EN VARIABLE $arreglo_insert_table */


$rta_sql_ibs = $db2conp->conectar($sql_ibs_1_meses__);
echo ($rta_sql_ibs)?'':'NO HAY DATOS PARA MOSTRAR REVISAR CONSULTA';

$insert_detalle_no_fac=(
	"INSERT INTO [dbo].[FACDETALLEFACTURANEW_____](
		[Tipo]
		,[Factura]
		,[Fecha]
		,[FechaOrden]
		,[Cedula]
		,[NombreCliente]
		,[Bodega]
		,[Vendedor]
		,[DesVendedor]
		,[Call]
		,[Manejador]
		,[Linea]
		,[Item]
		,[Descripcion]
		,[FOC]
		,[Grupo]
		,[Segmento]
		,[Familia]
		,[Cantidad]
		,[ValorSinIVA]
		,[ValorIVA]
		,[Valor]
		,[Planeador]
		,[Sector])
	VALUES ");

/** RECORREMOS PRIMERO LAS  FECHAS PARA LIMITAR LA CONSULTA */
$sql_rondas__=("SELECT distinct(FECHA_ORDEN) FECHA_ORDEN FROM AGR620CFAG.VISVENDT WHERE FECHA_ORDEN >='$ini_corte' order by fecha_orden");
$rta_sql_ibs_f = $db2conp->conectar($sql_rondas__);

while($fechas = odbc_fetch_array($rta_sql_ibs_f)){
	$arreglo_insert_table='';
	
	$sql_ibs_1_meses=("
	SELECT
	TIPO,
	FACTURA,
	FECHA_FACTURA,
	FECHA_ORDEN,
	LTRIM(RTRIM(CLIENTE)) AS CEDULA,
	LTRIM(RTRIM(NOMBRE_CLIENTE)) AS NOMBRE_CLIENTE,
	BODEGA,
	LTRIM(RTRIM(VENDEDOR)) AS  VENDEDOR,
	LTRIM(RTRIM(DES_VENDE)) AS DES_VENDE,
	LTRIM(RTRIM(CALL)) AS CALL,
	MANEJADOR,
	LINEA_ORDEN AS LINEA,
	LTRIM(RTRIM(CODIGO)) AS ITEM,
	LTRIM(RTRIM(DESCRIPCION)) AS DESCRIPCION,
	(CASE WHEN FOC='N'THEN 0 ELSE 1 END )FOC,
	LTRIM(RTRIM(GRUPO)) AS GRUPO,
	SEGMENTA AS SEGMENTO,
	LTRIM(RTRIM(FAMILIA)) AS FAMILIA,
	CANTIDAD,
	VLR_EXC_IVA AS VALORSINIVA,
	VLR_IVA AS IVA,
	VLR_INC_IVA VALOR
	FROM
	AGR620CFAG.VISVENDT
	WHERE FECHA_ORDEN ='$fechas[FECHA_ORDEN]'
	");

	// $rta_sql_ibs = $db2conp->conectar($sql_ibs_1_meses);
	while($datos = odbc_fetch_array($rta_sql_ibs_)){
		// $arreglo_insert_table = "('$datos[TIPO]','$datos[FACTURA]','$datos[FECHA_FACTURA]','$datos[FECHA_ORDEN]','$datos[CEDULA]','".str_replace("'",'',remove_characters($datos[NOMBRE_CLIENTE]))."','$datos[BODEGA]','$datos[VENDEDOR]','".remove_characters($datos[DES_VENDE])."','$datos[CALL]','$datos[MANEJADOR]',$datos[LINEA],'$datos[ITEM]','".remove_characters($dato[Descripcion])."',$datos[FOC],'$datos[GRUPO]','$datos[SEGMENTO]','$datos[FAMILIA]',$datos[CANTIDAD],$datos[VALORSINIVA],$datos[IVA],$datos[VALOR],null,null)";
		// echo $insert_detalle_no_fac.$arreglo_insert_table."<br><br><br>";


		// $sqlcon->insertar($insert_detalle_no_fac.$arreglo_insert_table);
		// mssql_query($insert_detalle_no_fac_hoy.$arreglo_insert_table) or mssql_get_last_message();
	}
}

$time_post = microtime( true );
$exec_time = $time_post - $time_pre;
echo( $exec_time.'ms' );
mssql_close();
mssql_free_result();
odbc_close_all();

?>
