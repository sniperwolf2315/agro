<? $areas = array('Call','Venta Externa','Almacen');

	$labs = array('BIOSTAR','COASPHARMA','PHARMEK','TECNOCALIDAD','COMERVET','INTERVET'); 
	$labsc = "'BIS','CPH','PHK','TEC','CMV','INC','INM'";
	$c_labs= "'CFBS','CGCS','CGPH','CGTC','CFCM','CFIN'";
	
   if($_POST['desde'] ==''){
    if(substr($hoy,8,2) < 16 ){
    	$_POST['desde'] = date("Y-m-16",strtotime("$hoy - 1 month"));
    	}else{
    	$_POST['desde'] = date("Y-m-16",strtotime("$hoy"));
    	}
    }
    if($_POST['hasta'] ==''){ $_POST['hasta'] = $hoy; }
    
    if($_POST['area'] == '' AND $_POST['vendedor'] == ''){$_POST['area'] = 'Venta Externa';}
    
    if($_POST['info'] == '' ){ $_POST['info'] = "Facturado";}

	//registros por pag paginador
	$regsxpag = 50;
	
	if($_POST['paginador'] ==''){ $_POST['paginador'] = "1-$regsxpag"; }
	$limit = explode("-",$_POST['paginador']);
	$limit[0] = $limit[0]-1;
	$flimit = " LIMIT $limit[0],$limit[1] ";	

$vendcall = "'VEND321','VEND389','VEND414','VEND419','VEND437','VEND439','VEND443','VEND452','VEND466','VEND468','VEND469',
			 'VEND471','VEND472','VEND473','VEND475','VEND480','VEND481','VEND483','VEND500','VEND501','VEND502','VEND503',
			 'VEND510','VEND515','VEND526'";
$arrcall= explode(",", $vendcall);
if(in_array("'".trim($_POST['vendedor'])."'",$arrcall)){$_POST['area'] = "Call";}

	
$vendext = "'VEND039', 'VEND040', 'VEND045', 'VEND078', 'VEND079', 'VEND081', 'VEND114',  'VEND165', 'VEND183', 'VEND214', 
	         'VEND252', 'VEND260', 'VEND310', 'VEND313', 'VEND314', 'VEND334', 'VEND338','VENDOTC'";
$arrext= explode(",", $vendext);
if(in_array("'".trim($_POST['vendedor'])."'",$arrext)){$_POST['area'] = "Venta Externa";}
	         
$vendalm = "'VEND050','VEND164','VEND250','VEND251','VEND302','VEND304','VEND327','VEND358','VEND363','VEND368','VEND369',
			'VEND380','VEND408','VEND417','VEND425','VEND492','VEND495','VEND498','VEND499','VEND506','VEND507','VEND509',
			'VEND512','VEND513','VEND514','VEND516','VEND517','VEND518','VEND519','VEND520','VEND521','VEND522','VEND523',
			'VEND524','VEND527' ";
$arralm= explode(",", $vendalm);			
if(in_array("'".trim($_POST['vendedor'])."'",$arralm)){$_POST['area'] = "Almacen";}

//print_r($arralm);
//echo $vendalm;
if($_POST['area'] == '' ){$fnom = "'$_POST[vendedor]'";}
if($_POST['area'] == 'Call' ){$fnom = $vendcall;}
if($_POST['area'] == 'Venta Externa' ){$fnom = $vendext;}
if($_POST['area'] == 'Almacen' ){$fnom = $vendalm;}
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
	}
	
//consulta de ventas y cuotas
$desde = str_replace("-", "", $_POST['desde']);
$hasta = str_replace("-", "", $_POST['hasta']);

