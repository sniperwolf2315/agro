<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" type="text/css" href="ofi/antenna.css" id="css" />

<title>Untitled 1</title>

</head>

<body>
<form id="movse1" action="SErotulos.php" method="post" name="submit button1">
<center>
<?
if($_POST['registros'] ==''){ $_POST['registros'] = '100';}
?>
INGRESE LOS MUEROS DE FACTURAS SEPARADOS POR COMAS :
<br/>
<textarea id="sql" name="sql" class="frm" rows="5" style="width:85%"><?= $_POST['sql']?></textarea>
<br/>
<input type="button" value=" BUSCAR " onclick="this.form.submit()"/>
</center>
</form>
<br/>
<?php

/*/mssql_connect 10.10.0.5
    $cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die('Murriu'.mssql_get_last_message());
    mssql_select_db('SqlFacturas',$cLink);
*/
//IBS 
$db2con = odbc_connect('IBM-AGROCAMPO-P','ODBC','ODBC');



$cont = -1;
$ejecuta ='SI';
$_POST['sql'] = str_replace('"','',$_POST['sql']);
$sqlArr = explode(",",$_POST['sql']);
foreach($sqlArr AS $fac ){
$consec = substr(trim($fac),2);
$facs .= "$coma$consec";
$coma = ",";
}

$_POST['sql'] =strtoupper(str_replace(",","','",str_replace('"','',str_replace(" ","",$_POST['sql']))));

$sql = "SELECT 
          IHCUNO AS IDENTIFICACION
          , NANAME AS DESTINANTARIO 
          , DIRECCION_DE_ENVIO AS DIRECCION
          , NAMCOD AS CIUDAD
          , '' AS DEPARTAMENTO
          , NANSNO AS CEL
          , GTTX70 AS OBS
          , IHINVN AS FACT  
        FROM VISETIFACT
        WHERE IHINVN IN ($facs)
          and IHIDAT LIKE '".date("Y")."%'
        ";
        


//echo "sql: ".$sql ;

if($ejecuta =='SI'){

$result = odbc_exec($db2con,$sql); // or die(mssql_get_last_message());
while($row = odbc_fetch_array($result))
	{
	$munDto = explode("-",$row[CIUDAD]);
	$mun =$munDto[1];
	$dto =$munDto[2];
	$row["CIUDAD"] = $mun;
	$row["DEPARTAMENTO"] = $dto;
	$cont ++;
	if($cont == 0){
	    echo "<table align='center' width='90%' cellspace='0' border='1'>";  
	}
	
    echo "<tr>";
	
    if($cont == 0){
      foreach($row as $campo => $valor){
	  echo "<th>$campo</th>";
	  }
	  echo "</tr><tr>";
	} 	
	foreach($row as $campo => $valor){	    
	  echo "<td>".utf8_encode($valor)."</td>";
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
<br/>
</body>

</html>

