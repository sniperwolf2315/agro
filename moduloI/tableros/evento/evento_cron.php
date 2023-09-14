<?php

/*
Cada hora:
Extrae la informacion de IBS y guarda en tabla MySql la infor a ser morstrada en el taglero de informe de evento

*/

//db2
	$db2con = odbc_connect('IBM-AGROCAMPO-P',odbc,odbc);	
	$db2conp = odbc_connect('IBM-AGROCAMPO-P',odbc,odbc);

//MYSQL
$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);

//MSSQL

    $cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); //AZURE10.10.0.5
    mssql_select_db('SqlFacturas',$cLink);


//configuracion de inicio fecha y tipo de evento: $inicia (aaaa-mm-dd), $finaliza (aaaa-mm-dd) y $evento (ANIVERSARIO o AGROMANIA)
include('config.php');
// $inicia     = '2022-05-09' ; 
// $finaliza   = '2022-05-14' ; 
// $evento     = 'AGROMANIA';  

$diasem = array('DOMINGO','LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO');

$hoy = date("Ymd");
$desde = str_replace("-","",$inicia);
$finaliza = str_replace("-","",$finaliza);
$year =date("Y");
// $year = date("Y",strtotime("$hoy - 1 Year"));

$hoy_1 = date("Ymd",strtotime("$hoy - 1 day"));
$hoy_2 = date("Ymd",strtotime("$hoy - 2 day"));
$hoy_3 = date("Ymd",strtotime("$hoy - 3 day"));
$hoy_4 = date("Ymd",strtotime("$hoy - 4 day"));

$hoy_10 = date("Ymd",strtotime("$hoy - 10 day"));
$n = 1;
$hoy_n = date("Ymd",strtotime("$hoy - $n day"));

$ahora = date("M-d. H:i");
$ahoraHM = date("H:i");  
$ahora = str_replace("Jan","Ene",$ahora);




$sql = "SELECT
SUBSTR(FECHA_ORDEN,1,4)||'-'||SUBSTR(FECHA_ORDEN,5,2)||'-'||SUBSTR(FECHA_ORDEN,7,2) AS DIA,
'' AS DIASEM,
CASE WHEN TIPO_ORDEN IN ('FR','KR') 
  THEN 'PLATAFORMAS DIGITALES'
ELSE
CASE WHEN VENDEDOR = 'VENDWEB' OR CALL = 'VENDWEB' 
  THEN 'PAGINA WEB'
ELSE
CASE WHEN VENDEDOR = 'VEND888' AND CALL = 'INTEGRATOR' 
  THEN 'ALMACEN'
ELSE
CASE WHEN CLIENTE in ('901110407','9011104074','9008390956','9008438981','9008438982','9008438984','9008714441','9008438983','900843898','9008438989','900839095','9007487391','900770206','900871444','900129597') 
  THEN 'PLATAFORMAS DIGITALES'
ELSE
CASE WHEN VENDEDOR IN ('VEND157','VEND217') OR CLIENTE in ('800159998','830092590','900099350','9002971538','860008068','900468472','900120344')
  THEN 'INSTITUCIONAL'
ELSE
CASE WHEN CLIENTE = '900423563' 
  THEN 'PESTAR'
