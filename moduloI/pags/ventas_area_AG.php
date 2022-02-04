<? $areas = array('Call','Venta Externa','Almacen','Rappi','Pagina WEB');
   if($_POST['area']=='Venta Externa'){
   $cuotasAD = array('C_RECAUDO');
   }
   if($_POST['desde'] ==''){
    if(substr($hoy,8,2) < 16 ){
    	$_POST['desde'] = date("Y-m-16",strtotime("$hoy - 1 month"));
    	}else{
    	$_POST['desde'] = date("Y-m-16",strtotime("$hoy"));
    	}
    }
    if($_POST['hasta'] ==''){ $_POST['hasta'] = $hoy; }
    
    //if($_POST['area'] == '' AND $_POST['vendedor'] == ''){$_POST['area'] = 'Venta Externa';}
    
    if($_POST['info'] == '' ){ $_POST['info'] = "Facturado";}


//historico de cuotas contro logico if $desde
if($_POST['desde'] > '0000-00-00'){   
	$labs = array(
	           'BIOSTAR' =>array('cod' => array('BIS'),'CuotaCod' => array('CFBS'),'item'=> array())
			  ,'COASPHARMA' =>array('cod' => array('CPH'),'CuotaCod' => array('CGCS'),'item'=> array())
			  ,'PHARMEK' =>array('cod' => array('PHK'),'CuotaCod' => array('CGPH'),'item'=> array())
			  ,'TECNOCALIDAD' =>array('cod' => array('TEC'),'CuotaCod' => array('CGTC'),'item'=> array())
			  ,'COMERVET' =>array('cod' => array('CMV'),'CuotaCod' => array('CFCM'),'item'=> array('636300016','636300025','636300110','636300134','636300047','636300142'))
			  ,'INTERVET' =>array('cod' => array('INC','INM'),'CuotaCod' => array('CFIN'),'item'=> array())
			  ,'HOLLIDAY' =>array('cod' => array('HOL'),'CuotaCod' => array('CGHO'),'item'=> array())
			  ,'ICOFARMA' =>array('cod' => array('ICO'),'CuotaCod' => array('CGIC'),'item'=> array())
			);
}
//solicita adriana x correo 06 feb 2020
if($_POST['desde'] >= '2020-01-16'){   
	$labs = array(
	          'BIOSTAR' =>array('cod' => array('BIS'),'CuotaCod' => array('CFBS'),'item'=> array())
			  ,'COASPHARMA' =>array('cod' => array('CPH'),'CuotaCod' => array('CGCS'),'item'=> array())
			  ,'TECNOCALIDAD' =>array('cod' => array('TEC'),'CuotaCod' => array('CGTC'),'item'=> array())
			  ,'COMERVET' =>array('cod' => array('CMV'),'CuotaCod' => array('CFCM'),'item'=> array('636300016','636300025','636300110','636300134','636300047','636300142'))
			  ,'INTERVET' =>array('cod' => array('INM'),'CuotaCod' => array('CFIN'),'item'=> array())
			  ,'HOLLIDAY' =>array('cod' => array('HOL'),'CuotaCod' => array('CGHO'),'item'=> array())
			  ,'ICOFARMA' =>array('cod' => array('ICO'),'CuotaCod' => array('CGIC'),'item'=> array())
			);
    if($_POST['area'] == 'Venta Externa'){
	$labs['PHARMEK'] = 	array('cod' => array('PHK'),'CuotaCod' => array('CGPH'),'item'=> array());
	}	
}
//solicita Juan Silva x tel: +INM,INV, INT -ICO 
if($_POST['desde'] >= '2020-04-16'){   
	$labs = array(
	          'BIOSTAR' =>array('cod' => array('BIS'),'CuotaCod' => array('CFBS'),'item'=> array())
			  ,'COASPHARMA' =>array('cod' => array('CPH'),'CuotaCod' => array('CGCS'),'item'=> array())
			  ,'TECNOCALIDAD' =>array('cod' => array('TEC'),'CuotaCod' => array('CGTC'),'item'=> array())
			  ,'COMERVET' =>array('cod' => array('CMV'),'CuotaCod' => array('CFCM'),'item'=> array('636300016','636300025','636300110','636300134','636300047','636300142'))
			  ,'INTERVET' =>array('cod' => array('INC','INM'),'CuotaCod' => array('CFIN'),'item'=> array())
			  ,'HOLLIDAY' =>array('cod' => array('HOL'),'CuotaCod' => array('CGHO'),'item'=> array())
			  ,'INVET' =>array('cod' => array('INT'),'CuotaCod' => array('CGIT'),'item'=> array())

			);
    if($_POST['area'] == 'Venta Externa'){
	$labs['PHARMEK'] = 	array('cod' => array('PHK'),'CuotaCod' => array('CGPH'),'item'=> array());
	}	
}
//solicita Julian x correo 3 de junio , Y EL 12JUN EL ITEM 636300101
if($_POST['desde'] >= '2020-05-16'){   
	$labs = array(
	          'BIOSTAR' =>array('cod' => array('BIS'),'CuotaCod' => array('CFBS'),'item'=> array())
			  ,'COASPHARMA' =>array('cod' => array('CPH'),'CuotaCod' => array('CGCS'),'item'=> array())
			  ,'TECNOCALIDAD' =>array('cod' => array('TEC'),'CuotaCod' => array('CGTC'),'item'=> array())
			  ,'COMERVET' =>array('cod' => array('CMV'),'CuotaCod' => array('CFCM'),'item'=> array('636300016','636300025','636300110','636300134','636300047','636300142','636300101'))
			  ,'INTERVET' =>array('cod' => array('INC','INM'),'CuotaCod' => array('CFIN'),'item'=> array())
			  ,'HOLLIDAY' =>array('cod' => array('HOL'),'CuotaCod' => array('CGHO'),'item'=> array())
			  ,'ICOFARMA' =>array('cod' => array('ICO'),'CuotaCod' => array('CGIC'),'item'=> array())

			);
    if($_POST['area'] == 'Venta Externa'){
	//$labs['PHARMEK'] = 	array('cod' => array('PHK'),'CuotaCod' => array('CGPH'),'item'=> array());
	}	
}	

