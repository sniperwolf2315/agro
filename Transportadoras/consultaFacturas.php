<!DOCTYPE html>
<html>
 
<head>
<style>
th, td {
   border: 1px solid #000;
   border-spacing: 0;
}
</style>
</head>
<body>
<div style="width: 100%; background-color: #024C68;">
                                    <form name="factur" method="post" action="consultaFacturas.php">
                                    <br /><center><label style="color: White; font-size: 1.2em; font-family: sans-serif; font-weight: bold;">Lista de Facturas y Cargue </label></center><br />
                                    <center><table style="width: 50%;">
                                    <tr style="border-color: white; border-width: thin;">
                                    <td style="text-align: center;">
                                    <span style="color: white;">Dia_fin&nbsp;&nbsp;</span><select id="df" name="df" class="browser-default light-blue-text" style="width: 60px; height: 25px; font-size: 0.8em;">
                                        <option value="" disabled selected>Dia</option>
                                        <?php
                                        $dia=1;
                                        while($dia<=31){
                                            if ($dia<10){
                                                $dia='0'.$dia;
                                            }
                                            echo "<option value=\"$dia\">$dia</option>";
                                            $dia++;
                                        }
                                        ?>
                                  </select>
                                  <span style="color: white; font-size: 0.6em;">&nbsp;(3 d&iacute;as)</span>
                                  </td>
                                  <td style="text-align: center;">
                                  <span style="color: white;">Mes&nbsp;&nbsp;</span><select id="m" name="m" class="browser-default light-blue-text" style="width: 60px; height: 25px; font-size: 0.8em;">
                                        <option value="" disabled selected>Mes</option>
                                        <?php
                                        $mes=1;
                                        while($mes<=12){
                                            if ($mes<10){
                                                $mes='0'.$mes;
                                            }
                                            echo "<option value=\"$mes\">$mes</option>";
                                            $mes++;
                                        }
                                        ?>
                                  </select>
                                  </td>
                                  <td>
                                  <span style="color: white;">A&ntilde;o&nbsp;&nbsp;</span><select id="a" name="a" class="browser-default light-blue-text" style="width: 80px; height: 25px; font-size: 0.8em;">
                                       <?php
                                       $anio=date("Y");
                                       for($i=2020;$i<=date("Y");$i++)
                                          {
                                            echo "<option value='".$i."'>".$i."</option>";
                                          }
                                          echo "</select>";

                                       /*
                                        $anio=date("Y");
                                        echo "<option value=\"$anio\">$anio</option>";*/
                                        
                                        ?> 
                                        
                                  </select>
                                  </td>
                                </tr>
                                </table></center>
                                <br /><br />
                                <center><input type="submit" onclick="VerificarOrdenMagento();" class="waves-efect waves-light btn" name="Enviar" value="Consultar Facturas" /></center><br /><br />
                                </form>
                          </div><br />
                          
