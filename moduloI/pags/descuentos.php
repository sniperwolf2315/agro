<? session_start();
 
if($_POST['empresa'] == ''){
	$_POST['empresa'] = $_SESSION['emp'];
	}

if($_SESSION['emp'] != $_POST['empresa']){
	$_SESSION['emp'] = $_POST['empresa'];
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
	 ){ $patrones ='si';
  }elseif(
  $_SESSION["usuARio"] == 'SUAREZM'
  OR $_SESSION["usuARio"] == 'FERROR'
  ){ $_POST['area'] = 'Venta Externa';
  }elseif(
  $_SESSION["usuARio"] == 'CHACONL'
  ){ $_POST['area'] = 'Call';
  }elseif(
  $_SESSION["usuARio"] == 'CASTILLOW'
  OR $_SESSION["usuARio"] == 'CASTILLOW'
  OR $_SESSION["usuARio"] == 'RODRIGUEZD'
  ){ $_POST['area'] = 'Almacen';
  }else{
  }
if($_SESSION["usuARio"] != 'OYUELAL'){$_POST['vendedor'] = $_SESSION["usuARio"];}
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
   margin: 10px;
}
header, footer, nav, aside {
  display: none;
}
</style>


</head>
<?  
    $ancho = '780px';
    $hoy = date("Y-m-d"); 
    if($_POST['desde'] ==''){ $_POST['desde'] = date("Y-m-d",strtotime("$hoy - 1 day")); }
    
    if($_POST['hasta'] ==''){ $_POST['hasta'] = $hoy; }
    
    if($_POST['area'] == '' AND $_POST['vendedor'] == ''){$_POST['area'] = 'Venta Externa';}
    
    if($_POST['info'] == '' ){ $_POST['info'] = "Facturado";}

	//registros por pag paginador
	$regsxpag = 50;
	
	if($_POST['paginador'] ==''){ $_POST['paginador'] = "1-$regsxpag"; }
	$limit = explode("-",$_POST['paginador']);
	$limit[0] = $limit[0]-1;
	$flimit = " LIMIT $limit[0],$limit[1] ";	

//print_r($arralm);
//echo $vendalm;
	
//consulta de ventas y cuotas
$desde = str_replace("-", "", $_POST['desde']);
$hasta = str_replace("-", "", $_POST['hasta']);

$dias = (strtotime("$_POST[hasta]")-strtotime("$_POST[desde]"))/86400 ;

$sqlp ="select
OLORDT AS TIPO
, IDINVN AS DOCUMENTO
, OHNAME AS CLIENTE
, concat(substr(IDIDAT,1,4),concat('-',concat(substr(IDIDAT,7,2),concat('-',substr(IDIDAT,7,2))))) AS FECHA
, IDSALE AS VENDEDOR
, SROORSHE.OHHAND AS RESPONSABLE
, IDPRDC AS CODIGO
, IDDESC AS DESCRIPCION
, IDQTY AS CANTIDAD
, sum(DDDIS1) AS DTO_INICIAL
, DTDIID AS MET_CAMBIO
, DPDESC AS DES_CAMBIO
, MAX(DTDCPR) AS PORC_CAMBIO
, CASE DTDCPR WHEN 0 THEN DTDCAM ELSE 0 END AS VLRCAMBIO
, '' as PRECIO
, '' as VLR_CAMBIO

from SROISDPL
   left outer join SROORSPL SROORSPL on SROISDPL.IDORNO = SROORSPL.OLORNO  AND SROISDPL.IDOLIN = SROORSPL.OLLINE
   left outer join SROORSHE on SROISDPL.IDORNO =  SROORSHE.OHORNO
   left outer join SROSDID  on SROISDPL.IDPCSQ = SROSDID.DDPCSQ                                                
   left outer join SROGDT on SROISDPL.IDGDSQ = SROGDT.DTGDSQ  
   left outer join SRODIS on SROGDT.DTDIID = SRODIS.DPDIID
where (SROISDPL.IDPCOD='180')  
   and (SROISDPL.IDTYPP=1) 
   and (SROISDPL.IDPLAN ='$_POST[vendedor]')
   and ((IFNULL(SROSDID.DDDIS1,0)<>IFNULL(SROGDT.DTDCPR,0)) or (IFNULL(SROSDID.DDCDMC,' ')<>IFNULL(SROGDT.DTDIID,' ')))
   and (IFNULL(SROGDT.DTDITY,'8')='8') 
   and not ((SROISDPL.IDIS01='40' and SROISDPL.IDIS02='400' and SROGDT.DTDCPR<=20) or (SROISDPL.IDIS01='41' and (SROISDPL.IDIS02='410' or SROISDPL.IDIS02='411') and SROGDT.DTDCPR<=20))
   and not (SROGDT.DTDIID='MET01' and (IFNULL(SROGDT.DTDCPR,0)-IFNULL(SROSDID.DDDIS1,0)<=2))
   and not (IFNULL(SROGDT.DTDCPR,0)=2)
   and (SROISDPL.IDIDAT>= $desde and SROISDPL.IDIDAT<= $hasta)
group by OLORDT 
, IDINVN 
, OHNAME
, IDIDAT
, IDSALE 
, SROORSHE.OHHAND 
, IDPRDC 
, IDDESC
, IDQTY
, DTDIID
, DPDESC 

