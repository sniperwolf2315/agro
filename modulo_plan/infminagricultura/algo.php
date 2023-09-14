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
$conta=0;
//items sin iva
$query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infVentasSinIva]");
//$query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infVentasIbs] WHERE PERIODO='".$periodo."'");
//while($row=mssql_num_rows($query)) {
//$r=$row2=mssql_num_rows($query);
while($resultado = mssql_fetch_array($query)){
    $dato=$resultado["ITEM"];
    $dato=trim($dato);
    //echo $dato."-";
    $conta++;                        
    $sql = "SELECT SROISDPL.IDPRDC AS ITEM, IDDESC AS DESCRIPCION,  SROISDPL.IDINVN AS FACTURA, SROISDPL.IDIDAT AS FECHA,  SROISDPL.IDQTY AS CANT, SROISDPL.IDAMOU AS VALOR";
    $sql = $sql. " FROM AGR620CFAG.SROISDPL SROISDPL";
    $sql = $sql. " WHERE SROISDPL.IDPLAN IN ('RODRIGUEZF', 'PINILLOSM', 'BARONF', 'SUAREZM') AND SROISDPL.IDIDAT BETWEEN '".$periodoi."' AND '".$periodof."' AND SROISDPL.IDSROM IN ('005', '008') AND SROISDPL.IDAMOU <> 0 AND SROISDPL.IDPRDC='".$dato."'";
    //$sql = $sql. " ORDER BY SROISDPL.IDSROM";
                    $result = odbc_exec($db2con, $sql);
                    //if($row = odbc_fetch_array($result)){
                    while($row = odbc_fetch_array($result)){
                        $dv1 = $row['ITEM'];
                        $dv2 = $row['DESCRIPCION'];
                        $dv3 = $row['FACTURA'];
                        $dv4 = $row['FECHA'];
                        $dv5 = $row['CANT'];
                        $dv6 = $row['VALOR'];
                        //divide el valor en la cantidad (valunit)
                        $valor=$dv6/$dv5;
                        $dv1=trim($dv1);
                        $query2 = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infVentaSinIvaIbs] WHERE FECHA='".$dv4."' AND ITEM='".$dv1."' AND FACTURA='".$dv3."'");
                        if (!mssql_num_rows($query2)) {
                            $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[infVentaSinIvaIbs](ITEM,DESCRIP,FACTURA,FECHA,CANTIDAD,VLR_EXC_IVA,VLR_INC_IVA) 
                            VALUES('$dv1','$dv2','$dv3','$dv4','$dv5','$dv6','0')"; 
                            mssql_query($sqlv,$cLink);
                        }
                    }  
}                 
echo "Completado".$conta." Items. No olvide dividir el valor en la cantidad.";                   
odbc_close($result);
mssql_close();
?>