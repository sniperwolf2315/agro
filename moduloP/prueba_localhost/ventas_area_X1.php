<? $areas = array('Ganaderia','Mascotas');
   $labs = array('COASPHARMA','TECNOCALIDAD','COMERVET','MICROSULES','QUALIVET');
   $cuotasAD = array('C_EARTHBORN','C_PROPAC'); 

   if($_POST['desde'] ==''){
    if(substr($hoy,8,2) < 21 ){
    	$_POST['desde'] = date("Y-m-21",strtotime("$hoy - 1 month"));
    	}else{
    	$_POST['desde'] = date("Y-m-21",strtotime("$hoy"));
    	}
    }
    if($_POST['hasta'] ==''){ $_POST['hasta'] = $hoy; }
    
    if($_POST['area'] == '' AND $_POST['vendedor'] == ''){$_POST['area'] = 'Ganaderia';}
    
    if($_POST['info'] == '' ){ $_POST['info'] = "Facturado";}


	

$vendgan = "'VENPEST003','VENPEST004','VENPEST006','VENPEST007','VENPEST008','VENPEST009','VENPEST010'
           ,'VENPEST011','VENPEST012','VENPEST013','VENPEST016'";
$arrgan= explode(",", $vendgan);
if(in_array("'".trim($_POST['vendedor'])."'",$arrgan)){$_POST['area'] = "Ganaderia";}


$vendmas = "'VENDOTC','VENPEST015','VENPEST017','VENPEST018','VENPEST019'";
$arrmas= explode(",", $vendmas);
if(in_array("'".trim($_POST['vendedor'])."'",$arrmas)){$_POST['area'] = "Mascotas";}

//print_r($arralm);
//echo $vendalm;
if($_POST['area'] == '' ){$fnom = "'$_POST[vendedor]'";}
if($_POST['area'] == 'Ganaderia' ){$fnom = $vendgan;}
if($_POST['area'] == 'Mascotas' ){$fnom = $vendmas;}
$sql = "select CTSIGN, CTNAME from SRBCTLSD WHERE SRBCTLSD.CTSIGN IN($fnom) order by CTSIGN";
$result = odbc_exec($db2conp, $sql);
while($row = odbc_fetch_array($result)){
	$nom = utf8_encode($row['CTNAME']);
	$cod = $row['CTSIGN'];
	$nombres["$cod"] = $nom;
}

if($_POST['vendedor'] != '' ){$fnom = "'".$_POST['vendedor']."'";}

if($_POST['info'] == 'Facturado' ){ $finfo = " AND ESTADO_ORDEN != 10 ";}
if($_POST['info'] == 'Ord Venta' ){ $finfo = " AND ESTADO_ORDEN = 10 ";}
if($_POST['info'] == 'Fac y Ord venta' ){$finfo = '';}
$finfo = '';
$paisano = "CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END";
$paisano_nom = "(select SRBCTLSD.CTNAME from SRBCTLSD WHERE SRBCTLSD.CTSIGN = $paisano)";
$farea = " AND $paisano IN ($fnom)";

//consulta de ventas y cuotas
$desde = str_replace("-", "", $_POST['desde']);
$hasta = str_replace("-", "", $_POST['hasta']);

