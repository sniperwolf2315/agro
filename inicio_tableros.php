

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Page-Enter" content="RevealTrans(duration=0.5,Transition=23)">

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>Untitled Web Page</title>

<meta name="generator" content="Antenna 3.0">

<meta http-equiv="imagetoolbar" content="no">

<link rel="stylesheet" type="text/css" href="antenna.css" id="css">

<script src="aajquery.js"></script>

<style type="text/css">
  .abs {position:absolute}
  .med {height:40%}
}
</style>

<script type="text/javascript" src="../../antenna/auto.js"></script>

<script>
$(document).ready(function(){
    $(".verloader").click(function(){
        $(".loader").show("slow");
    });
});

$(window).load(function() {
    $(".loader").fadeOut();
});

</script>


</head>

<body class="global">
<section align="center" class="frr med">
<?
$admitidos = array('RAMIREZS','RAMIREZJ','DIGITAL','CARDOZOJ');
if($_SESSION["dIr"] == 'SI' OR in_array($_SESSION["usuARio"], $admitidos) ){
$dir = "href='/moduloI/tableros/domi_dias/domi_dias.php' target='_blank'";
}else{
$dir = "";
}
?>
  <br><br>
  <p><b>PEDIDOS WEB PENDIENTES DE TRAMITE</b></p>
  <br><br>
  <a <?= $dir?> >
    <img src="/images/tabl_dias.png" align="middle" width="70%">
    <br><br><br>
    <p>Permite conocer el estado de los pedidos de pagina web <br> por dias, se refresca cada 15 minutos</p>
  </a>
</section>

<section align="center" class="frr med">
<?
//$admitidos = array('RAMIREZS','RAMIREZJ');
if($_SESSION["dIr"] == 'SI' OR in_array($_SESSION["usuARio"], $admitidos) ){
$dir = "href='/moduloI/tableros/evento/evento.php' target='_blank'";
}else{
$dir = "";
}
?>
  <br><br>
  <p><b>AVANCE DE VENTAS EVENTO</b></p>
  <br><br>
  <a <?= $dir?> >
    <img src="/images/tabl_evento.png" align="middle" width="70%">
    <br><br><br>
    <p>Permite conocer el estado del avance de las ventas<br> por dias, se refresca cada hora</p>
  </a>
</section>


</body>
</html>

