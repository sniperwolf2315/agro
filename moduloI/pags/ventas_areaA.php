<? session_start();

//*ECHO "EL SERVICIO DE CONSULTAS SE HABILITARA DE NUEVO A LAS 8:00 PM, GRACIAS POR SU COMPRENSIÓN"; DIE;**//

 
if($_POST['empresa'] == ''){
	$_POST['empresa'] = $_SESSION['emp'];
	}

if($_SESSION['emp'] != $_POST['empresa']){
	$_SESSION['emp'] = $_POST['empresa'];
	$_POST = array();
	$_POST['empresa'] = $_SESSION['emp'];
	}

include("../../user_con.php");
if($_SESSION["clAVe"] == ''){ECHO "<BR><BR> Registrese de nuevo<a href='../../index.php'> aqui</a>"; DIE;}

if(  $_SESSION["dIr"] == 'SI'){ 
	$patrones ='SI';
  }elseif(
  $_SESSION["usuARio"] == 'GRAJALESC'
  ){ $_POST['area'] = 'Mascotas'; $patrones ='SI';
  }elseif(
  $_SESSION["usuARio"] == 'TAMAYOD'
  OR $_SESSION["usuARio"] == 'ROMEROH' 
  ){ $_POST['area'] = 'Ganaderia'; $patrones ='SI';
  }elseif(
  $_SESSION["usuARio"] == 'FERROR'
  ){ $_POST['area'] = 'Venta Externa';
  }elseif(
  $_SESSION["usuARio"] == 'CHACONL'
  ){ $_POST['area'] = 'Call';
  }elseif(
  $_SESSION["usuARio"] == 'CASTILLOW'
  OR $_SESSION["usuARio"] == 'MONTENEGRO'
  OR $_SESSION["usuARio"] == 'VILLAJ'
  OR $_SESSION["usuARio"] == 'RODRIGUEZD'
  ){ $_POST['area'] = 'Almacen';
  }else{
  $sql ="select UPHAND from SROUSP WHERE UPUSER = '$_SESSION[usuARio]'";
  $result = odbc_exec($db2conp, $sql);
  while($row = odbc_fetch_array($result)){
  	if(trim($row["UPHAND"]) == 'VANANDELL'){
  		$_POST['vendedor'] = str_replace("EXT","D",$_SESSION['usuARio']);
  		}else{
 	 	$_POST['vendedor'] = $row["UPHAND"];
  		}
  //PESTAR GANADERIA
	if($_SESSION['usuARio'] =='CRUZS'){ $_POST['vendedor'] = 'VENPEST003'; }
	if($_SESSION['usuARio'] =='TORRESY'){ $_POST['vendedor'] = 'VENPEST004'; }
	if($_SESSION['usuARio'] =='HERNANDEZJ'){ $_POST['vendedor'] = 'VENPEST006'; }
	if($_SESSION['usuARio'] =='HERNANDEZF'){ $_POST['vendedor'] = 'VENPEST007'; }
	if($_SESSION['usuARio'] =='ARENASC'){ $_POST['vendedor'] = 'VENPEST008'; }
	if($_SESSION['usuARio'] =='TORRESJ'){ $_POST['vendedor'] = 'VENPEST009'; }
	if($_SESSION['usuARio'] =='URBINEZA'){ $_POST['vendedor'] = 'VENPEST010'; }
	if($_SESSION['usuARio'] =='MUÑOZJ'){ $_POST['vendedor'] = 'VENPEST011'; }
	if($_SESSION['usuARio'] =='SILVAM'){ $_POST['vendedor'] = 'VENPEST012'; }
	if($_SESSION['usuARio'] =='CASTROC'){ $_POST['vendedor'] = 'VENPEST013'; }
	if($_SESSION['usuARio'] =='GRISALESC'){ $_POST['vendedor'] = 'VENPEST016'; }

  //PESTAR MASCOTAS
	if($_SESSION['usuARio'] ==''){ $_POST['vendedor'] = 'VENPEST014'; }
	if($_SESSION['usuARio'] =='GARCIAD'){ $_POST['vendedor'] = 'VENPEST015'; }
	if($_SESSION['usuARio'] ==''){ $_POST['vendedor'] = 'VENPEST017'; }
	if($_SESSION['usuARio'] ==''){ $_POST['vendedor'] = 'VENPEST018'; }
	if($_SESSION['usuARio'] ==''){ $_POST['vendedor'] = 'VENPEST019'; }
  
  // COMERVET
  	if($_SESSION['usuARio'] ==''){ $_POST['vendedor'] = 'VENDCO01'; }
  	if($_SESSION['usuARio'] ==''){ $_POST['vendedor'] = 'VENDCO02'; }
  	if($_SESSION['usuARio'] =='TRUJILLOT'){ $_POST['vendedor'] = 'VENDCO03'; }
  	if($_SESSION['usuARio'] ==''){ $_POST['vendedor'] = 'VENDCO04'; }
  	if($_SESSION['usuARio'] =='LOPEZM'){ $_POST['vendedor'] = 'VENDCO05'; }
  	if($_SESSION['usuARio'] =='OTARTEO'){ $_POST['vendedor'] = 'VENDCO06'; }
  	if($_SESSION['usuARio'] =='SALAMANCAJ'){ $_POST['vendedor'] = 'VENDCO11'; }

  	
  }
  }

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
<script src="../../aajquery.js"></script>
<link rel="stylesheet" href="../../aajquery.css" >

<style type="text/css" media="print">
.nover {display:none}
</style>

<style type="text/css" >
.frxxs { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:7px; direction:ltr; }
.frxs { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:9px; direction:ltr; }
.frs { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:10px; direction:ltr; }
.frm { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:11px; direction:ltr; }
.frl { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:13px; direction:ltr; }
.campo{ width:90%	}
.boton{ width:33%	}
}
</style>

<script>
$(document).ready(function(){
    $(".verloader").click(function(){
        $(".loader").show();
    });
    
    $(".verloaderB").change(function(){
        $(".loader").show();
    });
    
    $("select").select2(); 
});

$(window).load(function() {
    $(".loader").fadeOut("slow");
});
</script>

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
    $hoy = date("Y-m-d"); 
