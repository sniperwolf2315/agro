<? session_start();
require('../../user_con.php');

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Page-Enter" content="RevealTrans(duration=0.5,Transition=23)">

<title>AMBIENTAL</title>
<meta name="generator" content="Antenna 3.0">
<meta http-equiv="imagetoolbar" content="no">

<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">

<style type="text/css" media="print">
.nover {display:none}
</style>

<link rel="stylesheet" type="text/css" href="../../antenna.css" id="css">
<link rel="stylesheet" type="text/css" href="../../modulo1/forms/view.css" media="all">
<script type="text/javascript" src="../../antenna/auto.js"></script>
<script type="text/javascript" src="../../modulo1/forms/view.js"></script>
<script type="text/javascript" src="../../modulo1/forms/calendar.js"></script>

<script type="text/javascript" src="../../antenna/auto.js"></script>

<script src="../../aajquery.js"></script>
<link rel="stylesheet" href="../../aajquery.css" >


<script>
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


$(window).load(function() {
	document.getElementById('ancho').value = screen.width;
	});

</script>

<?
//mssql_connect
    $cLink = mssql_connect('10.10.0.5', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message());
    mssql_select_db('SqlFacturas',$cLink);

//Listados
$sql ="SELECT TOP 100 PLACA FROM FACVEHICULO ORDER BY PLACA ASC";

$result = mssql_query($sql) or die(mssql_get_last_message());
while($row = mssql_fetch_assoc($result))
	{ 
	$placas[] = $row['PLACA'];
	}

$sql ="SELECT TOP 100 NOMBRE FROM AGRTRANSPORTADOR order by NOMBRE";

$result = mssql_query($sql) or die(mssql_get_last_message());
while($row = mssql_fetch_assoc($result))
	{ 
	$ttes[] = $row['NOMBRE'];
	}
?>
</head>
<body class="global" style=" background-color:white; background-repeat: no-repeat; background-attachment:fixed" >
<div class="loader" ><br><br><br><br><br>Cargando.....</div>
<center>

<form id="sistema" action="facturas.php" method="post" name="submit button1" autocomplete="off">


<div class="container" style="border:1;">

<section class="nover aut">
<table class="frm">
  <tr>
    <td colspan="2">
      <?
       if($_POST['tipo'] ==''){ $checkedQ = "checked";}
       if($_POST['tipo'] =='QUEMADO'){ $checkedQ = "checked";}
       if($_POST['tipo'] =='CARGA'){ $checkedC = "checked";}
      ?>
      Quema Fact <input onchange="this.form.submit()" id="tipo" <?= $checkedQ?> name="tipo" type="radio" value="QUEMADO">
      &nbsp;&nbsp;&nbsp;&nbsp;
      Reg Carga <input onchange="this.form.submit()" id="tipo" <?= $checkedC?> name="tipo" type="radio" value="CARGA">
    </td>
  </tr>
<?
if($_POST[tipo]== 'CARGA'){
?>  
  <tr>
    <td>Placa</td>
    <td>
      <select class="frm campo" id="placa" name="placa">
        <?
        echo "<option>$_POST[placa]</option>";
        foreach($placas AS $placa){
          echo "<option>$placa</option>";
        }
        ?>
      </select>
    </td>
  </tr>
  <tr>
    <td>Transportadora</td>
    <td>
      <select class="frm campo" id="tte" name="tte">
        <?
        echo "<option>$_POST[tte]</option>";
        foreach($ttes AS $tte){
          echo "<option>$tte</option>";
        }
        ?>
      </select>
    </td>
  </tr>
  <tr>
<? } //FINNF QUEMADO O CARGA?>  
    <td># Factura</td>
    <td>
      <input type="text" id="fact" name="fact" class="frm campo" value="<?= $_POST['fact']?>" />
    </td>
  </tr>
<?
if($_POST[tipo]== 'CARGA'){
?>  
  <tr>
    <td># Guia</td>
    <td>
      <input type="text" id="guia" name="guia" class="frm campo" value="<?= $_POST['guia']?>" />
    </td>
  </tr>
  <tr>
    <td>Vlr Guia $</td>
    <td>
      <input type="text" id="vlrguia" name="vlrguia" class="frm campo" value="<?= $_POST['vlrguia']?>" />
    </td>
  </tr>
<? } //FINNF QUEMADO O CARGA 2 ?>  
    <tr>
    <td colspan="2">Observaciones:<br/>
      <textarea type="text" id="obs" name="obs" class="frm campo" rows="3" style="width:99%"><?= $_POST['obs']?></textarea>
    </td>
  </tr>
</table>
    
</section>

 
</div>
 </form> 


</center>
</body>
</html>
