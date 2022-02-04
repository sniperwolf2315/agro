<? session_start();
if($_SESSION['usuARio'] == '' OR $_SESSION['clAVe'] == '')
    {
    header("location:user_conect.php"); die;
    }

require('user_con.php'); 

$fecha = date('l, F j, Y'); $hora = date('h:i A'); $ip=$_SERVER['REMOTE_ADDR'];
echo "<font class='frxs'>".substr($_SESSION[NIVel],0,1)." ".substr($_SESSION[servidor],0,2)."</font>";
?>
 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Page-Enter" content="RevealTrans(duration=0.5,Transition=23)">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>AGROCAMPO SIA</title>
<meta name="generator" content="Antenna 3.0">
<meta http-equiv="imagetoolbar" content="no">
<link rel="stylesheet" type="text/css" href="antenna.css" id="css">
<script type="text/javascript" src="antenna/auto.js"></script>
</head>
<body class="global" style="background-color:#E0E0E0;">
<div id="lays701jprcl">
</div>


<div id="lays701mnocu">


  <div id="ifra724vlrhy" class="abs" style="left:2px; top:15px; width:98%; height:97%; border-style:solid;"><iframe
 name="i-frame1" class="aut abs" src="inicio.php" frameborder="0" style="height:100%; width:100%;">
 <a href="modulo0/pags/inicio.php">modulo0/pags/inicio.php</a></iframe></div>
  
</div>


<?
if($_SESSION['ancho'] == 'cel'){
$ancho = "240";
$alto = "44";
$largo ="";
}else{
$ancho = "120px";
$alto = "22px";
$largo ="450px";
}
?>
<div id="menu494redin" class="mnus hid mnu abs frr" style="background-color:#FFFFFF; left:9px; top:8px; width:<?= $ancho?>; height:<?= $alto?>;" 
onMouseOut="tmenu494redin=setTimeout('document.getElementById(\'menu494redin\').style.height=\'<?= $alto?>\'',100);" onMouseOver="
 if (tmenu494redin!=undefined) {clearTimeout(tmenu494redin)}; this.style.height='<?= $largo?>'; this.style.zIndex=9999;">
 <script type="text/javascript">var tmenu494redin; </script>
 <p><b>Agro-menu</b></p>
 <p>&nbsp;</p> 
 <p>------------</p> 
 <div id="pict546orkcm" class="hid Aabs" align="center" style="background-color:#02764C; left:2px; top:31px; width:118px; ">
<img src="images/logopeq.jpg" alt="" width="118px"  class="fill smf" id="pict546orkcmi">
</div>
 <p><b>&nbsp;</b></p> 
 <p>&nbsp;</p> 
 <p>&nbsp;</p> 
 <p><B>BIENVENIDO</B></p>
 <p>&nbsp;</p> 
 <p><? echo $_SESSION["usuARio"];?></p> 
 <p>&nbsp;</p>
 <p><? echo"Conectado desde: ";echo $ip;?></p> 
 <p>&nbsp;</p> 
 <p>------------</p> 
 <p>&nbsp;</p> 
 <p><a href="index.php"><FONT color="#000000"><B>HOME</B></FONT></a></p> 
 <p>&nbsp;</p> 
 <p>
 <form class="miform" action="user_conect_ver_la.php" method="post">
 <input class="frr" type="button" onClick="this.form.submit();" value="Salida Segura" >
 </form>
 </p>
 </div>
 
</body></html>