// query empresa dependiente:

include("ventas_area_".substr($_POST['empresa'],0,2)."A.php"); 


//echo $farea;		
?>
<body class="global" <?= $autoprint?> >
<div class="loader" ><br><br><br><br><br>Cargando.....</div>

<form id="movse1" action="ventas_areaA.php" method="post" name="submit button1">

<table class="frs" align="center" width="100%" border="0" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0"> 
<tr>
<td align="center" valign="top" style="width:<?= $ancho?> ; background-color:white; height: 176px; border-color:white;">
<a class="frl" style="font-weight:bolder; font-size:20px">
<br><u><? if($_POST['vendedor']){ echo $_POST['vendedor'];}else{echo $_POST['area'];}?></u>
</a>
<a class="frl" style="font-weight:bolder; font-size:16px">
<br>INFORME DE VENTAS Vs CUOTA (<?= strtoupper($_POST['info'])?>)
<br>DEL <?= $_POST['desde']?> AL <?= $_POST['hasta']?>
<?
 if($cuotasmsg){
 	echo $cuotamsg;
 	}else{
 	
 	$color = 'black';
 	$tt = array_sum($ti["TOTALV"])/array_sum($ti["TOTALC"])*100;
		if($tt > 90){$color = 'GREEN';}
		elseif($tt >= 80){$color = 'DARKORANGE';}
		elseif($tt < 80 and $tt > 1){$color = 'CRIMSON';}
	echo "<br><font color='$color'>Cumplimiento: ".number_format($tt,1,",",".")."%</font>";
 	}
 ?>
