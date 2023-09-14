<? include("../../user_con.php");
 if($_SESSION["clAVe"] == ''){ECHO "<BR><BR> Registres de nuevo aqui<a href='../../index.php'></a>"; DIE;}
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
.frxxs { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:7px; direction:ltr; }
.frxs { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:9px; direction:ltr; }
.frs { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:10px; direction:ltr; }
.frm { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:11px; direction:ltr; }
.frl { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:13px; direction:ltr; }

</style>

<style type="text/css" media="print">
@page{
   size: letter portrait;	
   margin: 0;
}
header, footer, nav, aside {
  display: none;
}
</style>


</head>
<?  
    $ancho = '780px';
    
    

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
            SRBISH.IHIDAT AS FECHA_FACTURA,
            SRBISH.IHORNO AS NUMERO_ORDEN,
            SRBISH.IHODAT AS FECHA_ORDEN,
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
          , CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END AS VLR_EXC_IVA  
            
		  FROM SROISH SRBISH

            LEFT JOIN SROISDPL SRBISD ON SRBISH.IHINVN = SRBISD.IDINVN AND SRBISH.IHORNO = SRBISD.IDORNO
            LEFT JOIN SROPRG SRBPRG ON SRBISD.IDPRDC = SRBPRG.PGPRDC
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
            
            WHERE (((CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END )<> 0)
            AND (SRBSOH.OHORDT NOT IN ('03','13','19','Z3','Z4','Z5','Z6','Z7','ZN','67','68','72','25','93','K4'))
            AND SRBISD.IDNSVA <> 0
            AND SRBISH.IHINVN = '".substr($_POST[fac],2,20)."'
            )
            ";
//echo $sql;            
$result = odbc_exec($db2conp, $sql);
	while($row = odbc_fetch_array($result)){
		foreach($row as $campo => $valor){
		$ti["$campo"][]= utf8_encode($valor);
		}
	$autoprint = 'onload="javascript:window.print()"';	
	}
} //FINIF
//print_r($ti['DESCRIPCION']);		
?>
<body class="global" <?= $autoprint?> >
<form id="movse1" action="contingencia.php" method="post" name="submit button1">

