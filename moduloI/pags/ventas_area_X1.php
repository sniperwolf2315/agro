<? //$areas = array('Ganaderia','Mascotas');
   $areas = array('Ganaderia');
   $labs = array('COASPHARMA' => array()
                ,'TECNOCALIDAD' => array()
				,'COMERVET' => array()
				,'MICROSULES' => array()
				,'QUALIVET' => array()
			);
   
   //$cuotasAD = array('C_EARTHBORN','C_PROPAC','C_FCHOICE'); 
  $cuotasAD = array();
  
  $tipoExcluidosEspectro ="'07','17','03','13','19','Z3','Z4','Z5','Z6','Z7','ZN','62','63','67','68','72','25','93','K4','ZB','KB','ZM'";
  //$tipoExcluidosVentas ="'07','17','03','13','19','Z3','Z4','Z5','Z6','Z7','ZN','67','68','72','25','93','K4','ZM'";
  //20220222. Carlos Castelblanco. Luego de revisar con Juan Felipe se elimina de la variable $tipoExcluidosVentas el valor 'ZM' :
  $tipoExcluidosVentas ="'07','17','03','13','19','Z3','Z4','Z5','Z6','Z7','ZN','67','68','72','25','93','K4'";
  
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
           ,'VENPEST011','VENPEST012','VENPEST013','VENPEST016','VENPEST021'";
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

if($_POST['vendedor'] != '' ){$fnom = "'".$_POST['vendedor']."'";

// MIENTRAS 010 VENDE EN 007
// if($_POST['vendedor'] =='VENPEST010'){ $fnom = "'VENPEST007','VENPEST010'" ;}

}

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

/* query con el error en las notas credito
$sql ="SELECT 
 CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END AS VENDEDOR
,CASE SRBISD.IDINUM WHEN 0 THEN SRBCTLSD.CTNAME ELSE SRBCTLSD_1.CTNAME END  AS NOMBRE_VEND
,SUM(CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END)  AS OBJETIVO
,SUM(CASE when SRBPRG.PGPGRP IN('MIC','CMV','CPH','TEC','QUA') THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as LABORATORIOS
,SUM(CASE when SRBPRG.PGPGRP ='971' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as PROPAC
,SUM(CASE when SRBPRG.PGPGRP ='972' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as EARTHBORN
,SUM(CASE when SRBPRG.PGPGRP ='965' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as FCHOICE
,SUM(CASE when SRBPRG.PGPGRP NOT IN ('965','971','972','MIC','CMV','CPH','TEC','QUA') THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as IMPORTADOS

,SUM(CASE when SRBPRG.PGPGRP = 'MIC' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as MICROSULES
,SUM(CASE when SRBPRG.PGPGRP = 'CMV' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as COMERVET
,SUM(CASE when SRBPRG.PGPGRP = 'CPH' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as COASPHARMA
,SUM(CASE when SRBPRG.PGPGRP = 'TEC' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as TECNOCALIDAD
,SUM(CASE when SRBPRG.PGPGRP = 'QUA' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as QUALIVET
,sum( (CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END)*
        CASE WHEN substr(SRBPRG.PGDESC,1,6) ='WHISKY'
          THEN 54728
          ELSE
            CASE WHEN substr(SRBPRG.PGDESC,1,6) ='BOTELL'
            THEN 44271
            ELSE
              CASE WHEN substr(SRBPRG.PGDESC,1,16) ='TELEVISOR LED 40'
              THEN 830000
              ELSE
              	CASE WHEN substr(SRBPRG.PGDESC,1,16) ='BOLIGRAFO LATINA'
                THEN 998
                ELSE
              	  CASE WHEN substr(SRBPRG.PGDESC,1,12) ='GORRA TRUKER'
                  THEN 7973
                  ELSE
              	  SRBSOL.OLCOSP
                  END
                END
              END
            END
          END
          
       * CASE WHEN substr(SRBPRG.PGDESC,1,3) ='KIT' OR substr(SRBPRG.PGDESC,1,7) ='MAXIKIT' THEN 0 ELSE 1 END   ) AS COSTO_ULTIMO                   	
FROM SROISH SRBISH
	full outer JOIN SROCTLSD SRBCTLSD ON SRBISH.IHSALE = SRBCTLSD.CTSIGN
	LEFT JOIN SROISDPL SRBISD ON SRBISH.IHINVN = SRBISD.IDINVN AND SRBISH.IHORNO = SRBISD.IDORNO
	
	LEFT JOIN SROORSPL SRBSOL ON SRBISD.IDOLIN = SRBSOL.OLLINE AND SRBISD.IDORNO = SRBSOL.OLORNO
	
	LEFT JOIN SROPRG SRBPRG ON SRBISD.IDPRDC = SRBPRG.PGPRDC
	LEFT JOIN SROORSHE SRBSOH ON SRBISH.IHORNO = SRBSOH.OHORNO
	
	LEFT JOIN SROHNH SROHNH ON SRBISD.IDINUM = SROHNH.IHINUM
	LEFT JOIN SROISH SRBISH_1 ON SROHNH.IHRFNR = SRBISH_1.IHINVN AND SROHNH.IHCUNO = SRBISH_1.IHCUNO
	LEFT JOIN SROCTLSD SRBCTLSD_1 ON SRBISH_1.IHSALE = SRBCTLSD_1.CTSIGN

WHERE 
	((CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END )<> 0)
	AND (SRBSOH.OHORDT NOT IN ($tipoExcluidosVentas))
and SRBISH.IHIDAT BETWEEN '$desde'  AND '$hasta'
$finfo
$farea
GROUP BY $paisano , CASE SRBISD.IDINUM WHEN 0 THEN SRBCTLSD.CTNAME ELSE SRBCTLSD_1.CTNAME END
order by $paisano
";

*/

