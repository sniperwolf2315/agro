<?php
$Ordenx=$_GET['Ord'];
include('conectarbase.php');
$dato="";
$resultSQLIBS = mssql_query("SELECT * FROM facListaEmpaqueDetalle WHERE Bodega='008' AND Orden='$Ordenx'");
while($resultado = mssql_fetch_array($resultSQLIBS)){
    $d2=$resultado["Item"];
    $d2=trim($d2);
    $d3=$resultado["Descripcion"];
    $d3=trim($d3);
    $d4=$resultado["Cantidad"];
    $d4=trim($d4);
    $dato=$dato.$d2."^".$d3."^".$d4."_";         
}
echo $dato;
mssql_close();

?>