, CASE DTDCPR WHEN 0 THEN DTDCAM ELSE 0 END   
order by SROISDPL.IDIDAT, SROISDPL.IDINVN, IDPRDC
";
//echo $sqlp;           
$result = odbc_exec($db2conp, $sqlp) ; echo odbc_errormsg();
	while($row = odbc_fetch_array($result)){
		foreach($row as $campo => $valor){
		$ti["$campo"][]= utf8_encode($valor);
		}
	//$ti["TOTALV"][] = $row['OBJETIVO']+$row['CONTADO'];
	//$ti["TOTALC"][] = $row['C_OBJETIVO']+$row['C_CONTADO'];	
	}	
	
//echo $farea;		
?>
<body class="global" <?= $autoprint?> >
<div class="loader" ><br><br><br><br><br>Cargando.....</div>

<table class="frs" align="center" height="99%""" width="100%" border="0" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0"> 
<tr>
<td align="center" valign="top" style="width:<?= $ancho?> ; background-color:white; height: 176px; border-color:white;">
<div class="aut" style="width:100%; height:100%">

<a class="frl" style="font-weight:bolder; font-size:20px">
<br><u><? echo $_POST['vendedor']; ?></u>
</a>
<a class="frl" style="font-weight:bolder; font-size:16px">
<br>INFORME DE DESCUENTOS (<?= strtoupper($_POST['empresa'])?>)
<br>DEL <?= $_POST['desde']?> AL <?= $_POST['hasta']?>
<?= $cuotasmsg?>
</a>
<table align="center" class="frxs" border="1" cellspacing="0">
	<tr>
		<?
		foreach($ti as $titulo => $valor){
			echo "<th>$titulo</th>";
			}
		?>
	</tr>
	<?
	$cont = 0;
	while($cont < count($ti["$titulo"])){
		echo "<tr>";
		foreach($ti as $titulo => $valor){
			if(is_numeric($ti["$titulo"]["$cont"])){
	      		$ti["$titulo"]["$cont"] = number_format($ti["$titulo"]["$cont"],0,"","");
	      		$alri = "align='right'";
	      		}else{ $alri ='';}
	      		if($titulo == 'PRECIO'){
	      		$sqlP ="(SELECT NETO1  FROM VISNETPRC2 WHERE VISNETPRC2.PGPRDC = '".$ti["CODIGO"]["$cont"]."' limit 0,1)";
	      		$result = odbc_exec($db2conp, $sqlP);
	      		while($rowP = odbc_fetch_array($result)){
	      			$ti["$titulo"]["$cont"] = "$".number_format($rowP['NETO1']*(1-($ti["DTO_INICIAL"]["$cont"]/100))*$ti["CANTIDAD"]["$cont"],0,",",".");
	      			$alri = "align='right'";
	      			}
	      		}
	      		if($titulo == 'VLR_CAMBIO'){
	      			if($ti["VLRCAMBIO"]["$cont"] == '0'){
	      			$ti["$titulo"]["$cont"] = $ti["PRECIO"]["$cont"] - ($ti["VLRCAMBIO"]["$cont"]*$ti["CANTIDAD"]["$cont"]);
	      			}else{
	      			$ti["$titulo"]["$cont"] = $ti["PRECIO"]["$cont"]*(1-($ti["PORC_CAMBIO"]["$cont"]/100));
	      			}
	      		}
			echo "<td $alri style='padding-right:5px;border-radius:0; border-left-style:none; border-top-style:none; border-right-style:solid; border-bottom-style:solid; '>".$ti["$titulo"]["$cont"]."</td>";
			}
		echo "</tr>";
		$cont ++;
	}
	?>
</table>
</div>
</td>
<td class="nover" align="center" valign="top" width="22%" style="height: 176px">
<form id="movse1" action="descuentos.php" method="post" name="submit button1">
<table class="frm"  style="width:95%" >
<tr>
	<td align="center" valign="top" style="border-style:groove;">
	<table class="frm"  style=" width:95%" >
		<tr>
			<td>
				Empresa
			</td>
			<td>: 
				
	    		<select onchange="this.form.submit();" id="empresa" class="frm campo" name="empresa" tabindex="2">
        		<option><?= $_POST['empresa']?></option>
        		<?
        		foreach($_SESSION['empresA'] as $emp){
        		if($_POST['empresa'] != $emp){echo "<option>$emp</option>";}
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
				Colaborador
			</td>
			<td>
				: <select onchange="this.form.submit();" id="vendedor" name="vendedor" class=" verloaderB frm campo"  >
					<option ><?= $_POST['vendedor']?></option>
					<option >BARONF</option>
					<option >PINILLOSM</option>
					<option >RODRIGUEZF</option>

					
					
			
				  </select>			
			</td>
		</tr>
		<tr>
			<td colspan="2"> 
				<br>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="height: 17px"> 
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
</form>

<form id="movse2" action="0csv.php" method="post" name="submit button2">
<table class="frm"  style="width:95%" >
<tr>
	<td align="center">
	<input id="cons" name="cons" type="hidden" value="<?= $sqlp?>">
	<input onclick="this.form.submit();" type="button" style="background-image:url('../../images/excel.png'); background-color:white; background-position:center; background-repeat:no-repeat; width:60px; height:60px">
	</td>
</tr>
</table>
</form>

</td>
</table>
 
   

</body>
</html>