ELSE
CASE WHEN (MANEJADOR IN ('VANANDELL') AND CALL IN ('CAMACHOM', 'CIFUENTESD', 'INTEGRATOR', 'MATERONN', 'MERQUEO', 'NETSTORE', 'SILVAJ', 'TRANSFER1', 'TRANSFER2', 'TRANSFER3', 'TRANSFER4', 'VEND186', 'VEND272', 'VEND283', 'VEND293', 'VEND299', 'VEND300', 'VEND305', 'VEND306', 'VEND307', 'VEND308', 'VEND309', 'VEND315', 'VEND318', 'VEND319', 'VEND320', 'VEND321', 'VEND326', 'VEND328', 'VEND330', 'VEND331', 'VEND332', 'VEND339', 'VEND340', 'VEND341', 'VEND342', 'VEND343', 'VEND344', 'VEND350', 'VEND352', 'VEND354', 'VEND356', 'VEND360', 'VEND364', 'VEND366', 'VEND371', 'VEND372', 'VEND373', 'VEND374', 'VEND375', 'VEND376', 'VEND377', 'VEND378', 'VEND383', 'VEND384', 'VEND385', 'VEND386', 'VEND388', 'VEND389', 'VEND390', 'VEND391', 'VEND393', 'VEND394', 'VEND395', 'VEND396', 'VEND397', 'VEND398', 'VEND399', 'VEND400', 'VEND401', 'VEND402', 'VEND403', 'VEND407', 'VEND409', 'VEND410', 'VEND411', 'VEND412', 'VEND413', 'VEND414', 'VEND419', 'VEND421', 'VEND422', 'VEND423', 'VEND424', 'VEND428', 'VEND429', 'VEND430', 'VEND431', 'VEND432', 'VEND433', 'VEND434', 'VEND435', 'VEND436', 'VEND437', 'VEND438', 'VEND439', 'VEND440', 'VEND443', 'VEND444', 'VEND446', 'VEND447', 'VEND448', 'VEND449', 'VEND450', 'VEND451', 'VEND452', 'VEND453', 'VEND454', 'VEND455', 'VEND456', 'VEND457', 'VEND458', 'VEND459', 'VEND460', 'VEND465', 'VEND466', 'VEND468', 'VEND469', 'VEND470', 'VEND471', 'VEND472', 'VEND473', 'VEND475', 'VEND480', 'VEND481', 'VEND482', 'VEND483', 'VEND484', 'VEND485', 'VEND486', 'VEND488', 'VENDLINIO', 'TRANSFER11', 'VEND500', 'VEND501', 'VEND502', 'VEND503','VEND510','VEND511','VEND515','VEND525','VEND526','VEND530','VEND502', 'VEND503','VEND510','VEND511','VEND515','VEND525','VEND526','VEND530','VEND531','VEND532','VEND533','VEND535','VEND539','VEND540','VEND542','VEND543','VEND553','VEND565','VEND577','VEND578','VEND579','VEND580','VEND582','VEND583','VEND584','VEND585','VEND588','VEND589','VEND590','VEND594','VEND600','VEND605','VEND603','VEND606','VEND607','VEND610') ) 
  THEN 'APOYO CALL V.EXT'
ELSE
CASE WHEN CALL IN ('CAMACHOM', 'CIFUENTESD', 'INTEGRATOR', 'MATERONN', 'MERQUEO', 'NETSTORE', 'SILVAJ', 'TRANSFER1', 'TRANSFER2', 'TRANSFER3', 'TRANSFER4', 'VEND186', 'VEND272', 'VEND283', 'VEND293', 'VEND299', 'VEND300', 'VEND305', 'VEND306', 'VEND307', 'VEND308', 'VEND309', 'VEND315', 'VEND318', 'VEND319', 'VEND320', 'VEND321', 'VEND326', 'VEND328', 'VEND330', 'VEND331', 'VEND332', 'VEND339', 'VEND340', 'VEND341', 'VEND342', 'VEND343', 'VEND344', 'VEND350', 'VEND352', 'VEND354', 'VEND356', 'VEND360', 'VEND364', 'VEND366', 'VEND371', 'VEND372', 'VEND373', 'VEND374', 'VEND375', 'VEND376', 'VEND377', 'VEND378', 'VEND383', 'VEND384', 'VEND385', 'VEND386', 'VEND388', 'VEND389', 'VEND390', 'VEND391', 'VEND393', 'VEND394', 'VEND395', 'VEND396', 'VEND397', 'VEND398', 'VEND399', 'VEND400', 'VEND401', 'VEND402', 'VEND403', 'VEND407', 'VEND409', 'VEND410', 'VEND411', 'VEND412', 'VEND413', 'VEND414', 'VEND419', 'VEND421', 'VEND422', 'VEND423', 'VEND424', 'VEND428', 'VEND429', 'VEND430', 'VEND431', 'VEND432', 'VEND433', 'VEND434', 'VEND435', 'VEND436', 'VEND437', 'VEND438', 'VEND439', 'VEND440', 'VEND443', 'VEND444', 'VEND446', 'VEND447', 'VEND448', 'VEND449', 'VEND450', 'VEND451', 'VEND452', 'VEND453', 'VEND454', 'VEND455', 'VEND456', 'VEND457', 'VEND458', 'VEND459', 'VEND460', 'VEND465', 'VEND466', 'VEND468', 'VEND469', 'VEND470', 'VEND471', 'VEND472', 'VEND473', 'VEND475', 'VEND480', 'VEND481', 'VEND482', 'VEND483', 'VEND484', 'VEND485', 'VEND486', 'VEND488', 'VENDLINIO', 'TRANSFER11', 'VEND500', 'VEND501', 'VEND502', 'VEND503','VEND510','VEND511','VEND515','VEND525','VEND526','VEND530','VEND502', 'VEND503','VEND510','VEND511','VEND515','VEND525','VEND526','VEND530','VEND531','VEND532','VEND533','VEND535','VEND539','VEND540','VEND542','VEND543','VEND553','VEND565','VEND577','VEND578','VEND579','VEND580','VEND582','VEND583','VEND584','VEND585','VEND588','VEND589','VEND590','VEND594','VEND600','VEND605','VEND603','VEND606','VEND607','VEND610') 
  THEN 'CALL (NO VTA EXT)' 
