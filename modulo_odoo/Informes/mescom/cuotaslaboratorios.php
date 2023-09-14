<?php
//***CUOTA GENERAL****
$periodo = $_GET['periodo']; //'202109';
$fecha = date("Y-m-d h:i:s");

require_once('user_conmes.php');
//base sqlServer produccion
require_once('conectarbaseprodmes.php');
$querylab = mssql_query("SELECT Tipo_Cuota, Des_Campo_Buscar, Sectorlab FROM [sqlFacturas].[dbo].[facTipoCuota] WHERE Sectorlab!='-' AND Sectorlab!='Domicilios';", $cLink);


while ($rowlab = mssql_fetch_array($querylab)) {
    $tipoCuota      = trim($rowlab['Tipo_Cuota']);
    $laborator      = trim($rowlab['Sectorlab']);
    $desclaborator  = trim($rowlab['Des_Campo_Buscar']);

    //vendeores por areaS
    $queryv = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[cliVendedor] WHERE SectorLab != '' AND SectorLab!='TELEOPERADOR' AND Activo=1 ORDER BY SectorLab ASC;", $cLink);
    while ($row1 = mssql_fetch_array($queryv)) {
        $vend = trim($row1['Codigo']);
        $area = trim($row1['SectorLab']);
        $nomb = trim($row1['Apellidos']) . " " . trim($row1['Nombres']);
        $cuota = 0;

        //cuota lab 
        $sqlIBS = "SELECT IDTCUOTA, IDVEND, IDPER, VCUOTA FROM AGR620CFAG.VENDCUOTA WHERE IDTCUOTA='$tipoCuota' AND IDPER='$periodo' AND IDVEND = '$vend'";

        $result = odbc_exec($db2con, $sqlIBS);
        $num = odbc_num_rows($result);
        if ($num > 0) {
            while ($row = odbc_fetch_array($result)) {
                $cuota = trim($row['VCUOTA']);
                $tipocuot = trim($row['IDTCUOTA']);
                if ($cuota == NULL || $cuota == '') {
                    $cuota = 0;
                }
                $tipoc = "Cuota Laboratorio";
                //SQL SERVER
                $query2 = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='" . $vend . "' AND Area='" . $area . "' AND SectorLab='" . $desclaborator . "' AND Periodo='$periodo'");
                if (!mssql_num_rows($query2)) {
                    $sqlv = "INSERT INTO [sqlFacturas].[dbo].[facInfcomercial](Periodo,Fecha,Area,codVend,nomVend,tipoCuota,Cuotagen,SectorLab,Cuota,CuotaObj,Venta,VentaObj,VentaCont,VentaCred,VentaMixt,NotasCrCont,NotasCrCred,NotasCrMixt,NotaDebito,NotasdCobra,Subtotal,DistriBolsa,Total,Falta,DifTotMix,Obs)
                    VALUES('$periodo','$fecha','$area','$vend','$nomb','$tipoc','0','$desclaborator','$cuota','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','-')";
                    mssql_query($sqlv, $cLink);
                }
            }
        } else {
            $query2 = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='" . $vend . "' AND Area='" . $area . "' AND SectorLab='" . $desclaborator . "' AND Periodo='$periodo'");
            if (!mssql_num_rows($query2)) {
                $sqlv = "INSERT INTO [sqlFacturas].[dbo].[facInfcomercial](Periodo,Fecha,Area,codVend,nomVend,tipoCuota,Cuotagen,SectorLab,Cuota,CuotaObj,Venta,VentaObj,VentaCont,VentaCred,VentaMixt,NotasCrCont,NotasCrCred,NotasCrMixt,NotaDebito,NotasdCobra,Subtotal,DistriBolsa,Total,Falta,DifTotMix,Obs)
                    VALUES('$periodo','$fecha','$area','$vend','$nomb','$tipoc','0','$desclaborator','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','-')";
                mssql_query($sqlv, $cLink);
            }
        }
    }
}