$dias = (strtotime("$_POST[hasta]")-strtotime("$_POST[desde]"))/86400 ;
if( substr($desde,6,2)== 16
   and $dias <= 31
   ){
$cuotas =",'|' AS CUOTAS
, CASE WHEN (SUBSTRING(MIN(FECHA_ORDEN),7,2)+0) >= 16 
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
	AS MES_CUOTA
, (SELECT MAX(VCUOTA) FROM VENDCUOTA VENDCUOTA
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
	) 
    AS C_CONTADO
, (SELECT MAX(VCUOTA) FROM VENDCUOTA VENDCUOTA
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
	) 
    AS C_OBJETIVO
, (SELECT SUM(VCUOTA) FROM VENDCUOTA VENDCUOTA
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
	) 
    AS C_LABS
, (SELECT MAX(VCUOTA) FROM VENDCUOTA VENDCUOTA
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
	) 
    AS C_IMPOR

, (SELECT SUM(VCUOTA) FROM VENDCUOTA VENDCUOTA
	where IDTCUOTA = 'CFBS'
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
	) 
    AS C_BIOSTAR
, (SELECT SUM(VCUOTA) FROM VENDCUOTA VENDCUOTA
	where IDTCUOTA = 'CGCS'
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
	) 
    AS C_COASPHARMA
, (SELECT SUM(VCUOTA) FROM VENDCUOTA VENDCUOTA
	where IDTCUOTA = 'CGPH'
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
	) 
    AS C_PHARMEK
, (SELECT SUM(VCUOTA) FROM VENDCUOTA VENDCUOTA
	where IDTCUOTA = 'CGTC'
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
	) 
    AS C_TECNOCALIDAD    
, (SELECT SUM(VCUOTA) FROM VENDCUOTA VENDCUOTA
	where IDTCUOTA = 'CFCM'
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
	) 
    AS C_COMERVET
, (SELECT SUM(VCUOTA) FROM VENDCUOTA VENDCUOTA
	where IDTCUOTA = 'CFIN'
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
	) 
    AS C_INTERVET
    
  ";	
	}else{ $cuotas =""; $cuotasmsg ="<br>*No se muestran cuotas, no es periodo comercial"; }
 

$sql ="SELECT 
$paisano 
, $paisano_nom  AS NOMBRE_VEND
, CONCAT(CONCAT(CONCAT(CONCAT(SUBSTRING(MIN(FECHA_ORDEN),1,4), '-'  ),SUBSTRING(MIN(FECHA_ORDEN),5,2)),'-'),SUBSTRING(MIN(FECHA_ORDEN),7,2))  AS DESDE
, CONCAT(CONCAT(CONCAT(CONCAT(SUBSTRING(MAX(FECHA_ORDEN),1,4), '-'  ),SUBSTRING(MAX(FECHA_ORDEN),5,2)),'-'),SUBSTRING(MAX(FECHA_ORDEN),7,2))  AS HASTA
,SUM(CASE WHEN (MANEJADOR IN ('ADMINISTRA', 'CALLCENTER'))OR(MANEJADOR IN ('VANANDELL') AND VENDEDOR IN('VEND114','VEND214')) THEN VLR_EXC_IVA END) AS CONTADO
,SUM(CASE WHEN (MANEJADOR IN ('VANANDELL') AND VENDEDOR NOT IN('VEND114','VEND214')) THEN VLR_EXC_IVA END)  AS OBJETIVO
,SUM(CASE when GRUPO IN( $labsc ) OR ITEM IN ('636300016','636300025','636300110','636300134') THEN VLR_EXC_IVA End ) as LABORATORIOS
,SUM(CASE WHEN ((MANEJADOR IN ('ADMINISTRA', 'CALLCENTER' $vanandell)) $vany14s )AND(FAMILIA= 'IMPORTADOS') THEN VLR_EXC_IVA END)  AS IMPORTADOS
,SUM(CASE when GRUPO = 'BIS' THEN VLR_EXC_IVA End ) as BIOSTAR
,SUM(CASE when GRUPO = 'CPH' THEN VLR_EXC_IVA End ) as COASPHARMA
,SUM(CASE when GRUPO = 'PHK' THEN VLR_EXC_IVA End ) as PHARMEK
,SUM(CASE when GRUPO = 'TEC' THEN VLR_EXC_IVA End ) as TECNOCALIDAD
,SUM(CASE when GRUPO = 'CMV' OR ITEM IN ('636300016','636300025','636300110','636300134') THEN VLR_EXC_IVA End ) as COMERVET
,SUM(CASE when GRUPO IN ('INC','INM') THEN VLR_EXC_IVA End ) as INTERVET
$cuotas
                    	
FROM VISVENTASORDEN1
WHERE 

FECHA_ORDEN BETWEEN '$desde'  AND '$hasta'
$finfo
$farea
GROUP BY $paisano
order by NOMBRE_VEND
";
//echo $sql;
$cont = -1;       
$result = odbc_exec($db2conp, $sql) ; echo odbc_errormsg();
	while($row = odbc_fetch_array($result)){
	$cont += 1;
		foreach($row as $campo => $valor){
		$ti["$campo"][]= utf8_encode($valor);
		}
	//$ti["AREA"]	
	$ti["TOTALV"][] = $row['OBJETIVO']+$row['CONTADO'];
	$ti["TOTALC"][] = $row['C_OBJETIVO']+$row['C_CONTADO'];	
	}	

//ventas de kilos y unidades marcars propias