//query con la correccion para las notas credito
/*
se cambia 
CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE
por SRBISH.IHSALE en as vendedor , group by y where
y CASE SRBISD.IDINUM WHEN 0 THEN SRBCTLSD.CTNAME ELSE SRBCTLSD_1.CTNAME END
por SRBCTLSD.CTNAME en as NOMBRE_VEND Y GROUP BY
*/
$sql ="SELECT 
 SRBISH.IHSALE AS VENDEDOR
,SRBCTLSD.CTNAME AS NOMBRE_VEND
,SUM(CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END)  AS OBJETIVO
,SUM(CASE when SRBPRG.PGPGRP IN('MIC','CMV','CPH','TEC','QUA') THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as LABORATORIOS
,SUM(CASE when SRBPRG.PGPGRP ='971' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as PROPAC
,SUM(CASE when SRBPRG.PGPGRP ='972' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as EARTHBORN
,SUM(CASE when SRBPRG.PGPGRP ='965' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as FCHOICE
,SUM(CASE when SRBPRG.PGPGRP NOT IN ('965','971','972','MIC','CMV','CPH','TEC','QUA') THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as IMPORTADOS

,SUM(CASE when SRBPRG.PGPGRP = 'MIC' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as MICROSULES
,SUM(CASE when SRBPRG.PGPGRP = 'CMV' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as COMERVET
,SUM(CASE when SRBPRG.PGPGRP = 'CPH' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as COASPHARMA
,SUM(CASE when SRBPRG.PGPGRP = 'TEC' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as TECNOCALIDAD
,SUM(CASE when SRBPRG.PGPGRP = 'QUA' THEN CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END End ) as QUALIVET
,sum( (CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END)*
        CASE WHEN substr(SRBPRG.PGDESC,1,6) ='WHISKY'
          THEN 54728
          ELSE
            CASE WHEN substr(SRBPRG.PGDESC,1,6) ='BOTELL'
            THEN 44271
            ELSE
              CASE WHEN substr(SRBPRG.PGDESC,1,16) ='TELEVISOR LED 40'
              THEN 830000
              ELSE
              	CASE WHEN substr(SRBPRG.PGDESC,1,16) ='BOLIGRAFO LATINA'
                THEN 998
                ELSE
              	  CASE WHEN substr(SRBPRG.PGDESC,1,12) ='GORRA TRUKER'
                  THEN 7973
                  ELSE
              	  SRBSOL.OLCOSP
                  END
                END
              END
            END
          END
          
       * CASE WHEN substr(SRBPRG.PGDESC,1,3) ='KIT' OR substr(SRBPRG.PGDESC,1,7) ='MAXIKIT' THEN 0 ELSE 1 END   ) AS COSTO_ULTIMO                   	
FROM SROISH SRBISH
	full outer JOIN SROCTLSD SRBCTLSD ON SRBISH.IHSALE = SRBCTLSD.CTSIGN
	LEFT JOIN SROISDPL SRBISD ON SRBISH.IHINVN = SRBISD.IDINVN AND SRBISH.IHORNO = SRBISD.IDORNO
	
	LEFT JOIN SROORSPL SRBSOL ON SRBISD.IDOLIN = SRBSOL.OLLINE AND SRBISD.IDORNO = SRBSOL.OLORNO
	
	LEFT JOIN SROPRG SRBPRG ON SRBISD.IDPRDC = SRBPRG.PGPRDC
	LEFT JOIN SROORSHE SRBSOH ON SRBISH.IHORNO = SRBSOH.OHORNO
	
	LEFT JOIN SROHNH SROHNH ON SRBISD.IDINUM = SROHNH.IHINUM
	LEFT JOIN SROISH SRBISH_1 ON SROHNH.IHRFNR = SRBISH_1.IHINVN AND SROHNH.IHCUNO = SRBISH_1.IHCUNO
	LEFT JOIN SROCTLSD SRBCTLSD_1 ON SRBISH_1.IHSALE = SRBCTLSD_1.CTSIGN

WHERE 
	((CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END )<> 0)
	AND (SRBSOH.OHORDT NOT IN ($tipoExcluidosVentas))
and SRBISH.IHIDAT BETWEEN '$desde'  AND '$hasta'
$finfo
AND SRBISH.IHSALE IN ($fnom)
GROUP BY SRBISH.IHSALE , SRBCTLSD.CTNAME
order by SRBISH.IHSALE
";
//echo $sql; 




$cont = 0;      
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
      			,SUM(CASE WHEN IDTCUOTA = 'FCHO' THEN VCUOTA ELSE 0 END )AS C_FCHOICE
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
		, SUM(CASE WHEN IDTCUOTA = 'GENE' THEN VCUOTA ELSE 0 END) as C_OBJETIVO
		, SUM(CASE WHEN IDTCUOTA = 'ACCE' THEN VCUOTA ELSE 0 END) as C_IMPOR
		, SUM(CASE WHEN IDTCUOTA = 'MEDI' THEN VCUOTA ELSE 0 END) as C_LABS
		, SUM(CASE WHEN IDTCUOTA = 'EART' THEN VCUOTA ELSE 0 END) as C_EARTHBORN
		, SUM(CASE WHEN IDTCUOTA = 'PROP' THEN VCUOTA ELSE 0 END) as C_PROPAC
		, SUM(CASE WHEN IDTCUOTA = 'FCHO' THEN VCUOTA ELSE 0 END) as C_FCHOICE
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

// OV estado 10
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
			   AND SROORSHE.OHORDT NOT IN ($tipoExcluidosVentas)

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
		while($row = odbc_fetch_array($result)){
			foreach($row as $campo => $valor){
			$ti10["$campo"][]= utf8_encode($valor);
			}
		}	
}

//VENTAS *CLIENTE y PROD 
	//no cuando esta filtro cleinte seleccionado
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
	AND (SRBSOH.OHORDT NOT IN ($tipoExcluidosVentas))
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
  $result = odbc_exec($db2conp, $sql) ; //echo "........".odbc_errormsg();
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
if($_POST['queVer'] == 'CARTERA' ){	 
  $result = odbc_exec($db2conp, $sql) ;
  }else{ $result = '';} 
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

// espectros
    if(substr($_POST['hasta'],8,2) < 21 ){
    	$desdePE = date("Ym21",strtotime("$_POST[hasta] - 1 month"));
    	$desdeTR = date("Ym21",strtotime("$_POST[hasta] - 3 month"));
    	$hastaTR = date("Ym20",strtotime("$_POST[hasta] - 1 month"));
    	}else{
    	$desdePE = date("Ym21",strtotime("$_POST[hasta]"));
    	$desdeTR = date("Ym21",strtotime("$_POST[hasta] - 2 month"));
    	$hastaTR = date("Ym20",strtotime("$_POST[hasta]"));
    	}

if($_POST['productoESP'] != ''){
	$campoESP = "CASE SRBISD.IDINUM WHEN 0 THEN SRBCTLSD.CTNAME ELSE SRBCTLSD_1.CTNAME END";
	$fprodESP = " AND SROPCR.PCEDES = '".utf8_decode($_POST[productoESP])."' ";
	}else{
	$campoESP = "SROPCR.PCEDES";
	}

$sql = "SELECT DISTINCT
            $campoESP AS PADRE,
            SUM(
            		CASE WHEN SRBISH.IHIDAT BETWEEN '$desdeTR' AND '$hasta'
            		THEN
            		    CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END
            		END
            		) AS TRI,
            SUM(
            		CASE WHEN SRBISH.IHIDAT BETWEEN '$desdePE' AND '$hasta'
            		THEN
            		    CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END
            		END
            		) AS UN_PER		

            FROM SROISH SRBISH

            LEFT JOIN SROISDPL SRBISD ON SRBISH.IHINVN = SRBISD.IDINVN AND SRBISH.IHORNO = SRBISD.IDORNO
            LEFT JOIN SROHNH SROHNH ON SRBISD.IDINUM = SROHNH.IHINUM
            LEFT JOIN SROISH SRBISH_1 ON SROHNH.IHRFNR = SRBISH_1.IHINVN AND SROHNH.IHCUNO = SRBISH_1.IHCUNO
            LEFT JOIN SROCTLSD SRBCTLSD ON SRBISH.IHSALE = SRBCTLSD.CTSIGN
            LEFT JOIN SROCTLSD SRBCTLSD_1 ON SRBISH_1.IHSALE = SRBCTLSD_1.CTSIGN
            FULL JOIN SROPCR ON SROPCR.PCIPRC = SRBISD.IDPRDC   

            WHERE (((CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END )<> 0)

            AND (SRBISD.IDORDT NOT IN ($tipoExcluidosEspectro))
            AND SROPCR.PCXRTY = 'GE'
            AND SRBISD.IDPGRP ='CPH '
            $farea
            $fprodESP
            AND (SRBISH.IHIDAT>='$desdeTR') AND (SRBISH.IHIDAT<='$hasta'))
            
            GROUP BY 
            $campoESP
            ";
//echo $sql;
if($_POST['queVer'] == 'ESPECTROS' ){            
  $result = odbc_exec($db2conp, $sql) ; //echo odbc_errormsg();
  }else{ $result = '';}
	while($row = odbc_fetch_array($result)){
	$desc = utf8_encode($row["PADRE"]);
	$tiESP["$desc"]["TRI"] = $row["TRI"];
	$tiESP["$desc"]["UN_PER"] = $row["UN_PER"];
	}
	ksort($tiESP);
	
$paisano = "VENDEDOR";

?>
