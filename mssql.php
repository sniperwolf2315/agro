<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" type="text/css" href="ofi/antenna.css" id="css" />

<title>Untitled 1</title>

</head>

<body>
<form id="movse1" action="mssql.php" method="post" name="submit button1">
<center>
<?
if($_POST['registros'] ==''){ $_POST['registros'] = '100';}
?>
CONSULTA MOSTRAR MAXIMO <input type="text" id="registros" name="registros" class="frm" value="<?= $_POST['registros']?>"/> REGISTROS :
<br/>
<textarea id="sql" name="sql" class="frm" rows="5" style="width:85%"><?= $_POST['sql']?></textarea>
<br/>
<input type="button" value=" EXECUTE " onclick="this.form.submit()"/>
</center>
</form>
<?php

//mssql_connect 10.10.0.5
    $cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die('Murriu'.mssql_get_last_message());
    mssql_select_db('SqlFacturas',$cLink);
//
$cont = -1;
$ejecuta ='SI';
//$sql = "SELECT top 10 * FROM FacEstadoFActura ";
$_POST['sql'] =strtoupper($_POST['sql']);
if(substr($_POST['sql'],0,4) != 'LAO '){ $ejecuta = 'NO'; echo "<script>alert('*** SOLO sentencias Select ***')</script>"; }
$_POST['sql'] = substr($_POST['sql'],4);
$_POST['sql'] = str_Replace('SELECT',"SELECT TOP $_POST[registros] ",$_POST['sql'] );
echo "sql: ".$_POST['sql'] ;
if($ejecuta =='SI'){
$result = mssql_query($_POST['sql']); // or die(mssql_get_last_message());
while($row = mssql_fetch_assoc($result))
	{
	$cont ++;
	if($cont == 0){
	    echo "<table width='100%' cellspace='0' border='1'>";  
	}
	
    echo "<tr>";
	
    if($cont == 0){
      foreach($row as $campo => $valor){
	  echo "<th>$campo</th>";
	  }
	  echo "</tr><tr>";
	} 	
	foreach($row as $campo => $valor){	    
	  echo "<td>$valor</td>";
	} 
    echo "</tr>";
    if($cont >= $_POST['registros']){
      mssql_close();  
      }
    flush();
    ob_flush();   
    }
  echo "</table>";    
} //finif ejecuta
?>

</body>

</html>

