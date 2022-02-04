<?php
$compan=$_GET['c']; 
$datog='';
$cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message());
                           if($compan=='Agrocampo'){
                                $resultg = mssql_query("SELECT * FROM [sqlInventario008].[dbo].[invGrupoItem] WHERE Ejecutar='1'", $cLink);
                           }else if($compan=='Comervet'){
                                $resultg = mssql_query("SELECT * FROM [sqlInventarioComervet008].[dbo].[invGrupoItem] WHERE Ejecutar='1'", $cLink);
                           }
                           $datog= $datog."<option value=\"\"></option>";
                           while($filag = mssql_fetch_array($resultg)){
                                $Grupod=$filag['DESCRIPCION'];
                                $datog= $datog."<option value=\"$Grupod\">$Grupod</option>";
                           }
                           echo $datog;
                           mssql_close($resultg); 

?>