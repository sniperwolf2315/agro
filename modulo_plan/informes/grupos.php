<?php
//require_once('user_con.php');
include('conectarbase.php');
$grupo=$_GET['g'];
$manejador=$_GET['m'];
$categoria=$_GET['c'];
$rsocial=$_GET['d'];
                
        $query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infPeriodosAcumulados] WHERE CTPPGN='".$grupo."'");
        if (!mssql_num_rows($query)) {
            $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[infPeriodosAcumulados](CTPPGN,CTPPGD,RESPONSABLE,DESCRIPCION) VALUES('$grupo','$rsocial','$manejador','$categoria')"; 
            mssql_query($sqlv,$cLink);
            echo "Grupo ".$grupo." Guardado.";   
        }else{
            $sqlv = "UPDATE [InformesCompVentas].[dbo].[infPeriodosAcumulados] SET CTPPGD='$rsocial', RESPONSABLE='$manejador', DESCRIPCION='$categoria' WHERE CTPPGN='".$grupo."'"; 
            mssql_query($sqlv,$cLink);
            echo "Grupo ".$grupo." Actualizado.";
        }
                             
             
        mssql_close();

?>