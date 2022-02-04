<? session_start();
 
if($_POST['empresa'] == ''){
	$_POST['empresa'] = $_SESSION['emp'];
	}

if($_SESSION['emp'] != $_POST['empresa']){
	$_SESSION['emp'] = $_POST['empresa'];
	$_POST = array();
	$_POST['empresa'] = $_SESSION['emp'];
	}

include("../../user_con.php");
if($_SESSION["clAVe"] == ''){ECHO "<BR><BR> Registrese de nuevo aqui<a href='../../index.php'></a>"; DIE;}

if(  $_SESSION["usuARio"] == 'BARONF'
  OR $_SESSION["usuARio"] == 'SILVAJ'
  OR $_SESSION["usuARio"] == 'TORRESC'
  OR $_SESSION["usuARio"] == 'OYUELAL'
  OR $_SESSION["usuARio"] == 'SILVAJ'
  OR $_SESSION["usuARio"] == 'MORANTESM'
  OR $_SESSION["usuARio"] == 'SIERRAJ'
  OR $_SESSION["usuARio"] == 'HOYOSF'
  OR $_SESSION["usuARio"] == 'TAMAYOD'
  OR $_SESSION["usuARio"] == 'SUAREZM'
  OR $_SESSION["usuARio"] == 'RODRIGUEZA'
  OR $_SESSION["usuARio"] == 'IBANEZV'
  OR $_SESSION["usuARio"] == 'NIETOJ'
	 ){ $patrones ='si';
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

include("ventas_area_".substr($_POST['empresa'],0,2).".php"); 


//echo $farea;		
?>
<body class="global" <?= $autoprint?> >
<div class="loader" ><br><br><br><br><br>Cargando.....</div>

<form id="movse1" action="ventas_area.php" method="post" name="submit button1">

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
		<td colspan="3" align="center" style="height: 17px">
		LABORATORIOS
		</td>
		<td colspan="3" align="center" style="height: 17px">
		IMPORTADOS
		</td>
		<?
		foreach($cuotasAD as $titCUOTA){
		$titCUOTA = explode("_",$titCUOTA);
		echo "<td colspan='3' align='center' style='height: 17px'>$titCUOTA[1]</td>";
		}
		?>
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
		?>
	</tr>
	<?
	$cont = 0;
	while($cont < count($ti["NOMBRE_VEND"])){
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
		?>
	
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
		?>
	</tr>	
</table>

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

<br>

<?	// tabla de ventas kilos y unidades
	$cont = 0;
	$color = "";
	while($cont < count($tiPRO["VENDEDOR"])){
	    if($cont == 0){
	    	echo '<table align="center" class="frs" border="1">
	    		  <tr>
	    		     <td colspan="20" align="center" style="border:none"><b>VENTAS EN KILOS Y UNIDADES LINEAS PROPIAS</b></td>
	    		  </tr>
	    		  <tr>
	    		  ';
	   		foreach($tiPRO as $titulo => $valor){
			echo "<th>$titulo</th>";
			}
        echo "</tr>";
	    }
		echo "<tr>";
		foreach($tiPRO as $titulo => $valor){
			if(is_numeric($tiPRO["$titulo"]["$cont"])){
	      		$tiPRO["$titulo"]["$cont"] = number_format($tiPRO["$titulo"]["$cont"],0,"",".");
	      		$alri = "align='right'";
	      		}else{ $alri ='';}
	      	if($tiPRO["$titulo"]["$cont"] == '0'){ $tiPRO["$titulo"]["$cont"] =''; }
	      	echo "<td $alri style='padding-right:5px;border-radius:0; border-left-style:none; border-top-style:none; border-right-style:solid; border-bottom-style:solid; '>".$tiPRO["$titulo"]["$cont"]."</td>";
			}
		echo "</tr>";
		$cont ++;
	}
	if($cont > 0){
	    	echo '</table>';
	   		}


?>


<br>

<?	//tabla de ordenes estado 10	
	$cont = 0;
	$color = "";
	while($cont < count($ti10["VENDEDOR"])){
	    if($cont == 0){
	    	echo '<table align="center" class="frs" border="1">
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
