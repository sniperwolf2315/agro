<?php
//require_once('../user_con.php');
//require_once('user_con.php');
//$ano=trim($_GET['ano']);
//$mes=trim($_GET['mes']);
//$di=trim($_GET['di']);
//$df=trim($_GET['df']);
require_once('user_con.php');
include('conectarbase.php');
//$periodoi=$anio.$mes.$di;
//$periodof=$anio.$mes.$df;                                  
//$i=0;
//ITEMS autorizados BASE AG
/*$resultSQL = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[InfItemsMinAgricultura] ORDER BY Manejador desc");
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
}*/
//mssql_close();  
//sleep(10);
//CONSULTA LAS VENTAS EN IBS
//include('conectarbase.php');
//query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infVentasSinIva]");
//$query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infVentasIbs] WHERE PERIODO='".$periodo."'");
//while($row=mssql_num_rows($query)) {
//$r=$row2=mssql_num_rows($query);
$resultSQLIBS = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[MinAgriculturaInforme]");
while($resultado = mssql_fetch_array($resultSQLIBS)){
    $itemQ=$resultado["Item"];
    $itemQ=trim($itemQ);
    $item=str_replace("Q","",$itemQ);
    $item=trim($item);    
    $mane=$resultado["Manejador"];
    $mane=trim($mane);  
    $bode=$resultado["Bodega"];
    $bode=trim($bode);
        //SUM(IDITET)/SUM(IDQTY)
        $conta++;                        
        $sql = "SELECT VENTASAG.ITEM, VENTASAG.BODEGA, VENTASAG.MANEJADOR, SUM(VENTASAG.CANTIDAD) AS CANTIDADV, (SUM(VENTASAG.VLR_EXC_IVA)/SUM(VENTASAG.CANTIDAD)) AS VALOR";
        $sql = $sql. " FROM AGR620CFAG.VISINFMINAGR VENTASAG";
        $sql = $sql. " WHERE VENTASAG.ITEM='".$item."' AND VENTASAG.BODEGA='".$bode."' AND VENTASAG.MANEJADOR='".$mane."'";
        $sql = $sql. " GROUP BY VENTASAG.ITEM,VENTASAG.BODEGA,VENTASAG.MANEJADOR";
                    $result3 = odbc_exec($db2con, $sql);
                    //if($row = odbc_fetch_array($result)){
                    if($row = odbc_fetch_array($result3)){
                        $dv5 = $row['CANTIDADV'];
                        $dv6 = $row['VALOR'];
                        //divide el valor en la cantidad (valunit)
                        //$valor=$dv6/$dv5;
                        //$dv1=trim($dv1);
                        $query2 = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[MinAgriculturaInforme] WHERE Item='".$itemQ."' AND Bodega='".$bode."' AND Manejador='".$mane."'");
                        if (mssql_num_rows($query2)) {
                            $sqlv= "UPDATE [InformesCompVentas].[dbo].[MinAgriculturaInforme] SET CantVendida='$dv5', PromVenta='$dv6' WHERE Item='".$itemQ."' AND Bodega='".$bode."' AND Manejador='".$mane."'";
                            mssql_query($sqlv,$cLink);
                        }
                    }  
}
odbc_close($result);
mssql_close();

?>