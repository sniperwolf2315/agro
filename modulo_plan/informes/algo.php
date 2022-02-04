<?php
require_once('user_con.php');
include('conectarbase.php');
$periodo=$_GET['p'];
$vista=$_GET['v'];
                if($vista=='V'){
                    //ventas
                    $nomvis='Ventas';
                    //$sqlv = "TRUNCATE TABLE [InformesCompVentas].[dbo].[infVentasIbs]"; 
                    //mssql_query($sqlv,$cLink);
                    $sql = "SELECT * FROM AGR620CFAG.VISINFVENT WHERE PERIODO='$periodo' AND IDPLAN IN('RODRIGUEZF','SUAREZM','PINILLOSM','BARONF')";
                    $result = odbc_exec($db2con, $sql);
                    //if($row = odbc_fetch_array($result)){
                    while($row = odbc_fetch_array($result)){
                        $dv1 = $row['IDPGRP'];
                        $dv2 = $row['PERIODO'];
                        $dv3 = $row['IDPLAN'];
                        $dv3=trim($dv3);
                        $dv4 = $row['COSTO_TOTAL'];
                        $dv5 = $row['VLR_EXC_IVA'];
                        $query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infVentasIbs] WHERE PERIODO='".$periodo."' AND IDPGRP='".$dv1."' AND IDPLAN='".$dv3."'");
                        //$query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infVentasIbs] WHERE PERIODO='".$periodo."'");
                        if (!mssql_num_rows($query)) {
                        //$sqlg = "SELECT COUNT(*) AS T FROM [InformesCompVentas].[dbo].[infVentasIbs] WHERE PERIODO='$periodo' AND IDPGRP='$dv1'";
                        //$t= mssql_query($sqlg,$cLink);
                        //if ($t <= 0){
                            $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[infVentasIbs](IDPGRP,PERIODO,IDPLAN,PBDESC,COSTO_TOTAL,VLR_EXC_IVA) 
                            VALUES('$dv1','$dv2','$dv3','','$dv4','$dv5')"; 
                            mssql_query($sqlv,$cLink);
                        }
                    }
                }else if($vista=='C'){    
                    //carga compras
                    $nomvis='Compras';
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
                }
            echo "Datos ".$nomvis." periodo: ".$periodo." Guardados.";        
            odbc_close($result);
            mssql_close();

?>