//solicita Julian x telefono 22 de ago
if($_POST['desde'] >= '2020-05-16'){   
	$labs = array(
	          'BIOSTAR' =>array('cod' => array('BIS'),'CuotaCod' => array('CFBS'),'item'=> array())
			  ,'COASPHARMA' =>array('cod' => array('CPH'),'CuotaCod' => array('CGCS'),'item'=> array())
			  ,'TECNOCALIDAD' =>array('cod' => array('TEC'),'CuotaCod' => array('CGTC'),'item'=> array())
			  ,'COMERVET' =>array('cod' => array('CMV'),'CuotaCod' => array('CFCM'),'item'=> array('636300016','636300025','636300110','636300134','636300047','636300142','636300101'))
			  ,'INTERVET' =>array('cod' => array('INC','INM'),'CuotaCod' => array('CFIN'),'item'=> array())
			  ,'HOLLIDAY' =>array('cod' => array('HOL'),'CuotaCod' => array('CGHO'),'item'=> array())
			  ,'ICOFARMA' =>array('cod' => array('ICO'),'CuotaCod' => array('CGIC'),'item'=> array())
              ,'INVET' =>array('cod' => array('INT'),'CuotaCod' => array('CGIT'),'item'=> array())  
			);
    if($_POST['area'] == 'Venta Externa'){
	//$labs['PHARMEK'] = 	array('cod' => array('PHK'),'CuotaCod' => array('CGPH'),'item'=> array());
	}	
}	

		
	//contruye listas de codlabs, codcuota, items asi 'x','y','z'
	$coma = '';		
	foreach($labs as $lab => $valor){
		foreach($labs["$lab"]['cod'] AS $cod => $valor){
		$labsc .= "$coma'$valor'";	
		$coma =',';
		}
	}
	$coma = '';
	foreach($labs as $lab => $valor){
		foreach($labs["$lab"]['CuotaCod'] AS $cod => $valor){
		$c_labs .= "$coma'$valor'";	
		$coma =',';
		}
	}
	$coma = '';
	foreach($labs as $lab => $valor){
		foreach($labs["$lab"]['item'] AS $cod => $valor){
		$itemsc .= "$coma'$valor'";	
		$coma =',';
		}
	}
	$coma = '';
	
	//area Rappi no vea tabla labs
	if($_POST['area'] == 'Rappi'){
	$labs = array();
	}
	
	//$labsc = "'BIS','CPH','PHK','TEC','CMV','INC','INM','HOL','ICO'";
	//$c_labs= "'CFBS','CGCS','CGPH','CGTC','CFCM','CFIN','CGHO','CGIC'";
	//$itemsc = "'636300016','636300025','636300110','636300134','636300047','636300142'";
	//echo "<br>$itemsc";
	


	//registros por pag paginador
	$regsxpag = 50;
	
	if($_POST['paginador'] ==''){ $_POST['paginador'] = "1-$regsxpag"; }
	$limit = explode("-",$_POST['paginador']);
	$limit[0] = $limit[0]-1;
	$flimit = " LIMIT $limit[0],$limit[1] ";	


// DEFINICION DE GRUPOS DE USUARIOS $vendcall, $vendext, $vendalm EN user_user.php 


//print_r($arralm);
//echo $vendalm;
if($_POST['area'] == '' ){
  //$fnom = "'$_POST[vendedor]'";
  $fnom = "$vendcall,$vendext,$vendalm,$vendrappi";
  }
if($_POST['area'] == 'Call' ){$fnom = $vendcall;}
if($_POST['area'] == 'Venta Externa' ){$fnom = $vendext;}
if($_POST['area'] == 'Almacen' ){$fnom = $vendalm;}
if($_POST['area'] == 'Rappi' ){$fnom = $vendrappi;}
if($_POST['area'] == 'Pagina WEB' ){$fnom = $vendweb;}


if($_POST['cliente'] != '' ){
	$fcli = " AND SRBNAM.NANAME ='".utf8_decode($_POST[cliente])."' ";
	}

if($_POST['producto'] != '' ){
	$fpro = " AND SRBPRG.PGDESC LIKE '%".strtoupper(utf8_decode($_POST[producto]))."%' ";
	}

if($_POST['grupo'] != '' ){
	$fpro .= " AND SRBPRG.PGPGRP = '".strtoupper(utf8_decode($_POST[grupo]))."' ";
	}

$sql = "select CTSIGN, CTNAME from SRBCTLSD WHERE SRBCTLSD.CTSIGN IN($fnom) order by CTSIGN";
$result = odbc_exec($db2conp, $sql);
while($row = odbc_fetch_array($result)){
	$nom = utf8_encode($row['CTNAME']);
	$cod = $row['CTSIGN'];
	$nombres["$cod"] = $nom;
}

if($_POST['vendedor'] != '' ){$fnom = "'".$_POST['vendedor']."'";}

if($_POST['info'] == 'Facturado' ){ $finfo = " AND ESTADO_ORDEN = 60 ";}
if($_POST['info'] == 'Ord Venta' ){ $finfo = " AND ESTADO_ORDEN IN (10,20,30) ";}
if($_POST['info'] == 'Fac y Ord venta' ){$finfo = '';}

$paisano = VENDEDOR;
$paisano_nom = "(select SRBCTLSD.CTNAME from SRBCTLSD WHERE SRBCTLSD.CTSIGN = VENDEDOR)";

$farea = " AND VENDEDOR IN ($fnom)";   
   
if($_POST['area'] == 'Call'){
	$farea = " AND CALL IN ($fnom)";
	$paisano = CALL; 
	$paisano_nom = "(select SRBCTLSD.CTNAME from SRBCTLSD WHERE SRBCTLSD.CTSIGN = CALL)";
	$vany14s ="OR(MANEJADOR IN ('VANANDELL') AND VENDEDOR IN('VEND114','VEND214'))";						  
	}
if($_POST['area'] == 'Venta Externa'){
	$farea = " AND VENDEDOR IN ($fnom)";
	$vanandell =",'VANANDELL'";
	}
if($_POST['area'] == 'Almacen'){
	$farea = " AND VENDEDOR IN ($fnom)";
	$fecomerceVV1 = " AND CLIENTE != '901110407'";
	$fecomerceISH = " AND SRBISH.IHCUNO != '901110407'";
	}

if($patrones !='SI' AND $_POST['queVer'] == ''){
  	$_POST['queVer'] = 'VENTAS';
}
	
//consulta de ventas y cuotas
$desde = str_replace("-", "", $_POST['desde']);
$hasta = str_replace("-", "", $_POST['hasta']);

