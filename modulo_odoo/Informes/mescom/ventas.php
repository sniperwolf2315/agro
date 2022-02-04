<?php  
//***VENTAS****
$periodo='202109';
$fecha = date("Y-m-d h:i:s");

//require_once('user_con.php');
//base sqlServer produccion
require_once('conectarbaseprod.php');

$areax= array("VENTA EXTERNA","CONCENTRADOS","GATOS","MOSTRADOR","IMPORTADOS","SEMILLAS  Y FERRETERIA","VACUNACION","CANALES DIGITALES","PEQUEÑOS");

$num1=count($areax);

$n=0;

while($n < $num1){
    $area=$areax[$n];
    $queryv = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[cliVendedor] WHERE SectorLab='$area' AND Activo=1 ORDER BY SectorLab ASC;", $cLink);
    while($row1 = mssql_fetch_array($queryv)){
        $vend = trim($row1['Codigo']);
        $area = trim($row1['SectorLab']);
        $nomb = trim($row1['Apellidos'])." ".trim($row1['Nombres']);
        $cuotagen=0;
        $Venta=0;
        //VENTAS GENERALES
        $queryventas = mssql_query("
          SELECT Vendedor, SUM(ValorSinIVA) as Venta
          FROM [sqlFacturas].[dbo].[facDetalleFactura] f
          join [sqlFacturas].[dbo].[agrPeriodo] p ON f.FechaOrden >=CONVERT(VARCHAR, p.FechaIni) AND FechaOrden <=CONVERT(VARCHAR, p.FechaFin) 
         WHERE p.Codigo='$periodo' AND f.Vendedor='$vend' --AND f.Call='VANANDELL' AND f.Manejador='VANANDELL'
         GROUP BY f.Vendedor;");
        //$queryventas = mssql_query("SELECT ValorSinIVA FROM [sqlFacturas].[dbo].[facDetalleFactura] WHERE Vendedor='$vend' AND Call='VANANDELL' AND Manejador='VANANDELL';", $cLink);
        $num=mssql_num_rows($queryventas);
        if($num > 0){
            if($rowv = mssql_fetch_array($queryventas)){
                //$Vendedor = trim($rowv['Vendedor']);
                $Venta = trim($rowv['Venta']);
                //SQL SERVER
                if(trim($vend) == "VENDOTC" || trim($vend) == "SUAREZC" || trim($vend) == "CASTILLOW" || trim($vend) == "VEND999"){
                    $query2 = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='".$vend."' AND Area='".$area."' AND SectorLab='-' AND Periodo='".$periodo."'");
                }else{
                    $query2 = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='".$vend."' AND Area='".$area."' AND SectorLab='TODO' AND Periodo='".$periodo."'");
                }
                if (!mssql_num_rows($query2)) {
                    //$sqlv = "INSERT INTO [sqlFacturas].[dbo].[facInfcomercial](Periodo,Fecha,Area,codVend,nomVend,tipoCuota,Cuotagen,SectorLab,Cuota,CuotaObj,Venta,VentaObj,VentaCont,VentaCred,VentaMixt,NotasCrCont,NotasCrCred,NotasCrMixt,NotaDebito,NotasdCobra,Subtotal,DistriBolsa,Total,Falta,DifTotMix,Obs)
                    //VALUES('$periodo','$fecha','$area','$vend','$nomb','$tipoc','$cuotagen','-','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','-')"; 
                    //mssql_query($sqlv,$cLink);
                }else{
                    if(trim($vend) == "VENDOTC" || trim($vend) == "SUAREZC" || trim($vend) == "CASTILLOW" || trim($vend) == "VEND999"){
                        $sqlv = "UPDATE [sqlFacturas].[dbo].[facInfcomercial] SET Venta='$Venta' WHERE codVend='".$vend."' AND Area='".$area."' AND SectorLab='-' AND Periodo='".$periodo."'";
                    }else{
                        $sqlv = "UPDATE [sqlFacturas].[dbo].[facInfcomercial] SET Venta='$Venta' WHERE codVend='".$vend."' AND Area='".$area."' AND SectorLab='TODO' AND Periodo='".$periodo."'";
                    }
                    //echo $sqlv."</br>";
                    mssql_query($sqlv,$cLink);
                }
            }
        }
       
        //VENTAS POR LABORATORIOS
        $querylab = mssql_query("SELECT Tipo_Cuota, Col_Campo_Buscar, Des_Campo_Buscar, Sectorlab FROM [sqlFacturas].[dbo].[facTipoCuota] WHERE Sectorlab!='-';", $cLink);
        while($rowlab = mssql_fetch_array($querylab)){
            $tipoCuota = trim($rowlab['Tipo_Cuota']);
            $laborator = trim($rowlab['Sectorlab']);
            $campobusqueda = trim($rowlab['Col_Campo_Buscar']);
            $desclaborator = trim($rowlab['Des_Campo_Buscar']);
            
            //laboratorio NORMALES
            if($desclaborator!='FERRETERIA' && $desclaborator!='VARIOS' && $desclaborator!='CONCENTRADOS' && $desclaborator!='MASCOTAS' && $desclaborator!='MEDICAMENTOS' && $desclaborator!='AGROQUIMICOS / VENENOS'){
                    $queryventasLab = mssql_query("
                            SELECT 
								 sum(ValorSinIVA) as Venta
                                  FROM [sqlFacturas].[dbo].[facDetalleFactura] f
                                  join [sqlFacturas].[dbo].[agrPeriodo] p ON f.FechaOrden >=CONVERT(VARCHAR, p.FechaIni) AND FechaOrden <=CONVERT(VARCHAR, p.FechaFin) 
                                WHERE p.Codigo='$periodo' 
								and Vendedor='$vend'  AND ($campobusqueda= '$desclaborator')
                            ");
                            
            } else if($desclaborator=='VARIOS'){
                    $queryventasLab = mssql_query("
                            SELECT 
								 sum(ValorSinIVA) as Venta
                                  FROM [sqlFacturas].[dbo].[facDetalleFactura] f
                                  join [sqlFacturas].[dbo].[agrPeriodo] p ON f.FechaOrden >=CONVERT(VARCHAR, p.FechaIni) AND FechaOrden <=CONVERT(VARCHAR, p.FechaFin) 
                                WHERE p.Codigo='$periodo' 
								and Vendedor='$vend' AND FAMILIA IN ('VARIOS','PROMOCIONALES') 
                            ");
            
            } else {
                    $queryventasLab = mssql_query("
                            SELECT 
								 sum(ValorSinIVA) as Venta
                                  FROM [sqlFacturas].[dbo].[facDetalleFactura] f
                                  join [sqlFacturas].[dbo].[agrPeriodo] p ON f.FechaOrden >=CONVERT(VARCHAR, p.FechaIni) AND FechaOrden <=CONVERT(VARCHAR, p.FechaFin) 
                                WHERE p.Codigo='$periodo' 
								and Vendedor='$vend'  AND ($campobusqueda= '$desclaborator')
                                AND Grupo NOT IN('BIS','INT','CPH','ICO','HOL','TEC','BAI')
                            ");
            }
            $num=mssql_num_rows($queryventasLab);
            $Venta=0;
            if($num > 0){
                if($rowv = mssql_fetch_array($queryventasLab)){
                    //$Vendedor = trim($rowv['Vendedor']);
                    $Venta = trim($rowv['Venta']);
                    //trim($vend) == "VENDOTC" ||
                    if(trim($vend) == "SUAREZC" || trim($vend) == "CASTILLOW" || trim($vend) == "VEND999"){
                        $query2 = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='".$vend."' AND Area='".$area."' AND SectorLab='-' AND Periodo='".$periodo."'");
                    }else{
                        $query2 = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='".$vend."' AND Area='".$area."' AND SectorLab='$desclaborator' AND Periodo='".$periodo."'");
                    }
                    if (!mssql_num_rows($query2)) {
                        //$sqlv = "INSERT INTO [sqlFacturas].[dbo].[facInfcomercial](Periodo,Fecha,Area,codVend,nomVend,tipoCuota,Cuotagen,SectorLab,Cuota,CuotaObj,Venta,VentaObj,VentaCont,VentaCred,VentaMixt,NotasCrCont,NotasCrCred,NotasCrMixt,NotaDebito,NotasdCobra,Subtotal,DistriBolsa,Total,Falta,DifTotMix,Obs)
                        //VALUES('$periodo','$fecha','$area','$vend','$nomb','$tipoc','$cuotagen','-','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','-')"; 
                        //mssql_query($sqlv,$cLink);
                    }else{
                        //trim($vend) == "VENDOTC" ||
                        if(trim($vend) == "SUAREZC" || trim($vend) == "CASTILLOW" || trim($vend) == "VEND999"){
                            $sqlv = "UPDATE [sqlFacturas].[dbo].[facInfcomercial] SET Venta='$Venta' WHERE codVend='".$vend."' AND Area='".$area."' AND SectorLab='-' AND Periodo='".$periodo."'";
                        }else{
                            $sqlv = "UPDATE [sqlFacturas].[dbo].[facInfcomercial] SET Venta='$Venta' WHERE codVend='".$vend."' AND Area='".$area."' AND SectorLab='$desclaborator' AND Periodo='".$periodo."'";
                        }
                        //echo $sqlv."</br>";
                        mssql_query($sqlv,$cLink);
                    }
                }
            }
        ////
        }
    }  
$n++;
}       

echo "Completado1...";     

//TELEOPERADORES
$area="TELEOPERADOR";
    
$querylab = mssql_query("SELECT Col_Campo_Buscar, Des_Campo_Buscar, Sectorlab FROM [sqlFacturas].[dbo].[facTipoCuota] WHERE Sectorlab!='-' AND Sectorlab!='Total';", $cLink);
while($rowlab = mssql_fetch_array($querylab)){
    $tipoBusqueda = trim($rowlab['Col_Campo_Buscar']);
    $descBusqueda = trim($rowlab['Des_Campo_Buscar']);
    $laborator = trim($rowlab['Sectorlab']);
    
    $queryv = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[cliVendedor] WHERE SectorLab='$area' AND Activo=1;", $cLink);
    while($row1 = mssql_fetch_array($queryv)){
        $vend = trim($row1['Codigo']);
        $area = trim($row1['SectorLab']);
        $nomb = trim($row1['Apellidos'])." ".trim($row1['Nombres']);
        $cuotagen=0;
        $Venta=0;
        //VENTA EXTERNA VENTA GENERAL
        $VentaInd=0;
        $VentaObj=0;
        
        //echo "</br>".$vend."----".$area."---".$nomb;
        //VENTA INDIVIDUAL
        if($descBusqueda!='FERRETERIA' && $descBusqueda!='VARIOS' && $descBusqueda!='CONCENTRADOS' && $descBusqueda!='MASCOTAS' && $descBusqueda!='MEDICAMENTOS' && $descBusqueda!='AGROQUIMICOS / VENENOS'){
            $queryventaInd = mssql_query("
                        SELECT 
                         sum(ValorSinIVA) as VentaInd1
                                  FROM [sqlFacturas].[dbo].[facDetalleFactura] f
                                  join [sqlFacturas].[dbo].[agrPeriodo] p ON f.FechaOrden >=CONVERT(VARCHAR, p.FechaIni) AND FechaOrden <=CONVERT(VARCHAR, p.FechaFin) 
                                 WHERE p.Codigo='$periodo' 
								AND CALL IN ('$vend')
								 and ((Manejador IN ('ADMINISTRA', 'CALLCENTER')) OR (MANEJADOR IN ('VANANDELL') AND VENDEDOR IN('VEND114','VEND214'))) AND ($tipoBusqueda = '$descBusqueda') 
								GROUP BY CALL
                                ");
        
        } else if($descBusqueda=='VARIOS'){
            $queryventaInd = mssql_query("
                        SELECT 
                         sum(ValorSinIVA) as VentaInd1
                                  FROM [sqlFacturas].[dbo].[facDetalleFactura] f
                                  join [sqlFacturas].[dbo].[agrPeriodo] p ON f.FechaOrden >=CONVERT(VARCHAR, p.FechaIni) AND FechaOrden <=CONVERT(VARCHAR, p.FechaFin) 
                                 WHERE p.Codigo='$periodo' 
								AND CALL IN ('$vend')
								 and ((Manejador IN ('ADMINISTRA', 'CALLCENTER')) OR (MANEJADOR IN ('VANANDELL') AND VENDEDOR IN('VEND114','VEND214'))) AND FAMILIA IN ('VARIOS','PROMOCIONALES') 
								GROUP BY CALL
                                ");
        } else {
            $queryventaInd = mssql_query("
                        SELECT 
                         sum(ValorSinIVA) as VentaInd1
                                  FROM [sqlFacturas].[dbo].[facDetalleFactura] f
                                  join [sqlFacturas].[dbo].[agrPeriodo] p ON f.FechaOrden >=CONVERT(VARCHAR, p.FechaIni) AND FechaOrden <=CONVERT(VARCHAR, p.FechaFin)
                                 WHERE p.Codigo='$periodo' 
								AND CALL IN ('$vend')
								 and ((Manejador IN ('ADMINISTRA', 'CALLCENTER')) OR (MANEJADOR IN ('VANANDELL') AND VENDEDOR IN('VEND114','VEND214'))) AND ($tipoBusqueda = '$descBusqueda')
                                AND Grupo NOT IN('BIS','INT','CPH','ICO','HOL','TEC','BAI') 
								GROUP BY CALL
                                 ");
                        /*$queryConsulta=$vend." - SELECT 
                         sum(ValorSinIVA) as VentaInd1
                                  FROM [sqlFacturas].[dbo].[facDetalleFactura] f
                                  join [sqlFacturas].[dbo].[agrPeriodo] p ON f.FechaOrden >=CONVERT(VARCHAR, p.FechaIni) AND FechaOrden <=CONVERT(VARCHAR, p.FechaFin)
                                 WHERE p.Codigo='$periodo' 
								AND CALL IN ('$vend')
								 and ((Manejador IN ('ADMINISTRA', 'CALLCENTER')) OR (MANEJADOR IN ('VANANDELL') AND VENDEDOR IN('VEND114','VEND214'))) AND ($tipoBusqueda= '$descBusqueda')
                                AND Grupo NOT IN('BIS','INT','CPH','ICO','HOL','TEC','BAI') 
								GROUP BY CALL";*/
                        //echo $queryConsulta."</br></br>";
            
        }
        if($rowvI = mssql_fetch_array($queryventaInd)){
                $VentaInd = trim($rowvI['VentaInd1']);
        }
        
        //VENTA OBJETIVO
        
        if($descBusqueda!='FERRETERIA' && $descBusqueda!='VARIOS' && $descBusqueda!='CONCENTRADOS' && $descBusqueda!='MASCOTAS' && $descBusqueda!='MEDICAMENTOS' && $descBusqueda!='AGROQUIMICOS / VENENOS'){
            $queryventaObj = mssql_query("
                        SELECT 
                         sum(ValorSinIVA) as VentaObj
                                  FROM [sqlFacturas].[dbo].[facDetalleFactura] f
                                  join [sqlFacturas].[dbo].[agrPeriodo] p ON f.FechaOrden >=CONVERT(VARCHAR, p.FechaIni) AND FechaOrden <=CONVERT(VARCHAR, p.FechaFin) 
                                 WHERE p.Codigo='$periodo'
								AND CALL IN ('$vend')
								AND (Manejador IN ('VANANDELL') AND Vendedor NOT IN('VEND114','VEND214')) AND ($tipoBusqueda= '$descBusqueda')
								GROUP BY CALL
                        ");
        $XY="SELECT 
                         sum(ValorSinIVA) as VentaObj
                                  FROM [sqlFacturas].[dbo].[facDetalleFactura] f
                                  join [sqlFacturas].[dbo].[agrPeriodo] p ON f.FechaOrden >=CONVERT(VARCHAR, p.FechaIni) AND FechaOrden <=CONVERT(VARCHAR, p.FechaFin) 
                                 WHERE p.Codigo='$periodo'
								AND CALL IN ('$vend')
								AND (Manejador IN ('VANANDELL') AND Vendedor NOT IN('VEND114','VEND214')) AND ($tipoBusqueda= '$descBusqueda')
								GROUP BY CALL";
        //echo "</br><hr>".$XY;
        } else if($descBusqueda=='VARIOS'){
            $queryventaObj = mssql_query("
                        SELECT 
                         sum(ValorSinIVA) as VentaObj
                                  FROM [sqlFacturas].[dbo].[facDetalleFactura] f
                                  join [sqlFacturas].[dbo].[agrPeriodo] p ON f.FechaOrden >=CONVERT(VARCHAR, p.FechaIni) AND FechaOrden <=CONVERT(VARCHAR, p.FechaFin) 
                                 WHERE p.Codigo='$periodo'
								AND CALL IN ('$vend')
								AND (Manejador IN ('VANANDELL') AND Vendedor NOT IN('VEND114','VEND214')) AND FAMILIA IN ('VARIOS','PROMOCIONALES')
								GROUP BY CALL
                        ");
        } else {
            $queryventaObj = mssql_query("
                        SELECT 
                         sum(ValorSinIVA) as VentaObj
                                  FROM [sqlFacturas].[dbo].[facDetalleFactura] f
                                  join [sqlFacturas].[dbo].[agrPeriodo] p ON f.FechaOrden >=CONVERT(VARCHAR, p.FechaIni) AND FechaOrden <=CONVERT(VARCHAR, p.FechaFin) 
                                 WHERE p.Codigo='$periodo'
								AND CALL IN ('$vend')
								AND (Manejador IN ('VANANDELL') AND Vendedor NOT IN('VEND114','VEND214')) AND ($tipoBusqueda = '$descBusqueda')
                                AND Grupo NOT IN('BIS','INT','CPH','ICO','HOL','TEC','BAI') 
								GROUP BY CALL
                                ");
        }
        
        if($rowvO = mssql_fetch_array($queryventaObj)){
                $VentaObj = trim($rowvO['VentaObj']);
        }
        
        
        /*if($vend=='VEND481'){
            echo "</br></br>valorObjeitivo:".$VentaObj;
        }*/
        
                
        //SQL SERVER
                if($VentaInd=='-'){$VentaInd=0;}
                if($VentaObj=='-'){$VentaObj=0;}
                //actualiza venta individual*****
                $query2 = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='".$vend."' AND Area='".$area."' AND tipoCuota='Cuota Laboratorio' AND sectorLab = '$descBusqueda' AND Periodo='".$periodo."'");
                $zxx="SELECT * FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='".$vend."' AND Area='".$area."' AND tipoCuota='Cuota Laboratorio' AND sectorLab = '$descBusqueda' AND Periodo='".$periodo."'";
                //echo "</br><hr><hr>".$zxx;
                //echo "<hr>"."$vend SELECT * FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='".$vend."' AND Area='".$area."' AND tipoCuota='Cuota Laboratorio' AND sectorLab = '$descBusqueda' AND Periodo='".$periodo."'<hr>";
                if (!mssql_num_rows($query2)) {
                    //$sqlv = "INSERT INTO [sqlFacturas].[dbo].[facInfcomercial](Periodo,Fecha,Area,codVend,nomVend,tipoCuota,Cuotagen,SectorLab,Cuota,CuotaObj,Venta,VentaObj,VentaCont,VentaCred,VentaMixt,NotasCrCont,NotasCrCred,NotasCrMixt,NotaDebito,NotasdCobra,Subtotal,DistriBolsa,Total,Falta,DifTotMix,Obs)
                    //VALUES('$periodo','$fecha','$area','$vend','$nomb','$tipoc','$cuotagen','-','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','-')"; 
                    //mssql_query($sqlv,$cLink);
                }else{
                    $sqlv = "UPDATE [sqlFacturas].[dbo].[facInfcomercial] SET Venta='$VentaInd' WHERE codVend='".$vend."' AND Area='".$area."' AND tipoCuota='Cuota Laboratorio' AND sectorLab = '$descBusqueda' AND Periodo='".$periodo."'";
                    mssql_query($sqlv,$cLink);
                    //echo "</br><hr>".$sqlv;
                }
                
                //actualiza venta objetivo*******
                $query3 = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='".$vend."' AND Area='".$area."' AND tipoCuota='Cuota Laboratorio' AND sectorLab = '$descBusqueda' AND Periodo='".$periodo."'");
                if (!mssql_num_rows($query3)) {
                    //$sqlv = "INSERT INTO [sqlFacturas].[dbo].[facInfcomercial](Periodo,Fecha,Area,codVend,nomVend,tipoCuota,Cuotagen,SectorLab,Cuota,CuotaObj,Venta,VentaObj,VentaCont,VentaCred,VentaMixt,NotasCrCont,NotasCrCred,NotasCrMixt,NotaDebito,NotasdCobra,Subtotal,DistriBolsa,Total,Falta,DifTotMix,Obs)
                    //VALUES('$periodo','$fecha','$area','$vend','$nomb','$tipoc','$cuotagen','-','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','-')"; 
                    //mssql_query($sqlv,$cLink);
                }else{
                    $sqlvo = "UPDATE [sqlFacturas].[dbo].[facInfcomercial] SET VentaObj='$VentaObj' WHERE codVend='".$vend."' AND Area='".$area."' AND tipoCuota='Cuota Laboratorio' AND sectorLab = '$descBusqueda' AND Periodo='".$periodo."'";
                    mssql_query($sqlvo,$cLink);
                    //echo "</br><hr>".$sqlvo;
                }
            
           /* }*/
        //}
    }  
     
}                 
echo "Completado2...";    


//*******************************************************************************************************

//VENDEDORE 999 Y CASTILLOW AREA OTROS

$area="OTROS";
$querylab = mssql_query("SELECT Col_Campo_Buscar, Des_Campo_Buscar, Sectorlab FROM [sqlFacturas].[dbo].[facTipoCuota] WHERE Sectorlab!='-' AND Sectorlab!='Total';", $cLink);
while($rowlab = mssql_fetch_array($querylab)){
    $tipoBusqueda = trim($rowlab['Col_Campo_Buscar']);
    $laborator = trim($rowlab['Sectorlab']);
    $desclaborator = trim($rowlab['Des_Campo_Buscar']);
    
    $queryv = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[cliVendedor] WHERE SectorLab='$area' AND Activo=1;", $cLink);
    while($row1 = mssql_fetch_array($queryv)){
            $vend = trim($row1['Codigo']);
            $area = trim($row1['SectorLab']);
            $nomb = trim($row1['Apellidos'])." ".trim($row1['Nombres']);
            $cuotagen=0;
            $Venta=0;
            
            if($desclaborator!='FERRETERIA' && $desclaborator!='VARIOS' && $desclaborator!='CONCENTRADOS' && $desclaborator!='MASCOTAS' && $desclaborator!='MEDICAMENTOS' && $desclaborator!='AGROQUIMICOS / VENENOS'){
                //laboratorios normales
                $querylab2 = mssql_query("
                SELECT 
                       CONVERT(INT, SUM(valorSinIva)) as VentaIndX
                       FROM [sqlFacturas].[dbo].[facDetalleFactura] f
                       join [sqlFacturas].[dbo].[agrPeriodo] p ON f.FechaOrden >=CONVERT(VARCHAR, p.FechaIni) AND FechaOrden <=CONVERT(VARCHAR, p.FechaFin) 
                       WHERE p.Codigo='$periodo'
                AND f.Vendedor='$vend' AND f.Sector NOT IN('CALLCENTER') and f.bodega NOT IN('008') and $tipoBusqueda='$desclaborator' 
                ", $cLink);
            } else if($desclaborator=='VARIOS') {
                //varios
                $querylab2 = mssql_query("
                SELECT 
                       CONVERT(INT, SUM(valorSinIva)) as VentaIndX
                       FROM [sqlFacturas].[dbo].[facDetalleFactura] f
                       join [sqlFacturas].[dbo].[agrPeriodo] p ON f.FechaOrden >=CONVERT(VARCHAR, p.FechaIni) AND FechaOrden <=CONVERT(VARCHAR, p.FechaFin) 
                       WHERE p.Codigo='$periodo' 
                and f.Vendedor='$vend' AND FAMILIA IN ('VARIOS','PROMOCIONALES') AND f.Sector NOT IN('CALLCENTER') and f.bodega NOT IN('008')
                ", $cLink);
                
            } else {
                //laboratorios raros
                $querylab2 = mssql_query("
                SELECT 
                       CONVERT(INT, SUM(valorSinIva)) as VentaIndX
                       FROM [sqlFacturas].[dbo].[facDetalleFactura] f
                       join [sqlFacturas].[dbo].[agrPeriodo] p ON f.FechaOrden >=CONVERT(VARCHAR, p.FechaIni) AND FechaOrden <=CONVERT(VARCHAR, p.FechaFin) 
                       WHERE p.Codigo='$periodo'
                and Vendedor='$vend'  AND ($tipoBusqueda= '$desclaborator')
                AND f.Grupo NOT IN('BIS','INT','CPH','ICO','HOL','TEC','BAI') AND f.Sector NOT IN('CALLCENTER') and f.bodega NOT IN('008')
                ", $cLink);
            }
            
           while($rowVen = mssql_fetch_array($querylab2)){
                    $VentaInd = trim($rowVen['VentaIndX']);
                    $query2 = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='".$vend."' AND Area='".$area."' AND tipoCuota='Cuota Laboratorio' AND sectorLab='$desclaborator'  AND sectorLab!='-' AND Periodo='".$periodo."'");
                    if (!mssql_num_rows($query2)) {
                        //$sqlv = "INSERT INTO [sqlFacturas].[dbo].[facInfcomercial](Periodo,Fecha,Area,codVend,nomVend,tipoCuota,Cuotagen,SectorLab,Cuota,CuotaObj,Venta,VentaObj,VentaCont,VentaCred,VentaMixt,NotasCrCont,NotasCrCred,NotasCrMixt,NotaDebito,NotasdCobra,Subtotal,DistriBolsa,Total,Falta,DifTotMix,Obs)
                        //VALUES('$periodo','$fecha','$area','$vend','$nomb','$tipoc','$cuotagen','-','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','-')"; 
                        //mssql_query($sqlv,$cLink);
                    }else{
                        $sqlv = "UPDATE [sqlFacturas].[dbo].[facInfcomercial] SET Venta='$VentaInd' WHERE codVend='".$vend."' AND Area='".$area."' AND tipoCuota='Cuota Laboratorio' AND sectorLab='$desclaborator' AND sectorLab!='-' AND Periodo='".$periodo."'";
                        mssql_query($sqlv,$cLink);
                    }
            }
    
    } 

}

echo "Completado3..."; 

////////////////////FELIPE BARON vend157
$area="OTROS2";
    
/*$querylab = mssql_query("SELECT Col_Campo_Buscar, Des_Campo_Buscar, Sectorlab FROM [sqlFacturas].[dbo].[facTipoCuota] WHERE Sectorlab!='-' AND Sectorlab!='Total';", $cLink);
while($rowlab = mssql_fetch_array($querylab)){
    $tipoBusqueda = trim($rowlab['Col_Campo_Buscar']);
    $descBusqueda = trim($rowlab['Des_Campo_Buscar']);
    $laborator = trim($rowlab['Sectorlab']);
 */   
    $queryv = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[cliVendedor] WHERE SectorLab='$area' AND Activo=1;", $cLink);
    while($row1 = mssql_fetch_array($queryv)){
        $vend = trim($row1['Codigo']);
        $area = trim($row1['SectorLab']);
        $nomb = trim($row1['Apellidos'])." ".trim($row1['Nombres']);
        $cuotagen=0;
        $Venta=0;
        //VENTA EXTERNA VENTA GENERAL
        $VentaInd=0;
        $VentaObj=0;
        
        //VENTA INDIVIDUAL
        //laboratorios NORMALES VEND157
        if(substr($vend,-4,4)!='PEST'){
            
             $queryventaInd = mssql_query("SELECT 
                           CONVERT(INT, SUM(valorSinIva)) as VentaIndX
                           FROM [sqlFacturas].[dbo].[facDetalleFactura] f
                           join [sqlFacturas].[dbo].[agrPeriodo] p ON f.FechaOrden >=CONVERT(VARCHAR, p.FechaIni) AND FechaOrden <=CONVERT(VARCHAR, p.FechaFin) 
                           WHERE p.Codigo='$periodo'
                            AND f.Vendedor='$vend'
             ");
          $XX="SELECT 
                           CONVERT(INT, SUM(valorSinIva)) as VentaIndX
                           FROM [sqlFacturas].[dbo].[facDetalleFactura] f
                           join [sqlFacturas].[dbo].[agrPeriodo] p ON f.FechaOrden >=CONVERT(VARCHAR, p.FechaIni) AND FechaOrden <=CONVERT(VARCHAR, p.FechaFin) 
                           WHERE p.Codigo='$periodo'
                            AND f.Vendedor='$vend'";
          echo "</br>".$XX;      
            
            
        } else {
            $queryventaInd = mssql_query("SELECT 
                           CONVERT(INT, SUM(valorSinIva)) as VentaIndX
                           FROM [sqlFacturas].[dbo].[facDetalleFactura] f
                           join [sqlFacturas].[dbo].[agrPeriodo] p ON f.FechaOrden >=CONVERT(VARCHAR, p.FechaIni) AND FechaOrden <=CONVERT(VARCHAR, p.FechaFin) 
                           WHERE p.Codigo='$periodo'
                           AND f.Cedula='900423563'
            ");
            $YY="SELECT 
                           CONVERT(INT, SUM(valorSinIva)) as VentaIndX
                           FROM [sqlFacturas].[dbo].[facDetalleFactura] f
                           join [sqlFacturas].[dbo].[agrPeriodo] p ON f.FechaOrden >=CONVERT(VARCHAR, p.FechaIni) AND FechaOrden <=CONVERT(VARCHAR, p.FechaFin) 
                           WHERE p.Codigo='$periodo'
                           AND f.Cedula='900423563'";
             echo "</br>".$YY; 
        }
        
        if($rowvI = mssql_fetch_array($queryventaInd)){
                $VentaInd = trim($rowvI['VentaIndX']);
        }
                       
                //SQL SERVER
                if($VentaInd=='-'){$VentaInd=0;}
                //if($VentaObj=='-'){$VentaObj=0;}
                //actualiza venta individual*****
                $query2 = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='".$vend."' AND Area='".$area."' AND tipoCuota='Cuota Laboratorio' AND sectorLab = 'TODO' AND Periodo='".$periodo."'");
                //echo "<hr>"."$vend SELECT * FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='".$vend."' AND Area='".$area."' AND tipoCuota='Cuota Laboratorio' AND sectorLab = '$descBusqueda' AND Periodo='".$periodo."'<hr>";
                if (!mssql_num_rows($query2)) {
                    //$sqlv = "INSERT INTO [sqlFacturas].[dbo].[facInfcomercial](Periodo,Fecha,Area,codVend,nomVend,tipoCuota,Cuotagen,SectorLab,Cuota,CuotaObj,Venta,VentaObj,VentaCont,VentaCred,VentaMixt,NotasCrCont,NotasCrCred,NotasCrMixt,NotaDebito,NotasdCobra,Subtotal,DistriBolsa,Total,Falta,DifTotMix,Obs)
                    //VALUES('$periodo','$fecha','$area','$vend','$nomb','$tipoc','$cuotagen','-','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','-')"; 
                    //mssql_query($sqlv,$cLink);
                }else{
                    $sqlv = "UPDATE [sqlFacturas].[dbo].[facInfcomercial] SET Venta='$VentaInd' WHERE codVend='".$vend."' AND Area='".$area."' AND tipoCuota='Cuota Laboratorio' AND sectorLab = 'TODO' AND Periodo='".$periodo."'";
                    mssql_query($sqlv,$cLink);
                }
                
                
        
    }  
     
//}

echo "Completado4...";  
   
$sqlcontado="EXECUTE [sqlFacturas].[dbo].FACINFORMEVENTAS ".$periodo;
mssql_query($sqlcontado,$cLink);
echo "Completado3...";         
//odbc_close($result);
mssql_close();

?>