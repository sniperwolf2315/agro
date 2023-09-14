<? session_start();

require('../../user_con.php');

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<meta content="RevealTrans(duration=0.5,Transition=23)" http-equiv="Page-Enter">
<title>PROMOS</title>
<meta content="Antenna 3.0" name="generator">
<meta content="no" http-equiv="imagetoolbar">
<meta content="0" http-equiv="Expires">
<meta content="0" http-equiv="Last-Modified">
<meta content="no-cache, mustrevalidate" http-equiv="Cache-Control">
<meta content="no-cache" http-equiv="Pragma">
<style media="print" type="text/css">
.nover {
	display: none;
}
</style>
<link id="css" href="../../antenna.css" rel="stylesheet" type="text/css">
<script src="../../antenna/auto.js" type="text/javascript"></script>
<script src="../../antenna/auto.js" type="text/javascript"></script>
<script src="../../aajquery.js"></script>
<link href="../../aajquery.css" rel="stylesheet">
<?
//valores iniciales
$_POST['minrent'] = '55';

if($_POST['pooun'] ==''){
$_POST['pooun'] = '%';
}
if($_POST['veobo'] ==''){
$_POST['veobo'] = 'Vend';
}

if($_SESSION['dIr'] =='SI'){
	$areas = array('GANADERIA','MASCOTAS');
	if($_POST['area'] ==''){$_POST['area'] ='GANADERIA';}
	
	if($_SESSION["usuARio"] == 'GRAJALESC'){ $_POST['area'] ='MASCOTAS'; }
	if($_SESSION["usuARio"] == 'TAMAYOD'){ $_POST['area'] ='GANADERIA'; }
}else{
	$areas = array();
}


//AGREGA A LISTA
if($_POST['prod'] !=''){
	$_POST['cont'] += 1;
	$cont = $_POST['cont'];
	$_POST["prod$cont"] = $_POST['prod']; $_POST['prod']='';
	$_POST["veobo$cont"] = $_POST['veobo']; $_POST['veobo'] ='Vend';
	$_POST["cant$cont"] = $_POST['cant'];$_POST['cant']='';
	$_POST["bon$cont"] = $_POST['bon'];$_POST['bon']='';
	$_POST["pooun$cont"] = $_POST['pooun'];$_POST['pooun']='%';
}
// Filtros
$fgrupo = " GRUPO_ITEM IN ('') AND ";
if($_POST['area'] == 'GANADERIA' ){ $fgrupo = " GRUPO_ITEM IN ('CPH','QUA','TEC','CMV') AND ";}
if($_POST['area'] == 'MASCOTAS' ){ $fgrupo = " GRUPO_ITEM IN ('971','972') AND ";}

//LISTA PRODS
$sql = "select DESCRIPCION_ITEM, ULTIMO_COSTO_COMPRA, LISTAPRECIOS_A 
		from VISPESPRC 
		where
		$fgrupo 
		GRUPO_ITEM !='PPO' 
		AND substr(DESCRIPCION_ITEM,1,3) !='KIT' 
		AND substr(DESCRIPCION_ITEM,1,5) !='COMBO'
		AND STATUS_ITEM != 'D' 
		ORDER BY DESCRIPCION_ITEM 
		";
$result = odbc_exec($db2conp, $sql) or die($sql);
while($row = odbc_fetch_array($result)){
	$prod = utf8_encode(trim($row['DESCRIPCION_ITEM']));	
	$prods[] = utf8_encode($row['DESCRIPCION_ITEM']);
	$prodsP["$prod"]["CC"] = $row['ULTIMO_COSTO_COMPRA'];
	$prodsP["$prod"]["PP"] = $row['LISTAPRECIOS_A'];
	}
//registros por pag paginador