$dias = (strtotime("$_POST[hasta]")-strtotime("$_POST[desde]"))/86400 ;
if( substr($desde,6,2)== 16
   and $dias <= 31
   ){
$cuotas =",'|' AS CUOTAS
, (CASE WHEN (SUBSTRING(MIN(FECHA_ORDEN),7,2)+0) >= 16 
	THEN SUBSTRING(MIN(FECHA_ORDEN),1,6) 
	ELSE 
		CASE WHEN (SUBSTRING(MIN(FECHA_ORDEN),5,2)-1) > 0
		THEN
			CASE WHEN (SUBSTRING(MIN(FECHA_ORDEN),5,2)-0) > 10
			THEN CONCAT( SUBSTRING(MIN(FECHA_ORDEN),1,4), (SUBSTRING(MIN(FECHA_ORDEN),5,2)-1) ) 
			ELSE CONCAT(CONCAT( SUBSTRING(MIN(FECHA_ORDEN),1,4), '0'), (SUBSTRING(MIN(FECHA_ORDEN),5,2)-1))
			END
		ELSE CONCAT((SUBSTRING(MIN(FECHA_ORDEN),1,4)-1),'12')    
		END 
	END) 
	AS MES_CUOTA
, ifnull((SELECT MAX(VCUOTA) FROM VENDCUOTA VENDCUOTA
	where IDTCUOTA = 'CTGG' 
	and IDVEND = $paisano 
	and VENDCUOTA.IDPER= 
		CASE WHEN (SUBSTRING(MIN(FECHA_ORDEN),7,2)+0) >= 16 
		THEN SUBSTRING(MIN(FECHA_ORDEN),1,6) 
		ELSE 
			CASE WHEN (SUBSTRING(MIN(FECHA_ORDEN),5,2)-1) > 0
			THEN
				CASE WHEN (SUBSTRING(MIN(FECHA_ORDEN),5,2)-0) > 10
				THEN CONCAT( SUBSTRING(MIN(FECHA_ORDEN),1,4), (SUBSTRING(MIN(FECHA_ORDEN),5,2)-1) ) 
				ELSE CONCAT(CONCAT( SUBSTRING(MIN(FECHA_ORDEN),1,4), '0'), (SUBSTRING(MIN(FECHA_ORDEN),5,2)-1))
				END
			ELSE CONCAT((SUBSTRING(MIN(FECHA_ORDEN),1,4)-1),'12')    
			END 
		END
	) , 0)
    AS C_CONTADO
, ifnull((SELECT MAX(VCUOTA) FROM VENDCUOTA VENDCUOTA
	where IDTCUOTA = 'CTGO' 
	and IDVEND = $paisano 
	and VENDCUOTA.IDPER= 
		CASE WHEN (SUBSTRING(MIN(FECHA_ORDEN),7,2)+0) >= 16 
		THEN SUBSTRING(MIN(FECHA_ORDEN),1,6) 
		ELSE 
			CASE WHEN (SUBSTRING(MIN(FECHA_ORDEN),5,2)-1) > 0
			THEN
				CASE WHEN (SUBSTRING(MIN(FECHA_ORDEN),5,2)-0) > 10
				THEN CONCAT( SUBSTRING(MIN(FECHA_ORDEN),1,4), (SUBSTRING(MIN(FECHA_ORDEN),5,2)-1) ) 
				ELSE CONCAT(CONCAT( SUBSTRING(MIN(FECHA_ORDEN),1,4), '0'), (SUBSTRING(MIN(FECHA_ORDEN),5,2)-1))
				END
			ELSE CONCAT((SUBSTRING(MIN(FECHA_ORDEN),1,4)-1),'12')    
			END 
		END
	) , 0)
    AS C_OBJETIVO
, ifnull((SELECT SUM(VCUOTA) FROM VENDCUOTA VENDCUOTA
	where IDTCUOTA in( $c_labs )
 	and IDVEND = $paisano 
	and VENDCUOTA.IDPER= 
		CASE WHEN (SUBSTRING(MIN(FECHA_ORDEN),7,2)+0) >= 16 
		THEN SUBSTRING(MIN(FECHA_ORDEN),1,6) 
		ELSE 
			CASE WHEN (SUBSTRING(MIN(FECHA_ORDEN),5,2)-1) > 0
			THEN
				CASE WHEN (SUBSTRING(MIN(FECHA_ORDEN),5,2)-0) > 10
				THEN CONCAT( SUBSTRING(MIN(FECHA_ORDEN),1,4), (SUBSTRING(MIN(FECHA_ORDEN),5,2)-1) ) 
				ELSE CONCAT(CONCAT( SUBSTRING(MIN(FECHA_ORDEN),1,4), '0'), (SUBSTRING(MIN(FECHA_ORDEN),5,2)-1))
				END
			ELSE CONCAT((SUBSTRING(MIN(FECHA_ORDEN),1,4)-1),'12')    
			END 
		END
	), 0) 
    AS C_LABS
, ifnull((SELECT MAX(VCUOTA) FROM VENDCUOTA VENDCUOTA
	where IDTCUOTA = 'CFIM' 
	and IDVEND = $paisano 
	and VENDCUOTA.IDPER= 
		CASE WHEN (SUBSTRING(MIN(FECHA_ORDEN),7,2)+0) >= 16 
		THEN SUBSTRING(MIN(FECHA_ORDEN),1,6) 
		ELSE 
			CASE WHEN (SUBSTRING(MIN(FECHA_ORDEN),5,2)-1) > 0
			THEN
				CASE WHEN (SUBSTRING(MIN(FECHA_ORDEN),5,2)-0) > 10
				THEN CONCAT( SUBSTRING(MIN(FECHA_ORDEN),1,4), (SUBSTRING(MIN(FECHA_ORDEN),5,2)-1) ) 
				ELSE CONCAT(CONCAT( SUBSTRING(MIN(FECHA_ORDEN),1,4), '0'), (SUBSTRING(MIN(FECHA_ORDEN),5,2)-1))
				END
			ELSE CONCAT((SUBSTRING(MIN(FECHA_ORDEN),1,4)-1),'12')    
			END 
		END
	) , 0)
    AS C_IMPOR
 ";

//contruye couotas del array labs		
		foreach($labs as $lab => $valor){
			foreach($labs["$lab"]['CuotaCod'] AS $cod => $valor){
			$cuotas .= ", ifnull( (SELECT SUM(VCUOTA) FROM VENDCUOTA VENDCUOTA
					where IDTCUOTA = '$valor'
					and IDVEND = $paisano 
					and VENDCUOTA.IDPER= 
					CASE WHEN (SUBSTRING(MIN(FECHA_ORDEN),7,2)+0) >= 16 
					THEN SUBSTRING(MIN(FECHA_ORDEN),1,6) 
					ELSE 
						CASE WHEN (SUBSTRING(MIN(FECHA_ORDEN),5,2)-1) > 0
						THEN
							CASE WHEN (SUBSTRING(MIN(FECHA_ORDEN),5,2)-0) > 10
							THEN CONCAT( SUBSTRING(MIN(FECHA_ORDEN),1,4), (SUBSTRING(MIN(FECHA_ORDEN),5,2)-1) ) 
							ELSE CONCAT(CONCAT( SUBSTRING(MIN(FECHA_ORDEN),1,4), '0'), (SUBSTRING(MIN(FECHA_ORDEN),5,2)-1))
							END
						ELSE CONCAT((SUBSTRING(MIN(FECHA_ORDEN),1,4)-1),'12')    
						END 
					END
					), 0) 
					AS C_$lab
					";
			$cuotaNOvta .= ", SUM(CASE WHEN IDTCUOTA = '$valor' THEN VCUOTA ELSE 0 END) as C_$lab";		
			}
		}

	}else{ $cuotas =""; $cuotasmsg ="<br>*No se muestran cuotas, no es periodo comercial"; }