</a>
<table align="center" class="frxs" border="1">
	<tr>
		<td align="center" style="border-width:0px; height: 17px;">
		
		</td>
		<td colspan="3" align="center" style="height: 17px; background-color:lightgrey">
		TOTAL
		</td>
		<? if($_POST['area']== 'Call'){ ?>
		<td colspan="3" align="center" style="height: 17px;">
		CONTADO
		</td>
		<td colspan="3" align="center" style="height: 17px">
		OBJETIVO
		</td>
		<? } //finifcall ?>
		<? if(substr($_POST['empresa'],0,2) == 'AG'){ ?>
		<td colspan="3" align="center" style="height: 17px">
		LABORATORIOS
		</td>
		<td colspan="3" align="center" style="height: 17px">
		IMPORTADOS
		</td>
		<? } //finifcall ?>
		<?
		foreach($cuotasAD as $titCUOTA){
		$titCUOTA = explode("_",$titCUOTA);
		echo "<td colspan='3' align='center' style='height: 17px'>$titCUOTA[1]</td>";
		}
		
		//rentabilidad
		if(substr($_POST['empresa'],0,2) != 'AG' AND $patrones =='SI'){ ?>
		<td align="center">Rent - Utilidad</td>
		<? } //finif rentabilidad?>

	</tr>
	<tr>
		<td align="center" style="height: 18px;">
		Vendedor
		</td>
		<td align="center" style="height: 18px;  background-color:lightgrey">
		Venta
		</td>
		<td align="center" style="height: 18px;  background-color:lightgrey">
		Cuota
		</td>
		<td align="center" style="height: 18px;  background-color:lightgrey">
		%
		Cumpl
		</td>
		<? if($_POST['area']== 'Call'){ ?>
		<td align="center" style="height: 18px">
		Venta C.
		</td>
		<td align="center" style="height: 18px">
		Cuota
		</td>
		<td align="center" style="height: 18px">
		%
		Cumpl
		</td>
		<td align="center" style="height: 18px">
		Venta O.
		</td>
		<td align="center" style="height: 18px">
		Cuota
		</td>
		<td align="center" style="height: 18px">
		Cumpl
		</td>
		<? } //finif?>
		<? if(substr($_POST['empresa'],0,2) == 'AG'){ ?>
		<td align="center" style="height: 18px">
		Venta L.
		</td>
		<td align="center" style="height: 18px">
		Cuota
		</td>
		<td align="center" style="height: 18px">
		%
		Cumpl
		</td>
		<td align="center" style="height: 18px">
		Venta I.
		</td>
		<td align="center" style="height: 18px">
		Cuota
		</td>
		<td align="center" style="height: 18px">
		%
		Cumpl
		</td>
		<? } //finif?>
		<?
		foreach($cuotasAD as $titCUOTA){
		$titCUOTA = explode("_",$titCUOTA);
		echo '<td align="center" style="height: 18px">
		Venta.
		</td>
		<td align="center" style="height: 18px">
		Cuota
		</td>
		<td align="center" style="height: 18px">
		%
		Cumpl
		</td>';
		}
		
		//rentabilidad
		if(substr($_POST['empresa'],0,2) != 'AG' AND $patrones =='SI'){ ?>
		<td>&nbsp;</td>
		<? } //finif rentabilidad?>

		
	</tr>
	<?
	$cont = 0;
	while($cont < count($ti["$paisano"])){
	$ventaTT += number_format($ti['TOTALV']["$cont"],0,'','');
	$cuotaTT += $ti['TOTALC']["$cont"];
	
	$ventaTC += number_format($ti['CONTADO']["$cont"],0,'','');
	$cuotaTC += $ti['C_CONTADO']["$cont"];
	
	$ventaTO += number_format($ti['OBJETIVO']["$cont"],0,'','');
	$cuotaTO += $ti['C_OBJETIVO']["$cont"];
	
	$ventaTL += number_format($ti['LABORATORIOS']["$cont"],0,'','');
	$cuotaTL += $ti['C_LABS']["$cont"];
	
	$ventaTI += number_format($ti['IMPORTADOS']["$cont"],0,'','');
	$cuotaTI += $ti['C_IMPOR']["$cont"];
	
	$rentT += number_format($ti['COSTO_ULTIMO']["$cont"],0,'','');
	?>
	<tr>
		<td align="left" style="border-width:0px">
		<?= $ti["NOMBRE_VEND"]["$cont"]?>
		</td>
		<td align="right">
		<?= number_format($ti['TOTALV']["$cont"],0,',','.')?>
		</td>
		<td align="right" style="width: 30px">
		<?= number_format($ti['TOTALC']["$cont"],0,',','.')?>
		</td>
		<? 
		$cum = '';
		$cum = number_format($ti['TOTALV']["$cont"]/$ti['TOTALC']["$cont"]*100,1); 
		$color = 'black';
		if($cum >= 90){$color = 'GREEN; border-width:2px;';}
		elseif($cum >= 80){$color = 'DARKORANGE; border-width:2px;';}
		elseif($cum < 80 and $cum > 1){$color = 'CRIMSON; border-width:2px;';}
		?>
		<td align="center" style="border-color:<?=$color?>">
		<?=$cum?>
		</td>
		<? if($_POST['area']== 'Call'){ ?>
		<td align="right">
		<?= number_format($ti['CONTADO']["$cont"],0,',','.')?>
		</td>
		<td align="right">
		<?= number_format($ti['C_CONTADO']["$cont"],0,',','.')?>
		</td>
		<? 
		$cum = '';
		$cum = number_format($ti['CONTADO']["$cont"]/$ti['C_CONTADO']["$cont"]*100,1); 
		$color = 'black';
		if($cum >= 90){$color = 'GREEN; border-width:2px;';}
		elseif($cum >= 80){$color = 'DARKORANGE; border-width:2px;';}
		elseif($cum < 80  and $cum > 1){$color = 'CRIMSON; border-width:2px;';}
		?>
		<td align="center" style="border-color:<?=$color?>">
		<?=$cum?>
		</td>
		<td align="right">
		<?= number_format($ti['OBJETIVO']["$cont"],0,',','.')?>
		</td>
		<td align="right">
		<?= number_format($ti['C_OBJETIVO']["$cont"],0,',','.')?>
		</td>
		<? 
		$cum = '';
		$cum = number_format($ti['OBJETIVO']["$cont"]/$ti['C_OBJETIVO']["$cont"]*100,1); 
		$color = 'black';
		if($cum > 90){$color = 'green; border-width:2px;';}
		elseif($cum >= 80){$color = 'DARKORANGE; border-width:2px;';}
		elseif($cum < 80 and $cum > 1){$color = 'CRIMSON; border-width:2px;';}
		?>
		<td align="center" style="border-color:<?=$color?>">
		<?=$cum?>
		</td>
		<? } //finif?>
		<? if(substr($_POST['empresa'],0,2) == 'AG'){ ?>
		<td align="right">
		<?= number_format($ti['LABORATORIOS']["$cont"],0,',','.')?>
		</td>
		<td align="right">
		<?= number_format($ti['C_LABS']["$cont"],0,',','.')?>
		</td>
		<? 
		$cum = '';
		$cum = number_format($ti['LABORATORIOS']["$cont"]/$ti['C_LABS']["$cont"]*100,1); 
		$color = 'black';
		if($cum > 90){$color = 'green; border-width:2px;';}
		elseif($cum >= 80){$color = 'DARKORANGE; border-width:2px;';}
		elseif($cum < 80 and $cum > 1){$color = 'CRIMSON; border-width:2px;';}
		?>
		<td align="center" style="border-color:<?=$color?>">
		<?=$cum?>
		</td>
		<td align="right">
		<?= number_format($ti['IMPORTADOS']["$cont"],0,',','.')?>
		</td>
		<td align="right">
		<?= number_format($ti['C_IMPOR']["$cont"],0,',','.')?>
		</td>
		<? 
		$cum = '';
		$cum = number_format($ti['IMPORTADOS']["$cont"]/$ti['C_IMPOR']["$cont"]*100,1); 
		$color = 'black';
		if($cum > 90){$color = 'green; border-width:2px;';}
		elseif($cum >= 80){$color = 'DARKORANGE; border-width:2px;';}
		elseif($cum < 80 and $cum > 1){$color = 'CRIMSON; border-width:2px;';}
		?>
		<td align="center" style="border-color:<?=$color?>;">
		<?=$cum?>
		</td>
		<? } //finif?>
		<?
		foreach($cuotasAD as $titCUOTA){
		$titCUOTA = explode("_",$titCUOTA);
		$c_ = $titCUOTA[0]."_";
		$nombre = $titCUOTA[1];
		$cuota["$nombre"] += $ti["$c_$nombre"]["$cont"]; 
		$venta["$nombre"] += $ti["$nombre"]["$cont"];
		$cum = '';
		$cum = number_format($ti["$nombre"]["$cont"]/$ti["$c_$nombre"]["$cont"]*100,1); 
		$color = 'black';
		if($cum > 90){$color = 'green; border-width:2px;';}
		elseif($cum >= 80){$color = 'DARKORANGE; border-width:2px;';}
		elseif($cum < 80 and $cum > 1){$color = 'CRIMSON; border-width:2px;';}
		
		echo '<td align="right">'.number_format($ti["$nombre"]["$cont"],0,',','.').'</td>
		<td align="right">'.number_format($ti["$c_$nombre"]["$cont"],0,',','.').'</td>
		<td align="center" style="border-color:'.$color.';">'.$cum.'</td>
		';
		}
		
		//rentabilidad
		if(substr($_POST['empresa'],0,2) != 'AG' AND $patrones =='SI'){ 
		$rentP = ($ti['TOTALV']["$cont"]-$ti["COSTO_ULTIMO"]["$cont"])/$ti['TOTALV']["$cont"]*100;
		$color = 'black';
		if($rentP > 50){$color = 'green; border-width:2px;';}
		elseif($rentP >= 45){$color = 'DARKORANGE; border-width:2px;';}
		elseif($rentP < 45){$color = 'CRIMSON; border-width:2px;';}
		?>
		<td align="center" style="border-color:<?= $color?>"><?= number_format($rentP,0,",",".")?>%&nbsp; $<?= number_format($ti['TOTALV']["$cont"] - $ti["COSTO_ULTIMO"]["$cont"],0,'','.')?></td>
		<? } //finif rentabilidad?>

	
	</tr>
	<? $cont ++;
	}
	?>
	<tr style="font-weight:bold">
		<td align="center" style="height: 18px">
		TOTAL
		</td>
		<td align="center" style=" background-color:lightgrey; height: 18px;">
		<?= number_format($ventaTT,0,',','.')?>
		</td>
		<td align="center" style=" background-color:lightgrey; height: 18px;">
		<?= number_format($cuotaTT,0,',','.')?>
		</td>
		<? 
		
		$cumT = '';
		$cumT = number_format($ventaTT/$cuotaTT*100,1); 
		$color = 'black';
		if($cumT > 90){$color = 'GREEN; border-width:2px;';}
		elseif($cumT >= 80){$color = 'DARKORANGE; border-width:2px;';}
		elseif($cumT < 80 and $cumT > 1){$color = 'CRIMSON; border-width:2px;';}
		?>
		<td align="center" style="height: 18px; border-color:<?= $color?>">
		<?= $cumT ?>
		</td>
		<? if($_POST['area']== 'Call'){ ?>
		<td align="center" style="height: 18px">
		<?= number_format($ventaTC,0,',','.')?>
		</td>
		<td align="center" style="height: 18px">
		<?= number_format($cuotaTC,0,',','.')?>
		</td>
		<? 
		
		$cumT = '';
		$cumT = number_format($ventaTC/$cuotaTC*100,1); 
		$color = 'black';
		if($cumT > 90){$color = 'GREEN; border-width:2px;';}
		elseif($cumT >= 80){$color = 'DARKORANGE; border-width:2px;';}
		elseif($cumT < 80 and $cumT > 1){$color = 'CRIMSON; border-width:2px;';}
		?>
		<td align="center" style="height: 18px; border-color:<?= $color?> ">
		<?= $cumT ?>
		</td>
		<td align="center" style="height: 18px">
		<?= number_format($ventaTO,0,',','.')?>
		</td>
		<td align="center" style="height: 18px">
		<?= number_format($cuotaTO,0,',','.')?>
		</td>
		<? 
		
		$cumT = '';
		$cumT = number_format($ventaTO/$cuotaTO*100,1); 
		$color = 'black';
		if($cumT > 90){$color = 'GREEN; border-width:2px;';}
		elseif($cumT >= 80){$color = 'DARKORANGE; border-width:2px;';}
		elseif($cumT < 80 and $cumT > 1){$color = 'CRIMSON; border-width:2px;';}
		?>
		<td align="center" style="height: 18px; border-color:<?= $color?>">
		<?= $cumT ?>
		</td>
		<? } //finif?>
		<? if(substr($_POST['empresa'],0,2) == 'AG'){ ?>
		<td align="center" style="height: 18px">
		<?= number_format($ventaTL,0,',','.')?>
		</td>
		<td align="center" style="height: 18px">
		<?= number_format($cuotaTL,0,',','.')?>
		</td>
		<? 
		$cumT = '';
		$cumT = number_format($ventaTL/$cuotaTL*100,1); 
		$color = 'black';
		if($cumT > 90){$color = 'GREEN; border-width:2px;';}
		elseif($cumT >= 80){$color = 'DARKORANGE; border-width:2px;';}
		elseif($cumT < 80 and $cumT > 1){$color = 'CRIMSON; border-width:2px;';}
		?>
		<td align="center" style="height: 18px; border-color:<?= $color?>">
		<?= $cumT ?>
		</td>
		<td align="center" style="height: 18px">
		<?= number_format($ventaTI,0,',','.')?>
		</td>
		<td align="center" style="height: 18px">
		<?= number_format($cuotaTI,0,',','.')?>
		</td>
		<? 
		$cumT = '';
		$cumT = number_format($ventaTI/$cuotaTI*100,1); 
		$color = 'black';
		if($cumT > 90){$color = 'GREEN; border-width:2px;';}
		elseif($cumT >= 80){$color = 'DARKORANGE; border-width:2px;';}
		elseif($cumT < 80 and $cumT > 1){$color = 'CRIMSON; border-width:2px;';}
		?>
		<td align="center" style="height: 18px; border-color:<?= $color?>">
		<?= $cumT ?>
		</td>
		<? } //finif?>
		<?
		foreach($cuotasAD as $titCUOTA){
		$titCUOTA = explode("_",$titCUOTA);
		$c_ = $titCUOTA[0]."_";
		$nombre = $titCUOTA[1];
		$cum = '';
		$cum = number_format($venta["$nombre"]/$cuota["$nombre"]*100,1); 
		$color = 'black';
		if($cum > 90){$color = 'green; border-width:2px;';}
		elseif($cum >= 80){$color = 'DARKORANGE; border-width:2px;';}
		elseif($cum < 80 and $cum > 1){$color = 'CRIMSON; border-width:2px;';}
		
		echo '<td align="right">'.number_format($venta["$nombre"],0,',','.').'</td>
		<td align="right">'.number_format($cuota["$nombre"],0,',','.').'</td>
		<td align="center" style="border-color:'.$color.';">'.$cum.'</td>
		';
		}
		
		//rentabilidad
		if(substr($_POST['empresa'],0,2) != 'AG' AND $patrones =='SI'){ 
		$rentP = ($ventaTT - $rentT)/$ventaTT *100 ;
		$color = 'black';
		if($rentP > 50){$color = 'green; border-width:2px;';}
		elseif($rentP >= 45){$color = 'DARKORANGE; border-width:2px;';}
		elseif($rentP < 45){$color = 'CRIMSON; border-width:2px;';}
		?>
		<td align="center" style="border-color:<?= $color?>"><?= number_format( $rentP ,0,",",".")?>%&nbsp; $<?= number_format($ventaTT - $rentT,0,'','.')?></td>
		<? } //finif rentabilidad?>

	</tr>	
