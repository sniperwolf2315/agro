<?php
$periodo=$_GET['p'];
$diai=$_GET['diai'];
$diaf=$_GET['diaf'];
if ($diai < 10) {
    $diai= "0".$diai;
}
$periodoi=$periodo.$diai;
$periodof=$periodo.$diaf;
//require_once('user_con.php');
//include('conectarbase.php');
$sql = "SELECT SROISDPL.IDPRDC AS ITEM, IDDESC AS DESCRIPCION,  SROISDPL.IDINVN AS FACTURA, SROISDPL.IDIDAT AS FECHA,  SROISDPL.IDQTY AS CANT, SROISDPL.IDAMOU AS VALOR";
                    $sql= $sql + " FROM AGR620CFAG.SROISDPL SROISDPL";
                    $sql= $sql + " WHERE SROISDPL.IDPLAN IN ('RODRIGUEZF', 'PINILLOSM', 'BARONF', 'SUAREZM') AND SROISDPL.IDIDAT BETWEEN '".$periodoi."' AND '".$periodof."' AND SROISDPL.IDSROM IN ('005', '008') AND SROISDPL.IDAMOU <> 0";
                    $sql= $sql + " ORDER BY SROISDPL.IDSROM";
                    
                    echo $sql;
                    exit();
//odbc_close($result);
//mssql_close();
?>