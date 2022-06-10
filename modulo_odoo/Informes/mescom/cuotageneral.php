<?php
                                            //***CUOTA GENERAL***
require_once('user_conmes.php');
                                            // # BASE SQLSERVER PRODUCCION
require_once('conectarbaseprodmes.php');
$periodo       =$_GET['periodo']; //'202109';
$fec_desde     =$_GET['fd']; //'202109';
$fec_hasta     =$_GET['fh']; //'202109';
$tipo_consulta =$_GET['category']; //'202109';
$fecha         = date("Y-m-d h:i:s");
$fec_desde = substr(str_replace("-","",$fec_desde),0,6) ;
$fec_hasta = substr(str_replace("-","",$fec_hasta),0,6) ;




$sqlcontado="truncate table  [sqlFacturas].[dbo].[facInfcomercial]";
mssql_query($sqlcontado,$cLink);
                                        // # VENDEORES POR AREA
$queryv = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[cliVendedor] WHERE SectorLab != '' AND Activo=1 ORDER BY SectorLab ASC;", $cLink);


if($tipo_consulta ==='normal' ){
    $anexo_texto ="IDPER=$periodo" ;
}else if($tipo_consulta ==='rangos'){
    $anexo_texto ="IDPER between $fec_desde and $fec_hasta" ;
}
else{
    $anexo_texto ="IDPER= $periodo" ;
}



while($row1 = mssql_fetch_array($queryv)){
    $vend = trim($row1['Codigo']);
    $area = trim($row1['SectorLab']);
    $nomb = trim($row1['Apellidos'])." ".trim($row1['Nombres']);
    $cuotagen=0;
                                        // # CUOTA GENERAL
    $sqlIBS = "SELECT IDTCUOTA, IDVEND, IDPER, VCUOTA FROM AGR620CFAG.VENDCUOTA WHERE IDTCUOTA IN('CTGG','CTGO','CTDM') AND $anexo_texto AND IDVEND = '$vend'";   
    
    $result = odbc_exec($db2con, $sqlIBS);
    $num = odbc_num_rows($result);
    $PasaVendWeb=0;
    if($num > 0){
        while($row = odbc_fetch_array($result)){
            $cuotagen = trim($row['VCUOTA']);
            $tipocuot = trim($row['IDTCUOTA']);
            if($cuotagen==NULL || $cuotagen==''){
                $cuotagen=0;
            }
            if($tipocuot=='CTGG'){
                $tipoc="Cuota Individual";   
            } else if($tipocuot=='CTGO'){
                $tipoc="Cuota Objetivo Individual";   
            } else if($tipocuot=='CTDM'){ 
                $tipoc="Cuota Domicilios"; 
            } else {
                $tipoc="-";
            }
             

            //SQL SERVER
            $query2 = mssql_query("select  * FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='".$vend."' AND Area='".$area."' AND tipoCuota='".$tipoc."' AND Periodo='$periodo'");
            
            if (!mssql_num_rows($query2)) {
                $sqlv = "INSERT INTO [sqlFacturas].[dbo].[facInfcomercial](Periodo,Fecha,Area,codVend,nomVend,tipoCuota,Cuotagen,SectorLab,Cuota,CuotaObj,Venta,VentaObj,VentaCont,VentaCred,VentaMixt,NotasCrCont,NotasCrCred,NotasCrMixt,NotaDebito,NotasdCobra,Subtotal,DistriBolsa,Total,Falta,DifTotMix,Obs)
                VALUES('$periodo','$fecha','$area','$vend','$nomb','$tipoc','$cuotagen','-','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','-')"; 
                mssql_query($sqlv,$cLink);
            }
        } 
    } else { 
                                                    //SIN CUOTA
        $cuotagen=0;
        $tipoc="-";
                                                    //SQL SERVER
        $query2 = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='".$vend."' AND Area='".$area."' AND Periodo='$periodo'");
        if (!mssql_num_rows($query2)) {
            $sqlv = "INSERT INTO [sqlFacturas].[dbo].[facInfcomercial](Periodo,Fecha,Area,codVend,nomVend,tipoCuota,Cuotagen,SectorLab,Cuota,CuotaObj,Venta,VentaObj,VentaCont,VentaCred,VentaMixt,NotasCrCont,NotasCrCred,NotasCrMixt,NotaDebito,NotasdCobra,Subtotal,DistriBolsa,Total,Falta,DifTotMix,Obs)
            VALUES('$periodo','$fecha','$area','$vend','$nomb','$tipoc','$cuotagen','-','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','-')"; 
            mssql_query($sqlv,$cLink);
        }
    }
}                  
                 
echo "Cuota general completa para el perido $periodo <br>";                   
odbc_close($result);
mssql_close();