</table>

<? 
// tabla laboratorios
if(count($labs) > 0){ ?>
<br><table align="center" class="frs" border="1">
	<tr>
		<td align="center" style="height: 18px; width: 36px;">
		Lab
		</td>
		<td align="center" style="height: 18px">
		Venta.
		</td>
		<td align="center" style="height: 18px">
		Cuota
		</td>
		<td align="center" style="height: 18px">
		%
		Cumpl
		</td>
	</tr>
	<?
	$cont = 0;
	$ventaL =0;
	$cuotaC =0;
	while($cont < count($labs)){
	$lab = $labs["$cont"];
	$ventaL += number_format(array_sum($ti["$lab"]),0,'','');
	$cuotaC += array_sum($ti["C_$lab"]);
	?>
	<tr>
		<td align="left" style="border-width:0px; width: 36px;">
		<?= $lab?>
		</td>
		<td align="right">
		<?= number_format(array_sum($ti["$lab"]),0,',','.')?>
		</td>
		<td align="right">
		<?= number_format(array_sum($ti["C_$lab"]),0,',','.')?>
		</td>
		<? 
		$cum = '';
		$cum = number_format(array_sum($ti["$lab"])/array_sum($ti["C_$lab"])*100,1); 
		$color = 'black';
		if($cum >= 90){$color = 'GREEN; border-width:2px;';}
		elseif($cum >= 80){$color = 'DARKORANGE; border-width:2px;';}
		elseif($cum < 80 and $cum > 1){$color = 'CRIMSON; border-width:2px;';}
		?>
		<td align="center" style="border-color:<?=$color?>">
		<?=$cum?>
		</td>
		
	</tr>
	<? $cont ++;
	}
	?>
	<tr>
		<td align="center" style="width: 36px">
		TOTAL
		</td>
		<td align="center">
		<?= number_format($ventaL,0,',','.')?>
		</td>
		<td align="center">
		<?= number_format($cuotaC,0,',','.')?>
		</td>
		<? 
		
		$cumT = '';
		$cumT = number_format($ventaL/$cuotaC*100,1); 
		$color = 'black';
		if($cumT > 90){$color = 'GREEN; border-width:2px;';}
		elseif($cumT >= 80){$color = 'DARKORANGE; border-width:2px;';}
		elseif($cumT < 80 and $cumT > 1){$color = 'CRIMSON; border-width:2px;';}
		?>
		<td align="center" style="border-color:<?=$color?>">
		<?= $cumT ?>
		</td>
		
	</tr>	
</table>
<? } //fin if laboratorios ?>