$SELcontar ="SELECT count(*) AS REGS ";
$from ="FROM SRBSRO 
		LEFT JOIN SROPRG SRBPRG on SRBSRO.SRPRDC = SRBPRG.PGPRDC
		LEFT JOIN SROCTLP1 SRBCTLP1 ON SRBPRG.PGPCA1 = SRBCTLP1.CTPCA1
		LEFT JOIN SROCTLP2 SRBCTLP2 ON SRBPRG.PGPCA2 = SRBCTLP2.CTPCA2
		LEFT JOIN SROCTLP3 SRBCTLP3 ON SRBPRG.PGPCA3 = SRBCTLP3.CTPCA3
		LEFT JOIN SROCTLP4 SRBCTLP4 ON SRBPRG.PGPCA4 = SRBCTLP4.CTPCA4
		LEFT JOIN SROCTLP5 SRBCTLP5 ON SRBPRG.PGPCA5 = SRBCTLP5.CTPCA5
		LEFT JOIN SROCTLP6 SRBCTLP6 ON SRBPRG.PGPCA6 = SRBCTLP6.CTPCA6
 
		where PGSTAT <> 'D'
		$filtros 
		";
//lineas
$sql ="$SELcontar $from";
$result = odbc_exec($db2conp, $sql) or die($sql);
while($row = odbc_fetch_array($result)){
	$registros = $row['REGS'];
	}
//inventario

//}
?>
<script>
var veobon;
var campo; 
function ocultar(){
    campo = 'veobo'; 
	veobon = document.getElementById(campo).value;
	
	if(veobon == 'Bon'){
		document.getElementById('mas').style.display = 'none';
		document.getElementById('bon').style.display = 'none';
		document.getElementById('pooun').style.display = 'none';
	}else{
		document.getElementById("mas").style.display = "initial";
		document.getElementById("bon").style.display = "initial";
		document.getElementById("pooun").style.display = "initial";
	}
}

$(document).ready(function(){
    $(".verloader").click(function(){
        $(".loader").show();
    });
    
    $(".verloaderB").change(function(){
        $(".loader").show();
    });
    
    $(".select2").select2(); 
});

$(window).load(function() {
    $(".loader").fadeOut("slow");
});

</script>
</head>

<body onload="ocultar()" class="global" style="background-color: white; background-repeat: no-repeat; background-attachment: fixed">
<div class="loader" ><br><br><br><br><br>Cargando.....</div>
<center>

<form id="sistema" action="promo.php" autocomplete="off" method="post" name="submit button1">

<div class="container" style="border: 1;">

