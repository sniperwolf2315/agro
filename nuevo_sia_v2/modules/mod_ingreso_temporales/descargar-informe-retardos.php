<!DOCTYPE html>
<html>
<head>
	<title>Reporte retardos</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="./render.js"></script>
<?php
include_once('../../conection/conexion_sql.php');
$conn = new con_sql();

$area_url = $_GET['area'];
$area = mssql_fetch_array($conn->consultar("select VALOR,CAMPO from API_CONFIGURACION where VALOR='$area_url'"));
$area_nom = $area[1];
$area = $area[0];


$_POST['f_desde'] =($_POST['f_desde']=='')?date('Y-m-d'):$_POST['f_desde']; 
$_POST['f_hasta'] =($_POST['f_hasta']=='')?date('Y-m-d'):$_POST['f_hasta']; 

?>

</head>
<body>
<div class="container col-12">
	<h2>Retardos</h2>	
    <div class="panel panel-primary --bs-success-text">

    <div  class="row">
      <div  class="col-12">
        <label>Filtrar por fechas</label><br>
        <form action="#" method="POST">
          <label>Desde:</label>
          <input type="date" id="f_desde" name="f_desde" style="border:1.5px solid red;border-radius::20px;height:30px;" value="<?=$_POST['f_desde']?>" >
          <label>Hasta:</label>
          <input type="date"   id="f_hasta" name="f_hasta" style="border:1.5px solid red;border-radius::20px;height:30px;" value="<?=$_POST['f_hasta']?>">
          <input type="hidden" id="area_con" name="area_con" value="<?=$area?>" placeholder="<?=$area?>" >
          <input type="hidden" id="area_cod" name="area_cod" value="<?=$area_nom?>" placeholder="<?=$area_nom?>">
          <input type="button" id="consultar" name="consultar"  class="consultar btn btn-outline-success"  value="Consultar" onclick="consultar_query_retardos()" style="font-size:15px;">
        </form>
      </div>
    </div>
    <br>
    <br>
            

<div id="pedidos_all" name="pedidos_all" class="pedidos_all"></div>

</body>
</html>