<?	// tabla de ventas kilos y unidades
	$cont = 0;
	$color = "";
	while($cont < count($tiPROK["VENDEDOR"])){
	    if($cont == 0){
	    	echo '<br><table align="center" class="frs" border="1">
	    		  <tr>
	    		     <td colspan="20" align="center" style="border:none"><b>VENTAS EN KILOS Y UNIDADES LINEAS PROPIAS</b></td>
	    		  </tr>
	    		  <tr>
	    		  ';
	   		foreach($tiPROK as $titulo => $valor){
			echo "<th>$titulo</th>";
			}
        echo "</tr>";
	    }
		echo "<tr>";
		foreach($tiPROK as $titulo => $valor){
			if(is_numeric($tiPROK["$titulo"]["$cont"])){
	      		$tiPROK["$titulo"]["$cont"] = number_format($tiPROK["$titulo"]["$cont"],0,"",".");
	      		$alri = "align='right'";
	      		}else{ $alri ='';}
	      	
	      	$color ='';
	      	$porvalPROK ='';
	      	$porPROK ='';
	      	$porCD =''; 
	      	$porCI ='';
	      	if(COUNT(EXPLODE("/",$tiPROK["$titulo"]["$cont"])) == '2'){ 
	      		$valPROK = EXPLODE("/",$tiPROK["$titulo"]["$cont"]);
	      	  	$porvalPROK = number_format($valPROK[0]/$valPROK[1] * 100,0) ;
	      	  	$tiPROK["$titulo"]["$cont"] = number_format($valPROK[0],0,',','.')."/".number_format($valPROK[1],0,',','.');
	      	  	$porPROK ='%';
	      	  	$porCD =')'; 
	      		$porCI ='(';
	      		$alri = "align='center'" ;
	      	  	if($porvalPROK > 98){
	      	  	$color ='GREEN';
	      	  	}elseif($porvalPROK > 80){
	      	  	$color ='DARKORANGE';
	      	  	}elseif($porvalPROK > 1){
	      	  	$color ='CRIMSON';
	      	  	}else{
	      	  	$color ='';
	      	  	}
	      	  }
	      	
	      	echo "<td $alri style='border-width:2; border-color:$color;
	      						   padding-right:5px;
	      	                       border-radius:3; 
	      	                       border-left-style:none; 
	      	                       border-top-style:none; 
	      	                       border-right-style:solid; 
	      	                       border-bottom-style:solid; 
	      	                       '><b>$porvalPROK$porPROK</b> $porCI".$tiPROK["$titulo"]["$cont"]."$porCD</td>";
			}
		echo "</tr>";
		$cont ++;
	}
	if($cont > 0){
	     echo "<tr>";
	     foreach($tiPROKTV as $titulo => $valor){
	              $porvalPROK = number_format($tiPROKTV[$titulo]/$tiPROKTC[$titulo] * 100,0) ;
	      	  	  $porPROK ='%';
	      	  	  $alri = "align='center'" ;
	      	  	  if($porvalPROK > 98){
	      	  	  $color ='GREEN';
	      	  	  }elseif($porvalPROK > 80){
	      	  	  $color ='DARKORANGE';
	      	  	  }elseif($porvalPROK > 1){
	      	      $color ='CRIMSON';
	      	  	  }else{
	      	  	  $color ='';
	      	  	  }
            if($titulo == 'VENDEDOR'){
			  echo "<th border='none'>Total</th>";
			}else{
			  echo "<th $alri style='border-width:2; border-color:$color;'>$porvalPROK$porPROK (".number_format($tiPROKTV[$titulo],0,',','.')."/".number_format($tiPROKTC[$titulo],0,',','.').")</th>";
	      	}                       
			}
		 echo "</tr>
		       </table>";
	   		}


?>

