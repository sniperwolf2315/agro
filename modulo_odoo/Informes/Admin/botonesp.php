<?php
include('conectarbasepruebas.php');
$resultSqlP = mssql_query("SELECT Id, boton, identificador FROM [InformesCompVentas].[dbo].[botonreportp]");
    while($resultadoP = mssql_fetch_array($resultSqlP)){
        $btId=$resultadoP["Id"];
        $btn=$resultadoP["boton"];
        $idbtn=$resultadoP["identificador"];
        echo "<input type=\"checkbox\" id=\"$btId\" name=\"$btId\" />&nbsp;$btn";
}
?>