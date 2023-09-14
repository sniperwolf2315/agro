<?php
require_once('conectarbasepruebas.php');
$botonp=$_GET['btp'];
$titulo=$_GET['t'];
$d3=$_GET['u'];
$d4=$_GET['n'];
$d5=$_GET['c'];
$r2=$r2."<table>";
$r2=$r2."<tr style='background-color: #53B998;'><td>boton: $titulo</td><td>Activar</td><td>Desactivar</td></tr>";
$resultSqlS = mssql_query("SELECT Id, boton, identificador FROM [InformesCompVentas].[dbo].[botonreports] WHERE left(identificador,1)='$botonp'");
$b=1;
//6FBEA4
while($resultadoS = mssql_fetch_array($resultSqlS)){
    if(($b%2)==0){
        $color2="#A5E1CE";
    }else{
        $color2="#94C9B8";
    }
    $btId=$resultadoS["Id"];
    $btn=$resultadoS["boton"];
    $idbtn=$resultadoS["identificador"];
    $r2=$r2."<tr style='background-color: $color2;' >";
    $r2=$r2."<td>";
    $r2=$r2.$btn;                                    
    $r2=$r2."</td>";
    $r2=$r2."<td>";
    $r2=$r2."&nbsp;<input type=button id=\"$idbtn\" name=\"$btn\" onclick=\"buscarBotonesSec(this.id,this.name,'A','$d3','$d4','$d5','S');\" name=1 value=A>&nbsp;";                                     
    $r2=$r2."</td>";
    $r2=$r2."<td>";
    $r2=$r2."&nbsp;<input type=button id=\"$idbtn\" name=\"$btn\" onclick=\"buscarBotonesSec(this.id,this.name,'D','$d3','$d4','$d5','S');\" name=1 value=D>&nbsp;";                                     
    $r2=$r2."</td>";
    $r2=$r2."</tr>";
    $b++;
}
mssql_close();
echo $r2;
?>