<?	//tabla de VTA POR PRODUCTO	
	$color = "";
	if(count($tiPRO) > 0){
	    	echo '<br><table align="center" class="frs" border="1">
	    		  <tr>
	    		     <td colspan="5" align="center" style="border:none"><b>VENTAS POR PRODUCTO</b></td>
	    		  </tr>
	    		  <tr>
	    		  	<th>Producto</th>
	    		  	<th>Vta Un</th>
	    		  	<th>Vta $</th>
	    		  	<th>Cuota</th>
	    		  	<th>Cumpl</th>
	    		  </tr>	
	    		  ';
	   		        
	    }
		foreach($tiPRO as $titulo => $valor){
			
	      	$cum = '';
			$cum = number_format($tiPRO["$titulo"]["VLR"]/$tiPRO["$titulo"]["CUOTA"]*100,0); 
			$color = 'black;';
			if($cum >= 90){$color = 'GREEN; border-width:2px;';}
				elseif($cum >= 80){$color = 'DARKORANGE; border-width:2px;';}
				elseif($cum < 80 and $tiPRO["$titulo"]["CUOTA"] > 0){$color = 'CRIMSON; border-width:2px;';}
				
	      	echo "<tr>
	      			<td style='padding-right:5px; border-radius:0; 
	      					border-left-style:none; border-top-style:none; 
	      					border-right-style:solid; border-bottom-style:solid; '> $titulo </td>
	      			<td align='right' style='padding-right:5px; border-radius:0; 
	      					border-left-style:none; border-top-style:none; 
	      					border-right-style:solid; border-bottom-style:solid; '>".number_format($tiPRO["$titulo"]["CANT"],0,"",".")."</td>
	      			<td align='right' style='padding-right:5px; border-radius:0; 
	      					border-left-style:none; border-top-style:none; 
	      					border-right-style:solid; border-bottom-style:solid; '>$ ".number_format($tiPRO["$titulo"]["VLR"],0,"",".")."</td>
	      			<td align='right' style='padding-right:5px; border-radius:0; 
	      					border-left-style:none; border-top-style:none; 
	      					border-right-style:solid; border-bottom-style:solid; '>$ ".number_format($tiPRO["$titulo"]["CUOTA"],0,"",".")."</td>
	      			<td align='right' style='padding-right:5px; border-radius:0; border-color:$color
	      					border-left-style:none; border-top-style:none; 
	      					border-right-style:solid; border-bottom-style:solid; '>$cum %</td>								
	      		 </tr>";
			}
		
	if(count($tiPRO) > 0){
	    	echo '</table>';
	   		}


?>

<?	//tabla de VTA POR CLIENTE	
	$color = "";
	if(count($tiCLI) > 0){ //print_r($tiCLI);
			
			ksort($tiCLI);
	    	if($_POST['cliente'] != ''){
	    	$clienteCA = $_POST['cliente'];
	    	}else{
	    	$clienteCA ="CLIENTES";
	    	}
	    	echo '<br><table align="center" class="frs" border="1">
	    		  <tr>
	    		     <th colspan="2" align="center" style="border:none"><b>'.$clienteCA.'</b></th>
	    		     <th colspan="6" align="center" style="border:none"><b>CARTERA</b></th>
	    		  </tr>
	    		  <tr>
	    		     <th align="center" style="border:none"></th>
	    		     <th align="center" style="border:none"><b>Ventas</b></th>
	    		     <th align="center" style="border:none"><b> 0-30 </b></th>
	    		     <th align="center" style="border:none"><b>31-60 </b></th>
	    		     <th align="center" style="border:none"><b>61-90 </b></th>
	    		     <th align="center" style="border:none"><b>91-120</b></th>
	    		     <th align="center" style="border:none"><b>121-150</b></th>
	    		     <th align="center" style="border:none"><b>MORA</b></th>
	    		     <th align="center" style="border:none"><b>Total</b></th>
	    		  </tr>	
	    		  ';
	   		        
	    }
		
		foreach($tiCLI as $titulo => $valor){
		    $valor = $tiCLI["$titulo"]["Ventas"] ;
			$valT += number_format($valor,0,'',''); 
			if($valor != ''){ $valor = "$ ".number_format($valor,0,"",".");}
			$m0 ='';
			$mT ='';
			if($tiCLI["$titulo"]["0M(0-30)"] > 0 ){$m0 = "$ ".number_format($tiCLI["$titulo"]["0M(0-30)"],0,"",".");} $m0T += $tiCLI["$titulo"]["0M(0-30)"]; 
			$m1 =''; 
			if($tiCLI["$titulo"]["1M(31-60)"] > 0 ){$m1 = "$ ".number_format($tiCLI["$titulo"]["1M(31-60)"],0,"",".");} $m1T += $tiCLI["$titulo"]["1M(31-60)"];
			$m2 ='';
			if($tiCLI["$titulo"]["2M(61-90)"] > 0 ){$m2 = "$ ".number_format($tiCLI["$titulo"]["2M(61-90)"],0,"",".");} $m2T += $tiCLI["$titulo"]["2M(61-90)"]; 
			$m3 ='';
			if($tiCLI["$titulo"]["3M(91-120)"] > 0 ){$m3 = "$ ".number_format($tiCLI["$titulo"]["3M(91-120)"],0,"",".");} $m3T += $tiCLI["$titulo"]["3M(91-120)"]; 
			$m4 ='';
			if($tiCLI["$titulo"]["4M(121-150)"] > 0 ){$m4 = "$ ".number_format($tiCLI["$titulo"]["4M(121-150)"],0,"",".");} $m4T += $tiCLI["$titulo"]["4M(121-150)"]; 
			$mo ='';
			if($tiCLI["$titulo"]["MO(>=151)"] > 0 ){$mo = "$ ".number_format($tiCLI["$titulo"]["MO(>=151)"],0,"",".");} $moT += $tiCLI["$titulo"]["MO(>=151)"]; 
			$mT = $tiCLI["$titulo"]["0M(0-30)"]
					+ $tiCLI["$titulo"]["1M(31-60)"]
					+ $tiCLI["$titulo"]["2M(61-90)"]
					+ $tiCLI["$titulo"]["3M(91-120)"]
					+ $tiCLI["$titulo"]["4M(121-150)"]
					+ $tiCLI["$titulo"]["MO(>=151)"]
					;
			$mTT += $mT;					
	      	if($mT < 1){ $mT =''; }else{$mT = "$ ".number_format($mT,0,',','.');} 
	      	echo "<tr>
	      			<td style='padding-right:5px; border-radius:0; 
	      					border-left-style:none; border-top-style:none; 
	      					border-right-style:solid; border-bottom-style:solid; '>$titulo</td>
	      			<td align='right' style='padding-right:5px; border-radius:0; 
	      					border-left-style:none; border-top-style:none; 
	      					border-right-style:solid; border-bottom-style:solid; '><b>$valor</b></td>
	      			<td align='right' style='padding-right:5px; border-radius:0; 
	      					border-left-style:none; border-top-style:none; 
	      					border-right-style:solid; border-bottom-style:solid; '>$m0</td>
	      			<td align='right' style='padding-right:5px; border-radius:0; 
	      					border-left-style:none; border-top-style:none; 
	      					border-right-style:solid; border-bottom-style:solid; '>$m1</td>
	      			<td align='right' style='padding-right:5px; border-radius:0; 
	      					border-left-style:none; border-top-style:none; 
	      					border-right-style:solid; border-bottom-style:solid; '>$m2</td>
	      			<td align='right' style='padding-right:5px; border-radius:0; 
	      					border-left-style:none; border-top-style:none; 
	      					border-right-style:solid; border-bottom-style:solid; '>$m3</td>
	      			<td align='right' style='padding-right:5px; border-radius:0; 
	      					border-left-style:none; border-top-style:none; 
	      					border-right-style:solid; border-bottom-style:solid; '>$m4</td>
	      			<td align='right' style='padding-right:5px; border-radius:0; 
	      					border-left-style:none; border-top-style:none; 
	      					border-right-style:solid; border-bottom-style:solid; color:Red; '><b>$mo</b></td>
	      			<td align='right' style='padding-right:5px; border-radius:0; 
	      					border-left-style:none; border-top-style:none; 
	      					border-right-style:solid; border-bottom-style:solid; '>$mT</td>
	      																	
	      		 </tr>";
			}
		
	if(count($tiCLI) > 0){
	    	echo "	<tr>
	    				<th></th>
	    				<th></th>
	    				<th>".number_format($m0T,0,'','.')."</th>
	    				<th>".number_format($m1T,0,'','.')."</th>
	    				<th>".number_format($m2T,0,'','.')."</th>
	    				<th>".number_format($m3T,0,'','.')."</th>
	    				<th>".number_format($m4T,0,'','.')."</th>
	    				<th style='color:red'>".number_format($moT,0,'','.')."</th>
	    				<th>".number_format($mTT,0,'','.')."</th>
	    			</tr>	
	    		</table>";
	   		}