//contruye ventas por lab apratir de array labs
foreach($labs as $lab => $valor){
	$coma ='';
	$grupoL = "";
	foreach($labs["$lab"]['cod'] AS $cod => $valor){
		$grupoL .= "$coma'$valor'";
		$coma =',';
	}
	$coma ="";
	$itemL = "";
	foreach($labs["$lab"]['item'] AS $cod => $valor){
		$itemL .= "$coma'$valor'";
		$coma =',';
	}
	$coma ='';
	if(strlen($itemL)> 2){ 
		$itemL = "OR ITEM IN (".$itemL.")";
	} 
$vtaXlab .= ", SUM(CASE when GRUPO IN ($grupoL) $itemL THEN VLR_EXC_IVA End ) as $lab";	

}	
//echo "<br>$vtaXlab";
$sql ="SELECT 
$paisano AS VENDEDOR
, $paisano_nom  AS NOMBRE_VEND
, CONCAT(CONCAT(CONCAT(CONCAT(SUBSTRING(MIN(FECHA_ORDEN),1,4), '-'  ),SUBSTRING(MIN(FECHA_ORDEN),5,2)),'-'),SUBSTRING(MIN(FECHA_ORDEN),7,2))  AS DESDE
, CONCAT(CONCAT(CONCAT(CONCAT(SUBSTRING(MAX(FECHA_ORDEN),1,4), '-'  ),SUBSTRING(MAX(FECHA_ORDEN),5,2)),'-'),SUBSTRING(MAX(FECHA_ORDEN),7,2))  AS HASTA
,SUM(CASE WHEN (MANEJADOR IN ('ADMINISTRA', 'CALLCENTER'))OR(MANEJADOR IN ('VANANDELL') AND VENDEDOR IN('VEND114','VEND214')) THEN VLR_EXC_IVA END) AS CONTADO
,SUM(CASE WHEN (MANEJADOR IN ('VANANDELL') AND VENDEDOR NOT IN('VEND114','VEND214')) THEN VLR_EXC_IVA END)  AS OBJETIVO
,SUM(CASE when GRUPO IN( $labsc ) OR ITEM IN ( $itemsc ) THEN VLR_EXC_IVA End ) as LABORATORIOS
,SUM(CASE WHEN ((MANEJADOR IN ('ADMINISTRA', 'CALLCENTER' $vanandell)) $vany14s )AND(FAMILIA= 'IMPORTADOS') THEN VLR_EXC_IVA END)  AS IMPORTADOS

$vtaXlab

$cuotas
                    	
FROM VISVENTASORDEN1
WHERE 

FECHA_ORDEN BETWEEN '$desde'  AND '$hasta'
$finfo
$farea

$fecomerceVV1

GROUP BY $paisano
order by NOMBRE_VEND
";
//echo $sql;
$cont = -1;
if($_POST['queVer'] =='VENTAS'){       
  $result = odbc_exec($db2conp, $sql) ; echo odbc_errormsg();
  }else{ $result = '';}
	while($row = odbc_fetch_array($result)){
	$cont += 1;
		foreach($row as $campo => $valor){
		$ti["$campo"][]= utf8_encode($valor);
		}
	//$ti["AREA"]	
	$ti["TOTALV"][] = $row['OBJETIVO']+$row['CONTADO'];
	$ti["TOTALC"][] = $row['C_OBJETIVO']+$row['C_CONTADO'];	
	}	

//AGREGA A LA LISTA LOS QUE NO HAN VENDIDO
$fnom2 = implode("','",$ti['VENDEDOR']);
$fperiodo = substr($desde,0,6);

$sql = "SELECT
		  IDVEND as VENDEDOR
		, IFNULL((SELECT CTNAME FROM SRBCTLSD WHERE CTSIGN = IDVEND),IDVEND) as NOMBRE_VEND
		, '' as CONTADO
		, '' as OBJETIVO
		, '' as LABORATORIOS
		, '' as IMPORTADOS
		
	
		, SUM(CASE WHEN IDTCUOTA = 'CTGG' THEN VCUOTA ELSE 0 END) as C_CONTADO
		, SUM(CASE WHEN IDTCUOTA = 'CTGO' THEN VCUOTA ELSE 0 END) as C_OBJETIVO
		, SUM(CASE WHEN IDTCUOTA = 'CFIM' THEN VCUOTA ELSE 0 END) as C_IMPOR
		, SUM(CASE WHEN IDTCUOTA IN ($c_labs) THEN VCUOTA ELSE 0 END) as C_LABS
		
		$cuotaNOvta
		
		, SUM(CASE WHEN IDTCUOTA = 'CTGG' OR IDTCUOTA = 'CTGO'  THEN VCUOTA ELSE 0 END) as TOTALC
		, '' as TOTALV
		FROM VENDCUOTA 
		WHERE IDPER ='$fperiodo'
		AND IDVEND IN ($fnom)
		AND IDVEND NOT IN('$fnom2')
		GROUP BY IDVEND, (SELECT CTNAME FROM SRBCTLSD WHERE CTSIGN = IDVEND) 
		";
if($_POST['queVer'] =='VENTAS'){       
  $result = odbc_exec($db2conp, $sql) ; echo odbc_errormsg();
  }else{ $result = '';}
	while($row = odbc_fetch_array($result)){
		foreach($row as $campo => $valor){
		$ti["$campo"][]= utf8_encode($valor);
		}
	//$ti["TOTALC"][] += $row['C_OBJETIVO']+$row['C_CONTADO'];
	}	


//ventas de kilos y unidades marcars propias