ELSE
CASE WHEN VENDEDOR IN ('VEND039', 'VEND040', 'VEND045', 'VEND078', 'VEND081', 'VEND114', 'VEND165', 'VEND183', 'VEND214', 'VEND252', 'VEND260', 'VEND310', 'VEND313', 'VEND314', 'VEND334', 'VEND338', 'VEND079', 'VENDOTC') 
  THEN 'ZONAS VENTA EXTERNA'
ELSE
'ALMACEN'
END
END
END
END
END
END
END
END
END AS AREA,
SUM(VLR_EXC_IVA) AS VENTA,
'$evento' AS EVENTO,
'$year' AS YEAR,
'$ahora' AS ACTUALIZADO 
FROM VISVENTASORDEN1 WHERE FECHA_ORDEN  BETWEEN '$desde' AND '$hoy'



GROUP BY
FECHA_ORDEN,
CASE WHEN TIPO_ORDEN IN ('FR','KR') 
  THEN 'PLATAFORMAS DIGITALES'
ELSE
CASE WHEN VENDEDOR = 'VENDWEB' OR CALL = 'VENDWEB' 
  THEN 'PAGINA WEB'
ELSE
CASE WHEN VENDEDOR = 'VEND888' AND CALL = 'INTEGRATOR' 
  THEN 'ALMACEN'
ELSE
CASE WHEN CLIENTE in ('901110407','9011104074','9008390956','9008438981','9008438982','9008438984','9008714441','9008438983','900843898','9008438989','900839095','9007487391','900770206','900871444','900129597') 
  THEN 'PLATAFORMAS DIGITALES'
ELSE
CASE WHEN VENDEDOR IN ('VEND157','VEND217') OR CLIENTE in ('800159998','830092590','900099350','9002971538','860008068','900468472','900120344')
  THEN 'INSTITUCIONAL'
ELSE
CASE WHEN CLIENTE = '900423563' 
  THEN 'PESTAR'