?>

<?	//tabla de VTA ESPECTRO
	$color = "";
	$vends = 1;
	$vendsT ="PRODUCTO: "; 
	$cols = 3; //Resultados por fila
	if(count($tiESP) > 0 ){
			if($_POST['productoESP'] == ''){
				$vends = count($ti["$paisano"]);
				$vendsT ="VENDEDORES";
				foreach($tiESP as $titulo => $valor){
	    		     	$selectESP .= "<option>$titulo</option>";
	    		     	}
	    		$_POST['productoESP'] = 'Seleccione un Producto';
	    		$value = 'value=""';
	    		}
	    	echo '<br><table align="center" class="frs" border="1">
	    		  <tr>
	    		     <td colspan="'.($cols * 3).'" align="center" style="border:none"><b>ESPECTRO '.$vends.' '.$vendsT.'</b>
	    		     <br>
	    		     <select onchange="this.form.submit()" class="" id="productoESP" name="productoESP" >
	    		     	<option '.$value.'>'.$_POST['productoESP'].'</option>
	    		     	<option value="">Todos</option>
	    		     	'.$selectESP.'
	    		     </select>
	    		    </td>
	    		  </tr><tr>';
	    	for($i =1 ; $i <= $cols ; $i ++){
	    		echo "<td> Prod </td><td> Vta Trim </td><td> Falta </td>";
	    	   }
	    	echo "</tr><tr>";   	  
	    
	    
		$contCOL = 1;
		foreach($tiESP as $titulo => $valor){
		
			$tri = number_format($valor[TRI]/$vends,0,'','');

			$color = 'black;';
			$meta_tri = 36;
			if($tri >= $meta_tri){$color = 'GREEN; background-color:LIGHTGREEN; border-width:2px;'; $verdes += 1; $falta = ''; }
				elseif($tri >= 26){$color = 'DARKORANGE; border-width:2px;'; $falta = $meta_tri - $tri; } 
				elseif($tri < 26 ){$color = 'CRIMSON; border-width:2px;'; $falta = $meta_tri - $tri; }
			echo "<td>$titulo</td>
				  <td align='center' style='border-color:$color'>".number_format($tri,0,'','.')."</td>
				  <td align='center'>".number_format($falta,0,'','.')."</td>";	
	      	
	      	if($contCOL < $cols){ $contCOL +=1 ;}else{echo "</tr><tr>"; $contCOL = 1;}
	      	
	      	}
		
			if($contCOL > 1){
			echo '</tr>';
	   		}
	   		$porVerdes = number_format($verdes/count($tiESP)*100,0);
	   		echo " <tr>
	   			   		<th colspan='".($cols * 3)."'>Espectros Cumplidos: <u>$verdes</u> ($porVerdes %)</th>
	   			   </tr>
	   			  </table>";
	   	}


?>

<?	//tabla de ordenes estado 10	
	$cont = 0;
	$color = "";
	while($cont < count($ti10["VENDEDOR"])){
	    if($cont == 0){
	    	echo '<br><table align="center" class="frs" border="1">
	    		  <tr>
	    		     <td colspan="20" align="center" style="border:none"><b>ORDENES ESTADO 10</b></td>
	    		  </tr>
	    		  <tr>
	    		  ';
	   		foreach($ti10 as $titulo => $valor){
			echo "<th>$titulo</th>";
			}
        echo "</tr>";
	    }
		echo "<tr>";
		foreach($ti10 as $titulo => $valor){
			if(is_numeric($ti10["$titulo"]["$cont"])){
	      		if($titulo =="TOTAL_EXC_IVA"){$mil=".";}else{$mil="";}
	      		$ti10["$titulo"]["$cont"] = number_format($ti10["$titulo"]["$cont"],0,"","$mil");
	      		$alri = "align='right'";
	      		}else{ $alri ='';}
	      	if($ti10["$titulo"]["$cont"] == '0'){ $ti10["$titulo"]["$cont"] =''; }
	      	echo "<td $alri style='padding-right:5px;border-radius:0; border-left-style:none; border-top-style:none; border-right-style:solid; border-bottom-style:solid; '>".$ti10["$titulo"]["$cont"]."</td>";
			}
		echo "</tr>";
		$cont ++;
	}
	if($cont > 0){
	    	echo '</table>';
	   		}


