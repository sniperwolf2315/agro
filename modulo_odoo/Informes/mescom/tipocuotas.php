<?php
require_once('user_con.php');
//base sqlServer produccion
require_once('conectarbaseprod.php');
$query1 = mssql_query("DELETE FROM [sqlFacturas].[dbo].[facTipoCuota]");
mssql_query($query1,$cLink);

        $sqlIBS = "SELECT * from AGR620CFAG.VISVTICU";
        
        $result = odbc_exec($db2con, $sqlIBS);
                    while($row = odbc_fetch_array($result)){
                        $d1 = trim($row[TIPO_CUOTA]);
                        $d2 = trim($row[DES_TIPO_CUOTA]);
                        $d3 = trim($row[COL_CAMPO_BUSCAR]);
                        $d4 = trim($row[DES_CAMPO_BUSCAR]);
                        $d5 = trim($row[ORDEN]);
                        //SQL SERVER
                        $query2 = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[facTipoCuota] WHERE Tipo_Cuota='".$d1."' AND Des_Tipo_Cuota='".$d2."'");
                        if (!mssql_num_rows($query2)) {
                            $sqlv = "INSERT INTO [sqlFacturas].[dbo].[facTipoCuota](Tipo_Cuota,Des_Tipo_Cuota,Col_Campo_Buscar,Des_Campo_Buscar,Orden)
                            VALUES('$d1','$d2','$d3','$d4','$d5')"; 
                            mssql_query($sqlv,$cLink);
                        }  
                    }
                    
                 
echo "Completado...";                   
odbc_close($result);
mssql_close();
?>