$sql = "SELECT
		 (select SRBCTLSD.CTNAME as CT from SRBCTLSD WHERE SRBCTLSD.CTSIGN = 
		   CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END) AS VENDEDOR
		, IFNULL(
		    CAST(
		      SUM(CASE WHEN SRBPRG.PGPGRP = '971'
            	THEN
            		CASE SRBISH.IHTYPP WHEN 1 THEN SRBPRU.PJCONV  ELSE SRBPRU.PJCONV  * -1 END * SRBISD.IDQTY
            	END
            	)
            AS INTEGER)	
          ,'0')
          ||'/'||
          MAX( IFNULL( (SELECT max(VCUOTA) FROM VENDCUOTA WHERE IDPER ='$fperiodo' AND IDTCUOTA = '971K' and IDVEND = (CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END)),'0') ) 
          AS PROPAC   		
		, IFNULL(
		    CAST(
		      SUM(CASE WHEN SRBPRG.PGPGRP = '972'
            	THEN
            		CASE SRBISH.IHTYPP WHEN 1 THEN SRBPRU.PJCONV  ELSE SRBPRU.PJCONV  * -1 END *  SRBISD.IDQTY  
            	END
            	)	
             AS INTEGER)	
          ,'0')
          ||'/'||
          MAX( IFNULL( (SELECT max(VCUOTA) FROM VENDCUOTA WHERE IDPER ='$fperiodo' AND IDTCUOTA = '972K' and IDVEND = (CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END)),'0') ) 
          AS EARTHBORN
		, IFNULL(
		    CAST(
		      SUM(CASE WHEN SRBPRG.PGPGRP = '965'
            	THEN
            		CASE SRBISH.IHTYPP WHEN 1 THEN SRBPRU.PJCONV  ELSE SRBPRU.PJCONV  * -1 END * SRBISD.IDQTY 
            	END
            	)	
            AS INTEGER)	
          ,'0')
          ||'/'||
          MAX( IFNULL( (SELECT max(VCUOTA) FROM VENDCUOTA WHERE IDPER ='$fperiodo' AND IDTCUOTA = '965K' and IDVEND = (CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END)),'0') ) 
          AS F_CHOICE
		, IFNULL(
		    CAST(
		      SUM(CASE WHEN SRBPRG.PGPGRP = 'QUA'
            	THEN
            		CASE SRBISH.IHTYPP WHEN 1 THEN SRBPRU.PJCONV ELSE SRBPRU.PJCONV * -1 END * SRBISD.IDQTY 
            	END
            	)	
             AS INTEGER)	
          ,'0')
          ||'/'||
          MAX( IFNULL( (SELECT max(VCUOTA) FROM VENDCUOTA WHERE IDPER ='$fperiodo' AND IDTCUOTA = 'QUAU' and IDVEND = (CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END)),'0') ) 
          AS QUALIVET 
		, IFNULL(
		    CAST(
		    SUM(CASE WHEN SRBPRG.PGPGRP = '963'
            	THEN
            		CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END 
            	END
            	)	
            AS INTEGER)	
          ,'0')
          ||'/'||
          MAX( IFNULL( (SELECT max(VCUOTA) FROM VENDCUOTA WHERE IDPER ='$fperiodo' AND IDTCUOTA = '963U' and IDVEND = (CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END)),'0') ) 
          AS EVANGERS                		                   		            		            		
        , IFNULL(
            CAST(
		    SUM(CASE WHEN SRBPRG.PGPGRP = '140'
            	THEN
            		CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA *-1 END
            	END
            	)	
             AS INTEGER)	
          ,'0')
          ||'/'||
          MAX( IFNULL( (SELECT max(VCUOTA) FROM VENDCUOTA WHERE IDPER ='$fperiodo' AND IDTCUOTA = '140V' and IDVEND = (CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END)),'0') ) 
          AS A_Factor
          
          ,IFNULL(
          CAST(
		  SUM(CASE WHEN SRBPRG.PGPGRP = '929'
            	THEN
            		CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA *-1  END
            	END
            	)	
           AS INTEGER)	
          ,'0')
          ||'/'||
          MAX( IFNULL( (SELECT max(VCUOTA) FROM VENDCUOTA WHERE IDPER ='$fperiodo' AND IDTCUOTA = '929V' and IDVEND = (CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END)),'0') ) 
          
          AS Somex

    		
		FROM  SROISH SRBISH

            LEFT JOIN SROISDPL SRBISD ON SRBISH.IHINVN = SRBISD.IDINVN AND SRBISH.IHORNO = SRBISD.IDORNO
            LEFT JOIN SROPRG SRBPRG ON SRBISD.IDPRDC = SRBPRG.PGPRDC
            LEFT JOIN SROPRU SRBPRU ON SRBPRG.PGPRDC=SRBPRU.PJPRDC
            LEFT JOIN SROHNH SROHNH ON SRBISD.IDINUM = SROHNH.IHINUM
			LEFT JOIN SROISH SRBISH_1 ON SROHNH.IHRFNR = SRBISH_1.IHINVN AND SROHNH.IHCUNO = SRBISH_1.IHCUNO
            LEFT JOIN SROORSHE SRBSOH ON SRBISH.IHORNO = SRBSOH.OHORNO
            
		WHERE SRBPRU.PJUNIT =  CASE WHEN SRBPRG.PGPGRP IN('140','929') THEN 'UN' ELSE 'ME' END 
			AND SRBPRG.PGPGRP IN ('971','972','965','QUA','963','140','929')
			AND SRBSOH.OHORDT NOT IN ('03','13','19','Z3','Z4','Z5','Z6','Z7','ZN','67','68','72','25','93','K4')
			AND (CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END) IN ($fnom)
			AND (SRBISH.IHODAT BETWEEN '$desde' AND '$hasta')
			AND CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END != 0
			
            $fecomerceISH
                	
		GROUP BY (select SRBCTLSD.CTNAME as CT from SRBCTLSD WHERE SRBCTLSD.CTSIGN = 
		           CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END)
		ORDER BY (select SRBCTLSD.CTNAME as CT from SRBCTLSD WHERE SRBCTLSD.CTSIGN = 
		           CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END)                 
		";
if($_POST['area'] == 'Almacen'){ //echo "<br>$sql<br>";		
	$result = odbc_exec($db2conp, $sql) ; //echo $sql.odbc_errormsg();
		while($row = odbc_fetch_array($result)){
			foreach($row as $campo => $valor){
			$tiPROK["$campo"][]= utf8_encode($valor);
			$valorT = explode("/",$valor);
			$tiPROKTV["$campo"] += $valorT[0];
			$tiPROKTC["$campo"] += $valorT[1];
			}
		}	
}
//print_r($tiPRO);		
//echo $sql;



//recaudo

