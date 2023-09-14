<?php
//require_once('user_con.php');
include('conectarbase.php');
$grupo=$_GET['g'];
$manejador=$_GET['m'];
$categoria=$_GET['c'];
                
        $query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infPeriodosAcumulados] WHERE CTPPGN='".$grupo."'");
        if (!mssql_num_rows($query)) {
            $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[infPeriodosAcumulados](CTPPGN,RESPONSABLE,DESCRIPCION) VALUES('$grupo','$manejador','$categoria')"; 
            mssql_query($sqlv,$cLink);
            echo "Grupo ".$grupo." Guardado.";   
        }else{
            $sqlv = "UPDATE [InformesCompVentas].[dbo].[infPeriodosAcumulados] SET RESPONSABLE='$manejador', DESCRIPCION='$categoria' WHERE CTPPGN='".$grupo."'"; 
            mssql_query($sqlv,$cLink);
            echo "Grupo ".$grupo." Actualizado.";
        }
                             
             
        mssql_close();

?>