<?php
$periodo=$_GET['p'];
$diai=$_GET['diai'];
$diaf=$_GET['diaf'];
if ($diai < 10) {
    $diai= "0".$diai;
}
$periodoi=$periodo.$diai;
$periodof=$periodo.$diaf;
require_once('user_con.php');
include('conectarbase.php');
$sql = "SELECT SROISDPL.IDPRDC AS ITEM, IDDESC AS DESCRIPCION,  SROISDPL.IDINVN AS FACTURA, SROISDPL.IDIDAT AS FECHA,  SROISDPL.IDQTY AS CANT, SROISDPL.IDAMOU AS VALOR";
$sql = $sql. " FROM AGR620CFAG.SROISDPL SROISDPL";
$sql = $sql. " WHERE SROISDPL.IDPLAN IN ('RODRIGUEZF', 'PINILLOSM', 'BARONF', 'SUAREZM') AND SROISDPL.IDIDAT BETWEEN '".$periodoi."' AND '".$periodof."' AND SROISDPL.IDSROM IN ('005', '008') AND SROISDPL.IDAMOU <> 0";
$sql = $sql. " ORDER BY SROISDPL.IDSROM";
                    $result = odbc_exec($db2con, $sql);
                    //if($row = odbc_fetch_array($result)){
                    while($row = odbc_fetch_array($result)){
                        $dv1 = $row['ITEM'];
                        $dv2 = $row['DESCRIPCION'];
                        $dv3 = $row['FACTURA'];
                        $dv4 = $row['FECHA'];
                        $dv5 = $row['CANT'];
                        $dv6 = $row['VALOR'];
                        $dv1=trim($dv1);
                        $query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infVentaSinIvaIbs] WHERE FECHA='".$dv4."' AND ITEM='".$dv1."' AND FACTURA='".$dv3."'");
                        //$query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infVentasIbs] WHERE PERIODO='".$periodo."'");
                        if (!mssql_num_rows($query)) {
                            $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[infVentaSinIvaIbs](ITEM,DESCRIP,FACTURA,FECHA,CANTIDAD,VLR_EXC_IVA,VLR_INC_IVA) 
                            VALUES('$dv1','$dv2','$dv3','$dv4','$dv5','$dv6','0')"; 
                            mssql_query($sqlv,$cLink);
                        }
                    }                   
                   
odbc_close($result);
mssql_close();
?>