foreach($ti["VENDEDOR"] AS $cont => $vendRE){
$sql = "SELECT
		VCUOTA as C_RECAUDO
		FROM VENDCUOTA 
		WHERE IDPER ='$fperiodo'
		AND IDTCUOTA = 'RECA'
		AND IDVEND IN ('$vendRE') 
		";
$result = odbc_exec($db2conp, $sql) ; //echo odbc_errormsg(); //ECHO "$sql<br>";
	while($row = odbc_fetch_array($result)){
		foreach($row as $campo => $valor){
		$ti["$campo"]["$cont"]= utf8_encode($valor);
		}
	}

$cuotaPARAM['65'] = array('TODOS');
$cuotaPARAM['70'] = array('VEND081');
$cuotaPARAM['75'] = array('VEND079','VEND314','VEND334','VEND252');

$sql = " SELECT
		 SRODTA_1.DTVONO AS COMP
		, SRODTA_1.DTVODT AS FECHA_COMP 
		, SRODTA_1.DTIDNO AS R_CAJA
		, SRODTA.DTDOTY AS TIPO_DOC 
		, SRODTA.DTIDNO AS FACTURA 
		, SRODTA.DTDODT AS FECHA_FACTURA 
		, SRODTA.DTCUNO AS CLIENTE 
		, SRBNAM.NAARHA AS VENDEDOR_IBS 
		, SRBISH.IHSALE AS VENDEDOR 
		, SRBVPX.VPTCAM * -1 AS VLR_RECAUDO 
		, SRODTA_1.DTDODT AS FECHA_RECAUDO 
		, CASE WHEN SRODTA.DTTCRA <= 0 
		 	THEN 
		    	CASE WHEN 
           		(SELECT MAX(VPDODT) FROM AGR620CFAG.SRODTA SRODTA_U 
            		LEFT JOIN AGR620CFAG.SROVPX SRBVPX ON SRODTA.DTREFX=SRBVPX.VPREFX 
            		LEFT JOIN AGR620CFAG.SROVPH SRBVPH ON SRBVPX.VPREFS=SRBVPH.VPREFS 
           			WHERE SRODTA_U.DTIDNO = SRBISH.IHINVN AND SRODTA_U.DTCUNO = DTCUNO
           		) = SRODTA_1.DTDODT 
      			THEN 
          			DAYS(CAST(CONCAT(CONCAT(CONCAT(SUBSTR(SRODTA_1.DTDODT, 1, 4) , '-'), CONCAT(SUBSTR(SRODTA_1.DTDODT, 5, 2), '-')), SUBSTR(SRODTA_1.DTDODT, 7, 2)) AS DATE)) - DAYS(CAST(CONCAT(CONCAT(CONCAT(SUBSTR(SRODTA.DTDODT, 1, 4) , '-'), CONCAT(SUBSTR(SRODTA.DTDODT, 5, 2), '-')), SUBSTR(SRODTA.DTDODT, 7, 2)) AS DATE)) + 0 
      			END 
   			END
		  AS DIAS_RECAUDO	
		FROM AGR620CFAG.SRODTA SRODTA 
			LEFT JOIN AGR620CFAG.SROVPX SRBVPX ON SRODTA.DTREFX=SRBVPX.VPREFX 
			LEFT JOIN AGR620CFAG.SROVPH SRBVPH ON SRBVPX.VPREFS=SRBVPH.VPREFS 
			LEFT JOIN AGR620CFAG.SRODTA SRODTA_1 ON SRBVPH.VPREFX=SRODTA_1.DTREFX 
			LEFT JOIN AGR620CFAG.SRONAM SRBNAM ON SRODTA.DTCUNO=SRBNAM.NANUM 
			LEFT JOIN AGR620CFAG.SROISH SRBISH ON SRODTA.DTREFX=SRBISH.IHREFX 
		WHERE  SRODTA.DTDOTY IN('F1', '06', '07', '08')
		    AND SRODTA_1.DTVODT  BETWEEN '$desde' AND '$hasta' 
			AND SRBNAM.NAARHA = '$vendRE' 
			 
        ";
$result = odbc_exec($db2conp, $sql) ; //echo odbc_errormsg(); ECHO "$sql<br>";
	while($row = odbc_fetch_array($result)){
		
		foreach($row as $campo => $valor){
		$tiRECAUDO["$campo"][]= utf8_encode($valor);
		}
		
		//VALIDA DIAS SEGUN ARRAYS
		if($cuotaPARAM['65']){ $recDIAS = '65'; }
		if(in_array("$vendRE",$cuotaPARAM['70'])){ $recDIAS = '70'; }
		if(in_array("$vendRE",$cuotaPARAM['75'])){ $recDIAS = '75'; }
		
		//recaudo total
		$ti["RECAUDO"]["$cont"] += number_format($row["VLR_RECAUDO"],0,'','');
		
		//dentro de parametros perode be sumar total de la fact
		if( $row["DIAS_RECAUDO"] != '' AND $row["DIAS_RECAUDO"] <= $recDIAS)
		{
		$ti["RECAUDO_PAR"]["$cont"] += number_format($row["VLR_RECAUDO"],0,'','');
		}
		
		
		//echo "$row[FACTURA] $row[CLIENTE] $row[VENDEDOR] $row[VENDEDOR_IBS] : $row[DIAS_RECAUDO] => $row[VLR_RECAUDO] = ".$ti[RECAUDO][$cont]." <br>";
	}



}


//listado de ordenes estado 10
if($patrones =='SI'){
  $desde10 = date("Ymd",strtotime("$hoy - 2 month"));
  }else{
  $desde10 = date("Ymd",strtotime("$hoy - 7 day"));
  }	
$sql = "SELECT 
		TIPO_ORDEN||'-'||NUMERO_ORDEN as NUMERO_ORDEN
		, FECHA_ORDEN
		, $paisano_nom as VENDEDOR
		, RAZON_SOCIAL
		, SUM(VLR_EXC_IVA) AS TOTAL_EXC_IVA
		FROM VISVENTASORDEN1
		WHERE 
		  ESTADO_ORDEN = '10'
		  AND FECHA_ORDEN > '$desde10'
		  $farea
		GROUP BY
		  TIPO_ORDEN||'-'||NUMERO_ORDEN
		  ,FECHA_ORDEN
		  ,$paisano_nom
		  ,RAZON_SOCIAL
		ORDER BY FECHA_ORDEN, TIPO_ORDEN||'-'||NUMERO_ORDEN  
		";
if($_POST['queVer'] == 'EST10' ){	//echo $sql;	
	$result = odbc_exec($db2conp, $sql) ; //echo odbc_errormsg();
		while($row = odbc_fetch_array($result)){
			foreach($row as $campo => $valor){
			$ti10["$campo"][]= utf8_encode($valor);
			}
		}	
}