$sql = "SELECT
		 CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END AS VENDEDOR
		, SUM(CASE WHEN SRBPRG.PGPGRP = '971'
            	THEN
            		CASE SRBISH.IHTYPP WHEN 1 THEN SRBPRU.PJCONV  ELSE SRBPRU.PJCONV  * -1 END * SRBISD.IDQTY
            	END
            	)	
            		AS PROPAC
		, SUM(CASE WHEN SRBPRG.PGPGRP = '972'
            	THEN
            		CASE SRBISH.IHTYPP WHEN 1 THEN SRBPRU.PJCONV  ELSE SRBPRU.PJCONV  * -1 END *  SRBISD.IDQTY  
            	END
            	)	
            		AS EARTHBORN
		, SUM(CASE WHEN SRBPRG.PGPGRP = '965'
            	THEN
            		CASE SRBISH.IHTYPP WHEN 1 THEN SRBPRU.PJCONV  ELSE SRBPRU.PJCONV  * -1 END * SRBISD.IDQTY 
            	END
            	)	
            		AS F_CHOICE
		, SUM(CASE WHEN SRBPRG.PGPGRP = 'QUA'
            	THEN
            		CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END 
            	END
            	)	
            		AS QUALIVET 
		, SUM(CASE WHEN SRBPRG.PGPGRP = '963'
            	THEN
            		CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END 
            	END
            	)	
            		AS EVANGERS                		                   		            		            		
            		
		FROM  SROISH SRBISH

            LEFT JOIN SROISDPL SRBISD ON SRBISH.IHINVN = SRBISD.IDINVN AND SRBISH.IHORNO = SRBISD.IDORNO
            LEFT JOIN SROPRG SRBPRG ON SRBISD.IDPRDC = SRBPRG.PGPRDC
            LEFT JOIN SROPRU SRBPRU ON SRBPRG.PGPRDC=SRBPRU.PJPRDC
            LEFT JOIN SROHNH SROHNH ON SRBISD.IDINUM = SROHNH.IHINUM
			LEFT JOIN SROISH SRBISH_1 ON SROHNH.IHRFNR = SRBISH_1.IHINVN AND SROHNH.IHCUNO = SRBISH_1.IHCUNO
            
		WHERE SRBPRU.PJUNIT =  CASE WHEN SRBPRG.PGPGRP='QUA' THEN 'UN' ELSE 'ME' END 
			AND SRBPRG.PGPGRP IN ('971','972','965','QUA','963')
			AND (CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END) IN ($fnom)
			AND (SRBISH.IHODAT BETWEEN '$desde' AND '$hasta')
			AND CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END != 0    	
		GROUP BY CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END     
		";
if($_POST['area'] == 'Almacen'){		
	$result = odbc_exec($db2conp, $sql) ; echo odbc_errormsg();
		while($row = odbc_fetch_array($result)){
			foreach($row as $campo => $valor){
				if($campo == "VENDEDOR"){
					$sqlNV = "select SRBCTLSD.CTNAME as CT from SRBCTLSD WHERE SRBCTLSD.CTSIGN = '$valor'";
					$resultNV = odbc_exec($db2conp, $sqlNV) ; echo odbc_errormsg();
					while($rowNV = odbc_fetch_array($resultNV)){
						$valor = $rowNV["CT"]; 
						}
				}
			$tiPROK["$campo"][]= utf8_encode($valor);
			$tiPROKT["$campo"] += utf8_encode($valor);
			}
		}	
}
//print_r($tiPRO);		
//echo $sql;



//listado de ordenes estado 10	
$sql = "SELECT 
		NUMERO_ORDEN
		, FECHA_ORDEN
		, $paisano_nom as VENDEDOR
		, RAZON_SOCIAL
		, SUM(VLR_EXC_IVA) AS TOTAL_EXC_IVA
		FROM VISVENTASORDEN1
		WHERE 
		  ESTADO_ORDEN = '10'
		  AND FECHA_ORDEN BETWEEN '$desde'  AND '$hasta'
		  $farea
		GROUP BY
		  NUMERO_ORDEN
		  ,FECHA_ORDEN
		  ,$paisano_nom
		  ,RAZON_SOCIAL
		ORDER BY NUMERO_ORDEN  
		";
if($_POST['info'] == 'Ord Venta' ){		
	$result = odbc_exec($db2conp, $sql) ; echo odbc_errormsg();
		while($row = odbc_fetch_array($result)){
			foreach($row as $campo => $valor){
			$ti10["$campo"][]= utf8_encode($valor);
			}
		}	
}
//print_r($ti10);		
//echo $sql;
?>