ELSE
CASE WHEN (MANEJADOR IN ('VANANDELL') 
     AND CALL IN ('CAMACHOM', 'CIFUENTESD', 'INTEGRATOR', 'MATERONN', 'MERQUEO', 'NETSTORE', 'SILVAJ', 'TRANSFER1', 'TRANSFER2', 'TRANSFER3', 'TRANSFER4', 'VEND186', 'VEND272', 'VEND283', 'VEND293', 'VEND299', 'VEND300', 'VEND305', 'VEND306', 'VEND307', 'VEND308', 'VEND309', 'VEND315', 'VEND318', 'VEND319', 'VEND320', 'VEND321', 'VEND326', 'VEND328', 'VEND330', 'VEND331', 'VEND332', 'VEND339', 'VEND340', 'VEND341', 'VEND342', 'VEND343', 'VEND344', 'VEND350', 'VEND352', 'VEND354', 'VEND356', 'VEND360', 'VEND364', 'VEND366', 'VEND371', 'VEND372', 'VEND373', 'VEND374', 'VEND375', 'VEND376', 'VEND377', 'VEND378', 'VEND383', 'VEND384', 'VEND385', 'VEND386', 'VEND388', 'VEND389', 'VEND390', 'VEND391', 'VEND393', 'VEND394', 'VEND395', 'VEND396', 'VEND397', 'VEND398', 'VEND399', 'VEND400', 'VEND401', 'VEND402', 'VEND403', 'VEND407', 'VEND409', 'VEND410', 'VEND411', 'VEND412', 'VEND413', 'VEND414', 'VEND419', 'VEND421', 'VEND422', 'VEND423', 'VEND424', 'VEND428', 'VEND429', 'VEND430', 'VEND431', 'VEND432', 'VEND433', 'VEND434', 'VEND435', 'VEND436', 'VEND437', 'VEND438', 'VEND439', 'VEND440', 'VEND443', 'VEND444', 'VEND446', 'VEND447', 'VEND448', 'VEND449', 'VEND450', 'VEND451', 'VEND452', 'VEND453', 'VEND454', 'VEND455', 'VEND456', 'VEND457', 'VEND458', 'VEND459', 'VEND460', 'VEND465', 'VEND466', 'VEND468', 'VEND469', 'VEND470', 'VEND471', 'VEND472', 'VEND473', 'VEND475', 'VEND480', 'VEND481', 'VEND482', 'VEND483', 'VEND484', 'VEND485', 'VEND486', 'VEND488', 'VENDLINIO', 'TRANSFER11', 'VEND500', 'VEND501', 'VEND502', 'VEND503','VEND510','VEND511','VEND515','VEND525','VEND526','VEND530','VEND502', 'VEND503','VEND510','VEND511','VEND515','VEND525','VEND526','VEND530','VEND531','VEND532','VEND533','VEND535','VEND539','VEND540','VEND542','VEND543','VEND553','VEND565','VEND577','VEND578','VEND579','VEND580','VEND582','VEND583','VEND584','VEND585','VEND588','VEND589','VEND590','VEND594','VEND600','VEND605','VEND603','VEND606','VEND607','VEND610') )
  THEN 'APOYO CALL V.EXT'