<?php
if(isset($_POST[Enviar])){
    $cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); //AZURE10.10.0.5
    mssql_select_db('SqlFacturas',$cLink);
    //EXTRACT(YEAR FROM Fecha)
    $anio=trim($_POST['a']);
    $mes=trim($_POST['m']);
    $diaF=trim($_POST['df']);
    if($mes=='Mes' || $diaF=='Dia'){
        exit();
    }
    if($diaF <= 3){
        $diaI=1;
    }else{
        $diaI=$diaF-2;
    }
    if(strlen($diaF) < 2){
        $diaF='0'.$diaF;
    }
    if(strlen($diaI) < 2){
        $diaI='0'.$diaI;
    }
    $r=$r."<table style=\"border: 1px solid #000; width:100%; \">";
    $r=$r . "<tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">";
    $r=$r."<td style=\"font-weight: bold;text-align: left;\">No.</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Cedula</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Nombres</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Direccion</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Telefono</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Fecha</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Valor</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Factura</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">ConsecutivoCarga</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">IdRuta</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">IdDestino</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Destino</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">ShipmentNumber</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Orden</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">ID Conductor</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">IdVehiculo</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Ingresa</td>
    <td><a href='Rutas/FacturasCargue.xlsx' class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>";
    $r=$r . "</tr>";
    //excel
    $fd=3;
        $miruta='Rutas/';
        $nombre_fichero = 'FacturasCargue';
        $mipath=$miruta.$nombre_fichero.'.xlsx';
        //echo $mipath;
        if(file_exists($miruta)) {
            include('Classes/PHPExcel.php');
            include('Classes/PHPExcel/Reader/Excel2007.php');
            //Crear el objeto Excel: 
            $objPHPExcel = new PHPExcel();
            $mipath2=$miruta.$nombre_fichero.'.xlsx';
            
            if(file_exists($mipath2)) {
                $archivo = $mipath2;
                $inputFileType = PHPExcel_IOFactory::identify($archivo);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($archivo);                
            } else {              
                $objPHPExcel->getProperties()->setCreator("Autor: Agrocampo");
                $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo");
                $objPHPExcel->getProperties()->setTitle("Informe Agrocampo");
                $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
                $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
                $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
                $objPHPExcel->getProperties()->setCategory("Resultado de Informe"); 
                
                $objWorkSheet = $objPHPExcel->createSheet(0);
                    
                    $objWorkSheet->setCellValue('A2', 'No.')
                        ->setCellValue('B2', 'Cedula')
                        ->setCellValue('C2', 'Nombres')
                        ->setCellValue('D2', 'Direccion')
                        ->setCellValue('E2', 'Telefono')
                        ->setCellValue('F2', 'Fecha')
                        ->setCellValue('G2', 'Valor')
                        ->setCellValue('H2', 'Factura')
                        ->setCellValue('I2', 'ConsecutivoCarga')
                        ->setCellValue('J2', 'IdRuta')
                        ->setCellValue('K2', 'IdDestino')
                        ->setCellValue('L2', 'Destino')
                        ->setCellValue('M2', 'ShipmentNumber')
                        ->setCellValue('N2', 'Orden')
                        ->setCellValue('O2', 'ID Conductor')
                        ->setCellValue('P2', 'IdVehiculo')
                        ->setCellValue('Q2', 'Ingresa');
                     
                    
                    $objWorkSheet->setTitle("Validacion y Empaque");
                }
                
            //BORRAR DTOS
            $fil=3;
            $objPHPExcel->setActiveSheetIndex(0);
            $totalreg = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            $totalreg=$totalreg+1;
            while ($fil <= $totalreg) {
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$fil, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$fil, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$fil, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$fil, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$fil, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$fil, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$fil, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$fil, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$fil, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$fil, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$fil, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$fil, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('M'.$fil, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$fil, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('O'.$fil, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('P'.$fil, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$fil, '');
                $fil++;
            }
            
            //$objPHPExcel->setActiveSheetIndex(0)
          //              ->setCellValue('A1', "Facturacion y Cargue");
       // $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            
        }
        
    
$i=1;
/*$SqlLupa=mssql_query("SELECT 
f.Cedula as Cedula, 
f.Nombres as Nombre,
f.Direccion as Direc,
f.Telefono as Tele, 
f.Fecha as Fecha, 
f.Valor as Valor, 
f.Factura as Fact, 
f.ConsecutivoCarga as Cnscrg, 
f.IdRuta as Ruta, 
f.IdDestino as IdDest,
f.Destino as Desti,
f.ShipmentNumber as Ship,
f.Orden as Orden,
c.Nombres as IdCond,
v.placa as Placa 
FROM [sqlFacturas].[dbo].[facRegistroFactura] f
right join [sqlFacturas].[dbo].[facVehiculo] v ON f.IdConductor=v.IdVehiculo
right join [sqlFacturas].[dbo].[facConductor] c ON c.IdConductor=f.IdConductor
WHERE DATEPART(YEAR, f.Fecha)='$anio' and  DATEPART(MONTH, f.Fecha)='$mes' and (DATEPART(DAY, f.Fecha)>='$diaI' and DATEPART(DAY, f.Fecha)<='$diaF')
order by f.Orden desc
",$cLink);*/
$SqlLupa=mssql_query("SELECT
f.Cedula as Cedula, 
f.Nombres as Nombre,
f.Direccion as Direc,
f.Telefono as Tele, 
f.Fecha as Fecha, 
f.Valor as Valor, 
f.Factura as Fact, 
f.ConsecutivoCarga as Cnscrg, 
f.IdRuta as Ruta, 
f.IdDestino as IdDest,
f.Destino as Desti,
f.ShipmentNumber as Ship,
f.Orden as Orden,
c.Nombres as IdCond,
v2.placa as Placa,
f.Ingresa as Ingresa
FROM [sqlFacturas].[dbo].[facRegistroFactura] f
right join [sqlFacturas].[dbo].[facVehiculo] v2 ON f.IdVehiculo=v2.IdVehiculo
right join [sqlFacturas].[dbo].[facConductor] c ON f.IdConductor=c.IdConductor
WHERE DATEPART(YEAR, f.Fecha)='$anio' and  DATEPART(MONTH, f.Fecha)='$mes' and (DATEPART(DAY, f.Fecha)>='$diaI' and DATEPART(DAY, f.Fecha)<='$diaF')
order by f.Orden desc
",$cLink);
        if (mssql_num_rows($SqlLupa)) {
            while($rowPed = mssql_fetch_array($SqlLupa)){
                if(($i%2)==0){
                    $color="#AED6F1";
                }else{
                    $color="#E8F6F3";
                }
                $d1 = $rowPed[Cedula];
                $d2 = utf8_decode($rowPed[Nombre]);
                $d3 = utf8_decode($rowPed[Direc]);
                $d4 = $rowPed[Tele];
                $d5 = $rowPed[Fecha];
                $d6 = $rowPed[Valor];
                $d7 = $rowPed[Fact];
                $d8 = $rowPed[Cnscrg];
                $d9 = $rowPed[Ruta];
                $d10 = $rowPed[IdDest];
                $d11 = utf8_decode($rowPed[Desti]);
                $d12 = $rowPed[Ship];
                $d13 = $rowPed[Orden];
                $d14 = $rowPed[IdCond];
                $d15 = $rowPed[Placa];
                $d16 = $rowPed[Ingresa];
                //publica
                $r=$r."<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$i."</td>
                <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d1."</td>
                <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d2."</td>
                <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d3."</td>
                <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d4."</td>
                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d5."</td>
                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d6."</td>
                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d7."</td>
                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d8."</td>
                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d9."</td>
                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d10."</td>
                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d11."</td>
                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d12."</td>
                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d13."</td>
                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d14."</td>
                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d15."</td>
                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d16."</td>
                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'></td>
                ";
                //padding: 5px;
                $r=$r."</tr>";
                //excel
                //EXCEL
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$fd, $i)            
                ->setCellValue('B'.$fd, $d1)
                ->setCellValue('C'.$fd, $d2)
                ->setCellValue('D'.$fd, $d3)
                ->setCellValue('E'.$fd, $d4)
                ->setCellValue('F'.$fd, $d5)
                ->setCellValue('G'.$fd, $d6)
                ->setCellValue('H'.$fd, $d7)
                ->setCellValue('I'.$fd, $d8)
                ->setCellValue('J'.$fd, $d9)
                ->setCellValue('K'.$fd, $d10)
                ->setCellValue('L'.$fd, $d11)
                ->setCellValue('M'.$fd, $d12)
                ->setCellValue('N'.$fd, $d13)
                ->setCellValue('O'.$fd, $d14)
                ->setCellValue('P'.$fd, $d15)
                ->setCellValue('Q'.$fd, $d16);
                
            $i++;
            $fd++;
            }
            $r=$r . "</table>";
        }
             
                //->setCellValueExplicitByColumnAndRow(2, $fd, $d2, PHPExcel_Cell_DataType::TYPE_STRING)
                //->setCellValueExplicitByColumnAndRow(3, $fd, $d3, PHPExcel_Cell_DataType::TYPE_STRING)
        mssql_close();
        $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
        //Guardar el achivo: 
        $objWriter->save($mipath2);
        echo $r;
        }

?>

</body>
</html>