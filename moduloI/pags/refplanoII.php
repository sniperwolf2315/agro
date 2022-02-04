<? session_start();
include("../../user_con.php");

$desde = str_replace("-", "", $_POST['desde']);
$hasta = str_replace("-", "", $_POST['hasta']);

 
//error_reporting(E_PARSE);
//ini_set("display_errors", 1);

  $meses = array('0','Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
  
  $hoy = date ("Y-m-d");
  $hoy_2mes = date ("Y-m-d", strtotime("$hoy - 2 month")); 


$filtros .= " AND SRBISH.IHODAT BETWEEN '$desde' AND '$hasta' ";
//tipo de infomre
$sql = "select tipo FROM tipos WHERE doc_tipo = '$_POST[informe]' ";
$result = $mysqli->query($sql);
$coma ="";
while($row = $result->fetch_array())
	{
	$tipos .= $coma."'".$row[tipo]."'";
	$coma =",";
	}
$filtros .= " AND SRBSOH.OHORDT IN ($tipos) ";
//vendedores
$vends ='';
if($_POST[area] !=''){
	$sql = "select AREA, IDVEND from VENDCUOTA WHERE AREA = '$_POST[area]' order by IDVEND";	
	$result = $mysqli->query($sql);
	$coma ="";
	while($row = $result->fetch_array())
		{
		$vends .= $coma."'".$row[IDVEND]."'"; 
 		$coma = ",";
		}
}
if($_POST[vend] !=''){ $vends = "'". strtoupper($_POST[vend])."'"; }
if($vends != ''){ $filtros .= " AND (CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END) in($vends) "; }

if($_POST[fam] !=''){ $filtros .= " AND SRBCTLPB.PBDESC = '$_POST[fam]' ";  }

if($_POST[prov] !=''){ $var = explode(" - ",$_POST[prov]); $filtros .= " AND SRBPRG.PGPGRP = '$var[0]' ";  }
 
if($_POST[seg] !=''){ $filtros .= " AND SRBPRG.PGISET = '$_POST[seg]' ";  }

if($_POST['gru'] != ''){ $var = explode(" - ",$_POST[gru]); $filtros .=" AND PGIS01 = '$var[0]' ";} 
if($_POST['cat'] != ''){ $var = explode(" - ",$_POST[cat]); $filtros .=" AND PGIS02 = '$var[0]' ";} 
if($_POST['subcat'] != ''){$var = explode(" - ",$_POST[subcat]); $filtros .=" AND PGIS03 = '$var[0]' ";} 
if($_POST['pac'] != ''){
	$var = explode(" - ",$_POST[pac]);
	if(count($var) > 1){
		$filtros .=" AND PGIS04 = '$var[0]' ";
		}else{
		$var[0] = strtoupper($var[0]);
		$filtros .=" AND UPPER((SELECT IVSGVD AS NOMBRE FROM SROCTLIV WHERE IVISNO = '4' AND IVSGVA = PGIS04 )) LIKE '%$var[0]%' ";
		}
	} 
if($_POST[socio] !=''){ $filtros .= " AND SRBISD.IDCUNO = '$_POST[socio]' ";  }

//cats 1 a 6
for($i = 1; $i <= 6; $i++){
if($_POST["cat$i"] != ''){ $var = explode(" - ",$_POST["cat$i"]); $filtros .=" AND PGPCA".$i." = '$var[0]' ";} 
}
		
		  $sql = " 
		  	SELECT DISTINCT
           '' AS AREA
           ,SRBSOH.OHORDT AS TIPO
           ,SRBISH.IHINVN AS FACTURA
           ,SRBISH.IHIDAT AS FECHA_FACTURA
           ,CASE WHEN SUBSTRING(SRBISH.IHODAT,7,2)>='16'
            	THEN
            	  CASE WHEN SUBSTRING(SRBISH.IHODAT,5,2)='12'
            	  THEN
            	    1
            	  ELSE 
            	    SUBSTRING(SRBISH.IHODAT,5,2) + 1
            	  END
            	ELSE
            	   SUBSTRING(SRBISH.IHODAT,5,2) + 0
            	END
            AS MES_CORTE
           ,CASE WHEN SUBSTRING(SRBISH.IHODAT,5,2)='12' AND SUBSTRING(SRBISH.IHODAT,7,2)>='16'
            	    THEN
            	      SUBSTRING(SRBISH.IHODAT,1,4) + 1
            	    ELSE
            	      SUBSTRING(SRBISH.IHODAT,1,4) + 0
            	    END
            AS AO_CORTE 	    
           ,SRBISH.IHORNO AS NUMERO_ORDEN
           ,SRBISH.IHODAT AS FECHA_ORDEN
           ,SRBISD.IDCUNO AS CLIENTE
           ,NAARHA AS VENDEDOR_IBS
           ,Z3BCTLDN.Z3DNCODRUT AS RUTA
           ,DNDNAM AS DEPARTAMENTO
           ,DNMNAM AS MUNICIPIO
           ,CTNCT4 AS EST_CARTERA
           ,'' AS LIMITE_CREDITO
           ,'' AS USO_CREDITO
           ,SRBNAM.NANAME AS NOMBRE
           ,SRBISD.IDSROM AS BODEGA
           ,CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END AS VENDEDOR
           ,CASE SRBISD.IDINUM WHEN 0 THEN SRBCTLSD.CTNAME ELSE SRBCTLSD_1.CTNAME END AS DES_VENDE
           ,CASE SRBISD.IDINUM WHEN 0 THEN SRBSOH.OHHAND ELSE SRBSOH_1.OHHAND END AS CALL
           ,CASE SRBISD.IDINUM WHEN 0 THEN SRBCTLSD.CTSMAN ELSE SRBCTLSD_1.CTSMAN END AS MANEJADOR
           ,SRBISD.IDOLIN AS LINEA_ORDEN
           ,SRBPRG.PGPRDC AS CODIGO
           ,SRBPRG.PGDESC AS DESCRIPCION
           ,SRBISD.IDFOCC AS FOC
           ,SRBPRG.PGPGRP AS GRUPO
           ,SRBPRG.PGISET AS SEGMENTA
           ,SRBCTLPB.PBDESC AS FAMILIA
           ,CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END AS CANTIDAD
           ,SRBISD.IDUNIT AS UNIDAD
           ,CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END AS VLR_EXC_IVA
           ,CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDITT ELSE SRBISD.IDITT*-1 END AS VLR_IVA
           ,CASE SRBISD.IDTYPP WHEN 1 THEN (SRBISD.IDNSVA + SRBISD.IDITT) ELSE ((SRBISD.IDNSVA + SRBISD.IDITT)*-1) END AS VLR_INC_IVA
           ,(CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END)*SRBPRG.PGLPCO AS COSTO_ULTIMO
           ,SRBSOL.OLCOSP AS COSTO_TRANSACCION
           , '' AS VLR_FACTURA
			, '' AS SALDO
			, '' AS DIAS_CARTERA
			, '' AS VLR_RECAUDO
			, '' AS FECHA_RECAUDO
			, '' AS DIAS_RECUDO
, (SELECT IVSGVD AS NOMBRE FROM SROCTLIV WHERE IVISNO = '4' AND IVSGVA = PGIS04 ) AS PR_ACTIVO
            FROM SROISH SRBISH

            LEFT JOIN SROISDPL SRBISD ON SRBISH.IHINVN = SRBISD.IDINVN AND SRBISH.IHORNO = SRBISD.IDORNO

            LEFT JOIN SROORSPL SRBSOL ON SRBISD.IDOLIN = SRBSOL.OLLINE AND SRBISD.IDORNO = SRBSOL.OLORNO

            LEFT JOIN SROPRG SRBPRG ON SRBISD.IDPRDC = SRBPRG.PGPRDC

            LEFT JOIN SROHNH SROHNH ON SRBISD.IDINUM = SROHNH.IHINUM

            LEFT JOIN SROISH SRBISH_1 ON SROHNH.IHRFNR = SRBISH_1.IHINVN AND SROHNH.IHCUNO = SRBISH_1.IHCUNO

            LEFT JOIN SROORSHE SRBSOH_1 ON SRBISH_1.IHORNO = SRBSOH_1.OHORNO

            LEFT JOIN SROORSHE SRBSOH ON SRBISH.IHORNO = SRBSOH.OHORNO

            LEFT JOIN SROCTLPB SRBCTLPB ON SRBPRG.PGPRFA = SRBCTLPB.PBPRFA

            LEFT JOIN SROCTLSD SRBCTLSD ON SRBISH.IHSALE = SRBCTLSD.CTSIGN

            LEFT JOIN SROCTLSD SRBCTLSD_1 ON SRBISH_1.IHSALE = SRBCTLSD_1.CTSIGN

            LEFT JOIN SRONAM SRBNAM ON SRBISD.IDCUNO = SRBNAM.NANUM
            
            LEFT JOIN SROCTLC4 ON CTNCA4 = NANCA4 
            LEFT JOIN Z3ONAM ON SRBNAM.NANUM = Z3ONAM.Z3NANUM 
            LEFT JOIN COOCTLDN ON Z3NAMCOD = DNMCOD
            
			LEFT JOIN Z3OCTLDN Z3BCTLDN ON Z3BCTLDN.Z3DNMCOD=Z3ONAM.Z3NAMCOD
			
				LEFT JOIN SROCTLP1 SRBCTLP1 ON SRBPRG.PGPCA1 = SRBCTLP1.CTPCA1
				LEFT JOIN SROCTLP2 SRBCTLP2 ON SRBPRG.PGPCA2 = SRBCTLP2.CTPCA2
				LEFT JOIN SROCTLP3 SRBCTLP3 ON SRBPRG.PGPCA3 = SRBCTLP3.CTPCA3
				LEFT JOIN SROCTLP4 SRBCTLP4 ON SRBPRG.PGPCA4 = SRBCTLP4.CTPCA4
				LEFT JOIN SROCTLP5 SRBCTLP5 ON SRBPRG.PGPCA5 = SRBCTLP5.CTPCA5
				LEFT JOIN SROCTLP6 SRBCTLP6 ON SRBPRG.PGPCA6 = SRBCTLP6.CTPCA6

            WHERE ((CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END )<> 0)

            $filtros
 			"; 
	      //echo "$sql"; die;
	      $call = array('CADMASCOT2', 'CADMASCOTA', 'CAMACHOM', 'CIFUENTESD', 'INTEGRATOR', 'MATERONN', 'MERQUEO', 'NETSTORE', 'SILVAJ', 'TRANSFER1'
	      	            , 'TRANSFER2', 'TRANSFER3', 'TRANSFER4', 'VEND186', 'VEND272', 'VEND283', 'VEND293', 'VEND299', 'VEND300', 'VEND305', 'VEND306'
	      	            , 'VEND307', 'VEND308', 'VEND309', 'VEND315', 'VEND318', 'VEND319', 'VEND320', 'VEND321', 'VEND326', 'VEND328', 'VEND330'
	      	            , 'VEND331', 'VEND332', 'VEND339', 'VEND340', 'VEND341', 'VEND342', 'VEND343', 'VEND344', 'VEND350', 'VEND352', 'VEND354'
	      	            , 'VEND356', 'VEND360', 'VEND364', 'VEND366', 'VEND371', 'VEND372', 'VEND373', 'VEND374', 'VEND375', 'VEND376', 'VEND377'
	      	            , 'VEND378', 'VEND383', 'VEND384', 'VEND385', 'VEND386', 'VEND388', 'VEND389', 'VEND390', 'VEND391', 'VEND393', 'VEND394'
	      	            , 'VEND395', 'VEND396', 'VEND397', 'VEND398', 'VEND399', 'VEND400', 'VEND401', 'VEND402', 'VEND403', 'VEND407', 'VEND409'
	      	            , 'VEND410', 'VEND411', 'VEND412', 'VEND413', 'VEND414', 'VEND419', 'VEND421', 'VEND422', 'VEND423', 'VEND424', 'VEND428'
	      	            , 'VEND429', 'VEND430', 'VEND431', 'VEND432', 'VEND433', 'VEND434', 'VEND435', 'VEND436', 'VEND437', 'VEND438', 'VEND439'
	      	            , 'VEND440', 'VEND443', 'VEND444', 'VEND446', 'VEND447', 'VEND448', 'VEND449', 'VEND450', 'VEND451', 'VEND452', 'VEND453'
	      	            , 'VEND454', 'VEND455', 'VEND456', 'VEND457', 'VEND458', 'VEND459', 'VEND460', 'VEND465', 'VEND466', 'VEND468', 'VEND469'
	      	            , 'VEND470', 'VEND471', 'VEND472', 'VEND473', 'VEND475', 'VEND480', 'VEND481', 'VEND482', 'VEND483', 'VEND484', 'VEND485'
	      	            , 'VEND486', 'VEND488', 'VENDLINIO', 'TRANSFER11', 'VEND500', 'VEND501', 'VEND502', 'VEND503');
	      $vtaext = array('VEND039', 'VEND040', 'VEND045', 'VEND078', 'VEND081', 'VEND114', 'VEND165', 'VEND183', 'VEND214', 'VEND252', 'VEND260'
	      				, 'VEND310', 'VEND313', 'VEND314', 'VEND334', 'VEND338', 'VEND079', 'VENDOTC');	            
	      
	      $primero = true;
	      $result = odbc_exec($db2con, $sql) OR die ("<BR>ERROR query<BR>$sql<br> ".odbc_errormsg());
	      while($row = odbc_fetch_array($result))
	      { 
	        //encabezados
			if($primero == true){
			$primero = false;
			foreach($row as $titulo => $valor){
				$csv_output .=''.$titulo.';';
				}
			$csv_output .="\n"; 
			}	        
  			//valores
  			$row['VENDEDOR'] = trim($row['VENDEDOR']);
            $row['CALL'] = trim($row['CALL']);
	      	if( $row['VENDEDOR'] == 'VENDWEB' 
                OR $row['CALL'] == 'VENDWEB'){
                $row['AREA'] = 'PAGINA';
                }
  				elseif( $row['VENDEDOR'] == 'VEND157' OR $row['VENDEDOR'] =='VEND217' OR $row['CLIENTE'] == '800159998' ){
  					$row['AREA'] = 'INSTITUCIONAL';
  				}elseif($row['CLIENTE'] == '900423563'){
  					$row['AREA'] = 'PESTAR';
  				}elseif(in_array($row['CALL'],$call)){
  					$row['AREA'] = 'CALL';
  				}elseif(in_array($row['VENDEDOR'],$vtaext)){
  					$row['AREA'] = 'VENTA EXTERNA';
  				}else{
  					$row['AREA'] = 'ALMACÉN';
  				}		
	      	
	      	foreach($row as $valor){
	      		if(is_numeric($valor)){
	      		$valor = number_format($valor,0,"","");
	      		}
	      	$csv_output .=''.trim($valor).';';
	      	}
	      	$csv_output .="\n";
	      }  
	

$filename = "base_".$_POST[desde]."_A_".$_POST[hasta];
header("Content-Type: application/force-download");
header("Content-disposition: csv" .$filename. ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $csv_output;
exit;
?>
  