<table class="frs" align="center" width="1000px" border="0" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0"> 
<tr>
<td valign="top" style="width:<?= $ancho?> ; background-color:white; height: 176px; border-color:white;">
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
$ti["DESCRIPCION"][] ="<B>SE ACEPTARÁN RECLAMACIONES POR CALIDAD EN ELECTRODOMÉSTICOS, MÁXIMO 24 HORAS DESPUES DE RECIBIDOS</B>";
?>
        <table  class="frs" align="center" border="0" bgcolor="#FFFFFF" cellspacing="0" style="width: 100%">
        
            <tr class="frxs" align="center">
            	<td colspan="2" style="height: 28px;">
    			<?= $_POST['fac']?>        
				</td>
            </tr>
        
            <tr><td colspan="2" style="height: 137px;"></td></tr>
        <tr>
            <td colspan="2" style="height: 28px">
                <!--tabla de fechas-->
                
            </td>
        
        <!--FILA DATOS ENCABEZADO USUARIO-->
        <tr>
            <td valign="top" style="height: 185px; width: 58%;">
                   <table class="frs" align="left" border="0" bgcolor="#FFFFFF" cellspacing="0" style="width: 95%">
                    <tr><td style="width: 100px; height: 30px;"></td>
						<td style="height: 30px; width: 246px;" valign="top"></td></tr>
                    <tr><td style="width: 100px; height: 28px;"></td>
						<td style="height: 28px; width: 246px;" valign="top"><?= $ti['RAZON_SOCIAL'][0]?></td></tr>
                       <tr><td style="height: 21px; width: 100px;"></td>
						   <td style="height: 21px; width: 246px;" valign="top"><?= $ti['NIT'][0]?></td></tr>
                       <tr><td style="width: 100px; height: 36px;"></td>
						   <td style="width: 246px; height: 36px;" valign="top"><?= $ti['DIRECCION'][0]?></td></tr>
                       <tr><td style="width: 100px"></td>
						   <td style="width: 246px" valign="top"><?= $ti['TELEFONO'][0]?></td></tr>
                   </table>

            </td>
            <!--FILA DE DATOS ORDEN-->
            <td style="width: 45%; height: 148px;" valign="top">
            <table  class="frs" align="left" border="0" bgcolor="#FFFFFF" cellspacing="0" style="width: 95%" >
                    <tr><td style="width: 200px; height: 30px; text-align:left"><?= $ti['FECHA_ORDEN'][0]?></td>
						<td style="height: 30px; width: 208px; text-align:left; padding-left:15px"><?= $ti['FECHA_FACTURA'][0]?></td>
						<td style="height: 30px; width: 107px;">
						<? 
						if(substr($ti['FECHA_FACTURA'][0],4,2) == 12){
						echo substr($ti['FECHA_FACTURA'][0],0,4) +1 ."01".substr($ti['FECHA_FACTURA'][0],6,2);						
						}else{
						echo substr($ti['FECHA_FACTURA'][0],0,4).substr($ti['FECHA_FACTURA'][0],4,2) +1 .substr($ti['FECHA_FACTURA'][0],6,2);
						}
						
						?>
						</td></tr>
                    <tr><td style="width: 200px; height: 26px;"><label>&nbsp;</label></td>
						<td style="height: 26px" colspan="2"><label><?= $ti['NUMERO_ORDEN'][0]?></label></td></tr>
                       <tr><td style=" width: 200px; height: 21px;"><label>&nbsp;</label></td>
						   <td colspan="2" style="height: 21px" ><label><?= $ti['DES_VENDE'][0]?></label></td></tr>
                       <tr><td style="width: 200px; height: 21px;"><label>&nbsp;</label></td>
						   <td colspan="2" style="height: 21px"><label><?= $ti['MUNICIPIO'][0]?></label></td></tr>
                       <tr><td style="width: 200px; height: 19px;"><label>&nbsp;</label></td>
						   <td colspan="2" style="height: 19px"><label><?= $ti['CALL'][0]?></label></td></tr>
                       <tr><td style="width: 200px">&nbsp;</td>
						   <td colspan="2"></td></tr>
                   </table></td>
        </tr>
        <!--fILA DESCRIPCIONES-->
        <tr>
            <td colspan="2" align="right">
			<table align="left" class="frxxs"  border="0" bgcolor="#FFFFFF" cellspacing="0" style="width: 95%; height: 10px;">
            <?
            $cont = 0;
            while($cont < 57){
            
            ?>
            <tr>
                <td style="width: 94px; height: 9px;" ></td>
				<td style="height: 9px; width: 66px;">&nbsp;</td>
				<td style="height: 9px; width: 327px;"><?= $ti['DESCRIPCION']["$cont"]?></td>
				<td style="width: 66px; height: 9px;"><? if($ti['CANTIDAD']["$cont"] !=''){ echo number_format($ti['CANTIDAD']["$cont"],0); }?></td>
				<td style="width: 69px; height: 9px;"></td>
				<td style="width: 115px; text-align: right; height: 9px;"><? if($ti['VLR_EXC_IVA']["$cont"] !=''){ echo number_format($ti['VLR_EXC_IVA']["$cont"],0,',','.');} ?></td>
            </tr>
            <? $cont ++;} //finwhile ?>
            </table>
            <br>&nbsp;
            <br>&nbsp;
            <table align="left"  class="frxs"  border="0" bgcolor="#FFFFFF" cellspacing="0" style="width: 95%">
            <tr>
                <td style="height: 21px; width: 92px;">&nbsp;</td>
				<td style="height: 21px; width: 92px;">&nbsp;</td>
				<td style="height: 21px; width: 92px;">&nbsp;</td>
				<td style="height: 21px; width: 92px;">&nbsp;</td>
				<td style="height: 21px; width: 92px;">&nbsp;</td>
				<td style="width: 93px; height: 21px">
				&nbsp;</td>
                 <td style="width: 93px; height: 21px">&nbsp;</td>
				<td style="text-align: right; height: 21px; width: 93px;">&nbsp;</td>
            </tr>
            <tr>
                <td style="height: 21px; width: 92px;">&nbsp;</td>
				<td style="height: 21px; width: 92px;">&nbsp;</td>
				<td style="height: 21px; width: 92px;">&nbsp;</td>
				<td style="height: 21px; width: 92px;">&nbsp;</td>
				<td style="height: 21px; width: 92px;">&nbsp;</td>
				<td style="width: 93px; height: 21px">
				&nbsp;</td>
                 <td style="width: 93px; height: 21px">Flete</td>
				<td style="text-align: right; height: 21px; width: 93px;"><?= number_format($ti['VLR_FLETE'][0],0,',','.')?></td>
            </tr>
            <tr>
                <td style="height: 21px; width: 92px;"></td>
				<td style="height: 21px; width: 92px;"></td>
				<td style="height: 21px; width: 92px;"></td>
				<td style="height: 21px; width: 92px;"></td>
				<td style="height: 21px; width: 92px;"></td>
				<td style="width: 93px; height: 21px">
				</td>
                 <td style="width: 93px; height: 21px">Total ant. imp.</td>
				<td style="text-align: right; height: 21px; width: 93px;"><?= number_format($ti['VLRT_EXC_IVA'][0],0,',','.')?></td>
            </tr>
            <tr>
                <td style="height: 21px; width: 92px;"></td>
				<td style="height: 21px; width: 92px;"></td>
				<td style="height: 21px; width: 92px;"></td>
				<td style="height: 21px; width: 92px;">
				</td><td style="height: 21px; width: 92px;"></td>
				<td style="width: 93px; height: 21px;">
				</td>
                 <td style="width: 93px; height: 21px;">Retención </td>
				<td style="text-align: right; height: 21px; width: 93px;">
				<? 
				if($ti['VLRT_EXC_IVA'][0] >= 895000 AND $ti['AUTO_RETENEDOR'][0] == 'Y' ){
				$rte = $ti['VLRT_EXC_IVA'][0]*-0.025;
				}else{$rte = 0;}
				echo number_format($rte,0,',','.')?>
				</td>
            </tr>
            <tr>
                <td style="width: 92px">&nbsp;</td><td style="width: 92px">&nbsp;</td>
				<td style="width: 92px">&nbsp;</td><td style="width: 92px">
				&nbsp;</td><td style="width: 92px">&nbsp;</td>
				<td style="width: 93px">
				</td>
                 <td style="width: 93px">IVA</td>
				<td style="text-align: right; width: 93px;"><?= number_format( $ti['VLRT_IVA'][0]-$rte ,0,',','.')?></td>
           </tr>
            <tr>
                <td style="width: 92px">&nbsp;</td><td style="width: 92px">&nbsp;</td>
				<td style="width: 92px">&nbsp;</td>
                <td style="width: 92px">&nbsp;</td>
                <td style="width: 92px">&nbsp;</td>
                <td style="width: 93px">&nbsp;</td>
                <td style="width: 93px">TOTAL</td>
				<td style="text-align: right; width: 93px;"><?= number_format($ti['VLRT_INC_IVA'][0],0,',','.')?></td>
            </tr>
        </table>
           
        </td>
        </tr>
        
       
        </table>
<? } //FINIF FACT Y RESULT >0?>        
</center>


</td>
<td class="nover" align="center" valign="top" width="22%" style="height: 176px">
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


</td>
</table>
 
   
</form>
</body>
</html>
