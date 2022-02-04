<?php
$latitud=$_GET['lat'];
$longitud=$_GET['lon'];

include('conectarbasepruebas.php');

//$query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[ubicacionPcs]");
                      
//if (!mssql_num_rows($query)) {         
    /*$sqlv = "INSERT INTO [InformesCompVentas].[dbo].[ubicacionPcs](Ip ,Mac ,Usuario ,Latitud ,Longitud) 
    VALUES('','','','$latitud','$longitud')"; 
    mssql_query($sqlv,$cLink);
    */
$msqlINSERT = "INSERT INTO [sqlFacturasPestar].[dbo].[agrCoordenada] (Ip ,Mac ,Usuario ,Latitud ,Longitud) 
VALUES ('','','','$latitud','$longitud'); ";
mssql_query($msqlINSERT,$cLink);
 
//}
mssql_close();
echo "Datos Guardados.";        

?>