//CARTERA clientes

if($_POST['cliente'] != ''){
	    	$nomCA = "SRBISH.IHIDAT||' - '||SRBISH.IHINVN";
	    	$fnomCA = utf8_decode(" AND TRIM(SRBNAM.NANAME)||' | '||TRIM(NAARHA) = '$_POST[cliente]'");
	    	}else{
	    	$nomCA = "TRIM(SRBNAM.NANAME)||' | '||TRIM(NAARHA)";
	    	$fnomCA ='';
	    	}
$sql = "SELECT  
	
	$nomCA AS NOMBRE
	
    , sum(CASE WHEN
		DAYS(CAST(CONCAT(CONCAT(CONCAT(SUBSTR((SELECT MAX(SRBISH.IHIDAT) FROM SRBISH), 1, 4) , '-'), CONCAT(SUBSTR((SELECT MAX(SRBISH.IHIDAT) FROM SRBISH), 5, 2), '-')), SUBSTR((SELECT MAX(SRBISH.IHIDAT) FROM SRBISH), 7, 2)) AS DATE)) - DAYS(CAST(CONCAT(CONCAT(CONCAT(SUBSTR(SRODTA.DTDODT, 1, 4) , '-'), CONCAT(SUBSTR(SRODTA.DTDODT, 5, 2), '-')), SUBSTR(SRODTA.DTDODT, 7, 2)) AS DATE))
		BETWEEN 0 and 30
		THEN 
		SRODTA.DTSCRA
		END )
	 AS ".'"0M(0-30)"'."
    , sum(CASE WHEN
		DAYS(CAST(CONCAT(CONCAT(CONCAT(SUBSTR((SELECT MAX(SRBISH.IHIDAT) FROM SRBISH), 1, 4) , '-'), CONCAT(SUBSTR((SELECT MAX(SRBISH.IHIDAT) FROM SRBISH), 5, 2), '-')), SUBSTR((SELECT MAX(SRBISH.IHIDAT) FROM SRBISH), 7, 2)) AS DATE)) - DAYS(CAST(CONCAT(CONCAT(CONCAT(SUBSTR(SRODTA.DTDODT, 1, 4) , '-'), CONCAT(SUBSTR(SRODTA.DTDODT, 5, 2), '-')), SUBSTR(SRODTA.DTDODT, 7, 2)) AS DATE))
		BETWEEN 31 and 60
		THEN 
		SRODTA.DTSCRA
		END )
	 AS ".'"1M(31-60)"'."
	 , sum(CASE WHEN
		DAYS(CAST(CONCAT(CONCAT(CONCAT(SUBSTR((SELECT MAX(SRBISH.IHIDAT) FROM SRBISH), 1, 4) , '-'), CONCAT(SUBSTR((SELECT MAX(SRBISH.IHIDAT) FROM SRBISH), 5, 2), '-')), SUBSTR((SELECT MAX(SRBISH.IHIDAT) FROM SRBISH), 7, 2)) AS DATE)) - DAYS(CAST(CONCAT(CONCAT(CONCAT(SUBSTR(SRODTA.DTDODT, 1, 4) , '-'), CONCAT(SUBSTR(SRODTA.DTDODT, 5, 2), '-')), SUBSTR(SRODTA.DTDODT, 7, 2)) AS DATE))
		BETWEEN 61 and 90
		THEN 
		SRODTA.DTSCRA
		END )
	 AS ".'"2M(61-90)"'."
	 , sum(CASE WHEN
		DAYS(CAST(CONCAT(CONCAT(CONCAT(SUBSTR((SELECT MAX(SRBISH.IHIDAT) FROM SRBISH), 1, 4) , '-'), CONCAT(SUBSTR((SELECT MAX(SRBISH.IHIDAT) FROM SRBISH), 5, 2), '-')), SUBSTR((SELECT MAX(SRBISH.IHIDAT) FROM SRBISH), 7, 2)) AS DATE)) - DAYS(CAST(CONCAT(CONCAT(CONCAT(SUBSTR(SRODTA.DTDODT, 1, 4) , '-'), CONCAT(SUBSTR(SRODTA.DTDODT, 5, 2), '-')), SUBSTR(SRODTA.DTDODT, 7, 2)) AS DATE))
		BETWEEN 91 and 120
		THEN 
		SRODTA.DTSCRA
		END )
	 AS ".'"3M(91-120)"'."
	 , sum(CASE WHEN
		DAYS(CAST(CONCAT(CONCAT(CONCAT(SUBSTR((SELECT MAX(SRBISH.IHIDAT) FROM SRBISH), 1, 4) , '-'), CONCAT(SUBSTR((SELECT MAX(SRBISH.IHIDAT) FROM SRBISH), 5, 2), '-')), SUBSTR((SELECT MAX(SRBISH.IHIDAT) FROM SRBISH), 7, 2)) AS DATE)) - DAYS(CAST(CONCAT(CONCAT(CONCAT(SUBSTR(SRODTA.DTDODT, 1, 4) , '-'), CONCAT(SUBSTR(SRODTA.DTDODT, 5, 2), '-')), SUBSTR(SRODTA.DTDODT, 7, 2)) AS DATE))
		BETWEEN 121 and 150
		THEN 
		SRODTA.DTSCRA
		END )
	 AS ".'"4M(121-150)"'."
	 , sum(CASE WHEN
		DAYS(CAST(CONCAT(CONCAT(CONCAT(SUBSTR((SELECT MAX(SRBISH.IHIDAT) FROM SRBISH), 1, 4) , '-'), CONCAT(SUBSTR((SELECT MAX(SRBISH.IHIDAT) FROM SRBISH), 5, 2), '-')), SUBSTR((SELECT MAX(SRBISH.IHIDAT) FROM SRBISH), 7, 2)) AS DATE)) - DAYS(CAST(CONCAT(CONCAT(CONCAT(SUBSTR(SRODTA.DTDODT, 1, 4) , '-'), CONCAT(SUBSTR(SRODTA.DTDODT, 5, 2), '-')), SUBSTR(SRODTA.DTDODT, 7, 2)) AS DATE))
		>= 151
		THEN 
		SRODTA.DTSCRA
		END )
	 AS ".'"MO(>=151)"'."
     , SUM(SRBISH.IHIAET) AS VLRT_EXC_IVA
	 , max( (SELECT SUBSTRING(CMUFA1,3,1)  FROM SROCMA WHERE CMCUNO = SRODTA.DTCUNO)) AS AUTO_RETENEDOR
