<?php
//require_once('user_con.php');
//include('conectarbase.php');
echo "periodof";
exit();
$periodo=$_GET['p'];
$di=$_GET['di'];
$df=$_GET['df'];
if ($di < 10) {
    $di= "0".$di;
}
$periodoi=$periodo.$di;
$periodof=$periodo.$df;

//$vista=$_GET['v'];
                //if($vista=='V'){
                    //ventas
                    //$nomvis='Ventas';
                    //$sqlv = "TRUNCATE TABLE [InformesCompVentas].[dbo].[infVentasIbs]"; 
                    //mssql_query($sqlv,$cLink);
                    //$sql = "SELECT * FROM AGR620CFAG.VISINFVENT WHERE PERIODO='$periodo' AND IDPLAN IN('RODRIGUEZF','SUAREZM','PINILLOSM','BARONF')";
                    $sql = "SELECT SROISDPL.IDPRDC AS ITEM, IDDESC AS DESCRIPCION,  SROISDPL.IDINVN AS FACTURA, SROISDPL.IDIDAT AS FECHA,  SROISDPL.IDQTY AS CANT, SROISDPL.IDAMOU AS VALOR";
                    $sql= $sql + " FROM AGR620CFAG.SROISDPL SROISDPL";
                    $sql= $sql + " WHERE SROISDPL.IDPLAN IN ('RODRIGUEZF', 'PINILLOSM', 'BARONF', 'SUAREZM') AND SROISDPL.IDIDAT BETWEEN '".$periodoi."' AND '".$periodof."' AND SROISDPL.IDSROM IN ('005', '008') AND SROISDPL.IDAMOU <> 0";
                    $sql= $sql + " ORDER BY SROISDPL.IDSROM";
                    
                    
                     //FROM AGR620CFAG.VISINFVENT WHERE PERIODO='$periodo' AND IDPLAN IN('RODRIGUEZF','SUAREZM','PINILLOSM','BARONF')";
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
                        //$sqlg = "SELECT COUNT(*) AS T FROM [InformesCompVentas].[dbo].[infVentasIbs] WHERE PERIODO='$periodo' AND IDPGRP='$dv1'";
                        //$t= mssql_query($sqlg,$cLink);
                        //if ($t <= 0){
                            $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[infVentaSinIvaIbs](ITEM,DESCRIP,FACTURA,FECHA,CANTIDAD,VLR_EXC_IVA,VLR_INC_IVA) 
                            VALUES('$dv1','$dv2','$dv3','$dv4','$dv5','$dv6','0')"; 
                            mssql_query($sqlv,$cLink);
                        }
                    }
                //}/*else if($vista=='C'){    
                    //carga compras
                   /* $nomvis='Compras';
                    //$sqlc = "TRUNCATE TABLE [InformesCompVentas].[dbo].[infComprasIbs]"; 
                    //mssql_query($sqlc,  $cLink);
                    $sql = "SELECT * FROM AGR620CFAG.VISINFCOM WHERE PERIODO='$periodo'";
                    $result = odbc_exec($db2con, $sql);
                    //if($row = odbc_fetch_array($result)){
                    while($row = odbc_fetch_array($result)){
                        $dv1 = trim($row['PGPGRP']);
                        $dv2 = trim($row['PERIODO']);
                        $dv3 = '';//$row['IDPLAN'];
                        $dv4 = $row['VLR_EXC_IVA'];
                        $query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infComprasIbs] WHERE PERIODO='".$periodo."' AND IDPGRP='".$dv1."'");
                        //$query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infComprasIbs] WHERE PERIODO='".$periodo."'");
                        if (!mssql_num_rows($query)) {
                            $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[infComprasIbs](IDPGRP,PERIODO,IDPLAN,VLR_EXC_IVA) 
                            VALUES('$dv1','$dv2','$dv3','$dv4')"; 
                            mssql_query($sqlv,$cLink);
                        }
                    }
                }*/
            echo "Datos Guardados.";        
            odbc_close($result);
            mssql_close();

?>