ELSE
CASE WHEN CALL IN('CAMACHOM', 'CIFUENTESD', 'INTEGRATOR', 'MATERONN', 'MERQUEO', 'NETSTORE', 'SILVAJ', 'TRANSFER1', 'TRANSFER2', 'TRANSFER3', 'TRANSFER4', 'VEND186', 'VEND272', 'VEND283', 'VEND293', 'VEND299', 'VEND300', 'VEND305', 'VEND306', 'VEND307', 'VEND308', 'VEND309', 'VEND315', 'VEND318', 'VEND319', 'VEND320', 'VEND321', 'VEND326', 'VEND328', 'VEND330', 'VEND331', 'VEND332', 'VEND339', 'VEND340', 'VEND341', 'VEND342', 'VEND343', 'VEND344', 'VEND350', 'VEND352', 'VEND354', 'VEND356', 'VEND360', 'VEND364', 'VEND366', 'VEND371', 'VEND372', 'VEND373', 'VEND374', 'VEND375', 'VEND376', 'VEND377', 'VEND378', 'VEND383', 'VEND384', 'VEND385', 'VEND386', 'VEND388', 'VEND389', 'VEND390', 'VEND391', 'VEND393', 'VEND394', 'VEND395', 'VEND396', 'VEND397', 'VEND398', 'VEND399', 'VEND400', 'VEND401', 'VEND402', 'VEND403', 'VEND407', 'VEND409', 'VEND410', 'VEND411', 'VEND412', 'VEND413', 'VEND414', 'VEND419', 'VEND421', 'VEND422', 'VEND423', 'VEND424', 'VEND428', 'VEND429', 'VEND430', 'VEND431', 'VEND432', 'VEND433', 'VEND434', 'VEND435', 'VEND436', 'VEND437', 'VEND438', 'VEND439', 'VEND440', 'VEND443', 'VEND444', 'VEND446', 'VEND447', 'VEND448', 'VEND449', 'VEND450', 'VEND451', 'VEND452', 'VEND453', 'VEND454', 'VEND455', 'VEND456', 'VEND457', 'VEND458', 'VEND459', 'VEND460', 'VEND465', 'VEND466', 'VEND468', 'VEND469', 'VEND470', 'VEND471', 'VEND472', 'VEND473', 'VEND475', 'VEND480', 'VEND481', 'VEND482', 'VEND483', 'VEND484', 'VEND485', 'VEND486', 'VEND488', 'VENDLINIO', 'TRANSFER11', 'VEND500', 'VEND501', 'VEND502', 'VEND503','VEND510','VEND511','VEND515','VEND525','VEND526','VEND530','VEND502', 'VEND503','VEND510','VEND511','VEND515','VEND525','VEND526','VEND530','VEND531','VEND532','VEND533','VEND535','VEND539','VEND540','VEND542','VEND543','VEND553','VEND565','VEND577','VEND578','VEND579','VEND580','VEND582','VEND583','VEND584','VEND585','VEND588','VEND589','VEND590','VEND594','VEND600','VEND605','VEND603','VEND606','VEND607','VEND610')
  THEN 'CALL (NO VTA EXT)' 
ELSE
CASE WHEN VENDEDOR IN ('VEND039', 'VEND040', 'VEND045', 'VEND078', 'VEND081', 'VEND114', 'VEND165', 'VEND183', 'VEND214', 'VEND252', 'VEND260', 'VEND310', 'VEND313', 'VEND314', 'VEND334', 'VEND338', 'VEND079', 'VENDOTC') 
  THEN 'ZONAS VENTA EXTERNA'
ELSE
'ALMACEN'
END
END
END
END
END
END
END
END
END
ORDER BY FECHA_ORDEN ASC

		";
	//  echo $sql."<BR>";//;DIE;	
  $result = odbc_exec($db2conp, $sql);//echo $sql.odbc_errormsg();
  odbc_close();
	while($row = odbc_fetch_array($result)){
        
        $diaNum = date("w",STRTOTIME($row[DIA])); 
        $row['DIASEM'] = strtolower($diasem[$diaNum]);	
	    $row['DIA'] = 1+(strtotime("$row[DIA]")-strtotime("$inicia"))/86400;
	    
	    $comaC = '';
        $comaV = '';
		foreach($row as $campo => $valor){
		  //construye insert MySQL
		  $campos .= "$comaC$campo";
          $valores .= "$comaV$valor";
          $comaC = ',';
          $comaV = "','";
		  }
          $mysqlINSERT[] = "INSERT INTO tablero_eventos ($campos) VALUES ('$valores'); ";
          //INCLUYE EN VENTA EXTERNA LO DE APOYO CALL
          if($row[AREA] =='APOYO CALL V.EXT')
	        {
	        $mysqlINSERT[] = str_replace("APOYO CALL V.EXT","ZONAS VENTA EXTERNA","INSERT INTO tablero_eventos ($campos) VALUES ('$valores'); ");
	        }
          $campos =''; $valores='';   
    }	
	
	
      //inserta datos mysql local, sobreesrcibe los dias previos
    mysqli_query($mysqliL, "DELETE FROM tablero_eventos WHERE evento ='$evento' AND year ='$year'");
    foreach($mysqlINSERT AS $ins){
    // mysqli_query($mysqliL, $ins) or die(mysqli_error($mysqliL)."<br> $ins");
    if(mysqli_query($mysqliL, $ins)){}else{echo mysqli_error($mysqliL)."<br> $ins<br>"; }
    }
// ECHO '😂';
mssql_close();  
odbc_close();
?>