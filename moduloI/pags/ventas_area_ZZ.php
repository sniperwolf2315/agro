<? $areas = array('Comervet','Plagas','');
   //$labs = array('COASPHARMA','TECNOCALIDAD','COMERVET','MICROSULES','QUALIVET');
   //$cuotasAD = array('C_EARTHBORN','C_PROPAC'); 

   if($_POST['desde'] ==''){
     	$_POST['desde'] = date("Y-m-01");	
    }
    if($_POST['hasta'] ==''){ $_POST['hasta'] = $hoy; }
    
    //if($_POST['area'] == '' AND $_POST['vendedor'] == ''){$_POST['area'] = 'Ganaderia';}
    
    if($_POST['info'] == '' ){ $_POST['info'] = "Facturado";}


$vendCmv = " 'VENDCO01','VENDCO02','VENDCO03','VENDCO04','VENDCO05','VENDCO06','VENDCO07','VENDCO08','VENDCO09','VENDCO10','VENDCO11','VENDCO12' ";
$arrSF= explode(",", $vendPlagas);
if(in_array("'".trim($_POST['vendedor'])."'",$arrSF)){$_POST['area'] = "Comervet";}


$vendPlagas = "'VENDCO13','VENDCO14','VENDCO15','VENDCO16'";
$arrSF= explode(",", $vendPlagas);
if(in_array("'".trim($_POST['vendedor'])."'",$arrSF)){$_POST['area'] = "Plagas";}


if($_POST['area'] == '' ){$fnom = $vendCmv.",".$vendPlagas;}
if($_POST['area'] == 'Comervet' ){$fnom = $vendCmv;}
if($_POST['area'] == 'Plagas' ){$fnom = $vendPlagas;}
	

//print_r($arralm);
//echo $vendalm;

/*$sql = "select CTSIGN, CTNAME from SRBCTLSD WHERE CTSIGN IN ($fnom) order by CTSIGN";
$result = odbc_exec($db2conp, $sql);
while($row = odbc_fetch_array($result)){
	$nom = utf8_encode($row['CTNAME']);
	$cod = $row['CTSIGN'];
	$nombres["$cod"] = $nom;
}
*/

if($_POST['info'] == 'Facturado' ){ $finfo = " AND ESTADO_ORDEN != 10 ";}
if($_POST['info'] == 'Ord Venta' ){ $finfo = " AND ESTADO_ORDEN = 10 ";}
if($_POST['info'] == 'Fac y Ord venta' ){$finfo = '';}


$finfo = '';
$paisano = "CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END";
$paisano_nom = "(select SRBCTLSD.CTNAME from SRBCTLSD WHERE SRBCTLSD.CTSIGN = $paisano)";
$farea = " AND $paisano IN ($fnom)";
if($_POST['vendedor'] != '' ){
	$fnom = "'".$_POST['vendedor']."'";
	$farea = " AND $paisano IN ($fnom)";
	}

if($_POST['cliente'] != '' ){
	$fcli = " AND SRBNAM.NANAME ='".utf8_decode($_POST[cliente])."' ";
	}

if($_POST['producto'] != '' ){
	$fpro = " AND SRBPRG.PGDESC ='".utf8_decode($_POST[producto])."' ";
	}


//consulta de ventas y cuotas
$desde = str_replace("-", "", $_POST['desde']);
$hasta = str_replace("-", "", $_POST['hasta']);

$dias = (strtotime("$_POST[hasta]")-strtotime("$_POST[desde]"))/86400 ;
if( substr($desde,6,2)== 01
   and $dias <= 31){
	$sqlcuotas ="SI";
	}else{ $cuotas =""; $cuotasmsg ="<br>*No se muestran cuotas, no es periodo comercial"; }
 
//VENTAS + CUOTA
$sql ="SELECT 
 CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END AS VENDEDOR