FROM SRODTA SRODTA
	LEFT JOIN SRONAM SRBNAM ON SRODTA.DTCUNO=SRBNAM.NANUM
	LEFT JOIN SROISH SRBISH ON SRODTA.DTREFX=SRBISH.IHREFX
    LEFT JOIN SROCTLC4 ON CTNCA4 = NANCA4 
    LEFT JOIN Z3ONAM ON SRBNAM.NANUM = Z3ONAM.Z3NANUM 
    LEFT JOIN COOCTLDN ON Z3NAMCOD = DNMCOD
    LEFT JOIN Z3OCTLDN Z3BCTLDN ON Z3BCTLDN.Z3DNMCOD=Z3ONAM.Z3NAMCOD
    LEFT JOIN SROCTLSD SRBCTLSD ON SRBISH.IHSALE = SRBCTLSD.CTSIGN
 WHERE 
    
    SRODTA.DTTCRA <> 0
    AND SRBNAM.NANCA1 = 'CC01'
    AND NAARHA IN($fnom)
    $fnomCA
    GROUP BY $nomCA
    
	"; 
	//echo $sql;
if($_POST['queVer'] == 'CARTERA'){		 
$result = odbc_exec($db2conp, $sql) ;
}else{$result = '';} 
	while($row = odbc_fetch_array($result)){
	$desc = utf8_encode($row["NOMBRE"]);
	$tiCLI["$desc"]["0M(0-30)"] = $row["0M(0-30)"];
	$tiCLI["$desc"]["1M(31-60)"] = $row["1M(31-60)"];
	$tiCLI["$desc"]["2M(61-90)"] = $row["2M(61-90)"];
	$tiCLI["$desc"]["3M(91-120)"] = $row["3M(91-120)"];
	$tiCLI["$desc"]["4M(121-150)"] = $row["4M(121-150)"];
	$tiCLI["$desc"]["MO(>=151)"] = $row["MO(>=151)"];
	 $tiCLI_rte["$desc"] = $row["AUTO_RETENEDOR"];
	 $tiCLI_base["$desc"] = $row["VLRT_EXC_IVA"];
	}

//VENTAS *CLIENTE*PROD
	//no cuando esta filtro cliente seleccionado AND NAARNA != 'VEND999'
	if($_POST['cliente'] != ''){
	$nolistCLI = "nolist";
	}else{
	$nolistCLI = "";
	}
  if($_POST['queVer'] == 'CARTERA'){
  $f999 = " AND NAARHA != 'VEND999' ";
  }
$sql = "$nolistCLI select 
TRIM(SRBNAM.NANAME)||' | '||TRIM(NAARHA) AS NOMBRE
, SRBPRG.PGDESC AS DESCRIPCION
, SRBPRG.PGPGRP AS GRUPO
, SUM(CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END) AS CANTIDAD
, sum(CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END) AS VLR_EXC_IVA

FROM SROISH SRBISH
	LEFT JOIN SROISDPL SRBISD ON SRBISH.IHINVN = SRBISD.IDINVN AND SRBISH.IHORNO = SRBISD.IDORNO
	LEFT JOIN SROORSHE SRBSOH ON SRBISH.IHORNO = SRBSOH.OHORNO
	LEFT JOIN SRONAM SRBNAM ON SRBISD.IDCUNO = SRBNAM.NANUM
	LEFT JOIN SROPRG SRBPRG ON SRBISD.IDPRDC = SRBPRG.PGPRDC
WHERE
(((CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END )<> 0)
    
	AND (SRBSOH.OHORDT NOT IN ('07','17','03','13','19','Z3','Z4','Z5','Z6','Z7','ZN','67','68','72','25','93','K4'))
	AND  SRBSOH.OHSALE IN ($fnom)
    AND (SRBISH.IHIDAT>='$desde') AND (SRBISH.IHIDAT<='$hasta'))
    $f999
    $fcli
    $fpro
GROUP BY
TRIM(SRBNAM.NANAME)||' | '||TRIM(NAARHA) 
, SRBPRG.PGDESC
, SRBPRG.PGPGRP
ORDER BY
SUM(CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END) ASC 
";
	
if($_POST['queVer'] == 'CARTERA' or $_POST['queVer'] == 'PRODUCTO' or $_POST['queVer'] == 'GRUPO'){
$result = odbc_exec($db2conp, $sql) ; //echo $sql; //echo odbc_errormsg();
}else{$result = '';}
	while($row = odbc_fetch_array($result)){
			$nom = utf8_encode($row["NOMBRE"]);
			$desc = utf8_encode($row["DESCRIPCION"]);
			$grupo = utf8_encode($row["GRUPO"]);
			$grupos["$grupo"] = $grupo;
			$totalVLR += $row["VLR_EXC_IVA"]; 
			if($row["VLR_EXC_IVA"] != 0){
				
				if($_POST['queVer'] == 'CARTERA'){
				  $tiCLI["$nom"]["Ventas"] += $row["VLR_EXC_IVA"];
				  }
				if($_POST['queVer'] == 'PRODUCTO'){
				  $tiPRO["$desc"]["CANT"] += $row["CANTIDAD"];
				  $tiPRO["$desc"]["VLR"] += $row["VLR_EXC_IVA"];
				  $tiPRO["$desc"]["CUOTA"] = $row["CUOTA"];
				  }
				if($_POST['queVer'] == 'GRUPO'){
				  $tiPRO["$grupo"]["CANT"] += $row["CANTIDAD"];
				  $tiPRO["$grupo"]["VLR"] += $row["VLR_EXC_IVA"];
				  $tiPRO["$grupo"]["CUOTA"] = $row["CUOTA"];
				  }
  
			}
		if(count($tiPRO) >0){
		  $tiPRO["TOTAL"]["VLR"] = $totalVLR;
		  }	
	}
/* para cuotas no se usa aca
$fprod2 ="'JIMBO'";	
foreach($tiPRO as $titulo => $valor){
	$fprod2 .= ",'".trim($titulo)."'";
	}
$sql = "SELECT
		  IDTCUOTA AS DESCRIPCION
		  ,SUM(VCUOTA) AS CUOTA
		FROM VENDCUOTA 
		WHERE IDPER ='$fperiodo'
		AND IDVEND IN ($fnom)
		AND IDTCUOTA NOT IN($fprod2)
		GROUP BY IDTCUOTA 
		"; 
if($_POST['area'] == 'Rappi'){
$result = odbc_exec($db2conp, $sql) ; //echo odbc_errormsg();
}
	while($row = odbc_fetch_array($result)){
	$desc = utf8_encode($row["DESCRIPCION"]);
	$tiPRO["$desc"]["CUOTA"] = $row["CUOTA"];
	}
*/

?>
