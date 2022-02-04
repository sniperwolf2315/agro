<?php
$area=$_GET['area'];
$activo='1';
$fnom='';

if($area == 'CALL' ){$fnom = 'CALLCENTER';}
if($area == 'VE' ){$fnom = 'VENTA EXTERNA';}
if($area == 'AL' ){$fnom = 'ALMACEN';}
if($area == 'RAPPI' ){$fnom = 'RAPPI';}
if($area == 'WEB' ){$fnom = 'PAGINA WEB';}

require_once('../user_con.php');
include('conectarbasepruebas.php');
$conta=0;

    if($area=='RAPPI' || $area=='WEB') {
        $sqlIBS = "SELECT CTSIGN AS CODV, CTNAME AS NOMBRE, CTSMAN AS MANEJAVEND from SRBCTLSD WHERE CTSIGN LIKE '%VEND%' and CTNAME LIKE '%$area%' AND CTYNSA='Y'";
    }else{  
        $sqlIBS = "SELECT CTSIGN AS CODV, CTNAME AS NOMBRE, CTSMAN AS MANEJAVEND from SRBCTLSD WHERE CTSIGN LIKE '%VEND%' and CTNAME LIKE '%($area)%' AND CTYNSA='Y'";
    }
    //    $sql = $sql. " FROM AGR620CFAG.SROISDPL SROISDPL";
   // $sql = $sql. " WHERE SROISDPL.IDPLAN IN ('RODRIGUEZF', 'PINILLOSM', 'BARONF', 'SUAREZM') AND SROISDPL.IDIDAT BETWEEN '".$periodoi."' AND '".$periodof."' AND SROISDPL.IDSROM IN ('005', '008') AND SROISDPL.IDAMOU <> 0 AND SROISDPL.IDPRDC='".$dato."'";
    
                    $query1 = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[vendxarea] WHERE prefarea='".$area."'");
                    $T=mssql_num_rows($query1);
                    if($T > 0){
                        $queryA = mssql_query("DELETE FROM [InformesCompVentas].[dbo].[vendxarea] WHERE prefarea='".$area."'");
                        mssql_query($queryA,$cLink);
                    }
                    $result = odbc_exec($db2con, $sqlIBS);
                    while($row = odbc_fetch_array($result)){
                        $dv1 = trim($row[CODV]);
                        $query2 = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[vendxarea] WHERE prefarea='".$area."' AND codvend='".$dv1."'");
                        if (!mssql_num_rows($query2)) {
                            $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[vendxarea](area,prefarea,codvend,activo)
                            VALUES('$fnom','$area','$dv1','$activo')"; 
                            mssql_query($sqlv,$cLink);
                        }
                    }  
                 
echo "Completado...";                   
odbc_close($result);
mssql_close();
?>