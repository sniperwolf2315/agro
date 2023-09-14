<? session_start();?>

 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Page-Enter" content="RevealTrans(duration=0.5,Transition=23)">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Untitled Web Page</title>
<meta name="generator" content="Antenna 3.0">
<meta http-equiv="imagetoolbar" content="no">
<link rel="stylesheet" type="text/css" href="antenna.css" id="css">
<style type="text/css">.abs {position:absolute}</style>
<script type="text/javascript" src="/antenna/auto.js"></script>
</head>
<body class="global" >


 <?if(isset($_SESSION["NOMbre"]) && empty($_SESSION["NOMbre"])){
header("location:login.php");
} else {
session_unset();
session_destroy();
?>
<BR>
<h1 align="center">AGROCAMPO, Nuevo SIA</h1>
<br>
<h2 align="center">Las variables de sesión han sido eliminadas, y la sesión se ha dado por finalizada correctamente da click 
    <a href='index.php'>aqui para Inciar de sesion</a></h2>
<?
}
?>
</body>
</html>