<section33 style="height:90%" class="nover aut">
		<table class="frxl" style=" max-width:1000px; width: 100%" cellspacing="0">
			<? $color = lightgrey; ?>
			<tr bgcolor="silver">
				<th align="center">&nbsp;</th>
				<th align="center" colspan="6">CALCULADORA DE OFERTAS 
				<select onchange="this.form.submit();" id="area" name="area" class="verloaderB frxl campo" style="background-color:silver; width:auto; font-weight:bold; font-size: large;"  >
					<option><?= $_POST['area']?></option>
					<?
					foreach($areas as $area){
					if($_POST['area'] != $area ){echo "<option >$area</option>";}
					}
					?>
				</select>	
				</th>
			</tr>
			<tr bgcolor="<?= $color?>">
				<th align="center" style="width: 5%;">&nbsp;</th>
				<th align="center" style="width: 55%;">PRODUCTO </th>
				<th align="center" style="width: 10%;">COSTO </th>
				<th align="center" style="width: 10%;">VENTA </th>
				<th align="center" style="width: 10%;">UTILIDAD </th>
				<th align="center" style="width: 5%;">RENT </th>
				<th align="center" style="width: 5%;">Vlr</th>
			</tr>
			<?
			$cont = 0;
			for($i = 1; $i <= $_POST['cont'] ; $i++){ 
			if($_POST["prod$i"] == ''){ continue;}
			$cont ++;
			$prod = $_POST["prod$i"];
			$cant = $_POST["cant$i"];
			if($_POST["pooun$i"] == '%'){
				$bon = number_format(($cant*$_POST["bon$i"]/100)-0.4,0);
				}
			if($_POST["pooun$i"] == 'un'){
				$bon = $_POST["bon$i"];
				}
	
			$co = $prodsP["$prod"]["CC"]*($cant + $bon);
			$coT += $co;
			
			if($_POST["veobo$i"] == 'Bon'){
				$bonT = 0 ;
				}
			if($_POST["veobo$i"] == 'Vend'){
				$bonT = 1 ;
				}

			$ve = $prodsP["$prod"]["PP"]*($cant * $bonT);
			$veT += $ve;
			
			if($color ==''){$color ='whitesmoke';}else{ $color ='';}
			?>
			<tr bgcolor="<?= $color?>" >
				<td align="center" style="padding-top:5px; padding-bottom:5px;" >
						<input onchange="this.form.submit();" id="prod<?=$cont?>" class=" frxl campo" name="prod<?= $cont?>" class="frxl" style="font-size:large;" type="checkbox" checked value="<?= $prod ?>">
						</td>
				<td align="center" style="padding-top:5px; padding-bottom:5px;" >
						<!--
						<select onchange="this.form.submit();" id="prod<?=$cont?>" class=" frxl campo" name="prod<?= $cont?>" style="font-size: large;">
							<option><?= $prod ?></option>
							<option value="">Borrar</option>
						</select> 
						-->
						
						<?= $prod?>
						<br>
						Vend/Bon: <b><?= $_POST["veobo$cont"]?></b>
						<input type="hidden" id="veobo<?=$cont?>" name="veobo<?= $cont?>" value="<?= $_POST["veobo$cont"]?>">
						<!--<select style="width:15%; font-size: large;" onchange="this.form.submit();" class=" frxl campo" id="veobo<?=$cont?>" name="veobo<?= $cont?>">
							<?
							echo "<option>".$_POST["veobo$cont"]."</option>";
							if($_POST["veobo$cont"] != "Vend"){ echo "<option>Vend</option>"; }else{}
							if($_POST["veobo$cont"] != "Bon"){ echo "<option>Bon</option>"; }else{ $inv ='inv'; }
							?>
						</select>
						-->
						Cant: <b><?= $_POST["cant$i"]?></b>
						<input type="hidden" id="cant<?=$cont?>" name="cant<?=$cont?>" value="<?= $_POST["cant$i"]?>">
						<!--
						<input style="width:10%; font-size: large;" onchange="this.form.submit();" class=" frxl campo ctt"  id="cant<?=$cont?>" name="cant<?=$cont?>"  maxlength="5" value="<?= $_POST["cant$i"]?>">
						-->
						<a class="frl <?= $inv?>" >+</a>
						<b><?= $_POST["bon$i"]?></b> <?= $_POST["pooun$cont"]?> = <b><?=$cant+$bon?></b>
						<input type="hidden" id="bon<?=$cont?>" name="bon<?=$cont?>" value="<?= $_POST["bon$i"]?>">
						<input type="hidden" id="pooun<?=$cont?>" name="pooun<?=$cont?>" value="<?= $_POST["pooun$cont"]?>">
						<!--
						<input style="width:10%; font-size: large;" onchange="this.form.submit();" class=" frxl campo ctt <?= $inv?>"  id="bon<?=$cont?>" name="bon<?=$cont?>" maxlength="5" value="<?= $_POST["bon$i"]?>">
						<select style="width:10%; font-size: large;" onchange="this.form.submit();" class="frxl campo <?= $inv?>" id="pooun<?=$cont?>" name="pooun<?=$cont?>">
							<?
							echo "<option>".$_POST["pooun$cont"]."</option>";
							if($_POST["pooun$cont"] != "%"){ echo "<option>%</option>"; }
							if($_POST["pooun$cont"] != "un"){ echo "<option>un</option>"; }
							?>
						</select>
						=<input readonly class="ctt frxl campo" style="width:30px; font-weight:bold; font-size: large;" value="<?=$cant+$bon?>"> 
						-->
						</td>
				<td align="right" style="">$<?= number_format($co,0,'','.') ?></td>
				<td align="right" style="">$<?= number_format($ve,0,'','.') ?></td>
				<td align="right" style="">$<?= number_format(($ve-$co),0,'','.') ?></td>
				<td align="center" style=""><?= number_format(($ve-$co)/$ve*100,0,'','.') ?>%</td>
				<td align="center" style="">
				<?
				echo "$".number_format($ve/($cant+$bon),0,'','.');
				?>
				</td>
			</tr>
			<? } 
				if( ($veT-$coT)/$veT*100 < $_POST["minrent"] ){
				$msjV ="NO ES VIABLE"; $colorV ="PINK";
				}else{
				$msjV = "VIABLE"; $colorV ="LIGHTGREEN";
				}
				
			?>
			<tr>
				<td align="center">
						&nbsp;</td>
				<td align="center">
						&nbsp;</td>
				<td align="right">----------</td>
				<td align="right">----------</td>
				<td align="right">----------</td>
				<td align="center">-----</td>
				<td align="center">
				&nbsp;</td>
			</tr>
			<tr>
				<td align="center" style=" ; background-color:<?=$colorV?>;">
					&nbsp;</td>
				<td align="center" style=" ; background-color:<?=$colorV?>;">
					<input id="cont" name="cont" type="hidden" value="<?= $cont?>">
					<select id="prod" class="  frxl campo select2" name="prod" style="background-color:<?=$colorV?>;">
						<option value="">Seleccione un producto</option>
						<?
						foreach($prods as $tit){
						echo "<option>$tit</option>";
						}
						?></select> 
					<br>
					</td>
				<th bgcolor="<?=$colorV?>" align="right" style=" ">$<?= number_format($coT,0,'','.') ?></th>
				<th bgcolor="<?=$colorV?>" align="right" style=" ">$<?= number_format($veT,0,'','.') ?></th>
				<th bgcolor="<?=$colorV?>" align="right" style=" ">$<?= number_format(($veT-$coT),0,'','.') ?></th>
				<th bgcolor="<?=$colorV?>" align="center" style=" "><?= number_format(($veT-$coT)/$veT*100,0,'','.') ?>%</th>
				<th bgcolor="<?=$colorV?>" align="center" style=" "><?=$msjV?></th>
			</tr>
			
			<tr>
				<td align="center" style=" ; background-color:<?=$colorV?>;">
					&nbsp;</td>
				<td align="center" style=" ; background-color:<?=$colorV?>;">
					Vend/Bon: 
						<select onchange="ocultar()" style="width:15%; font-size: large;" class=" frxl campo " id="veobo" name="veobo">
							<?
							echo "<option>".$_POST["veobo"]."</option>";
							if($_POST["veobo"] != "Vend"){ echo "<option>Vend</option>"; }
							if($_POST["veobo"] != "Bon"){ echo "<option>Bon</option>"; }
							?>
						</select>
						Cant:
						<input style="width:10%; font-size: large;" class=" frxl campo ctt"  id="cant" name="cant"  maxlength="5" value="<?= $_POST["cant"]?>">
						<a class=" frxl" id="mas">+</a>
						<input style="width:10%; font-size: large;" class=" frxl campo ctt"  id="bon" name="bon" maxlength="5" value="<?= $_POST["bon"]?>">
						<select style="width:10%; font-size: large;" class="frxl campo " id="pooun" name="pooun">
							<?
							echo "<option>".$_POST["pooun"]."</option>";
							if($_POST["pooun"] != "%"){ echo "<option>%</option>"; }
							if($_POST["pooun"] != "un"){ echo "<option>un</option>"; }
							?>
						</select>
						
					<input onclick="this.form.submit();" type="button" value=" Incluir " id="inc" name="inc"></td>
				<th bgcolor="<?=$colorV?>" align="right" style=" ">&nbsp;</th>
				<th bgcolor="<?=$colorV?>" align="right" style=" ">&nbsp;</th>
				<th bgcolor="<?=$colorV?>" align="right" style=" " colspan="3">
				Limite Rent <input type="hidden" id="minrent" name="minrent" value="<?= $_POST["minrent"]?>"><?= $_POST["minrent"]?>%
				</th>
			</tr>
			
			<tr>
				<td align="center" style=" ">
					&nbsp;</td>
				<td align="center" style=" ">
					&nbsp;</td>
				<th align="right" style=" ">&nbsp;</th>
				<th align="right" style=" ">&nbsp;</th>
				<th align="right" style=" ">&nbsp;</th>
				<th align="center" style=" ">&nbsp;</th>
				<th align="center" style=" ">&nbsp;</th>
			</tr>
</table>
 </section33>

	</div>
</form>
</center>

</body>

</html>
