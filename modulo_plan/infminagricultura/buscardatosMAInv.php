<?php
//require_once('../user_con.php');
//require_once('user_con.php');
//$ano=trim($_GET['ano']);
//$mes=trim($_GET['mes']);
//$di=trim($_GET['di']);
//$df=trim($_GET['df']);
include('conectarbase.php');
//borra la tabla 
$queryBorra = mssql_query("DELETE FROM [InformesCompVentas].[dbo].[MinAgriculturaInforme]");
if (mssql_num_rows($queryBorra)) {
    echo "Tabla limpiada";   
}
//$periodoi=$anio.$mes.$di;
//$periodof=$anio.$mes.$df;                                  
$i=0;
//ITEMS autorizados BASE AG
$resultSQL = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[InfItemsMinAgricultura] ORDER BY Manejador desc");
while($resultado = mssql_fetch_array($resultSQL)){
    $item=$resultado["Item"];
    $item=trim($item);    
    $mane=$resultado["Manejador"];
    $mane=trim($mane);  
    //TRANSFIERE INVENTARIO YA SUBIDO
    $resultSQLCat = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[InfMinAgricultura] WHERE Item='$item' AND Manejador='$mane'");
    while($resultadocat = mssql_fetch_array($resultSQLCat)){
        $Existen=$resultadocat["Existen"];
        $Bodega=$resultadocat["Bodega"];
        $query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[MinAgriculturaInforme] WHERE Item='".$item."' AND Manejador='".$mane."' AND Bodega='".$Bodega."'");
        if (!mssql_num_rows($query)) {
            $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[MinAgriculturaInforme](Item,Manejador,Bodega,InvFinal,CantVendida,PromVenta)VALUES('$item','$mane','$Bodega','$Existen','','')"; 
            mssql_query($sqlv,$cLink);
        }
    }  
}
mssql_close();  
?>