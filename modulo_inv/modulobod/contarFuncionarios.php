<?php
$anio=trim($_GET['a']);
$mes=trim($_GET['m']);
include('conectarbase.php');
$d1=0;
//SELECT count(distinct(s.Responsable)) as cantFuncionarios FROM [sqlFacturas].[dbo].[facRegistroSeparacion] s left join [sqlFacturas].[dbo].[facRegistroValidacion] v ON s.Orden=v.Orden WHERE (YEAR(v.HoraFinal)='2021' AND MONTH(v.HoraFinal)='03') AND v.TipoFactura IN ('07','S2','FD','F1','D4')
$resultSQLItemsc = mssql_query("SELECT count(distinct(s.Responsable)) as cantFuncionarios FROM [sqlFacturas].[dbo].[facRegistroSeparacion] s left join [sqlFacturas].[dbo].[facRegistroValidacion] v ON s.Orden=v.Orden WHERE (YEAR(v.HoraFinal)='".$anio."' AND MONTH(v.HoraFinal)='".$mes."') AND v.TipoFactura IN ('07','S2','FD','F1','D4')",$cLink);
if($resultadoitemsc = mssql_fetch_array($resultSQLItemsc)){
    $d1=$resultadoitemsc["cantFuncionarios"];
}
mssql_close();
echo $d1;
?>