?>

</td>
<td class="nover" align="center" valign="top" width="22%" style="height: 176px">
<table class="frm"  style="height:100%; width:95%" >
<tr>
	<td align="center" valign="top" style="border-style:groove;">
	<table class="frm"  style=" width:95%" >
		<tr>
			<td>
				Empresa
			</td>
			<td>: 
				<form id="movse" class="Aabs" action="refplanoI.php" method="post" name="submit button" enctype="multipart/form-data">	
	    		<select onchange="this.form.submit();" id="empresa" class="frm campo" name="empresa" tabindex="2">
        		<option><?= $_POST['empresa']?></option>
        		<?
        		foreach($_SESSION['empresA'] as $emp){
        		if($_POST['empresa'] != $emp){echo "<option>$emp</option>";}
        		}
        ?> 
       </select>
</form> 
			</td>
		</tr>
		<tr>
			<td colspan="2"> 
				<br>
			</td>
		</tr>
		<tr>
			<td> 
				Desde
			</td>
			<td>
				: <input id="desde" name="desde" class="frm campo afil" value="<?= $_POST['desde']?>" type="date" >
			</td>
		</tr>
		<tr>
			<td colspan="2"> 
				<br>
			</td>
		</tr>
		<tr>
			<td> 
				Hasta
			</td>
			<td>
				: <input id="hasta" name="hasta" class="frm campo Aabs" value="<?= $_POST['hasta']?>" type="date" >
			</td>
		</tr>
		<tr>
			<td colspan="2"> 
				<br>
			</td>
		</tr>
		<?	// i if empresa area
			if(substr($_POST['empresa'],0,2) == 'AG' or substr($_POST['empresa'],0,2) == 'X1'){
			?>
			<tr>
			<td> 
				Area
			</td>
			<td>
				: <select onchange="this.form.submit();" id="area" name="area" class="verloaderB frm campo"  >
					<option><?= $_POST['area']?></option>
					<?
					foreach($areas as $area){
					if($_POST['area'] != $area ){echo "<option >$area</option>";}
					}
					?>

				  </select>			
			</td>
			</tr>
			<tr>
			<td colspan="2"> 
				<br>
			</td>
		</tr>
			<? } //fin if empresa?>
		<?	// i if empresa cliente
			//if(substr($_POST['empresa'],0,2) == 'ZZ'){
			?>
			<tr>
			<td> 
				Cliente
			</td>
			<td>
				: <select onchange="this.form.submit();" id="cliente" name="cliente" class="verloaderB frm campo"  >
					<option><?= $_POST['cliente']?></option>
					<option value="">Todos</option>
					<?
					if($_POST['cliente'] == ''){
						foreach($tiCLI as $titulo => $valor){
						if($_POST['cliente'] != trim($titulo) ){echo "<option >$titulo</option>";}
						}
					}
					?>

				  </select>			
			</td>
			</tr>
			<tr>
				<td colspan="2"> 
					<br>
				</td>
			</tr>

			<? // } //fin if empresa?>
		<?	// i if empresa producto
			if(substr($_POST['empresa'],0,2) == 'ZZ'){
			?>
			<tr>
			<td> 
				Producto
			</td>
			<td>
				: <select onchange="this.form.submit();" id="prodcuto" name="producto" class="verloaderB frm campo"  >
					<option><?= $_POST['producto']?></option>
					<option value="">Todos</option>
					<?
					foreach($tiPRO as $titulo => $valor){
					if($_POST['producto'] != trim($titulo) ){echo "<option >$titulo</option>";}
					}
					?>

				  </select>			
			</td>
			</tr>
			<tr>
				<td colspan="2"> 
					<br>
				</td>
			</tr>
			<? } //fin if empresa?>	
		
		<tr>
			<td> 
				Vendedor
			</td>
			<td>
				: <select onchange="this.form.submit();" id="vendedor" name="vendedor" class=" verloaderB frm campo"  >
					<option ><?= $_POST['vendedor']?></option>
					<option value="">Todos</option>
					<?
					foreach($nombres AS $cod => $nom){
					echo "<option class='verloader' value='$cod'>$cod $nom</option>";
					}
					?>
			
				  </select>			
			</td>
		</tr>
		<tr>
			<td colspan="2"> 
				<br>
			</td>
		</tr>
		<? if($_SESSION['emp'] == 'AG- AGROCAMPO'){ ?>
		<tr>
			<td> 
				Informe de
			</td>
			<td>
				: <select onchange="this.form.submit();" id="info" name="info" class="verloaderB frm campo" >
					<option ><?= $_POST['info']?></option>
					<?
					if($_POST['info'] != 'Facturado' ){echo "<option >Facturado</option>";}
					if($_POST['info'] != 'Ord Venta' ){echo "<option >Ord Venta</option>";}
					if($_POST['info'] != 'Fac y Ord venta' ){echo "<option >Fac y Ord venta</option>";}
				    ?>
				  </select>				
			</td>
		</tr>
		<? } // finif ?>
		<tr>
			<td colspan="2"> 
				<br>
			</td>
		</tr>
		<tr align="center">
			<td colspan="2"> 
				<input onClick="this.form.submit();" id="sdas" name="botonref1" class="verloader frm boton" value=" Ver " type="button" >
			</td>
		</tr>
		<tr>
			<td colspan="2"> 
				<br>
			</td>
		</tr>
		<tr align="center">
			<td colspan="2"> 
				<input type="button" class="frm boton" value=" Imprimir " onClick="javascript:window.print()" /> 
			</td>
		</tr>
	</table>
		 
		
		
	    <br><br>
	    
	</td>
</tr>
</table>


</td>
</table>
 
   
</form>
</body>
</html>
