<? include("../../user_con.php");
  include("../../user_user.php");
if($_SESSION["usuARio"] != 'OYUELAL'){
//echo "<br>La facturacion de contingencia no esta habilitada "; die;
}
 if($_SESSION["clAVe"] == ''){ECHO "<BR><BR> Registrese de nuevo aqui<a href='../../index.php'></a>"; DIE;}
// error_reporting(1);
// ini_set('error_reporting', E_ALL);
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Untitled Web Page</title>
<meta name="generator" content="Antenna 3.0">
<meta http-equiv="imagetoolbar" content="no">
<link rel="stylesheet" type="text/css" href="../../antenna.css" id="css" media="all">
<script type="text/javascript" src="../../antenna/auto.js"></script>
<style type="text/css" media="print">
.nover {display:none}
</style>

<style type="text/css" >
td{
 border-radius:0px;
}
.lineAr{border-top-style:solid; border-top-width:1}
.lineAb{border-bottom-style:solid; border-bottom-width:1}
.frxxs { font-family:Arial; color:#000000; font-size:6pt; direction:ltr; }
.frxs { font-family:Arial; color:#000000; font-size:8.5pt; direction:ltr; }
.frs { font-family:Arial; color:#000000; font-size:8pt; direction:ltr; }
.frm { font-family:Arial; color:#000000; font-size:10pt; direction:ltr; }
.frl { font-family:Arial; color:#000000; font-size:12pt; direction:ltr; }
.frxl { font-family:Arial; color:#000000; font-size:14pt; direction:ltr; }
.frxxl { font-family:Arial; color:#000000; font-size:19pt; direction:ltr; }
</style>

<style type="text/css" media="print">
@page{
   size: 7.9cm auto portrait;	
   margin: 0;
}
header, footer, nav, aside {
  display: none;
}
</style>


</head>
<?  
    $ancho = '7.1cm';
    
    $hoyIBS = date("Ymd");


	//registros por pag paginador
	$regsxpag = 50;
	
	if($_POST['paginador'] ==''){ $_POST['paginador'] = "1-$regsxpag"; }
	$limit = explode("-",$_POST['paginador']);
	$limit[0] = $limit[0]-1;
	$flimit = " LIMIT $limit[0],$limit[1] ";	


//consulta de factura
if($_POST['fac']){
    $sql ="SELECT DISTINCT
			CONCAT( SRBSOH.OHORDT, SRBISH.IHINVN )  AS FACTURA,
            SRBSOH.OHORDT AS TIPO,
            '' AS AREA,
            SUBSTR(SRBISH.IHIDAT,1,4)||'/'||SUBSTR(SRBISH.IHIDAT,5,2)||'/'||SUBSTR(SRBISH.IHIDAT,7,2) AS FECHA_FACTURA,
            SRBISH.IHORNO AS NUMERO_ORDEN,
            SUBSTR(SRBISH.IHODAT,1,4)||'/'||SUBSTR(SRBISH.IHODAT,5,2)||'/'||SUBSTR(SRBISH.IHODAT,7,2) AS FECHA_ORDEN,
            SRBISD.IDCUNO AS NIT,
            SRBNAM.NAADR2 AS DIRECCION,
            SRBNAM.NANSNO AS TELEFONO,
            SRBNAM.NANAME AS RAZON_SOCIAL,
            DNMNAM AS MUNICIPIO,
            SRBISD.IDSROM AS BODEGA,
            CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END AS VENDEDOR,
            CASE SRBISD.IDINUM WHEN 0 THEN SRBCTLSD.CTNAME ELSE SRBCTLSD_1.CTNAME END AS DES_VENDE,
            CASE SRBISD.IDINUM WHEN 0 THEN SRBSOH.OHHAND ELSE SRBSOH_1.OHHAND END AS CALL,
            CASE SRBISD.IDINUM WHEN 0 THEN SRBCTLSD.CTSMAN ELSE SRBCTLSD_1.CTSMAN END AS MANEJADOR,
            CASE SRBISD.IDTYPP WHEN 1 THEN SRBISH.IHIAET ELSE SRBISH.IHIAET*-1 END AS VLRT_EXC_IVA,
            CASE SRBISD.IDTYPP WHEN 1 THEN SRBISH.IHITTA ELSE SRBISH.IHITTA*-1 END AS VLRT_IVA,
            CASE SRBISD.IDTYPP WHEN 1 THEN (SRBISH.IHIAIT) ELSE (SRBISH.IHIAIT)*-1 END AS VLRT_INC_IVA,
            ( SELECT SUBSTRING(CMUFA1,3,1)  FROM SROCMA WHERE CMCUNO = SRBISD.IDCUNO) AS AUTO_RETENEDOR,
            SRBISA.IAAMOU AS VLR_FLETE
          , CONCAT(SRBISD.IDOLIN,CONCAT( SRBSOH.OHORDT, SRBISH.IHINVN ))                          
          , SRBISD.IDOLIN AS LINEA_ORDEN
          , SRBPRG.PGPRDC AS CODIGO
          , SRBPRG.PGDESC AS DESCRIPCION
          , CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END AS CANTIDAD
          
          ,CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDSALP ELSE  SRBISD.IDSALP*-1 END AS PRECIO_PUBLICO
          ,CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDNPRC ELSE  SRBISD.IDNPRC *-1 END AS VLR_EXC_IVA_UN
          ,CASE  SRBISD.IDTYPP WHEN 1 THEN (1-(SRBISD.IDNPRC/SRBISD.IDSALP))*100 ELSE 0 END AS POR_DTO
          
          , CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDITT ELSE SRBISD.IDITT*-1 END AS VLR_IVA
          , CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END AS VLR_EXC_IVA  
          , SRBCTLSQ.SQSETD AS SEGMENTO
          , CASE WHEN SRBEAN.PJEANP IS NULL THEN '-' ELSE SRBEAN.PJEANP END AS EAN  
		  , (select trim(ctstx1)||'<br>'||trim(ctstx2) from cooctld2 left join sroctldd ON cttxno = cztxre where czotyp ='".substr($_POST[fac],0,2)."') as RES
		  FROM SROISH SRBISH

            LEFT JOIN SROISDPL SRBISD ON SRBISH.IHINVN = SRBISD.IDINVN AND SRBISH.IHORNO = SRBISD.IDORNO
            LEFT JOIN SROPRG SRBPRG ON SRBISD.IDPRDC = SRBPRG.PGPRDC
            LEFT JOIN SROEAN SRBEAN ON SRBPRG.PGPRDC= SRBEAN.PJPRDC AND PJOUTB ='Y'
            LEFT JOIN SROHNH SROHNH ON SRBISD.IDINUM = SROHNH.IHINUM
            LEFT JOIN SROISH SRBISH_1 ON SROHNH.IHRFNR = SRBISH_1.IHINVN AND SROHNH.IHCUNO = SRBISH_1.IHCUNO
            LEFT JOIN SROORSHE SRBSOH_1 ON SRBISH_1.IHORNO = SRBSOH_1.OHORNO
            LEFT JOIN SROORSHE SRBSOH ON SRBISH.IHORNO = SRBSOH.OHORNO
            LEFT JOIN SROCTLSD SRBCTLSD ON SRBISH.IHSALE = SRBCTLSD.CTSIGN
            LEFT JOIN SROCTLSD SRBCTLSD_1 ON SRBISH_1.IHSALE = SRBCTLSD_1.CTSIGN
            LEFT JOIN SRONAM SRBNAM ON SRBISD.IDCUNO = SRBNAM.NANUM
            LEFT JOIN SROCTLC4 ON CTNCA4 = NANCA4 
            LEFT JOIN Z3ONAM ON SRBNAM.NANUM = Z3ONAM.Z3NANUM 
            LEFT JOIN COOCTLDN ON Z3NAMCOD = DNMCOD
            LEFT JOIN SROISA SRBISA ON SRBISH.IHORNO = SRBISA.IAORNO AND SRBISH.IHINVN = SRBISA.IAINVN AND IACODE = 21
            LEFT JOIN SROCTLSQ SRBCTLSQ ON SRBPRG.PGISET= SRBCTLSQ.SQISET
            WHERE (((CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END )<> 0)
            AND (SRBSOH.OHORDT NOT IN ('03','13','19','Z3','Z4','Z5','Z6','Z7','ZN','67','68','72','25','93','K4'))
            AND SRBISH.IHINVN = '".substr($_POST[fac],2,20)."'
            AND SRBSOH.OHORDT = '".substr($_POST[fac],0,2)."'
            )
            ORDER BY SRBISD.IDOLIN
            ";
//echo $sql;            
$result = odbc_exec($db2conp, $sql);
	while($row = odbc_fetch_array($result)){
		foreach($row as $campo => $valor){
		$ti["$campo"][]= utf8_encode($valor);
		}
	  $iva = number_format($row['VLR_IVA']/$row['VLR_EXC_IVA']*100,0);
	  if($iva > 0){
	    $ti['IVA']["$iva"] += $row['VLR_IVA'] ;
	    $ti['BASE']["$iva"] += $row['VLR_EXC_IVA'] ;
	  }  	
	$autoprint = 'onload="javascript:window.print()"';	
	if($row['SEGMENTO']==''){
	$seg = "OTROS";
	}else{$seg =  $row['SEGMENTO'];}	
	$valorSEG["$seg"] += $row['VLR_EXC_IVA'];
	}
} //FINIF
//print_r($valorSEG);		

//lista ultimas 5 facturas
if($_POST[vendedor] != ''){
  $flist =" AND IHSALE ='$_POST[vendedor]' ";
  }else{
  $flist =" AND IHSALE IN($vendrappi) ";
  }

$sql = "SELECT
        SRBSOH.OHORDT AS TIPO
        ,SRBISH.IHINVN AS FACTURA
        ,SRBISH.IHIAIT AS VALOR
        ,SRBISH.IHNSNA AS CLIENTE
        ,SRBISH.IHIDAT AS FECHA
        ,SRBISH.*
        FROM SROISH SRBISH
        LEFT JOIN AGR620CFAG.SROORSHE SRBSOH ON SRBISH.IHORNO = SRBSOH.OHORNO
        WHERE 
        SRBISH.IHIDAT = '$hoyIBS'
        AND SRBISH.IHTYPP = '1'
        $flist
        ORDER BY SRBISH.IHIDAT, SRBISH.IHINVN DESC ";
$result = odbc_exec($db2conp, $sql);
	while($row = odbc_fetch_array($result)){
		foreach($row as $campo => $valor){
		$list["$campo"][]= utf8_encode($valor);
		}
	}		
?>
<body class="global" <?= $autoprint?> >
<form id="movse1" action="cont_tira.php" method="post" name="submit button1">

<table class="frs" align="center" width="100%" border="0" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0"> 
<tr>
<td class="nover" width="25%"></td>
<td valign="top" style="width:<?= $ancho?> ; background-color:white;  border-color:white;">
<center>
<?
if($_POST['fac'] ==''){
	echo "<br><br><br><br><br><br><br><br><br>
    <a style='color:OLIVE; font-size:20; font-weight:bolder;'>ESCANEE O DIGITE EL NUMERO DE PEDIDO =></a>
	 ";
}elseif($_POST['fac'] !='' AND count($ti) == 0){
	echo "<br><br><br><br><br><br>
    <a style='color:red; font-size:20; font-weight:bolder;'>** NO SE ENCONTRO EL PEDIDO **<br>$_POST[fac]</a>
	";
	}
else{
//$ti["DESCRIPCION"][] ="<B>SE ACEPTARÁN RECLAMACIONES POR CALIDAD EN ELECTRODOMÉSTICOS, MÁXIMO 24 HORAS DESPUES DE RECIBIDOS</B>";
?>
        <table  class="frs" align="left" border="0" bgcolor="#FFFFFF" cellspacing="0" style="width:<?= $ancho?> ;">
        
            <tr class="frxxs" align="center">
            	<td style="width:33.3%; height: 2px;"></td>
            	<td style="width:33.3%; height: 2px;"></td>
            	<td style="width:33.3%; height: 2px;"></td>
            </tr>
        
            <tr class="frxxl" align="center">
            	<td style="height: 28px;" colspan="3">
    			<b>AGROCAMPO S.A.S</b></td>
            </tr>
            <tr class="frm" align="center">
            	<td style="height: 28px;" colspan="3">
    			TODO EN VETERINARIA<br>NIT 860.069.284 - 2<br>AVENIDA CARACAS 73-53</td>
            </tr>
            <tr class="frxl" align="center">
            	<td style="height: 28px;" colspan="3">
    			<b>REGIMEN COMUN</b>
    			</td>
            </tr>

        <!--fILA DESCRIPCIONES-->
            <tr class="frxl" align="center">
            	<td colspan="3">
    			<table align="left" class="frxxs"  border="0" bgcolor="#FFFFFF" cellspacing="0" style="width: 100%; height: 10px;">
            	<?
            	$cont = 0;
            	while($cont < count($ti['DESCRIPCION'])){
            		
            		            		?>	
            			<tr>
                			<td colspan="5" style="width: 94px; height: 8px;"  >- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= $ti['DESCRIPCION']["$cont"]?></td>
						</tr>
            			<tr>
                			<td style="height: 7px; width: 25%; "  ><?= $ti['EAN']["$cont"]?></td>
							<td align="right" style="height: 7px; width: 25%;"><? if($ti['VLR_EXC_IVA']["$cont"] != 0){ echo number_format($ti['PRECIO_PUBLICO']["$cont"],0);}?> </td>
							<td style="height: 7px; width: 12.5%;" > <? if($ti['POR_DTO']["$cont"] != 0){ echo number_format($ti['POR_DTO']["$cont"],2)."%";}?></td>
							<td align="right" style="height: 7px; width: 12.5%; "><? if($ti['CANTIDAD']["$cont"] !=''){ echo number_format($ti['CANTIDAD']["$cont"],0); }?> UN</td>
							<td style="width: 25%; text-align: right; height: 7px;"><? if($ti['VLR_EXC_IVA']["$cont"] != 0){ echo number_format($ti['VLR_EXC_IVA']["$cont"],0);} ?></td>
            			</tr>
                       	<? 	 
				  $cont ++;	
			 	} //finwhile	
            	?>
	
            </table>
    			</td>
            </tr>

        <tr class="frs">
            <td class="lineAr" style="height: 13px" colspan="2">
			TOTAL ANTES IMP
			</td>
            <td class="lineAr" style="height: 13px" align="right"><?= number_format($ti['VLRT_EXC_IVA'][0],0)?></td>
        </tr>
        <tr class="frs">
            <td>
			FLETE</td>
            <td >&nbsp;</td>
            <td align="right"><?= number_format($ti['FLETE'][0],0)?></td>
        </tr>
        <tr class="frxs">
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr class="frxs">
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr class="frxs">
            <td style="height: 16px" ></td>
            <td style="height: 16px" ></td>
            <td style="height: 16px"></td>
        </tr>
        <tr class="frxs">
            <td style="height: 16px" >TOTAL IMPUESTO</td>
            <td style="height: 16px" ></td>
            <td align="right" style="height: 16px"><?= number_format($ti['VLRT_IVA'][0],0)?></td>
        </tr>
        <tr class="frl">
            <th valign="bottom" style="height: 16px"><b>TOTAL</b></th>
            <td style=" height: 16px;"></td>
            <th align="right" style="height: 16px"><?= number_format($ti['VLRT_INC_IVA'][0],0)?></th>
        </tr>
        <tr class="frxs">
            <td class="lineAb" valign="bottom" style="height: 12px">Tarifa</td>
            <td class="lineAb" style="height: 12px; ">Base</td>
            <td class="lineAb" style="height: 12px; ">IVA</td>
        </tr>
        <?
        foreach($ti[IVA] AS $iva => $valorIVA){
        $contIva += 1;
        echo "<tr class='frxs'>
                <td >& IVA-$iva%</td>
                <td >".number_format($ti[BASE][$iva],0)."</td>
                <td >".number_format($ti[IVA][$iva],0)."</td>
              </tr>
             ";
        $baseT += $ti[BASE][$iva];
        $ivaT += $ti[IVA][$iva];    
        }
        for($i = 0 ; $i < (4 - $contIva) ; $i ++ ){
        echo "<tr class='frxs'>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
              </tr>
             ";

        }
        ?>
        <tr class="lineAr frxs">
            <td class="lineAr" ></td>
            <td class="lineAr" ><?= number_format($baseT,0)?></td>
            <td class="lineAr" ><?= number_format($ivaT,0)?></td>
        </tr>
        <tr class="frxs">
            <td valign="bottom">TOTAL ARTICULOS</td>
            <td style="width: 28px" >&nbsp;</td>
            <td align="right"><?= count($ti['DESCRIPCION'])?></td>
        </tr>
        <tr class="frxs">
            <td valign="bottom">&nbsp;</td>
            <td style="width: 28px" >&nbsp;</td>
            <td >&nbsp;</td>
        </tr>
        <tr class="frxs">
            <th align="justify" valign="bottom" style="height: 22px" colspan="3">
            <?= $ti['RES'][0]?></th>
        </tr>
        <tr class="frxs">
            <th valign="middle" style="height: 22px">FACTURA</th>
            <th valign="bottom" style="" ><?= $ti['TIPO'][0]?></th>
            <th valign="bottom" style="" ><?= $ti['FACTURA'][0]?></th>
        </tr>
        <tr class="frxs">
            <td valign="bottom" style="height: 12px" colspan="3">Fecha fac&nbsp;&nbsp;&nbsp;<?= $ti['FECHA_FACTURA'][0]?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			caja No xxxxx</td>
        </tr>
        <tr class="frxs">
            <td valign="bottom">fch.orden&nbsp;&nbsp;&nbsp;<?= $ti['FECHA_FACTURA'][0]?></td>
            <td style="width: 28px" >&nbsp;</td>
            <td >&nbsp;</td>
        </tr>
        <tr class="frxxs">
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr class="frxs">
            <th align="left" valign="bottom" style="height: 12px" colspan="3">
              CEDULA O NIT&nbsp;&nbsp;<?= $ti['NIT'][0]?>
              <br>
              <?= $ti['RAZON_SOCIAL'][0]?> CEL: <?= $ti['TELEFONO'][0]?>
            </th>
        </tr>
        <tr class="frxxs">
            <td colspan="3">&nbsp;</td>
        </tr>
		<tr class="frxs">
            <th align="left" valign="bottom" style="height: 16px" colspan="3">
            <?= $ti['DIRECCION'][0]?>
            <br>
            <?= $ti['MUNICIPIO'][0]?> <?= $ti['DIRECCION'][0]?>
            </th>
        </tr>
        <tr class="frxs">
            <td valign="bottom" style="height: 12px" colspan="3">&nbsp;</td>
        </tr>
        <tr class="frxs">
            <td valign="bottom" style="height: 12px" colspan="3">Vendedor:&nbsp;&nbsp;<?= $ti['DES_VENDE'][0]?></td>
        </tr>
        <tr class="frs">
            <td valign="bottom" style="height: 12px">&nbsp;</td>
            <td style="height: 16px; " ></td>
            <td style="height: 16px" ></td>
        </tr>
        <tr class="frxs">
            <td valign="bottom" style="height: 12px">&nbsp;</td>
            <td style="height: 16px; " >&nbsp;</td>
            <td style="height: 16px" >&nbsp;</td>
        </tr>
        <tr class="frxs">
            <td align="center"valign="bottom" style="height: 16px" colspan="3">
            
            LE ATENDEMOS EN EL SIGUIENTE HORARIO
			<br>
			LUN-VIE 7:30am - 7:00pm
			<br>
			SABADOS 7:30am - 7:30pm
			<br>
			-----------------------------------
			<br>
			VISITEMOS EN: www.agrocampo.com.co
			<br>
			CALL CENTER TEL. 326 59 99
			<br>
			LINEA GRATUITA NACIONAL 018000911298
			<br>
			-----------------------------------
			<br>
			<b>CONSERVE SU TIQUETE PARA SUS CAMBIOS</b>
			<br>
			NO SE ACEPTAN CAMBIOS DE VACUNAS
			<br>
			NI DE GUACALES
			<br>
			O DESPUÉS DE 8 DÍAS DE ESTA COMPRA
            <br>
            <b>COPIA</b>
            </td>
         </tr>
         <tr class="frxxs">
            <td colspan="3">
            <br>
            Imprime <?= $_SESSION["usuARio"]?> <?= date("Y-m-d : H:i")?>
            </td>
        </tr>
        <tr class="frxxs">
            <td colspan="3">&nbsp;</td>
        </tr>

        </table>
<? } //FINIF FACT Y RESULT >0?>        
</center>


</td>
<td class="nover" width="25%"></td>
<td class="nover" align="center" valign="top" width="22%" style="height: 176px">

<table class="frm"  style="width:95%" >
<tr>
	<th>Factura</th>
	<th>Valor</th>
	<th>Ver</th>
</tr>
<?
$cont = -1;
foreach($list['FACTURA'] as $ti => $valor){
$cont += 1;
if($colorL ==''){$colorL ='GAINSBORO';}else{$colorL ='';}
echo "<tr bgcolor='$colorL'>
	    <td>".$list[TIPO][$cont]." ".$list[FACTURA][$cont]."</td>
	    <td align='right'>$ ".number_format($list[VALOR][$cont],0,',','.')."</td>
	    <td align='center' rowspan='2'><input onchange='this.form.submit()' type='radio' id='fac' name='fac' value='".$list[TIPO][$cont].$list[FACTURA][$cont]."'</td>
      </tr>
      <tr bgcolor='$colorL'>
        <td align='right' colspan='2'>".$list[CLIENTE][$cont]."</td>   
      </tr>
    ";
}
?>
<tr>
  <td colspan="3" align="center">
    <br><br> 
    <input onClick="this.form.submit();" id="sdas" name="botonref1" class="frm Aabs" value=" Ver " type="button" >
  </td>
</tr>
</table>
<!--
<table class="frm"  style="height:100%; width:95%" >
<tr>
	<td align="center" valign="top" style="border-style:groove;">
		<br><br>
		Factura : 
		<input value="" autofocus onchange="this.form.submit();" id="fac" name="fac" class="frm" style="width:100px; border-color:<?= $bordeRP[1]["$bodegaT"]?>" >
		<input onClick="this.form.submit();" id="sdas" name="botonref1" class="frm Aabs" value=" Ver " type="button" >
	    <br><br>
	    <input type="button" class="frm" value=" Imprimir " onClick="javascript:window.print()" /> 
	</td>
</tr>
</table>
-->
</td>
</table>
 
   
</form>
</body>
</html>
