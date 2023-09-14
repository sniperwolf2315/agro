<?php
$usuario=trim($_GET['u']);
$usuario=strtoupper($usuario);
$clave=trim($_GET['c']);
$clave=strtoupper($clave);
$pw=md5($clave);
$Acceso1='';
$Acceso2='';
            require_once('conexionFacturas.php');
            $resultusuY = mssql_query("SELECT IdFuncionario FROM [sqlFacturas].[dbo].[autFuncionario] where login ='$usuario'", $cLinkf);
            $fila2 = mssql_fetch_array($resultusuY);
            $IdFunc=$fila2['IdFuncionario'];
            //****
            require_once('conexioninventario80.php');
            //$resultusu = mssql_query("SELECT * FROM [sqlInventario008].[dbo].[invAcceso] WHERE idUsu='$usuario' AND pasw='$pw' AND tipous='A'", $cLink);
            $resultusu = mssql_query("SELECT * FROM [sqlInventario008].[dbo].[invAcceso] WHERE idUsu='$IdFunc' AND pasw='$pw' AND tipous='A'", $cLink);
            $fila = mssql_fetch_array($resultusu);
            $numero = mssql_num_rows($resultusu);
            if ($numero>0){
                $Acceso1=$fila['acceso1'];
                $Acceso2=$fila['acceso2'];
            }
           echo $Acceso1.'^'.$Acceso2;
mssql_close($resultusu);
mssql_close($resultusuY);
?>