//TELEOPERADORES CUOTAS POR LABORATORIOS O SECTORLAB AREA TELEOPERADOR
$AreaB = 'TELEOPERADOR';
$querylab = mssql_query("SELECT Tipo_Cuota, Des_Campo_Buscar, Sectorlab FROM [sqlFacturas].[dbo].[facTipoCuota] WHERE Sectorlab!='-' AND Sectorlab!='Domicilios';", $cLink);
while ($rowlab = mssql_fetch_array($querylab)) {
    $tipoCuota      = trim($rowlab['Tipo_Cuota']);
    $laborator      = trim($rowlab['Sectorlab']);
    $desclaborator  = trim($rowlab['Des_Campo_Buscar']);

    $queryv = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[cliVendedor] WHERE SectorLab='$AreaB' AND SectorLab!='CANALES DIGITALES' AND Activo=1 ORDER BY SectorLab ASC;", $cLink);
    while ($row1 = mssql_fetch_array($queryv)) {
        $vend = trim($row1['Codigo']);
        $area = trim($row1['SectorLab']);
        $nomb = trim($row1['Apellidos']) . " " . trim($row1['Nombres']);
        $cuota = 0;

        //cuota lab 
        $sqlIBS = "SELECT IDTCUOTA, IDVEND, IDPER, VCUOTA FROM AGR620CFAG.VENDCUOTA WHERE IDTCUOTA='$tipoCuota' AND IDPER='$periodo' AND IDVEND = '$vend'";

        $result = odbc_exec($db2con, $sqlIBS);
        $num = odbc_num_rows($result);
        $tipoc = "Cuota Laboratorio";
        if ($num > 0) {
            while ($row = odbc_fetch_array($result)) {
                $cuota      = trim($row['VCUOTA']);
                $tipocuot = trim($row['IDTCUOTA']);
                if ($cuota == NULL || $cuota == '') {
                    $cuota = 0;
                }

                $query2 = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area='$AreaB' AND codVend='" . $vend . "' AND Area='" . $area . "' AND SectorLab='" . $desclaborator . "' AND Periodo='$periodo'");
                if (!mssql_num_rows($query2)) {
                    if ($desclaborator == 'TODO') {
                        $tipoc = '';
                    }

                    $sqlv = "INSERT INTO [sqlFacturas].[dbo].[facInfcomercial](Periodo,Fecha,Area,codVend,nomVend,tipoCuota,Cuotagen,SectorLab,Cuota,CuotaObj,Venta,VentaObj,VentaCont,VentaCred,VentaMixt,NotasCrCont,NotasCrCred,NotasCrMixt,NotaDebito,NotasdCobra,Subtotal,DistriBolsa,Total,Falta,DifTotMix,Obs)
                    VALUES('$periodo','$fecha','$area','$vend','$nomb','$tipoc','0','$desclaborator','$cuota','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','-')";
                    mssql_query($sqlv, $cLink);
                }
            }
        } else {
            if ($desclaborator == 'TODO') {
                $tipoc = '';
            }
            $query2 = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area='$AreaB' AND codVend='" . $vend . "' AND Area='" . $area . "' AND SectorLab='" . $desclaborator . "' AND Periodo='$periodo'");
            if (!mssql_num_rows($query2)) {
                $sqlv = "INSERT INTO [sqlFacturas].[dbo].[facInfcomercial](Periodo,Fecha,Area,codVend,nomVend,tipoCuota,Cuotagen,SectorLab,Cuota,CuotaObj,Venta,VentaObj,VentaCont,VentaCred,VentaMixt,NotasCrCont,NotasCrCred,NotasCrMixt,NotaDebito,NotasdCobra,Subtotal,DistriBolsa,Total,Falta,DifTotMix,Obs)
                    VALUES('$periodo','$fecha','$area','$vend','$nomb','$tipoc','0','$desclaborator','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','-')";
                mssql_query($sqlv, $cLink);
            }
        }
    }
}
echo "Cuotas laboratorios completado en el  periodo $periodo <br>";
odbc_close($result);
mssql_close();
?>