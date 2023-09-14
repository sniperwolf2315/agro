<? 
if(session_start()===FALSE){
        session_start();
    }
    /*
    if($_SESSION['usuARio'] == '' OR $_SESSION['clAVe'] == '')
    {
        header("location:user_conect.php"); die;
    }
    */
    $email=$_POST['email'];
    $_SESSION['email']=$email;
    $ip=$_SERVER['REMOTE_ADDR'];
    //$error=$_GET['a'];
    $error=$_SESSION['acc'];
    if($error=='1'){
        $msg="Acceso Denegado, Datos incorrectos!";
    }else{
        $msg="BIENVENIDO";
    }
?>
 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Page-Enter" content="RevealTrans(duration=0.5,Transition=23)">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Untitled Web Page</title>
<meta name="generator" content="Antenna 3.0">
<meta http-equiv="imagetoolbar" content="no">
<link rel="stylesheet" type="text/css" href="../antenna.css" id="css">
<style type="text/css">.abs {position:absolute}
.auto-style1 {
	color: #FFFFFF;
}
</style>
<script type="text/javascript" src="/antenna/auto.js"></script>
<script>
function cambiarRuta(url){
                location.href=url;
                return true;
            }
</script>
</head>

<body class="Aglobal" >
<center>
<br><br>
<table style="height:478; width:471;">
<tr>

<td align="center" valign="bottom" style="background-image: url('../images/agroc_logoINI.png'); background-repeat:no-repeat; background-position:center; ">

<table width=300 height="262" border=0 cellpadding="2" cellspacing="1" style=" top:400; "> 
	<form name="<?=rand()?>" id="<?=rand()?>"  class="frxl" action="user_conect.php" method="post" >
	<tr> 
	<th colspan="2" style="height: 55px;"><font color="white"><center>TAREAS AGROCAMPO <br /><?php echo $msg; ?> </center></font></th>
	</tr>
    <tr> 
	<td colspan="2" style="height: 46px"><font color="white"><center>Su dir IP: <?echo $ip;?> </center></font></td>
	</tr>
	<tr>
	<td style="height: 38px;" class="auto-style1">Usuarioibs</td> 
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
	<!--<td height="60" colspan="2"><center><input type="submit" name="Enviar" value="enviar"></center></td>-->
	</tr>
    
    <tr>
	<td><font color="white"><center>Correo</center></font></td> 
	<td>
	
	<center>
	<input style="height:20;width:250;" autocomplete="off" name="email" id="email" type="text" maxlength="50" />
	</center></td>
	</tr>
    <tr>
	<td height="60" colspan="2"><center><input type="submit" name="Enviar" value="enviar"></center></td>
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
<?php 
if(isset($_POST['Enviar'])){
    echo "Pruebas";
$lOGin= sha1(date("Y-m-d:H"));  
$loginBO = htmlspecialchars(trim(strtoupper($_POST["$lOGin"])));
$email=$_POST['email'];
$_SESSION['email']=$email;
$pASs=  sha1(date("H:Y-m-d"));
$passBO = trim(mb_strtoupper($_POST["$pASs"]));
 
//CONECCION DB2

//echo "odbc_connect('IBM-AGROCAMPO',$loginBO,$passBO)";
$emP = "";
$handle = odbc_connect('IBM-AGROCAMPO-P',$loginBO,$passBO);
$result = odbc_exec($handle, "select 'AG- AGROCAMPO' AS EMPRESA from SRBUSP where UPUSER = '$loginBO'");
	while($row = odbc_fetch_array($result)){
		$_SESSION['empresA'][] ='AG- AGROCAMPO'; $emP = "DeNtR";
		}
		
$handleP = odbc_connect('IBM-PESTAR-P',$loginBO,$passBO);
$result = odbc_exec($handleP, "select 'AG- AGROCAMPO' AS EMPRESA from SRBUSP where UPUSER = '$loginBO'");
	while($row = odbc_fetch_array($result)){
		$_SESSION['empresA'][] ='X1- PESTAR'; $emP = "DeNtR"; 
		}

$handleC = odbc_connect('IBM-COMERVET-P',$loginBO,$passBO);
$result = odbc_exec($handleC, "select 'AG- AGROCAMPO' AS EMPRESA from SRBUSP where UPUSER = '$loginBO'");
	while($row = odbc_fetch_array($result)){
		$_SESSION['empresA'][] ='ZZ- COMERVET'; $emP = "DeNtR"; 
		}

if($emP == "DeNtR" ){
    $_SESSION['usuARio'] = $loginBO;
    $_SESSION['clAVe'] = $passBO;
    $_SESSION['emp'] = $_SESSION['empresA'][0];
    if(  $_SESSION["usuARio"] == 'CARDOZOJ'
  		OR $_SESSION["usuARio"] == 'TORRESC'
		){ 
		  $_SESSION["dIr"] ='SI';
		}

    
    if($_POST['claves'] < 750){
    	$_SESSION['ancho'] = 'cel' ;
   	 	}else{
    	$_SESSION['ancho'] = 'pc' ;
    	}
    //echo "Aqui2";	
   // echo $_SESSION['usuARio'];
    echo "<script>";
    echo "cambiarRuta('index.php');";
    echo "</script>";
    //header("location: index.php");
    //header( "refresh:1; url=index.php" );
    }
    else{
    //echo "hola mundo";
    header("location:user_conect.php");
    $_SESSION['acc']='1';
    $_SESSION['usuARio']="";
    /*if(session_start()===TRUE){
        session_destroy();
    }*/
    }
}
?>
</body> 
</html>