$dias = (strtotime("$_POST[hasta]")-strtotime("$_POST[desde]"))/86400 ;
if( substr($desde,6,2)== 21
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

WHERE 
	((CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END )<> 0)
	AND (SRBSOH.OHORDT NOT IN ('07','17','03','13','19','Z3','Z4','Z5','Z6','Z7','ZN','67','68','72','25','93','K4'))
and SRBISH.IHIDAT BETWEEN '$desde'  AND '$hasta'
$finfo
$farea
GROUP BY $paisano , CASE SRBISD.IDINUM WHEN 0 THEN SRBCTLSD.CTNAME ELSE SRBCTLSD_1.CTNAME END
order by $paisano
";

//echo $sql; 

      
$result = odbc_exec($db2conp, $sql) ; echo odbc_errormsg();
	while($row = odbc_fetch_array($result)){
		foreach($row as $campo => $valor){
		$ti["$campo"][]= utf8_encode($valor);
		}
		
		if($sqlcuotas =='SI'){
		 $fperiodo = substr($desde,0,6);
		 $sqlQ ="SELECT
 	   			SUM(CASE WHEN IDTCUOTA = 'GENE' THEN VCUOTA ELSE 0 END )AS C_OBJETIVO
      			,SUM(CASE WHEN IDTCUOTA = 'ACCE' THEN VCUOTA ELSE 0 END )AS C_IMPOR
      			,SUM(CASE WHEN IDTCUOTA = 'MEDI' THEN VCUOTA ELSE 0 END )AS C_LABS
      			,SUM(CASE WHEN IDTCUOTA = 'EART' THEN VCUOTA ELSE 0 END )AS C_EARTHBORN
      			,SUM(CASE WHEN IDTCUOTA = 'PROP' THEN VCUOTA ELSE 0 END )AS C_PROPAC
				FROM VENDCUOTA WHERE IDPER = '$fperiodo' AND IDVEND = '$row[VENDEDOR]' GROUP BY IDPER, IDVEND
				";
		//ECHO "<BR>$sqlQ";
		$resultQ = odbc_exec($db2conp, $sqlQ) ; echo odbc_errormsg();
		while($rowQ = odbc_fetch_array($resultQ)){
			foreach($rowQ as $campo => $valor){
				$ti["$campo"][]= utf8_encode($valor);
				}	
			$ti["TOTALC"][] = $rowQ['C_OBJETIVO']+$rowQ['C_CONTADO'];
			}
		}
	//$ti["AREA"]	
	$ti["TOTALV"][] = $row['OBJETIVO']+$row['CONTADO'];
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
		, SUM(CASE WHEN IDTCUOTA = 'GENE' THEN VCUOTA ELSE 0 END) as C_OBJETIVO
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
$result = odbc_exec($db2conp, $sql) ; echo odbc_errormsg();
	while($row = odbc_fetch_array($result)){
		foreach($row as $campo => $valor){
		$ti["$campo"][]= utf8_encode($valor);
		}
	//$ti["TOTALC"][] += $row['C_OBJETIVO']+$row['C_CONTADO'];
	}	


$sql = "SELECT 
		SRBSOL.OLORNO AS NUMERO_ORDEN
		, SROORSHE.OHODAT AS FECHA_ORDEN
		, (select SRBCTLSD.CTNAME from SRBCTLSD WHERE SRBCTLSD.CTSIGN = SROORSHE.OHSALE ) as VENDEDOR
		, SRBNAM.NANSNA AS RAZON_SOCIAL
		, SUM(CASE WHEN SRBSOL.OLFOCC='Y' THEN 0 ELSE SRBSOL.OLITET END) AS TOTAL_EXC_IVA
		FROM SROORSHE SROORSHE
		LEFT JOIN SROORSPL SRBSOL ON SROORSHE.OHORNO = SRBSOL.OLORNO
		LEFT JOIN SRONAM SRBNAM ON SRBNAM.NANUM=SROORSHE.OHCUNO
		WHERE
		 OHSTAT <> 'D'
			   AND SROORSHE.OHORDT NOT IN ('R5','R6','R8','75','69','70','24','71','02','33','73','72','25','65','60','SG','SR','EG'
			                              ,'ER','66','67','76','N2','77','Z3','Z5','Z6','Z7','ZM','ZN','K9','68','SN','R7','K4','Z4')

               AND (SRBSOL.OLSTAT <> 'D')

               AND (SRBSOL.OLORDS=10) 
		  AND SROORSHE.OHODAT  BETWEEN '$desde'  AND '$hasta'
		  AND SROORSHE.OHSALE  IN ($fnom)
		GROUP BY
		  SRBSOL.OLORNO
		  ,SROORSHE.OHODAT
		  ,(select SRBCTLSD.CTNAME from SRBCTLSD WHERE SRBCTLSD.CTSIGN = SROORSHE.OHSALE )
		  ,SRBNAM.NANSNA
		ORDER BY SRBSOL.OLORNO  
		";
if($_POST['info'] == 'Ord Venta' ){		
	$result = odbc_exec($db2conp, $sql) ; echo odbc_errormsg();
		while($row = odbc_fetch_array($result)){
			foreach($row as $campo => $valor){
			$ti10["$campo"][]= utf8_encode($valor);
			}
		}	
}

	
$paisano = "VENDEDOR";

?>