,CASE SRBISD.IDINUM WHEN 0 THEN SRBCTLSD.CTNAME ELSE SRBCTLSD_1.CTNAME END  AS NOMBRE_VEND
,SUM(CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END)  AS OBJETIVO
,SUM(CASE when SRBPRG.PGPGRP IN('MIC','CMV','CPH','TEC','QUA') THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as LABORATORIOS
,SUM(CASE when SRBPRG.PGPGRP ='971' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as PROPAC
,SUM(CASE when SRBPRG.PGPGRP ='972' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as EARTHBORN
,SUM(CASE when SRBPRG.PGPGRP NOT IN ('971','972','MIC','CMV','CPH','TEC','QUA') THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as IMPORTADOS

,SUM(CASE when SRBPRG.PGPGRP = 'MIC' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as MICROSULES
,SUM(CASE when SRBPRG.PGPGRP = 'CMV' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as COMERVET
,SUM(CASE when SRBPRG.PGPGRP = 'CPH' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as COASPHARMA
,SUM(CASE when SRBPRG.PGPGRP = 'TEC' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as TECNOCALIDAD
,SUM(CASE when SRBPRG.PGPGRP = 'QUA' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as QUALIVET
                   	
FROM SROISH SRBISH
	full outer JOIN SROCTLSD SRBCTLSD ON SRBISH.IHSALE = SRBCTLSD.CTSIGN
	LEFT JOIN SROISDPL SRBISD ON SRBISH.IHINVN = SRBISD.IDINVN AND SRBISH.IHORNO = SRBISD.IDORNO
	LEFT JOIN SROPRG SRBPRG ON SRBISD.IDPRDC = SRBPRG.PGPRDC
	LEFT JOIN SROORSHE SRBSOH ON SRBISH.IHORNO = SRBSOH.OHORNO
	
	LEFT JOIN SROHNH SROHNH ON SRBISD.IDINUM = SROHNH.IHINUM
	LEFT JOIN SROISH SRBISH_1 ON SROHNH.IHRFNR = SRBISH_1.IHINVN AND SROHNH.IHCUNO = SRBISH_1.IHCUNO
	LEFT JOIN SROCTLSD SRBCTLSD_1 ON SRBISH_1.IHSALE = SRBCTLSD_1.CTSIGN
	LEFT JOIN SRONAM SRBNAM ON SRBISD.IDCUNO = SRBNAM.NANUM
WHERE 
	((CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END )<> 0)
	AND (SRBSOH.OHORDT NOT IN ('07','17','03','19','Z3','Z4','Z5','Z6','Z7','ZN','67','68','72','25','93','K4'))
and SRBISH.IHIDAT BETWEEN '$desde'  AND '$hasta'
$finfo
$farea
$fcli
$fpro
GROUP BY $paisano , CASE SRBISD.IDINUM WHEN 0 THEN SRBCTLSD.CTNAME ELSE SRBCTLSD_1.CTNAME END
order by $paisano
";

//echo $sql; 

$cont = 0; 
if($_POST['queVer'] == 'VENTAS' ){	
  $result = odbc_exec($db2conp, $sql) ; echo odbc_errormsg();
  }else{$result = '';}
     
	while($row = odbc_fetch_array($result)){
	    //lista de vendedores
	    $cod = $row['VENDEDOR'];
	    $nombres["$cod"] = $row['NOMBRE_VEND'];
	    
		foreach($row as $campo => $valor){
		$ti["$campo"][]= utf8_encode($valor);
		}
		
		if($sqlcuotas =='SI'){
		 $fperiodo = substr($desde,0,6);
		 $sqlQ ="SELECT
 	   			SUM(VCUOTA)AS C_OBJETIVO
      			FROM VENDCUOTA WHERE IDPER = '$fperiodo' AND IDVEND = '$row[VENDEDOR]' GROUP BY IDPER, IDVEND
				";
		//ECHO "<BR>$sqlQ";
		$resultQ = odbc_exec($db2conp, $sqlQ) ; echo odbc_errormsg();
		while($rowQ = odbc_fetch_array($resultQ)){
			foreach($rowQ as $campo => $valor){
				$ti["$campo"]["$cont"]= utf8_encode($valor);
				}	
			$ti["TOTALC"]["$cont"] = $rowQ['C_OBJETIVO']+$rowQ['C_CONTADO'];
			}
		}
	//$ti["AREA"]	
	$ti["TOTALV"][] = $row['OBJETIVO']+$row['CONTADO'];
	$cont ++;
	}	

//AGREGA A LA LISTA LOS QUE NO HAN VENDIDO
$fnom2 = implode("','",$ti['VENDEDOR']);
$sql = "SELECT
		  IDVEND as VENDEDOR
		, (SELECT CTNAME FROM SRBCTLSD WHERE CTSIGN = IDVEND) as NOMBRE_VEND
		, '' as OBJETIVO
		, '' as LABORATORIOS
		, '' as PROPAC
		, '' as EARTHBORN
		, '' as IMPORTADOS
		, '' as MICROSULES
		, '' as COMERVET
		, '' as COASPHARMA
		, '' as TECNOCALIDAD
		, '' as QUALIVET
		, SUM(VCUOTA) as C_OBJETIVO
		, SUM(CASE WHEN IDTCUOTA = 'ACCE' THEN VCUOTA ELSE 0 END) as C_IMPOR
		, SUM(CASE WHEN IDTCUOTA = 'MEDI' THEN VCUOTA ELSE 0 END) as C_LABS
		, SUM(CASE WHEN IDTCUOTA = 'EART' THEN VCUOTA ELSE 0 END) as C_EARTHBORN
		, SUM(CASE WHEN IDTCUOTA = 'PROP' THEN VCUOTA ELSE 0 END) as C_PROPAC
		, SUM(CASE WHEN IDTCUOTA = 'GENE' THEN VCUOTA ELSE 0 END) as TOTALC
		, '' as TOTALV
		FROM VENDCUOTA 
		WHERE IDPER ='$fperiodo'
		AND IDVEND IN ($fnom)
		AND IDVEND NOT IN('$fnom2')
		GROUP BY IDVEND, (SELECT CTNAME FROM SRBCTLSD WHERE CTSIGN = IDVEND) 
		"; 
if($_POST['queVer'] == 'VENTAS' ){	
  $result = odbc_exec($db2conp, $sql) ; echo odbc_errormsg();
  }else{$result = '';}

	while($row = odbc_fetch_array($result)){ 
		foreach($row as $campo => $valor){
		$ti["$campo"][]= utf8_encode($valor);
		$ti["TOTALC"][] += $row['C_OBJETIVO']+$row['C_CONTADO'];
		}
	
	}	

// ordenes est 10
$sql = "SELECT 
		SRBSOL.OLORNO AS NUMERO_ORDEN
		, SROORSHE.OHODAT AS FECHA_ORDEN
		, (select SRBCTLSD.CTNAME from SRBCTLSD WHERE SRBCTLSD.CTSIGN = SROORSHE.OHSALE ) as VENDEDOR
		, SRBNAM.NANAME AS RAZON_SOCIAL
		, SUM(CASE WHEN SRBSOL.OLFOCC='Y' THEN 0 ELSE SRBSOL.OLITET END) AS TOTAL_EXC_IVA
		FROM SROORSHE SROORSHE
		LEFT JOIN SROORSPL SRBSOL ON SROORSHE.OHORNO = SRBSOL.OLORNO
		LEFT JOIN SRONAM SRBNAM ON SRBNAM.NANUM=SROORSHE.OHCUNO
		WHERE
		 OHSTAT <> 'D'
			   AND SROORSHE.OHORDT NOT IN ('07','17','03','13','19','Z3','Z4','Z5','Z6','Z7','ZN','67','68','72','25','93','K4')

               AND (SRBSOL.OLSTAT <> 'D')

               AND (SRBSOL.OLORDS=10) 
		  AND SROORSHE.OHODAT  BETWEEN '$desde'  AND '$hasta'
		  AND SROORSHE.OHSALE  IN ($fnom)
		GROUP BY
		  SRBSOL.OLORNO
		  ,SROORSHE.OHODAT
		  ,(select SRBCTLSD.CTNAME from SRBCTLSD WHERE SRBCTLSD.CTSIGN = SROORSHE.OHSALE )
		  ,SRBNAM.NANAME
		ORDER BY SRBSOL.OLORNO  
		";
if($_POST['queVer'] == 'EST10' ){	
  $result = odbc_exec($db2conp, $sql) ; echo odbc_errormsg();
  }else{$result = '';}
	while($row = odbc_fetch_array($result)){
			foreach($row as $campo => $valor){
			$ti10["$campo"][]= utf8_encode($valor);
			}
		}	


//VENTAS *CLIENTE*PROD
	//no cuando esta filtro cliente seleccionado
	if($_POST['cliente'] != ''){
	$nolistCLI = "nolist";
	}else{
	$nolistCLI = "";
	}

$sql = "$nolistCLI select 
TRIM(SRBNAM.NANAME)||' | '||TRIM(NAARHA) AS NOMBRE
, SRBPRG.PGDESC AS DESCRIPCION
, SUM(CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END) AS CANTIDAD
, sum(CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END) AS VLR_EXC_IVA
, (SELECT SUM(VCUOTA) FROM VENDCUOTA WHERE IDTCUOTA = SRBPRG.PGDESC AND IDPER ='$fperiodo' AND IDVEND IN ($fnom) ) AS CUOTA
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
    $fcli
    $fpro
GROUP BY
TRIM(SRBNAM.NANAME)||' | '||TRIM(NAARHA) 
, SRBPRG.PGDESC 
";
//echo $sql;
if($_POST['queVer'] == 'CARTERA' or $_POST['queVer'] == 'PRODUCTO'){	
	$result = odbc_exec($db2conp, $sql) ; //echo odbc_errormsg();
	}else{$result = '';}
	while($row = odbc_fetch_array($result)){
			$nom = utf8_encode($row["NOMBRE"]);
			$desc = utf8_encode($row["DESCRIPCION"]);
			if($row["VLR_EXC_IVA"] != 0){
				
				if($_POST['queVer'] == 'CARTERA'){
				  $tiCLI["$nom"]["Ventas"] += $row["VLR_EXC_IVA"];
				  }
				if($_POST['queVer'] == 'PRODUCTO'){
				  $tiPRO["$desc"]["CANT"] += $row["CANTIDAD"];
				  $tiPRO["$desc"]["VLR"] += $row["VLR_EXC_IVA"];
				  $tiPRO["$desc"]["CUOTA"] = $row["CUOTA"];
				  }
			}
	}
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
$result = odbc_exec($db2conp, $sql) ; //echo odbc_errormsg();
	while($row = odbc_fetch_array($result)){
	$desc = utf8_encode($row["DESCRIPCION"]);
	$tiPRO["$desc"]["CUOTA"] = $row["CUOTA"];
	}

//CARTERA 
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

FROM SRODTA SRODTA
	LEFT JOIN SRONAM SRBNAM ON SRODTA.DTCUNO=SRBNAM.NANUM
	LEFT JOIN SROISH SRBISH ON SRODTA.DTREFX=SRBISH.IHREFX
    LEFT JOIN SROCTLC4 ON CTNCA4 = NANCA4 
    LEFT JOIN Z3ONAM ON SRBNAM.NANUM = Z3ONAM.Z3NANUM 
    LEFT JOIN COOCTLDN ON Z3NAMCOD = DNMCOD
    LEFT JOIN Z3OCTLDN Z3BCTLDN ON Z3BCTLDN.Z3DNMCOD=Z3ONAM.Z3NAMCOD
    LEFT JOIN SROCTLSD SRBCTLSD ON SRBISH.IHSALE = SRBCTLSD.CTSIGN
 WHERE 
    
    SRODTA.DTSCRA <> 0
    AND SRBNAM.NANCA1 != 'CC01'
    AND NAARHA IN($fnom)
    $fnomCA
    GROUP BY $nomCA 
	"; 
	//echo $sql; 
if($_POST['queVer'] == 'CARTERA' ){	 
  $result = odbc_exec($db2conp, $sql) ; //echo odbc_errormsg();
  }else{ $result = '';}	
	while($row = odbc_fetch_array($result)){
	$desc = utf8_encode($row["NOMBRE"]);
	$tiCLI["$desc"]["0M(0-30)"] = $row["0M(0-30)"];
	$tiCLI["$desc"]["1M(31-60)"] = $row["1M(31-60)"];
	$tiCLI["$desc"]["2M(61-90)"] = $row["2M(61-90)"];
	$tiCLI["$desc"]["3M(91-120)"] = $row["3M(91-120)"];
	$tiCLI["$desc"]["4M(121-150)"] = $row["4M(121-150)"];
	$tiCLI["$desc"]["MO(>=151)"] = $row["MO(>=151)"];
	}



		
	ksort($tiCLI);
	ksort($tiPRO);
	
	
$paisano = "VENDEDOR";

?>
