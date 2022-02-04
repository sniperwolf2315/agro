<? include("../../user_con.php");

// if($_SESSION["clAVe"] == ''){ECHO "<BR><BR> Registres de nuevo aqui<a href='../../index.php'></a>"; DIE;}
// error_reporting(1);
// ini_set('error_reporting', E_ALL);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
<title>Untitled Web Page</title>
<meta content="Antenna 3.0" name="generator" />
<meta content="no" http-equiv="imagetoolbar" />
<link id="css" href="../../antenna.css" media="all" rel="stylesheet" type="text/css" />
<script src="../../antenna/auto.js" type="text/javascript"></script>
<style media="print" type="text/css">
.nover {
	display: none;
}
</style>
<style type="text/css">
th, td {
	border-radius: 12px;
}
.frxxs {
	font-family: Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif;
	color: #000000;
	font-size: 7px;
	direction: ltr;
}
.frxs {
	font-family: Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif;
	color: #000000;
	font-size: 9px;
	direction: ltr;
}
.frs {
	font-family: Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif;
	color: #000000;
	font-size: 10px;
	direction: ltr;
}
.frm {
	font-family: Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif;
	color: #000000;
	font-size: 11px;
	direction: ltr;
}
.frl {
	font-family: Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif;
	color: #000000;
	font-size: 14px;
	direction: ltr;
}
.frxl {
	font-family: Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif;
	color: #000000;
	font-size: 19px;
	direction: ltr;
}
.hor {
	writing-mode: vertical-lr;
	-webkit-writing-mode: vertical-lr;
	-moz-writing-mode: vertical-lr;
	-o-writing-mode: vertical-lr;
	-ms-writing-mode: vertical-lr;
	transform: rotate(-90deg);
	-webkit-transform: rotate(-90deg);
	-moz-transform: rotate(-90deg);
	-o-transform: rotate(-90deg);
	-ms-transform: rotate(-90deg);
}
</style>
<!--
<style media="print" type="text/css">
@page{
   size: landscape;	
   margin: 0;
}
header, footer, nav, aside {
	display: none;
}
</style>
-->
<?  
    $ancho = '780px';
    
    foreach ($_GET as $a=>$b) $_GET[$a] = trim(preg_replace('/\s+/', ' ', preg_replace('/\'/', 'Â´', preg_replace('/\"/', 'Â¨', $b))));
	$hoy = date(" d, Y");
	$hoyM= date("m") - 1 ;
	$meses = array('Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
	
if($_GET['emp'] =='AG'){
	$db2con = odbc_connect('IBM-AGROCAMPO-P',ODBC,ODBC);	
	$db2conp = odbc_connect('IBM-AGROCAMPO-P',ODBC,ODBC);
	$web ="www.agrocampo.com.co";
	}

if($_GET['emp'] =='X1'){
	$db2con = odbc_connect('IBM-PESTAR-P',ODBC,ODBC);
	$db2conp = odbc_connect('IBM-PESTAR-P',ODBC,ODBC);
	$web ="www.pestar.com.co";
	}

if($_GET['emp'] =='ZZ'){
	$db2con = odbc_connect('IBM-COMERVET-P',ODBC,ODBC);
	$db2conp = odbc_connect('IBM-COMERVET-P',ODBC,ODBC);
	$web ="www.comervet.com.co";
	}
    $emp =$_GET['emp'];
    $ov =$_GET['ov'];
    $cajas =$_GET['cajas'];
    $tte =$_GET['tte'];
    $guia =$_GET['guia'];
    $peso =$_GET['peso'];

	//registros por pag paginador
	$regsxpag = 50;
	
	if($_POST['paginador'] ==''){ $_POST['paginador'] = "1-$regsxpag"; }
	$limit = explode("-",$_POST['paginador']);
	$limit[0] = $limit[0]-1;
	$flimit = " LIMIT $limit[0],$limit[1] ";	


//consulta de factura
if($_GET['ov']){
    $sql ="select 
		DIRECCION_DE_ENVIO AS DIR
		, NAMCOD AS DEST
		, NOMBRE_NTERNO AS RASO
		, trim(NANAME) AS CLI
		, TELEFONO AS TEL
		, TELEFONO_FAX AS FAX
		, NANSNO AS CEL
		, GTTX70 AS OBS
		, (SELECT LISTAGG (CONCAT(OHORDT,IHINVN), ', ') from VISETIFACT VI2  WHERE VI2.IHORNO = VI1.IHORNO ) AS FACS
		, IHCUNO AS CC
	 from VISETIFACT VI1 WHERE IHORNO = '$ov'
	 LIMIT 0,1 ";
//echo $sql;            
$result = odbc_exec($db2conp, $sql); echo odbc_errormsg();
	while($row = odbc_fetch_array($result)){
		foreach($row as $campo => $valor){
		$ti["$campo"] = utf8_encode(strtoupper($valor));
		}
		}
} //FINIF
//print_r($valorSEG);		
//$autoprint = 'onload="javascript:window.print()"';	
?>
</head>


<?
if ( $_GET['cajas'] == ''){ $_GET['cajas'] = 1; }

$_GET['tipo'] = 'caja';
  if(substr($ti["FACS"],0,2)== 'D3'
     or substr($ti["FACS"],0,2)== 'S3' 
     or substr($ti["FACS"],0,2)== 'S1' ){
    $_GET['tipo'] = 'bolsa'; 
    }

for($i = 1 ; $i <= $_GET['cajas'] ; $i++){

//rotulo cuadrado para caja
if($_GET['tipo']=='caja'){
?>
<body <?= $autoprint?>="" bgcolor="white" class="global Aabs" style=" background-color:white; width: 588px;">
<table border="1" class=" frm" style=" border: none; page-break-after: always;">
	<tr>
		<th class="frxxs" rowspan="4" style="width: 2.5cm; border: none;">
		<img src="../../images/logo<?= $emp?>.jpg" style="" width="100%" />
		<br />
		Km 2.5 Vía Bogotá- Siberia. Vereda Parcelas Parque Industrial Portos Sabana 
		80 Bodegas 11, 12 , 13 , 14 <br />
		VENTAS PBX <br />
		(1) 326599 COTA <br />
		(CUNDINAMARCA) <br />
		<br />
		Visitanos en: <?= $web?>
		<img src="../../_qr.php?busca=https://<?= $web?>	" width="75%" />
		</th>
		<td align="center" colspan="2" style="height: 1cm; border: none;"><b>
		<font style="font-size: +20">URGENTE - VIDRIO - DELICADO</font></b>
		<br />
		<?= $meses["$hoyM"].$hoy?></td>
		<td rowspan="4" style="width: 1.5cm; border: none;">
		<img alt="" src="../../images/rotulo/copa.png" width="100%" /> <br />
		<br />
		<br />
		<br />
		<img alt="" src="../../images/rotulo/sombrilla.png" width="100%" />
		<br />
		<br />
		<br />
		<br />
		<img alt="" src="../../images/rotulo/cuidado.png" width="100%" /> <br />
		<br />
		<br />
		<br />
		<img alt="" src="../../images/rotulo/arriba.png" width="100%" /> </td>
	</tr>
	<tr>
		<td colspan="2" style="height: 3.5cm">
		<table class="frs">
			<tr>
				<td style="height: 17px">Direccion</td>
				<td class="frl" style="height: 17px"><b><?= $ti["DIR"]?></b>
				</td>
			</tr>
			<tr>
				<td>Destino</td>
				<td class="frl"><?= $ti["DEST"]?></td>
			</tr>
			<tr>
				<td>Razon Social</td>
				<td class="frl"><?= $ti["RASO"]?></td>
			</tr>
			<tr>
				<td>Cliente</td>
				<td class="frl"><b><?= $ti["CLI"]?></b></td>
			</tr>
			<tr>
				<td>Telefono</td>
				<td class="frl"><?= $ti["TEL"]?> <b>Cel</b> <?= $ti["CEL"]?></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td align="right" style="width: 7cm; height: 2.5cm; border: none;" valign="top">
		<table>
			<? 
				$cont = 0;
				$facs = explode(',',$ti["FACS"]);
				foreach($facs as $fac){
				$cont++;
				$facod["$cont"] ="<img height='60%' src='../../php-barcode/php/sample php/sample-gd.php?type=datamatrix&width=4&height=20&code=".trim($fac)."&angle=0&x=75&y=25&font=7' />";
				}
				?>
			<tr>
				<td height="50%"><?= $facod[3]?></td>
				<td><?= $facod[2]?></td>
				<td><?= $facod[1]?></td>
			</tr>
			<tr>
				<td height="50%"><?= $facod[4]?></td>
				<td><?= $facod[5]?></td>
				<td><?= $facod[6]?></td>
			</tr>
		</table>
		</td>
		<td style="width: 4cm;">
		<table cellspacing="0" class="frxs">
			<tr>
				<td style="height: 14px"># Piezas</td>
				<td class="frl" style="height: 14px"><? echo "<b>$i</b> de <b>$_GET[cajas]</b>"; ?>
				</td>
			</tr>
			<tr>
				<td style="height: 14px">Peso</td>
				<td class="frm"><?= $peso?></td>
			</tr>
			<tr>
				<th class="frm" colspan="2" style="height: 15px"><?= $tte?></th>
			</tr>
			<tr>
				<td style="height: 14px">Guia</td>
				<td class="frm"><?= $guia?></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="height: 2.5cm" valign="top">Observaciones: <br />
		<?= $ti["OBS"]?><br />
		<br />
		<a class="frl"><?= $ti["FACS"]?></a></td>
	</tr>
</table>
<? 
} //finif caja

//rotulo tipo manilla para bolsa
if($_GET['tipo']=='bolsa'){
  
  if( strlen($ti["DIR"]) < 55 ){ $tamaD ="frl"; }
    elseif( strlen($ti["DIR"]) < 70 ){ $tamaD ="frm"; }
    elseif( strlen($ti["DIR"]) > 70 ){ $tamaD ="frs"; }
  
  $largoNCC = strlen($ti["CLI"]) + strlen($ti["CC"]) + strlen($ti["CEL"]);
  if( $largoNCC < 45 ){ $tamaNCC ="frl"; }
    elseif( $largoNCC < 70 ){ $tamaNCC ="frm"; }
    elseif( $largoNCC > 70 ){ $tamaNCC ="frs"; }
  
  if( strlen($ti["OBS"]) <= 50 ){ $tamaF ="frl"; }
    else{ $tamaF ="frm";} 
?>
<body <?= $autoprint?>="" bgcolor="white" class="global Aabs" style=" background-color:white; ">
<table class=" frm" style=" border: none; page-break-after: always;" cellspacing="0">
	<tr>
		<th class="frxxs" style="width: 5.5cm; border: none;">
		</th>
		<td style="height: 2cm; width: 13.5cm" valign="top">
		<table class="frs" width="100%" cellspacing="0" border="0">
			<tr>
				<td style="width:100%; height: 8px;" >Dir: <a class="<?= $tamaD?>"><b><?= $ti["DIR"]?></b></a></td>
				
			</tr>
			<tr>
				<td style="height: 10px">
					<a class="<?= $tamaNCC?>"><u><?= $ti["CLI"]?></u></a> 
					C.C. <a class="<?= $tamaNCC?>"><?= $ti["CC"]?></a>
					Cel : <a class="<?= $tamaNCC?>"><?= $ti["CEL"]?></a>
				</td>
				
			</tr>
			<tr>
				<td style="height: 10px">Obs: <?= substr($ti["OBS"],0,130)?> <a class="<?= $tamaF?>"><b><?= $meses["$hoyM"].$hoy?></b></a> Piezas <a class="<?= $tamaF?>"><b><?= $i?></b></a> de <a class="<?= $tamaF?>"><b><?= $_GET[cajas]?></b></a> </td>
			</tr>
		</table>
		</td>
		<td style="border-style: none; border-color: inherit; border-width: medium; width: 2cm;">
		
		<? 
				$cont = 0;
				$facs = explode(',',$ti["FACS"]);
				foreach($facs as $fac){
				$cont++;
				$facod["$cont"] ="<img height='100%' src='../../php-barcode/php/sample php/sample-gd.php?type=datamatrix&width=4&height=20&code=".trim($fac)."&angle=0&x=38&y=25&font=9' />";
				}
				?>
		
		<div align="right" style="width:2cm; height:2cm;" class="hid"><center><?= $facod[1]?></center></div>

		</td>
		<td style="width: 0.5cm; border:none;" >
		</td>
	</tr>
	</table>
<? 
} //finif bolsa

} //finfor ?>

</body>

</html>
