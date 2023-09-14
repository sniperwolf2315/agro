<? 
$ip=$_SERVER['REMOTE_ADDR'];
?>
 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Page-Enter" content="RevealTrans(duration=0.5,Transition=23)">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>NUEVO SIA AGROCAMPO</title>
<meta name="generator" content="Antenna 3.0">
<meta http-equiv="imagetoolbar" content="no">
<link rel="stylesheet" type="text/css" href="antenna.css" id="css">
<style type="text/css">.abs {position:absolute}
.auto-style1 {
	color: #FFFFFF;
}
</style>
<script type="text/javascript" src="/antenna/auto.js"></script>
</head>

<body class="Aglobal" >
<center>
<br><br>
<table style="height:478; width:471;">
<tr>

<!-- <td align="center" 
	valign="bottom" 
	style="background-image: url('../images/agroc_logoINI.png'); background-repeat:no-repeat; background-position:center; "
	> -->
<td id="img_form" name="img_form" class="img_form"  align="center">
<table width=300 height="262" border=0 cellpadding="2" cellspacing="1" style=" top:400; "> 
	<form name="<?=rand()?>" id="<?=rand()?>"  class="frxl" action="user_conect_ver.php" method="post" >
	<tr> 
	<th colspan="2" style="height: 55px;"><font color="white"><center>Nuevo S.I.A. <br>BIENVENIDO </center></font></th>
	</tr>
    <tr> 
	<td colspan="2" style="height: 46px"><font color="white"><center>Su dir IP:<br> <?echo $ip;?> </center></font></td>
	</tr>
	<tr>
	<td style="height: 38px;" class="auto-style1">Usuario IBS</td> 
		<td style="height: 38px">
			<input type="hidden" id="claves" name="claves" >
			<?
			$lOGin= sha1(date("Y-m-d:H"));  
			$pASs=  sha1(date("H:Y-m-d"));
			?>
		<center><input autofocus style="height:20;width:150" autocomplete="off" name="<?=$lOGin?>" id="A<?=$lOGin?>O" type="text" value='' maxlength="50"/></center></td>
	</tr>
    <tr>
	<td><font color="white"><center>Clave</center></font></td> 
	<td>
	
	<center>
	<input style="height:20;width:150; letter-spacing:5px; font-family:gatos" autocomplete="off" name="<?=$pASs?>" id="L<?=$pASs?>E" type="text" maxlength="50" />
	</center></td>
	</tr>
    <tr>
	<td height="60" colspan="2">
		<center>
				<input type="submit" value="enviar">
				<br><a onclick="mostrar_login()">___</a>
				<!-- <a href="/nuevo_sia_v2/services/ws_services_soap "></a> -->
		</center>

	</td>
	</tr>

	</form>
	</table>

</td>
</tr>
</table>
</center>
<script>
	document.getElementById('claves').value = screen.width;
</script>

<script type="text/javascript" src="./nuevo_sia_v2/assets/js/login.js "></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body> 
</html>

