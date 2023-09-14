<?php
$ced=$_GET['c'];
$nom=$_GET['n'];
$usu=$_GET['u'];
$btn=$_GET['b'];
$tipomenu=$_GET['t'];
$estadomenu=$_GET['e'];
require_once('conectarbasepruebas.php');
if($tipomenu=='P'){
    $resultSqlS = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[usuariosReportodoo] WHERE IdUs='$ced' AND Usuario='$usu' AND MenuPri='$btn'");
}
if($tipomenu=='S'){
    $resultSqlS = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[usuariosReportodoo] WHERE IdUs='$ced' AND Usuario='$usu' AND MenuSec='$btn'");
}
$numero2 = mssql_num_rows($resultSqlS);

if($estadomenu=='A'){
    if($numero2 <= 0){
        //inserta dato
        if($tipomenu=='P'){
            $consulta2="INSERT INTO [InformesCompVentas].[dbo].[usuariosReportodoo] (IdUs,Nombre,Usuario,MenuPri,MenuSec) VALUES ('$ced','$nom','$usu','$btn','')";
        }
        if($tipomenu=='S'){
            echo "Cedula:".$ced;
            $consulta2="INSERT INTO [InformesCompVentas].[dbo].[usuariosReportodoo] (IdUs,Nombre,Usuario,MenuPri,MenuSec) VALUES ('$ced','$nom','$usu','','$btn')";
        }
        if($resultado1=mssql_query($consulta2)){
            echo "Datos actualizados";
        }
    }
}
if($estadomenu=='D'){
    if($numero2 > 0){
        $fila = mssql_fetch_array($resultSqlS);
        $id=$fila['Id'];
        if($tipomenu=='P'){
            $consulta2="DELETE FROM [InformesCompVentas].[dbo].[usuariosReportodoo] WHERE id='$id' AND MenuPri='$btn' ";
        }
        if($tipomenu=='S'){
            $consulta2="DELETE FROM [InformesCompVentas].[dbo].[usuariosReportodoo] WHERE id='$id' AND MenuSec='$btn'";
        }
        if($resultado1=mssql_query($consulta2)){
            echo "Datos actualizados";
        }
    }
}
mssql_close();
?>