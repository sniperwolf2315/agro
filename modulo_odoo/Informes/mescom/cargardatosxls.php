<?php
$periodo=$_GET['periodo']; //'202109';
$fecha = date("Y-m-d h:i:s");

require_once('user_conmes.php');
//base sqlServer produccion
require_once('conectarbaseprodmes.php');
//genera datos xls sobre formato
$miruta='Informe/';
$nombref="Mes_Comercial";
$nombre_fichero = 'Informe_'.$nombref."_".$periodo;
$mipath=$miruta.$nombre_fichero.'.xlsx';
unlink($mipath);
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
                $objPHPExcel->getProperties()->setTitle("Informe de Ordenes");
                $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
                $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
                $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
                $objPHPExcel->getProperties()->setCategory("Resultado de Informe"); 
                
                $objWorkSheet = $objPHPExcel->createSheet(0);
                
                //Combinar
                $objWorkSheet->mergeCells("A4:C4");
                $objWorkSheet->mergeCells("E4:G4");
                $objWorkSheet->mergeCells("H4:J4");
                $objWorkSheet->mergeCells("K4:M4");
                $objWorkSheet->mergeCells("N4:P4");
                $objWorkSheet->mergeCells("Q4:S4");
                $objWorkSheet->mergeCells("T4:V4");
                $objWorkSheet->mergeCells("W4:Y4");
                $objWorkSheet->mergeCells("Z4:AB4");
                $objWorkSheet->mergeCells("AC4:AE4");
                $objWorkSheet->mergeCells("AI4:AK4");
                $objWorkSheet->mergeCells("AL4:AN4");
                $objWorkSheet->mergeCells("AR4:AT4");
                $objWorkSheet->mergeCells("AU4:AW4");
                $objWorkSheet->mergeCells("AX4:AZ4");
                $objWorkSheet->mergeCells("BD4:BF4");
                $objWorkSheet->mergeCells("BG4:BI4");
                $objWorkSheet->mergeCells("BJ4:BL4");
                $objWorkSheet->mergeCells("BM4:BO4");
                $objWorkSheet->mergeCells("BP4:BR4");
                
                //combinar cuota general
                $objWorkSheet->mergeCells("D4:D5");
                
                
                    //titulos
                    $objWorkSheet->setCellValue('A2', '')
                        ->setCellValue('B2', '')
                        ->setCellValue('C2', 'DIAS DEL PERIODO')
                        ->setCellValue('A4', 'Vendedor')
                        ->setCellValue('E4', 'Ferreteria')
                        ->setCellValue('H4', 'Varios')
                        ->setCellValue('K4', 'Concentrados')
                        ->setCellValue('N4', 'Pets')
                        ->setCellValue('Q4', 'Ganaderia')
                        ->setCellValue('T4', 'Insecticidas y Otros')
                        ->setCellValue('W4', 'Invet')
                        ->setCellValue('Z4', 'Icofarma')
                        ->setCellValue('AC4', 'Comervet')
                        ->setCellValue('AI4', 'Gabrica')
                        ->setCellValue('AL4', 'Biostar')
                        ->setCellValue('AR4', 'Coaspharma')
                        ->setCellValue('AU4', 'Importados')
                        ->setCellValue('AX4', 'Intervet')
                        ->setCellValue('BD4', 'Linea Agil')
                        ->setCellValue('BG4', 'Linea Agil Importados')
                        ->setCellValue('BJ4', 'Laboratorio BAI')
                        ->setCellValue('BM4', 'Tecnocalidad')
                        ->setCellValue('BP4', 'TOTAL')
                        ->setCellValue('A5', 'AREA')
                        ->setCellValue('B5', 'Codigo')
                        ->setCellValue('C5', 'Nombre')
                        ->setCellValue('D4', 'Cuota General')
                        ->setCellValue('E5', 'CUOTA')
                        ->setCellValue('F5', 'VENTA')
                        ->setCellValue('G5', '%')
                        ->setCellValue('H5', 'CUOTA')
                        ->setCellValue('I5', 'VENTA')
                        ->setCellValue('J5', '%')
                        ->setCellValue('K5', 'CUOTA')
                        ->setCellValue('L5', 'VENTA')
                        ->setCellValue('M5', '%')
                        ->setCellValue('N5', 'CUOTA')
                        ->setCellValue('O5', 'VENTA')
                        ->setCellValue('P5', '%')
                        ->setCellValue('Q5', 'CUOTA')
                        ->setCellValue('R5', 'VENTA')
                        ->setCellValue('S5', '%')
                        ->setCellValue('T5', 'CUOTA')
                        ->setCellValue('U5', 'VENTA')
                        ->setCellValue('V5', '%')
                        ->setCellValue('W5', 'CUOTA')
                        ->setCellValue('X5', 'VENTA')
                        ->setCellValue('Y5', '%')
                        ->setCellValue('Z5', 'CUOTA')
                        ->setCellValue('AA5', 'VENTA')
                        ->setCellValue('AB5', '%')
                        ->setCellValue('AC5', 'CUOTA')
                        ->setCellValue('AD5', 'VENTA')
                        ->setCellValue('AE5', '%')
                        ->setCellValue('AI5', 'CUOTA')
                        ->setCellValue('AJ5', 'VENTA')
                        ->setCellValue('AK5', '%')
                        ->setCellValue('AL5', 'CUOTA')
                        ->setCellValue('AM5', 'VENTA')
                        ->setCellValue('AN5', '%')
                        ->setCellValue('AR5', 'CUOTA')
                        ->setCellValue('AS5', 'VENTA')
                        ->setCellValue('AT5', '%')
                        ->setCellValue('AU5', 'CUOTA')
                        ->setCellValue('AV5', 'VENTA')
                        ->setCellValue('AW5', '%')
                        ->setCellValue('AX5', 'CUOTA')
                        ->setCellValue('AY5', 'VENTA')
                        ->setCellValue('AZ5', '%')
                        ->setCellValue('BD5', 'CUOTA')
                        ->setCellValue('BE5', 'VENTA')
                        ->setCellValue('BF5', '%')
                        ->setCellValue('BG5', 'CUOTA')
                        ->setCellValue('BH5', 'VENTA')
                        ->setCellValue('BI5', '%')
                        ->setCellValue('BJ5', 'CUOTA')
                        ->setCellValue('BK5', 'VENTA')
                        ->setCellValue('BL5', '%')
                        ->setCellValue('BM5', 'CUOTA')
                        ->setCellValue('BN5', 'VENTA')
                        ->setCellValue('BO5', '%')
                        ->setCellValue('BP5', 'CUOTA')
                        ->setCellValue('BQ5', 'VENTA')
                        ->setCellValue('BR5', '%')
                        
                        ->setCellValue('BU5', 'VTA.CONTADO')
                        ->setCellValue('BV5', 'VTA.CREDITO')
                        ->setCellValue('BW5', 'VTA. MIXTA')
                        ->setCellValue('BX5', 'NOTAS CR.CONTADO')
                        ->setCellValue('BY5', 'NOTAS CR.CREDITO')
                        ->setCellValue('BZ5', 'NOTAS CR. MIXTAS')
                        ->setCellValue('CA5', 'NOTA DEBITO')
                        ->setCellValue('CB5', 'NOTAS DE. COBRADA')
                        ->setCellValue('CC5', 'SUBTOTAL')
                        ->setCellValue('CD5', 'DISTRI BOLSA')
                        ->setCellValue('CE5', 'TOTAL')
                        ->setCellValue('CF5', 'LE FALTA')
                        ->setCellValue('CG5', 'DIFERENCIA ENTRE TOTAL Y   V.MIXTA(SOLO PARA EXTERNOS)')
                        ->setCellValue('CH5', '%');
                
                //Formatos encabezados
                $objPHPExcel->setActiveSheetIndex(0);
                
                //anchos columnas
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                
                //ancho columnas de valores
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                //***
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
                //***
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
                //***
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
                //***
                $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
                //***
                $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
                //***
                $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(15);
                //***
                $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(15);
                //***
                $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(15);
                //***
                $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(15);
                //***
                $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(15);
                //***
                $objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setWidth(15);
                //***
                $objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AV')->setWidth(15);
                //***
                $objPHPExcel->getActiveSheet()->getColumnDimension('AX')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AY')->setWidth(15);
                //***
                $objPHPExcel->getActiveSheet()->getColumnDimension('BD')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('BE')->setWidth(15);
                //***
                $objPHPExcel->getActiveSheet()->getColumnDimension('BG')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('BH')->setWidth(15);
                //***
                $objPHPExcel->getActiveSheet()->getColumnDimension('BJ')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('BK')->setWidth(15);
                //***
                $objPHPExcel->getActiveSheet()->getColumnDimension('BM')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('BN')->setWidth(15);
                //***
                $objPHPExcel->getActiveSheet()->getColumnDimension('BP')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('BQ')->setWidth(15);
                
                //FILAS OCULTAS
                $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(0);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(0);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(0);
                
                $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(0);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setWidth(0);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setWidth(0);
                
                $objPHPExcel->getActiveSheet()->getColumnDimension('BA')->setWidth(0);
                $objPHPExcel->getActiveSheet()->getColumnDimension('BB')->setWidth(0);
                $objPHPExcel->getActiveSheet()->getColumnDimension('BC')->setWidth(0);
                
                //alto filas
                $objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(35);
                                
                //negrilla
                $objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('E4:BR4')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('E5:BR5')->getFont()->setBold(true);
                
                //centrar H
                $objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('A4:BR4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('E5:BR5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                
                //centrar V
                $objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('E4:BR4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('E5:BR5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('C5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                
                //bordes
                $objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                $objPHPExcel->getActiveSheet()->getStyle('A4:C4')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                $objPHPExcel->getActiveSheet()->getStyle('E4:BR4')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                $objPHPExcel->getActiveSheet()->getStyle('A5:C5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                $objPHPExcel->getActiveSheet()->getStyle('E5:BR5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                $objPHPExcel->getActiveSheet()->getStyle('D4:D5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                //BORDER_THICK=grueso
                                     
                $objPHPExcel->getActiveSheet()->getStyle('BT5:CH5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                //centrar horizontal
                $objPHPExcel->getActiveSheet()->getStyle('BU5:CH5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                //centrar V
                $objPHPExcel->getActiveSheet()->getStyle('BU5:CH5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('BU5:CH5')->getFont()->setBold(true);
                
                     
                //titulo HOJA  
                $objWorkSheet->setTitle("Informe de Ventas");
       }
       //proceso del cuerpo
       //AREAS
       //vendeores por areas
        $TotalT=0;
        $TotCuotaFinal=0;
        
        $Laboratoriostot=new ArrayIterator();
        $TotCuotaFinaLab=new ArrayIterator();
        $TotVentaFinaLab=new ArrayIterator();
        
        //el total almacen nb lleva a venta externa
        $TotalTotalAlmacen=0;
        //TOTALES ALMACEN
        $VentaCont1=0; $VentaCred1=0; $VentaMixt1=0; $NotasCrCont1=0; $NotasCrCred1=0; $NotasCrMixt1=0; $NotaDebito1=0; $NotasdCobra1=0; $Subtotal1=0; $DistriBolsa1=0;
        
        $TotalTCuo1=0;$TotalTCuo2=0;$TotalTCuo3=0;$TotalTCuo4=0;$TotalTCuo5=0;$TotalTCuo6=0;$TotalTCuo7=0;$TotalTCuo8=0;$TotalTCuo9=0;$TotalTCuo10=0;$TotalTCuo11=0;$TotalTCuo12=0;$TotalTCuo13=0;$TotalTCuo14=0;$TotalTCuo15=0;$TotalTCuo16=0;$TotalTCuo17=0;$TotalTCuo18=0;
        $TotalTLab1=0;$TotalTLab2=0;$TotalTLab3=0;$TotalTLab4=0;$TotalTLab5=0;$TotalTLab6=0;$TotalTLab7=0;$TotalTLab8=0;$TotalTLab9=0;$TotalTLab10=0;$TotalTLab11=0;$TotalTLab12=0;$TotalTLab13=0;$TotalTLab14=0;$TotalTLab15=0;$TotalTLab16=0;$TotalTLab17=0;$TotalTLab18=0;
        //VENTA EXTERNA*****************************************************************************************************************
        $area='VENTA EXTERNA';
        $queryv = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[cliVendedor] WHERE SectorLab = '$area' ORDER BY Codigo ASC;", $cLink);
        $num=mssql_num_rows($queryv);
        $fila=7;
        $tamfilArea=$fila+$num-1;
        $Total=0;
        //combina areas
        $objWorkSheet->mergeCells("A".$fila.":A".$tamfilArea."");
        $objWorkSheet->setCellValue('A'.$fila, $area);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':A'.$tamfilArea)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //SUBTOTALES
        $TotalLab1=0;$TotalLab2=0;$TotalLab3=0;$TotalLab4=0;$TotalLab5=0;$TotalLab6=0;$TotalLab7=0;$TotalLab8=0;$TotalLab9=0;$TotalLab10=0;$TotalLab11=0;$TotalLab12=0;$TotalLab13=0;$TotalLab14=0;$TotalLab15=0;$TotalLab16=0;$TotalLab17=0;$TotalLab18=0;
        $TotalCuo1=0;$TotalCuo2=0;$TotalCuo3=0;$TotalCuo4=0;$TotalCuo5=0;$TotalCuo6=0;$TotalCuo7=0;$TotalCuo8=0;$TotalCuo9=0;$TotalCuo10=0;$TotalCuo11=0;$TotalCuo12=0;$TotalCuo13=0;$TotalCuo14=0;$TotalCuo15=0;$TotalCuo16=0;$TotalCuo17=0;$TotalCuo18=0;
        $TotTotGen=0;
        $filainicio=$fila;
        while($rowVend = mssql_fetch_array($queryv)){
            $vend = trim($rowVend['Codigo']);
            $nomb = trim($rowVend['Apellidos'])." ".trim($rowVend['Nombres']);
            //cod vendedores
            $objWorkSheet->setCellValue('B'.$fila, $vend);  
            $objWorkSheet->setCellValue('C'.$fila, utf8_encode($nomb));
            $objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //valores cuota general
            $queryval = mssql_query("SELECT cuotagen FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND codVend='$vend' AND Periodo='$periodo' AND tipoCuota != 'Cuota Laboratorio';", $cLink);
            if($rowVendVal = mssql_fetch_array($queryval)){
                $cuotag = trim($rowVendVal['cuotagen']);
                $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
                $Total=$Total+$cuotag;         
            }else{
                $cuotag = 0;
                $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
            }
            //VENTA GENERAL
            $queryvalv = mssql_query("SELECT Venta FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND codVend='$vend' AND Periodo='$periodo' AND SectorLab='TODO' AND tipoCuota = 'Cuota Laboratorio';", $cLink);
            if($rowVendVenta = mssql_fetch_array($queryvalv)){
                $VentaTot = trim($rowVendVenta['Venta']);
                $objWorkSheet->setCellValue('BQ'.$fila, $VentaTot);
                $TotTotGen=$TotTotGen+$VentaTot;
                //$Total=$Total+$cuotag;         
            }else{
                $VentaTot = 0;
                $objWorkSheet->setCellValue('D'.$fila, $VentaTot);
            }
            
            //porcentaje total*******
            $P=0;
            if($cuotag > 0){
                // $P=round(($VentaTot/$cuotag));
                $P=round(($VentaTot/$cuotag));
            }
            $objWorkSheet->setCellValue('BR'.$fila, $P);
            $objPHPExcel->getActiveSheet()->getStyle('BR'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        
            //CUOTAS Y VENTAS LABORATORIOS
            $queryval = mssql_query("SELECT Cuota, Venta, SectorLab FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND tipoCuota='Cuota Laboratorio' AND codVend='$vend' AND Periodo='$periodo';", $cLink);
            //echo "</br></br>SELECT Cuota, Venta, SectorLab FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND tipoCuota='Cuota Laboratorio' AND codVend='$vend' AND Periodo='$periodo';";
            while($rowVendValab = mssql_fetch_array($queryval)){
                $cuotaLab = trim($rowVendValab['Cuota']);
                $ventaLab = trim($rowVendValab['Venta']);
                $sectorLab = trim($rowVendValab['SectorLab']);
                include('valoresVC.php');
                $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$fila,'=(F'.$fila.'+I'.$fila.'+L'.$fila.'+O'.$fila.'+R'.$fila.'+U'.$fila.'+X'.$fila.'+AA'.$fila.'+AD'.$fila.'+AJ'.$fila.'+AM'.$fila.'+AS'.$fila.'+AV'.$fila.'+AY'.$fila.'+BE'.$fila.'+BH'.$fila.'+BK'.$fila.'+BN'.$fila.')');
                // $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
                $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
                $objWorkSheet->setCellValue('BR'.$fila, $Porc);
            }//FIN LABORATORIOS
            
            
            //CUADRO 2 JORGE
            $querysumCom = mssql_query("SELECT SUM(VentaCont) as VentaCont, sum(VentaCred) as VentaCred, sum(VentaMixt) as VentaMixt, sum(NotasCrCont) as NotasCrCont, sum(NotasCrCred) as NotasCrCred, sum(NotasCrMixt) as NotasCrMixt, sum(NotaDebito) as NotaDebito,sum(NotasdCobra) as NotasdCobra,sum(Subtotal) as Subtotal,sum(DistriBolsa) as DistriBolsa,sum(Total) as Total,sum(Falta) as Falta,sum(DifTotMix) as DifTotMix FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='$vend' and Periodo='$periodo';", $cLink);
            //$TotalLab17
            if($rowVendValab = mssql_fetch_array($querysumCom)){
                
                $VentaCont = trim($rowVendValab['VentaCont']);
                $VentaCred = trim($rowVendValab['VentaCred']);
                $VentaMixt = trim($rowVendValab['VentaMixt']);
                $NotasCrCont = trim($rowVendValab['NotasCrCont']);
                $NotasCrCred = trim($rowVendValab['NotasCrCred']);
                $NotasCrMixt = trim($rowVendValab['NotasCrMixt']);
                $NotaDebito = trim($rowVendValab['NotaDebito']);
                $NotasdCobra = trim($rowVendValab['NotasdCobra']);
                //Subtotal = trim($rowVendValab['Subtotal']);
                $Subtotal=$Subtotal+$VentaCont+$VentaCred+$VentaMixt+$NotasCrCont+$NotasCrCred+$NotasCrMixt+$NotaDebito+$NotasdCobra;
                
                $DistriBolsa = trim($rowVendValab['DistriBolsa']);
                $Totalkl = trim($rowVendValab['Total']);
                $Falta="=BQ".$fila."-BP".$fila;
                $DifTotMix="=CE".$fila."-BW".$fila."+BZ".$fila;  //=CE9-BW9+BZ9
                $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(CE".$fila."/BP".$fila.",0)");
                
                
                //filas
                if($VentaCont=='-'){$VentaCont=0;}
                $objWorkSheet->setCellValue('BU'.$fila, $VentaCont);
                if($VentaCred=='-'){$VentaCred=0;}
                $objWorkSheet->setCellValue('BV'.$fila, $VentaCred);
                if($VentaMixt=='-'){$VentaMixt=0;}
                $objWorkSheet->setCellValue('BW'.$fila, $VentaMixt);
                if($NotasCrCont=='-'){$NotasCrCont=0;}
                $objWorkSheet->setCellValue('BX'.$fila, $NotasCrCont);
                if($NotasCrCred=='-'){$NotasCrCred=0;}
                $objWorkSheet->setCellValue('BY'.$fila, $NotasCrCred);
                if($NotasCrMixt=='-'){$NotasCrMixt=0;}
                $objWorkSheet->setCellValue('BZ'.$fila, $NotasCrMixt);
                if($NotaDebito=='-'){$NotaDebito=0;}
                $objWorkSheet->setCellValue('CA'.$fila, $NotaDebito);
                if($NotasdCobra=='-'){$NotasdCobra=0;}
                $objWorkSheet->setCellValue('CB'.$fila, $NotasdCobra);
                if($DistriBolsa=='-'){$DistriBolsa=0;}
                $objWorkSheet->setCellValue('CD'.$fila, $DistriBolsa);
                if($Totalkl=='-'){$Totalkl=0;}
                $objWorkSheet->setCellValue('CE'.$fila, $Totalkl);
                if($Falta=='-'){$Falta=0;}
                $objWorkSheet->setCellValue('CF'.$fila, $Falta);
                if($DifTotMix=='-'){$DifTotMix=0;}
                $objWorkSheet->setCellValue('CG'.$fila, $DifTotMix);
                if($Porc=='-'){$Porc=0;}
                $objWorkSheet->setCellValue('CH'.$fila, $Porc);
                
            }
            
            //SUBTOTAL CUADRO DERECHA
            $objPHPExcel->getActiveSheet()->setCellValue('CC'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')');
            $objPHPExcel->getActiveSheet()->setCellValue('CE'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')-CD'.$fila);
            $objPHPExcel->getActiveSheet()->setCellValue('CF'.$fila,'=(BQ'.$fila.'-BP'.$fila.')');
                       
            /*$VentaCont1 = $VentaCont1+$VentaCont;
            $VentaCred1 = $VentaCred1+$VentaCred;
            $VentaMixt1 = $VentaMixt1+$VentaMixt;
            $NotasCrCont1 = $NotasCrCont1+$NotasCrCont;
            $NotasCrCred1 = $NotasCrCred1+$NotasCrCred;
            $NotasCrMixt1 = $NotasCrMixt1+$NotasCrMixt;
            $NotaDebito1 = $NotaDebito1+$NotaDebito;
            $NotasdCobra1 = $NotasdCobra1+$NotasdCobra;
            $Subtotal1 = $Subtotal1+$Subtotal;
            $DistriBolsa1 = $DistriBolsa1+$DistriBolsa;
            $Subtotal=0;
            
            $Total1 = $Total1+$Total;
            //$Total1="=CC7+CD7"."aqui";
            $Falta1 = $Falta1+$Falta;
            //$Falta1="=CD7+CE7"."aqui";
            $DifTotMix1 = $DifTotMix1+$DifTotMix;
            */
            //FIN JORGE
            
            $fila++;          
        }
            //combinar celdas
            $objWorkSheet->mergeCells("A".$fila.":C".$fila."");
        
            //borde
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
            //centrar horizontal
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            //centrar V
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getFont()->setBold(true);
            
            //tama�o} cuadro derecha
            $objPHPExcel->getActiveSheet()->getColumnDimension('BT')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BU')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BV')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BW')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BX')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BY')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BZ')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CA')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CB')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CC')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CD')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CE')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CF')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CG')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CH')->setWidth(22);
            //total 
         
            
        
            //SUMA VERTICAL
            $filafin=$fila-1;
            
            //contado
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BU".$filainicio.":BU".$filafin.")");
            $objWorkSheet->setCellValue('BU'.$fila, $SumaVertical1);
            //credito
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BV".$filainicio.":BV".$filafin.")");
            $objWorkSheet->setCellValue('BV'.$fila, $SumaVertical1);
            //MIXTA
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BW".$filainicio.":BW".$filafin.")");
            $objWorkSheet->setCellValue('BW'.$fila, $SumaVertical1);
            //NOTAS CREDITO CONTADO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BX".$filainicio.":BX".$filafin.")");
            $objWorkSheet->setCellValue('BX'.$fila, $SumaVertical1);
            //NOTAS CREDITO CREDITO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BY".$filainicio.":BY".$filafin.")");
            $objWorkSheet->setCellValue('BY'.$fila, $SumaVertical1);
            //NOTAS CREDITO MIXTAS
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BZ".$filainicio.":BZ".$filafin.")");
            $objWorkSheet->setCellValue('BZ'.$fila, $SumaVertical1);
            //NOTAS DEBITO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CA".$filainicio.":CA".$filafin.")");
            $objWorkSheet->setCellValue('CA'.$fila, $SumaVertical1);
            //NOTAS DEBITO COBRADAS
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CB".$filainicio.":CB".$filafin.")");
            $objWorkSheet->setCellValue('CB'.$fila, $SumaVertical1);
            //SUBTOTAL
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CC".$filainicio.":CC".$filafin.")");
            $objWorkSheet->setCellValue('CC'.$fila, $SumaVertical1);
            //suma distribolsa
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CD".$filainicio.":CD".$filafin.")");
            $objWorkSheet->setCellValue('CD'.$fila, $SumaVertical1);
            //suma total
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CE".$filainicio.":CE".$filafin.")");
            $objWorkSheet->setCellValue('CE'.$fila, $SumaVertical1);
            //suma LE FALTA
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CF".$filainicio.":CF".$filafin.")");
            $objWorkSheet->setCellValue('CF'.$fila, $SumaVertical1);
            //SUMA DIFERENCIA TOTAL
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CG".$filainicio.":CG".$filafin.")");
            $objWorkSheet->setCellValue('CG'.$fila, $SumaVertical1);
            //PORCENTAJE TOTAL
            $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(CE".$fila."/BP".$fila.",0)");
            $objWorkSheet->setCellValue('CH'.$fila, $Porc);
        
        $objWorkSheet->setCellValue('A'.$fila, 'TOTAL '.$area);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //valores totales
        $objWorkSheet->setCellValue('D'.$fila, $Total);
        $objWorkSheet->setCellValue('BP'.$fila, $Total);
        
        //VARIABLE TOTAL FINAL
        $TotCuotaFinal=$TotCuotaFinal+$Total; 
        
        //total total
        $objWorkSheet->setCellValue('BQ'.$fila, $TotTotGen);
        
        
        //porcentaje total por vendedor jairo
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        //totales laboratorios
        include('totalesLaboratoriosVE.php');
        //CUOTA Y VENTA FINAL
        $Laboratoriostot[18]="TOTALCV"; //$area
        $TotCuotaFinaLab[18]=$TotCuotaFinaLab[18]+$Total;
        $TotVentaFinaLab[18]=$TotVentaFinaLab[18]+$TotTotGen;
        
        //el total almacen no lleva venta externa
        //TOTAL AREA
        $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$fila,'=(F'.$fila.'+I'.$fila.'+L'.$fila.'+O'.$fila.'+R'.$fila.'+U'.$fila.'+X'.$fila.'+AA'.$fila.'+AD'.$fila.'+AJ'.$fila.'+AM'.$fila.'+AS'.$fila.'+AV'.$fila.'+AY'.$fila.'+BE'.$fila.'+BH'.$fila.'+BK'.$fila.'+BN'.$fila.')');
        // $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        $fila++;
        
        //JORGE
        $VentaCont1=0;$VentaCred1=0;$VentaMixt1=0;$NotasCrCont1=0;$NotasCrCred1=0;$NotasCrMixt1=0;$NotaDebito1=0;$NotasdCobra1=0;$NotasdCobra1=0;$Subtotal1=0;$DistriBolsa1=0;$Total1=0;
        
        //CONCENTRADOS*********************************************************************************************************************
        $area='CONCENTRADOS';
        $fila++;
        $queryv = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[cliVendedor] WHERE SectorLab = '$area' ORDER BY Codigo ASC;", $cLink);
        $num=mssql_num_rows($queryv);
        $tamfilArea=$fila+$num-1;
        $Total=0;
        //combina areas
        $objWorkSheet->mergeCells("A".$fila.":A".$tamfilArea."");
        $objWorkSheet->setCellValue('A'.$fila, $area);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':A'.$tamfilArea)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        $VentaCont1=0; $VentaCred1=0; $VentaMixt1=0; $NotasCrCont1=0; $NotasCrCred1=0; $NotasCrMixt1=0; $NotaDebito1=0; $NotasdCobra1=0; $Subtotal1=0; $DistriBolsa1=0;
        $filainicio=$fila;
        $TotalLab1=0;$TotalLab2=0;$TotalLab3=0;$TotalLab4=0;$TotalLab5=0;$TotalLab6=0;$TotalLab7=0;$TotalLab8=0;$TotalLab9=0;$TotalLab10=0;$TotalLab11=0;$TotalLab12=0;$TotalLab13=0;$TotalLab14=0;$TotalLab15=0;$TotalLab16=0;$TotalLab17=0;$TotalLab18=0;
        $TotalCuo1=0;$TotalCuo2=0;$TotalCuo3=0;$TotalCuo4=0;$TotalCuo5=0;$TotalCuo6=0;$TotalCuo7=0;$TotalCuo8=0;$TotalCuo9=0;$TotalCuo10=0;$TotalCuo11=0;$TotalCuo12=0;$TotalCuo13=0;$TotalCuo14=0;$TotalCuo15=0;$TotalCuo16=0;$TotalCuo17=0;$TotalCuo18=0;
        $TotTotGen=0;
        while($rowVend = mssql_fetch_array($queryv)){
            $vend = trim($rowVend['Codigo']);
            $nomb = trim($rowVend['Apellidos'])." ".trim($rowVend['Nombres']);
            //cod vendedores
            $objWorkSheet->setCellValue('B'.$fila, $vend);  
            $objWorkSheet->setCellValue('C'.$fila, utf8_encode($nomb));
            $objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //valores
            $queryval = mssql_query("SELECT cuotagen FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND codVend='$vend' AND Periodo='$periodo' AND tipoCuota != 'Cuota Laboratorio';", $cLink);
            if($rowVendVal = mssql_fetch_array($queryval)){
                $cuotag = trim($rowVendVal['cuotagen']);
                $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
                $Total=$Total+$cuotag;         
            }else{
                $cuotag = 0;
                $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
            }
            $queryvalv = mssql_query("SELECT Venta FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND codVend='$vend' AND Periodo='$periodo' AND SectorLab='TODO' AND tipoCuota = 'Cuota Laboratorio';", $cLink);
            if($rowVendVenta = mssql_fetch_array($queryvalv)){
                $VentaTot = trim($rowVendVenta['Venta']);
                $objWorkSheet->setCellValue('BQ'.$fila, $VentaTot);
                $TotTotGen=$TotTotGen+$VentaTot;
                //$Total=$Total+$cuotag;         
            }else{
                $VentaTot = 0;
                $objWorkSheet->setCellValue('D'.$fila, $VentaTot);
            }
            
            //porcentaje total*******
            $P=0;
            if($cuotag > 0){
                // $P=round(($VentaTot/$cuotag));
                $P=round(($VentaTot/$cuotag));
            }
            $objWorkSheet->setCellValue('BR'.$fila, $P);
            $objPHPExcel->getActiveSheet()->getStyle('BR'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            //LABORATORIOS
            $queryval = mssql_query("SELECT Cuota, Venta, SectorLab FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND tipoCuota='Cuota Laboratorio' AND codVend='$vend' AND Periodo='$periodo';", $cLink);
            while($rowVendValab = mssql_fetch_array($queryval)){
                $cuotaLab = trim($rowVendValab['Cuota']);
                $ventaLab = trim($rowVendValab['Venta']);
                $sectorLab = trim($rowVendValab['SectorLab']);
                include('valoresVC.php');
                $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$fila,'=(F'.$fila.'+I'.$fila.'+L'.$fila.'+O'.$fila.'+R'.$fila.'+U'.$fila.'+X'.$fila.'+AA'.$fila.'+AD'.$fila.'+AJ'.$fila.'+AM'.$fila.'+AS'.$fila.'+AV'.$fila.'+AY'.$fila.'+BE'.$fila.'+BH'.$fila.'+BK'.$fila.'+BN'.$fila.')');
                // $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
                $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
                $objWorkSheet->setCellValue('BR'.$fila, $Porc);
            }//FIN LABORATORIOS
            
            //CUADRO 2 JORGE
            $querysumCom = mssql_query("SELECT SUM(VentaCont) as VentaCont, sum(VentaCred) as VentaCred, sum(VentaMixt) as VentaMixt, sum(NotasCrCont) as NotasCrCont, sum(NotasCrCred) as NotasCrCred, sum(NotasCrMixt) as NotasCrMixt, sum(NotaDebito) as NotaDebito,sum(NotasdCobra) as NotasdCobra,sum(Subtotal) as Subtotal,sum(DistriBolsa) as DistriBolsa,sum(Total) as Total,sum(Falta) as Falta,sum(DifTotMix) as DifTotMix FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='$vend' and Periodo='$periodo';", $cLink);
            if($rowVendValab = mssql_fetch_array($querysumCom)){
                
                $VentaCont = trim($rowVendValab['VentaCont']);
                $VentaCred = trim($rowVendValab['VentaCred']);
                $VentaMixt = trim($rowVendValab['VentaMixt']);
                $NotasCrCont = trim($rowVendValab['NotasCrCont']);
                $NotasCrCred = trim($rowVendValab['NotasCrCred']);
                $NotasCrMixt = trim($rowVendValab['NotasCrMixt']);
                $NotaDebito = trim($rowVendValab['NotaDebito']);
                $NotasdCobra = trim($rowVendValab['NotasdCobra']);
                $Subtotal = trim($rowVendValab['Subtotal']);
                $DistriBolsa = trim($rowVendValab['DistriBolsa']);
                $Totalkl = trim($rowVendValab['Total']);
                //$Total="=CC7+CD7"."aqui";
                //$Falta = trim($rowVendValab['Falta']);
                $Falta="=BQ".$fila."-BP".$fila;
                //$DifTotMix = trim($rowVendValab['DifTotMix']);
                $DifTotMix="=CE".$fila."-BW".$fila."+BZ".$fila;
                //$Porc="=CE".$fila."/BP".$fila;
                $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(CE".$fila."/BP".$fila.",0)");
                
                
                //filas
                if($VentaCont=='-'){$VentaCont=0;}
                $objWorkSheet->setCellValue('BU'.$fila, $VentaCont);
                if($VentaCred=='-'){$VentaCred=0;}
                $objWorkSheet->setCellValue('BV'.$fila, $VentaCred);
                if($VentaMixt=='-'){$VentaMixt=0;}
                $objWorkSheet->setCellValue('BW'.$fila, $VentaMixt);
                if($NotasCrCont=='-'){$NotasCrCont=0;}
                $objWorkSheet->setCellValue('BX'.$fila, $NotasCrCont);
                if($NotasCrCred=='-'){$NotasCrCred=0;}
                $objWorkSheet->setCellValue('BY'.$fila, $NotasCrCred);
                if($NotasCrMixt=='-'){$NotasCrMixt=0;}
                $objWorkSheet->setCellValue('BZ'.$fila, $NotasCrMixt);
                if($NotaDebito=='-'){$NotaDebito=0;}
                $objWorkSheet->setCellValue('CA'.$fila, $NotaDebito);
                if($NotasdCobra=='-'){$NotasdCobra=0;}
                $objWorkSheet->setCellValue('CB'.$fila, $NotasdCobra);
                if($DistriBolsa=='-'){$DistriBolsa=0;}
                $objWorkSheet->setCellValue('CD'.$fila, $DistriBolsa);
                if($Totalkl=='-'){$Totalkl=0;}
                $objWorkSheet->setCellValue('CE'.$fila, $Totalkl);
                if($Falta=='-'){$Falta=0;}
                $objWorkSheet->setCellValue('CF'.$fila, $Falta);
                if($DifTotMix=='-'){$DifTotMix=0;}
                $objWorkSheet->setCellValue('CG'.$fila, $DifTotMix);
                if($Porc=='-'){$Porc=0;}
                $objWorkSheet->setCellValue('CH'.$fila, $Porc);
            }
            
            //SUBTOTAL CUADRO DERECHA
            $objPHPExcel->getActiveSheet()->setCellValue('CC'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')');
            
            //SUBTOTAL CUADRO DERECHA
            $objPHPExcel->getActiveSheet()->setCellValue('CC'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')');
            $objPHPExcel->getActiveSheet()->setCellValue('CE'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')-CD'.$fila);
            $objPHPExcel->getActiveSheet()->setCellValue('CF'.$fila,'=(BQ'.$fila.'-BP'.$fila.')');
            
            
            //FIN JORGE
            
            $fila++;          
        }
            //borde cuadro derecha
            $objWorkSheet->setCellValue('BT'.$fila, 'TOTAL '.$area);
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
            //centrar horizontal
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //centrar V
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getFont()->setBold(true);
            
            //tama�o} cuadro derecha
            $objPHPExcel->getActiveSheet()->getColumnDimension('BT')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BU')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BV')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BW')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BX')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BY')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BZ')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CA')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CB')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CC')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CD')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CE')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CF')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CG')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CH')->setWidth(22);
            //total 
         
                    
            //SUMA VERTICAL
            $filafin=$fila-1;
            //contado
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BU".$filainicio.":BU".$filafin.")");
            $objWorkSheet->setCellValue('BU'.$fila, $SumaVertical1);
            //credito
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BV".$filainicio.":BV".$filafin.")");
            $objWorkSheet->setCellValue('BV'.$fila, $SumaVertical1);
            //MIXTA
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BW".$filainicio.":BW".$filafin.")");
            $objWorkSheet->setCellValue('BW'.$fila, $SumaVertical1);
            //NOTAS CREDITO CONTADO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BX".$filainicio.":BX".$filafin.")");
            $objWorkSheet->setCellValue('BX'.$fila, $SumaVertical1);
            //NOTAS CREDITO CREDITO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BY".$filainicio.":BY".$filafin.")");
            $objWorkSheet->setCellValue('BY'.$fila, $SumaVertical1);
            //NOTAS CREDITO MIXTAS
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BZ".$filainicio.":BZ".$filafin.")");
            $objWorkSheet->setCellValue('BZ'.$fila, $SumaVertical1);
            //NOTAS DEBITO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CA".$filainicio.":CA".$filafin.")");
            $objWorkSheet->setCellValue('CA'.$fila, $SumaVertical1);
            //NOTAS DEBITO COBRADAS
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CB".$filainicio.":CB".$filafin.")");
            $objWorkSheet->setCellValue('CB'.$fila, $SumaVertical1);
            //SUBTOTAL
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CC".$filainicio.":CC".$filafin.")");
            $objWorkSheet->setCellValue('CC'.$fila, $SumaVertical1);
            //suma distribolsa
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CD".$filainicio.":CD".$filafin.")");
            $objWorkSheet->setCellValue('CD'.$fila, $SumaVertical1);
            //suma total
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CE".$filainicio.":CE".$filafin.")");
            $objWorkSheet->setCellValue('CE'.$fila, $SumaVertical1);
            //suma LE FALTA
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CF".$filainicio.":CF".$filafin.")");
            $objWorkSheet->setCellValue('CF'.$fila, $SumaVertical1);
            //SUMA DIFERENCIA TOTAL
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CG".$filainicio.":CG".$filafin.")");
            $objWorkSheet->setCellValue('CG'.$fila, $SumaVertical1);
            //PORCENTAJE TOTAL
            $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(CE".$fila."/BP".$fila.",0)");
            $objWorkSheet->setCellValue('CH'.$fila, $Porc);
            
        //total 
        //combinar celdas
        $objWorkSheet->mergeCells("A".$fila.":C".$fila."");
        $objWorkSheet->setCellValue('A'.$fila, 'TOTAL '.$area);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //valor
        $objWorkSheet->setCellValue('D'.$fila, $Total);
        $objWorkSheet->setCellValue('BP'.$fila, $Total);
        //total total
        $objWorkSheet->setCellValue('BQ'.$fila, $TotTotGen);
        $TotalTotalAlmacen=$TotalTotalAlmacen+$TotTotGen;
        
        //porcentaje total por vendedor jairo
        // $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        //totales laboratorios
        include('totalesLaboratorios.php');
        //TOTAL AREA
        $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$fila,'=(F'.$fila.'+I'.$fila.'+L'.$fila.'+O'.$fila.'+R'.$fila.'+U'.$fila.'+X'.$fila.'+AA'.$fila.'+AD'.$fila.'+AJ'.$fila.'+AM'.$fila.'+AS'.$fila.'+AV'.$fila.'+AY'.$fila.'+BE'.$fila.'+BH'.$fila.'+BK'.$fila.'+BN'.$fila.')');
        // $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        $TotalT=$TotalT+$Total;
        
        //JORGE
        $VentaCont1=0;$VentaCred1=0;$VentaMixt1=0;$NotasCrCont1=0;$NotasCrCred1=0;$NotasCrMixt1=0;$NotaDebito1=0;$NotasdCobra1=0;$NotasdCobra1=0;$Subtotal1=0;$DistriBolsa1=0;$Total1=0;      
        
        //GATOS*********************************************************************************************************************
        $fila++;
        $area='GATOS';
        $fila++;
        $queryv = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[cliVendedor] WHERE SectorLab = '$area' ORDER BY Codigo ASC;", $cLink);
        $num=mssql_num_rows($queryv);
        $tamfilArea=$fila+$num-1;
        $Total=0;
        //combina areas
        $objWorkSheet->mergeCells("A".$fila.":A".$tamfilArea."");
        $objWorkSheet->setCellValue('A'.$fila, $area);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':A'.$tamfilArea)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //SUBTOTALES
        $VentaCont1=0; $VentaCred1=0; $VentaMixt1=0; $NotasCrCont1=0; $NotasCrCred1=0; $NotasCrMixt1=0; $NotaDebito1=0; $NotasdCobra1=0; $Subtotal1=0; $DistriBolsa1=0;
        $filainicio=$fila;
        $TotalLab1=0;$TotalLab2=0;$TotalLab3=0;$TotalLab4=0;$TotalLab5=0;$TotalLab6=0;$TotalLab7=0;$TotalLab8=0;$TotalLab9=0;$TotalLab10=0;$TotalLab11=0;$TotalLab12=0;$TotalLab13=0;$TotalLab14=0;$TotalLab15=0;$TotalLab16=0;$TotalLab17=0;$TotalLab18=0;
        $TotalCuo1=0;$TotalCuo2=0;$TotalCuo3=0;$TotalCuo4=0;$TotalCuo5=0;$TotalCuo6=0;$TotalCuo7=0;$TotalCuo8=0;$TotalCuo9=0;$TotalCuo10=0;$TotalCuo11=0;$TotalCuo12=0;$TotalCuo13=0;$TotalCuo14=0;$TotalCuo15=0;$TotalCuo16=0;$TotalCuo17=0;$TotalCuo18=0;
        $TotTotGen=0;
        while($rowVend = mssql_fetch_array($queryv)){
            $vend = trim($rowVend['Codigo']);
            $nomb = trim($rowVend['Apellidos'])." ".trim($rowVend['Nombres']);
            //cod vendedores
            $objWorkSheet->setCellValue('B'.$fila, $vend);  
            $objWorkSheet->setCellValue('C'.$fila, utf8_encode($nomb));
            $objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //valores
            $queryval = mssql_query("SELECT cuotagen FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND codVend='$vend' AND Periodo='$periodo' AND tipoCuota != 'Cuota Laboratorio';", $cLink);
            if($rowVendVal = mssql_fetch_array($queryval)){
                $cuotag = trim($rowVendVal['cuotagen']);
                $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
                $Total=$Total+$cuotag;         
            }else{
                $cuotag = 0;
                $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
            }
            $queryvalv = mssql_query("SELECT Venta FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND codVend='$vend' AND Periodo='$periodo' AND SectorLab='TODO' AND tipoCuota = 'Cuota Laboratorio';", $cLink);
            if($rowVendVenta = mssql_fetch_array($queryvalv)){
                $VentaTot = trim($rowVendVenta['Venta']);
                $objWorkSheet->setCellValue('BQ'.$fila, $VentaTot);
                $TotTotGen=$TotTotGen+$VentaTot;
                //$Total=$Total+$cuotag;         
            }else{
                $VentaTot = 0;
                $objWorkSheet->setCellValue('D'.$fila, $VentaTot);
            }
            
            //porcentaje total*******
            $P=0;
            if($cuotag > 0){
                // $P=round(($VentaTot/$cuotag));
                $P=round(($VentaTot/$cuotag));
            }
            $objWorkSheet->setCellValue('BR'.$fila, $P);
            $objPHPExcel->getActiveSheet()->getStyle('BR'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            //LABORATORIOS
            $queryval = mssql_query("SELECT Cuota, Venta, SectorLab FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND tipoCuota='Cuota Laboratorio' AND codVend='$vend' AND Periodo='$periodo';", $cLink);
            while($rowVendValab = mssql_fetch_array($queryval)){
                $cuotaLab = trim($rowVendValab['Cuota']);
                $ventaLab = trim($rowVendValab['Venta']);
                $sectorLab = trim($rowVendValab['SectorLab']);
                include('valoresVC.php');
                $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$fila,'=(F'.$fila.'+I'.$fila.'+L'.$fila.'+O'.$fila.'+R'.$fila.'+U'.$fila.'+X'.$fila.'+AA'.$fila.'+AD'.$fila.'+AJ'.$fila.'+AM'.$fila.'+AS'.$fila.'+AV'.$fila.'+AY'.$fila.'+BE'.$fila.'+BH'.$fila.'+BK'.$fila.'+BN'.$fila.')');
                // $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
                $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
                $objWorkSheet->setCellValue('BR'.$fila, $Porc);
            }//FIN LABORATORIOS
            
            //CUADRO 2 JORGE
            $querysumCom = mssql_query("SELECT SUM(VentaCont) as VentaCont, sum(VentaCred) as VentaCred, sum(VentaMixt) as VentaMixt, sum(NotasCrCont) as NotasCrCont, sum(NotasCrCred) as NotasCrCred, sum(NotasCrMixt) as NotasCrMixt, sum(NotaDebito) as NotaDebito,sum(NotasdCobra) as NotasdCobra,sum(Subtotal) as Subtotal,sum(DistriBolsa) as DistriBolsa,sum(Total) as Total,sum(Falta) as Falta,sum(DifTotMix) as DifTotMix FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='$vend' and Periodo='$periodo';", $cLink);
            if($rowVendValab = mssql_fetch_array($querysumCom)){
                
                $VentaCont = trim($rowVendValab['VentaCont']);
                $VentaCred = trim($rowVendValab['VentaCred']);
                $VentaMixt = trim($rowVendValab['VentaMixt']);
                $NotasCrCont = trim($rowVendValab['NotasCrCont']);
                $NotasCrCred = trim($rowVendValab['NotasCrCred']);
                $NotasCrMixt = trim($rowVendValab['NotasCrMixt']);
                $NotaDebito = trim($rowVendValab['NotaDebito']);
                $NotasdCobra = trim($rowVendValab['NotasdCobra']);
                $Subtotal = trim($rowVendValab['Subtotal']);
                $DistriBolsa = trim($rowVendValab['DistriBolsa']);
                $Totalkl = trim($rowVendValab['Total']);
                //$Total="=CC7+CD7"."aqui";
                //$Falta = trim($rowVendValab['Falta']);
                $Falta="=BQ".$fila."-BP".$fila;
                //$DifTotMix = trim($rowVendValab['DifTotMix']);
                $DifTotMix="=CE".$fila."-BW".$fila."+BZ".$fila;
                //$Porc="=CE".$fila."/BP".$fila;
                $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(CE".$fila."/BP".$fila.",0)");
                
                
                //filas
                if($VentaCont=='-'){$VentaCont=0;}
                $objWorkSheet->setCellValue('BU'.$fila, $VentaCont);
                if($VentaCred=='-'){$VentaCred=0;}
                $objWorkSheet->setCellValue('BV'.$fila, $VentaCred);
                if($VentaMixt=='-'){$VentaMixt=0;}
                $objWorkSheet->setCellValue('BW'.$fila, $VentaMixt);
                if($NotasCrCont=='-'){$NotasCrCont=0;}
                $objWorkSheet->setCellValue('BX'.$fila, $NotasCrCont);
                if($NotasCrCred=='-'){$NotasCrCred=0;}
                $objWorkSheet->setCellValue('BY'.$fila, $NotasCrCred);
                if($NotasCrMixt=='-'){$NotasCrMixt=0;}
                $objWorkSheet->setCellValue('BZ'.$fila, $NotasCrMixt);
                if($NotaDebito=='-'){$NotaDebito=0;}
                $objWorkSheet->setCellValue('CA'.$fila, $NotaDebito);
                if($NotasdCobra=='-'){$NotasdCobra=0;}
                $objWorkSheet->setCellValue('CB'.$fila, $NotasdCobra);
                if($DistriBolsa=='-'){$DistriBolsa=0;}
                $objWorkSheet->setCellValue('CD'.$fila, $DistriBolsa);
                if($Totalkl=='-'){$Totalkl=0;}
                $objWorkSheet->setCellValue('CE'.$fila, $Totalkl);
                if($Falta=='-'){$Falta=0;}
                $objWorkSheet->setCellValue('CF'.$fila, $Falta);
                if($DifTotMix=='-'){$DifTotMix=0;}
                $objWorkSheet->setCellValue('CG'.$fila, $DifTotMix);
                if($Porc=='-'){$Porc=0;}
                $objWorkSheet->setCellValue('CH'.$fila, $Porc);
            }
            
            //SUBTOTAL CUADRO DERECHA
            $objPHPExcel->getActiveSheet()->setCellValue('CC'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')');
            
            //SUBTOTAL CUADRO DERECHA
            $objPHPExcel->getActiveSheet()->setCellValue('CC'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')');
            $objPHPExcel->getActiveSheet()->setCellValue('CE'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')-CD'.$fila);
            $objPHPExcel->getActiveSheet()->setCellValue('CF'.$fila,'=(BQ'.$fila.'-BP'.$fila.')');
            
            
            //FIN JORGE
            
            $fila++;          
        }
            //borde cuadro derecha
            $objWorkSheet->setCellValue('BT'.$fila, 'TOTAL '.$area);
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
            //centrar horizontal
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //centrar V
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getFont()->setBold(true);
            
            //tama�o} cuadro derecha
            $objPHPExcel->getActiveSheet()->getColumnDimension('BT')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BU')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BV')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BW')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BX')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BY')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BZ')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CA')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CB')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CC')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CD')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CE')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CF')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CG')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CH')->setWidth(22);
            //total 
         
                    
            //SUMA VERTICAL
            $filafin=$fila-1;
            //contado
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BU".$filainicio.":BU".$filafin.")");
            $objWorkSheet->setCellValue('BU'.$fila, $SumaVertical1);
            //credito
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BV".$filainicio.":BV".$filafin.")");
            $objWorkSheet->setCellValue('BV'.$fila, $SumaVertical1);
            //MIXTA
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BW".$filainicio.":BW".$filafin.")");
            $objWorkSheet->setCellValue('BW'.$fila, $SumaVertical1);
            //NOTAS CREDITO CONTADO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BX".$filainicio.":BX".$filafin.")");
            $objWorkSheet->setCellValue('BX'.$fila, $SumaVertical1);
            //NOTAS CREDITO CREDITO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BY".$filainicio.":BY".$filafin.")");
            $objWorkSheet->setCellValue('BY'.$fila, $SumaVertical1);
            //NOTAS CREDITO MIXTAS
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BZ".$filainicio.":BZ".$filafin.")");
            $objWorkSheet->setCellValue('BZ'.$fila, $SumaVertical1);
            //NOTAS DEBITO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CA".$filainicio.":CA".$filafin.")");
            $objWorkSheet->setCellValue('CA'.$fila, $SumaVertical1);
            //NOTAS DEBITO COBRADAS
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CB".$filainicio.":CB".$filafin.")");
            $objWorkSheet->setCellValue('CB'.$fila, $SumaVertical1);
            //SUBTOTAL
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CC".$filainicio.":CC".$filafin.")");
            $objWorkSheet->setCellValue('CC'.$fila, $SumaVertical1);
            //suma distribolsa
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CD".$filainicio.":CD".$filafin.")");
            $objWorkSheet->setCellValue('CD'.$fila, $SumaVertical1);
            //suma total
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CE".$filainicio.":CE".$filafin.")");
            $objWorkSheet->setCellValue('CE'.$fila, $SumaVertical1);
            //suma LE FALTA
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CF".$filainicio.":CF".$filafin.")");
            $objWorkSheet->setCellValue('CF'.$fila, $SumaVertical1);
            //SUMA DIFERENCIA TOTAL
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CG".$filainicio.":CG".$filafin.")");
            $objWorkSheet->setCellValue('CG'.$fila, $SumaVertical1);
            //PORCENTAJE TOTAL
            $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(CE".$fila."/BP".$fila.",0)");
            $objWorkSheet->setCellValue('CH'.$fila, $Porc);
            
        //total
        //combinar celdas
        $objWorkSheet->mergeCells("A".$fila.":C".$fila."");
        $objWorkSheet->setCellValue('A'.$fila, 'TOTAL '.$area);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //valor
        $objWorkSheet->setCellValue('D'.$fila, $Total);
        $objWorkSheet->setCellValue('BP'.$fila, $Total);
        //total total
        $objWorkSheet->setCellValue('BQ'.$fila, $TotTotGen);
        $TotalTotalAlmacen=$TotalTotalAlmacen+$TotTotGen;
        
        //porcentaje total por vendedor jairo
        // $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        //totales laboratorios
        include('totalesLaboratorios.php');
        //TOTAL AREA
        $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$fila,'=(F'.$fila.'+I'.$fila.'+L'.$fila.'+O'.$fila.'+R'.$fila.'+U'.$fila.'+X'.$fila.'+AA'.$fila.'+AD'.$fila.'+AJ'.$fila.'+AM'.$fila.'+AS'.$fila.'+AV'.$fila.'+AY'.$fila.'+BE'.$fila.'+BH'.$fila.'+BK'.$fila.'+BN'.$fila.')');
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        $TotalT=$TotalT+$Total;
        
        //JORGE
        $VentaCont1=0;$VentaCred1=0;$VentaMixt1=0;$NotasCrCont1=0;$NotasCrCred1=0;$NotasCrMixt1=0;$NotaDebito1=0;$NotasdCobra1=0;$NotasdCobra1=0;$Subtotal1=0;$DistriBolsa1=0;$Total1=0;
        
        //MOSTRADOR*********************************************************************************************************************
        $fila++;
        $area='MOSTRADOR';
        $fila++;
        $queryv = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[cliVendedor] WHERE SectorLab = '$area' ORDER BY Codigo ASC;", $cLink);
        $num=mssql_num_rows($queryv);
        $tamfilArea=$fila+$num-1;
        $Total=0;
        //combina areas
        $objWorkSheet->mergeCells("A".$fila.":A".$tamfilArea."");
        $objWorkSheet->setCellValue('A'.$fila, $area);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':A'.$tamfilArea)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //SUBTOTALES
        $VentaCont1=0; $VentaCred1=0; $VentaMixt1=0; $NotasCrCont1=0; $NotasCrCred1=0; $NotasCrMixt1=0; $NotaDebito1=0; $NotasdCobra1=0; $Subtotal1=0; $DistriBolsa1=0;
        $filainicio=$fila;
        $TotalLab1=0;$TotalLab2=0;$TotalLab3=0;$TotalLab4=0;$TotalLab5=0;$TotalLab6=0;$TotalLab7=0;$TotalLab8=0;$TotalLab9=0;$TotalLab10=0;$TotalLab11=0;$TotalLab12=0;$TotalLab13=0;$TotalLab14=0;$TotalLab15=0;$TotalLab16=0;$TotalLab17=0;$TotalLab18=0;
        $TotalCuo1=0;$TotalCuo2=0;$TotalCuo3=0;$TotalCuo4=0;$TotalCuo5=0;$TotalCuo6=0;$TotalCuo7=0;$TotalCuo8=0;$TotalCuo9=0;$TotalCuo10=0;$TotalCuo11=0;$TotalCuo12=0;$TotalCuo13=0;$TotalCuo14=0;$TotalCuo15=0;$TotalCuo16=0;$TotalCuo17=0;$TotalCuo18=0;
        $TotTotGen=0;
        while($rowVend = mssql_fetch_array($queryv)){
            $vend = trim($rowVend['Codigo']);
            $nomb = trim($rowVend['Apellidos'])." ".trim($rowVend['Nombres']);
            //cod vendedores
            $objWorkSheet->setCellValue('B'.$fila, $vend);  
            $objWorkSheet->setCellValue('C'.$fila, utf8_encode($nomb));
            $objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //valores
            $queryval = mssql_query("SELECT cuotagen FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND codVend='$vend' AND Periodo='$periodo' AND tipoCuota != 'Cuota Laboratorio';", $cLink);
            if($rowVendVal = mssql_fetch_array($queryval)){
                $cuotag = trim($rowVendVal['cuotagen']);
                $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
                $Total=$Total+$cuotag;         
            }else{
                $cuotag = 0;
                $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
            }
            $queryvalv = mssql_query("SELECT Venta FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND codVend='$vend' AND Periodo='$periodo' AND SectorLab='TODO' AND tipoCuota = 'Cuota Laboratorio';", $cLink);
            if($rowVendVenta = mssql_fetch_array($queryvalv)){
                $VentaTot = trim($rowVendVenta['Venta']);
                $objWorkSheet->setCellValue('BQ'.$fila, $VentaTot);
                $TotTotGen=$TotTotGen+$VentaTot;
                //$Total=$Total+$cuotag;         
            }else{
                $VentaTot = 0;
                $objWorkSheet->setCellValue('D'.$fila, $VentaTot);
            }
            
            //porcentaje total*******
            $P=0;
            if($cuotag > 0){
                // $P=round(($VentaTot/$cuotag));
                $P=round(($VentaTot/$cuotag));
            }
            $objWorkSheet->setCellValue('BR'.$fila, $P);
            $objPHPExcel->getActiveSheet()->getStyle('BR'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            //LABORATORIOS
            $formulaH='';
            $VentasTotHorizontal=0;
            $queryval = mssql_query("SELECT Cuota, Venta, SectorLab FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND tipoCuota='Cuota Laboratorio' AND codVend='$vend' AND Periodo='$periodo';", $cLink);
            while($rowVendValab = mssql_fetch_array($queryval)){
                $cuotaLab = trim($rowVendValab['Cuota']);
                $ventaLab = trim($rowVendValab['Venta']);
                $sectorLab = trim($rowVendValab['SectorLab']);
                include('valoresVC.php');
                //SUBTOTALES
                $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$fila,'=(F'.$fila.'+I'.$fila.'+L'.$fila.'+O'.$fila.'+R'.$fila.'+U'.$fila.'+X'.$fila.'+AA'.$fila.'+AD'.$fila.'+AJ'.$fila.'+AM'.$fila.'+AS'.$fila.'+AV'.$fila.'+AY'.$fila.'+BE'.$fila.'+BH'.$fila.'+BK'.$fila.'+BN'.$fila.')');
                $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
                $objWorkSheet->setCellValue('BR'.$fila, $Porc);
            }//FIN LABORATORIOS
            
            //CUADRO 2 JORGE
            $querysumCom = mssql_query("SELECT SUM(VentaCont) as VentaCont, sum(VentaCred) as VentaCred, sum(VentaMixt) as VentaMixt, sum(NotasCrCont) as NotasCrCont, sum(NotasCrCred) as NotasCrCred, sum(NotasCrMixt) as NotasCrMixt, sum(NotaDebito) as NotaDebito,sum(NotasdCobra) as NotasdCobra,sum(Subtotal) as Subtotal,sum(DistriBolsa) as DistriBolsa,sum(Total) as Total,sum(Falta) as Falta,sum(DifTotMix) as DifTotMix FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='$vend' and Periodo='$periodo';", $cLink);
            if($rowVendValab = mssql_fetch_array($querysumCom)){
                
                $VentaCont = trim($rowVendValab['VentaCont']);
                $VentaCred = trim($rowVendValab['VentaCred']);
                $VentaMixt = trim($rowVendValab['VentaMixt']);
                $NotasCrCont = trim($rowVendValab['NotasCrCont']);
                $NotasCrCred = trim($rowVendValab['NotasCrCred']);
                $NotasCrMixt = trim($rowVendValab['NotasCrMixt']);
                $NotaDebito = trim($rowVendValab['NotaDebito']);
                $NotasdCobra = trim($rowVendValab['NotasdCobra']);
                $Subtotal = trim($rowVendValab['Subtotal']);
                $DistriBolsa = trim($rowVendValab['DistriBolsa']);
                $Totalkl = trim($rowVendValab['Total']);
                //$Total="=CC7+CD7"."aqui";
                //$Falta = trim($rowVendValab['Falta']);
                $Falta="=BQ".$fila."-BP".$fila;
                //$DifTotMix = trim($rowVendValab['DifTotMix']);
                $DifTotMix="=CE".$fila."-BW".$fila."+BZ".$fila;
                //$Porc="=CE".$fila."/BP".$fila;
                $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(CE".$fila."/BP".$fila.",0)");
                
                
                //filas
                if($VentaCont=='-'){$VentaCont=0;}
                $objWorkSheet->setCellValue('BU'.$fila, $VentaCont);
                if($VentaCred=='-'){$VentaCred=0;}
                $objWorkSheet->setCellValue('BV'.$fila, $VentaCred);
                if($VentaMixt=='-'){$VentaMixt=0;}
                $objWorkSheet->setCellValue('BW'.$fila, $VentaMixt);
                if($NotasCrCont=='-'){$NotasCrCont=0;}
                $objWorkSheet->setCellValue('BX'.$fila, $NotasCrCont);
                if($NotasCrCred=='-'){$NotasCrCred=0;}
                $objWorkSheet->setCellValue('BY'.$fila, $NotasCrCred);
                if($NotasCrMixt=='-'){$NotasCrMixt=0;}
                $objWorkSheet->setCellValue('BZ'.$fila, $NotasCrMixt);
                if($NotaDebito=='-'){$NotaDebito=0;}
                $objWorkSheet->setCellValue('CA'.$fila, $NotaDebito);
                if($NotasdCobra=='-'){$NotasdCobra=0;}
                $objWorkSheet->setCellValue('CB'.$fila, $NotasdCobra);
                if($DistriBolsa=='-'){$DistriBolsa=0;}
                $objWorkSheet->setCellValue('CD'.$fila, $DistriBolsa);
                if($Totalkl=='-'){$Totalkl=0;}
                $objWorkSheet->setCellValue('CE'.$fila, $Totalkl);
                if($Falta=='-'){$Falta=0;}
                $objWorkSheet->setCellValue('CF'.$fila, $Falta);
                if($DifTotMix=='-'){$DifTotMix=0;}
                $objWorkSheet->setCellValue('CG'.$fila, $DifTotMix);
                if($Porc=='-'){$Porc=0;}
                $objWorkSheet->setCellValue('CH'.$fila, $Porc);
            }
            
            //SUBTOTAL CUADRO DERECHA
            $objPHPExcel->getActiveSheet()->setCellValue('CC'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')');
            
            //SUBTOTAL CUADRO DERECHA
            $objPHPExcel->getActiveSheet()->setCellValue('CC'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')');
            $objPHPExcel->getActiveSheet()->setCellValue('CE'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')-CD'.$fila);
            $objPHPExcel->getActiveSheet()->setCellValue('CF'.$fila,'=(BQ'.$fila.'-BP'.$fila.')');
            
            //FIN JORGE
            
            $fila++;          
        }
         //borde cuadro derecha
            $objWorkSheet->setCellValue('BT'.$fila, 'TOTAL '.$area);
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
            //centrar horizontal
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //centrar V
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getFont()->setBold(true);
            
            //tama�o} cuadro derecha
            $objPHPExcel->getActiveSheet()->getColumnDimension('BT')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BU')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BV')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BW')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BX')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BY')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BZ')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CA')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CB')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CC')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CD')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CE')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CF')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CG')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CH')->setWidth(22);
            //total 
         
        
            //SUMA VERTICAL
            $filafin=$fila-1;
            //contado
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BU".$filainicio.":BU".$filafin.")");
            $objWorkSheet->setCellValue('BU'.$fila, $SumaVertical1);
            //credito
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BV".$filainicio.":BV".$filafin.")");
            $objWorkSheet->setCellValue('BV'.$fila, $SumaVertical1);
            //MIXTA
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BW".$filainicio.":BW".$filafin.")");
            $objWorkSheet->setCellValue('BW'.$fila, $SumaVertical1);
            //NOTAS CREDITO CONTADO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BX".$filainicio.":BX".$filafin.")");
            $objWorkSheet->setCellValue('BX'.$fila, $SumaVertical1);
            //NOTAS CREDITO CREDITO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BY".$filainicio.":BY".$filafin.")");
            $objWorkSheet->setCellValue('BY'.$fila, $SumaVertical1);
            //NOTAS CREDITO MIXTAS
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BZ".$filainicio.":BZ".$filafin.")");
            $objWorkSheet->setCellValue('BZ'.$fila, $SumaVertical1);
            //NOTAS DEBITO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CA".$filainicio.":CA".$filafin.")");
            $objWorkSheet->setCellValue('CA'.$fila, $SumaVertical1);
            //NOTAS DEBITO COBRADAS
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CB".$filainicio.":CB".$filafin.")");
            $objWorkSheet->setCellValue('CB'.$fila, $SumaVertical1);
            //SUBTOTAL
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CC".$filainicio.":CC".$filafin.")");
            $objWorkSheet->setCellValue('CC'.$fila, $SumaVertical1);
            //suma distribolsa
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CD".$filainicio.":CD".$filafin.")");
            $objWorkSheet->setCellValue('CD'.$fila, $SumaVertical1);
            //suma total
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CE".$filainicio.":CE".$filafin.")");
            $objWorkSheet->setCellValue('CE'.$fila, $SumaVertical1);
            //suma LE FALTA
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CF".$filainicio.":CF".$filafin.")");
            $objWorkSheet->setCellValue('CF'.$fila, $SumaVertical1);
            //SUMA DIFERENCIA TOTAL
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CG".$filainicio.":CG".$filafin.")");
            $objWorkSheet->setCellValue('CG'.$fila, $SumaVertical1);
            //PORCENTAJE TOTAL
            $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(CE".$fila."/BP".$fila.",0)");
            $objWorkSheet->setCellValue('CH'.$fila, $Porc);
            
        //total
        //combinar celdas
        $objWorkSheet->mergeCells("A".$fila.":C".$fila."");
        $objWorkSheet->setCellValue('A'.$fila, 'TOTAL '.$area);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //valor
        $objWorkSheet->setCellValue('D'.$fila, $Total);
        $objWorkSheet->setCellValue('BP'.$fila, $Total);
        //total total
        $objWorkSheet->setCellValue('BQ'.$fila, $TotTotGen);
        $TotalTotalAlmacen=$TotalTotalAlmacen+$TotTotGen;
        
        //porcentaje total por vendedor jairo
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        //totales laboratorios
        include('totalesLaboratorios.php');
        
        //TOTAL AREA
        $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$fila,'=(F'.$fila.'+I'.$fila.'+L'.$fila.'+O'.$fila.'+R'.$fila.'+U'.$fila.'+X'.$fila.'+AA'.$fila.'+AD'.$fila.'+AJ'.$fila.'+AM'.$fila.'+AS'.$fila.'+AV'.$fila.'+AY'.$fila.'+BE'.$fila.'+BH'.$fila.'+BK'.$fila.'+BN'.$fila.')');
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        $TotalT=$TotalT+$Total;
        
        
        //JORGE
        $VentaCont1=0;$VentaCred1=0;$VentaMixt1=0;$NotasCrCont1=0;$NotasCrCred1=0;$NotasCrMixt1=0;$NotaDebito1=0;$NotasdCobra1=0;$NotasdCobra1=0;$Subtotal1=0;$DistriBolsa1=0;$Total1=0;
        
        //PEQUEÑOS*********************************************************************************************************************
        $fila++;
        $area='PEQUE';
        $msg=utf8_encode("PEQUENOS");
        $fila++;
        $queryv = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[cliVendedor] WHERE left(SectorLab,5) = '$area' ORDER BY Codigo ASC;", $cLink);
        $num=mssql_num_rows($queryv);
        $tamfilArea=$fila+$num-1;
        $Total=0;
        //combina areas
        $objWorkSheet->mergeCells("A".$fila.":A".$tamfilArea."");
        $objWorkSheet->setCellValue('A'.$fila, $msg);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':A'.$tamfilArea)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //SUBTOTALES
        $VentaCont1=0; $VentaCred1=0; $VentaMixt1=0; $NotasCrCont1=0; $NotasCrCred1=0; $NotasCrMixt1=0; $NotaDebito1=0; $NotasdCobra1=0; $Subtotal1=0; $DistriBolsa1=0;
        $filainicio=$fila;
        $TotalLab1=0;$TotalLab2=0;$TotalLab3=0;$TotalLab4=0;$TotalLab5=0;$TotalLab6=0;$TotalLab7=0;$TotalLab8=0;$TotalLab9=0;$TotalLab10=0;$TotalLab11=0;$TotalLab12=0;$TotalLab13=0;$TotalLab14=0;$TotalLab15=0;$TotalLab16=0;$TotalLab17=0;$TotalLab18=0;
        $TotalCuo1=0;$TotalCuo2=0;$TotalCuo3=0;$TotalCuo4=0;$TotalCuo5=0;$TotalCuo6=0;$TotalCuo7=0;$TotalCuo8=0;$TotalCuo9=0;$TotalCuo10=0;$TotalCuo11=0;$TotalCuo12=0;$TotalCuo13=0;$TotalCuo14=0;$TotalCuo15=0;$TotalCuo16=0;$TotalCuo17=0;$TotalCuo18=0;
        $TotTotGen=0;
        while($rowVend = mssql_fetch_array($queryv)){
            $vend = trim($rowVend['Codigo']);
            $nomb = trim($rowVend['Apellidos'])." ".trim($rowVend['Nombres']);
            //cod vendedores
            $objWorkSheet->setCellValue('B'.$fila, $vend);  
            $objWorkSheet->setCellValue('C'.$fila, utf8_encode($nomb));
            $objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //valores
            $queryval = mssql_query("SELECT cuotagen FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE left(Area,5) = '$area' AND codVend='$vend' AND Periodo='$periodo' AND tipoCuota != 'Cuota Laboratorio';", $cLink);
            if($rowVendVal = mssql_fetch_array($queryval)){
                $cuotag = trim($rowVendVal['cuotagen']);
                $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
                $Total=$Total+$cuotag;         
            }else{
                $cuotag = 0;
                $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
            }
            $queryvalv = mssql_query("SELECT Venta FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE left(Area,5) = '$area' AND codVend='$vend' AND Periodo='$periodo' AND SectorLab='TODO' AND tipoCuota = 'Cuota Laboratorio';", $cLink);
            if($rowVendVenta = mssql_fetch_array($queryvalv)){
                $VentaTot = trim($rowVendVenta['Venta']);
                $objWorkSheet->setCellValue('BQ'.$fila, $VentaTot);
                $TotTotGen=$TotTotGen+$VentaTot;
                //$Total=$Total+$cuotag;         
            }else{
                $VentaTot = 0;
                $objWorkSheet->setCellValue('D'.$fila, $VentaTot);
            }
            
            //porcentaje total*******
            $P=0;
            if($cuotag > 0){
                // $P=round(($VentaTot/$cuotag));
                $P=round(($VentaTot/$cuotag));
            }
            $objWorkSheet->setCellValue('BR'.$fila, $P);
            $objPHPExcel->getActiveSheet()->getStyle('BR'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            //LABORATORIOS
            $queryval = mssql_query("SELECT Cuota, Venta, SectorLab FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE left(Area,5) = '$area' AND tipoCuota='Cuota Laboratorio' AND codVend='$vend' AND Periodo='$periodo';", $cLink);
            while($rowVendValab = mssql_fetch_array($queryval)){
                $cuotaLab = trim($rowVendValab['Cuota']);
                $ventaLab = trim($rowVendValab['Venta']);
                $sectorLab = trim($rowVendValab['SectorLab']);
                include('valoresVC.php');
                $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$fila,'=(F'.$fila.'+I'.$fila.'+L'.$fila.'+O'.$fila.'+R'.$fila.'+U'.$fila.'+X'.$fila.'+AA'.$fila.'+AD'.$fila.'+AJ'.$fila.'+AM'.$fila.'+AS'.$fila.'+AV'.$fila.'+AY'.$fila.'+BE'.$fila.'+BH'.$fila.'+BK'.$fila.'+BN'.$fila.')');
                $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
                $objWorkSheet->setCellValue('BR'.$fila, $Porc);
            }//FIN LABORATORIOS
            
            //CUADRO 2 JORGE
            $querysumCom = mssql_query("SELECT SUM(VentaCont) as VentaCont, sum(VentaCred) as VentaCred, sum(VentaMixt) as VentaMixt, sum(NotasCrCont) as NotasCrCont, sum(NotasCrCred) as NotasCrCred, sum(NotasCrMixt) as NotasCrMixt, sum(NotaDebito) as NotaDebito,sum(NotasdCobra) as NotasdCobra,sum(Subtotal) as Subtotal,sum(DistriBolsa) as DistriBolsa,sum(Total) as Total,sum(Falta) as Falta,sum(DifTotMix) as DifTotMix FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='$vend' and Periodo='$periodo';", $cLink);
            if($rowVendValab = mssql_fetch_array($querysumCom)){
                
                $VentaCont = trim($rowVendValab['VentaCont']);
                $VentaCred = trim($rowVendValab['VentaCred']);
                $VentaMixt = trim($rowVendValab['VentaMixt']);
                $NotasCrCont = trim($rowVendValab['NotasCrCont']);
                $NotasCrCred = trim($rowVendValab['NotasCrCred']);
                $NotasCrMixt = trim($rowVendValab['NotasCrMixt']);
                $NotaDebito = trim($rowVendValab['NotaDebito']);
                $NotasdCobra = trim($rowVendValab['NotasdCobra']);
                $Subtotal = trim($rowVendValab['Subtotal']);
                $DistriBolsa = trim($rowVendValab['DistriBolsa']);
                $Totalkl = trim($rowVendValab['Total']);
                //$Total="=CC7+CD7"."aqui";
                //$Falta = trim($rowVendValab['Falta']);
                $Falta="=BQ".$fila."-BP".$fila;
                //$DifTotMix = trim($rowVendValab['DifTotMix']);
                $DifTotMix="=CE".$fila."-BW".$fila."+BZ".$fila;
                //$Porc="=CE".$fila."/BP".$fila;
                $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(CE".$fila."/BP".$fila.",0)");
                
                
                //filas
                if($VentaCont=='-'){$VentaCont=0;}
                $objWorkSheet->setCellValue('BU'.$fila, $VentaCont);
                if($VentaCred=='-'){$VentaCred=0;}
                $objWorkSheet->setCellValue('BV'.$fila, $VentaCred);
                if($VentaMixt=='-'){$VentaMixt=0;}
                $objWorkSheet->setCellValue('BW'.$fila, $VentaMixt);
                if($NotasCrCont=='-'){$NotasCrCont=0;}
                $objWorkSheet->setCellValue('BX'.$fila, $NotasCrCont);
                if($NotasCrCred=='-'){$NotasCrCred=0;}
                $objWorkSheet->setCellValue('BY'.$fila, $NotasCrCred);
                if($NotasCrMixt=='-'){$NotasCrMixt=0;}
                $objWorkSheet->setCellValue('BZ'.$fila, $NotasCrMixt);
                if($NotaDebito=='-'){$NotaDebito=0;}
                $objWorkSheet->setCellValue('CA'.$fila, $NotaDebito);
                if($NotasdCobra=='-'){$NotasdCobra=0;}
                $objWorkSheet->setCellValue('CB'.$fila, $NotasdCobra);
                if($DistriBolsa=='-'){$DistriBolsa=0;}
                $objWorkSheet->setCellValue('CD'.$fila, $DistriBolsa);
                if($Totalkl=='-'){$Totalkl=0;}
                $objWorkSheet->setCellValue('CE'.$fila, $Totalkl);
                if($Falta=='-'){$Falta=0;}
                $objWorkSheet->setCellValue('CF'.$fila, $Falta);
                if($DifTotMix=='-'){$DifTotMix=0;}
                $objWorkSheet->setCellValue('CG'.$fila, $DifTotMix);
                if($Porc=='-'){$Porc=0;}
                $objWorkSheet->setCellValue('CH'.$fila, $Porc);
            }
            
            //SUBTOTAL CUADRO DERECHA
            $objPHPExcel->getActiveSheet()->setCellValue('CC'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')');
            
            //SUBTOTAL CUADRO DERECHA
            $objPHPExcel->getActiveSheet()->setCellValue('CC'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')');
            $objPHPExcel->getActiveSheet()->setCellValue('CE'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')-CD'.$fila);
            $objPHPExcel->getActiveSheet()->setCellValue('CF'.$fila,'=(BQ'.$fila.'-BP'.$fila.')');
            
            //FIN JORGE
            
            $fila++;          
        }
            //borde cuadro derecha
            $objWorkSheet->setCellValue('BT'.$fila, 'TOTAL '.$msg);
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
            //centrar horizontal
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //centrar V
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getFont()->setBold(true);
            
            //tama�o} cuadro derecha
            $objPHPExcel->getActiveSheet()->getColumnDimension('BT')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BU')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BV')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BW')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BX')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BY')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BZ')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CA')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CB')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CC')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CD')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CE')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CF')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CG')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CH')->setWidth(22);
            //total 
         
        
            //SUMA VERTICAL
            $filafin=$fila-1;
            //contado
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BU".$filainicio.":BU".$filafin.")");
            $objWorkSheet->setCellValue('BU'.$fila, $SumaVertical1);
            //credito
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BV".$filainicio.":BV".$filafin.")");
            $objWorkSheet->setCellValue('BV'.$fila, $SumaVertical1);
            //MIXTA
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BW".$filainicio.":BW".$filafin.")");
            $objWorkSheet->setCellValue('BW'.$fila, $SumaVertical1);
            //NOTAS CREDITO CONTADO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BX".$filainicio.":BX".$filafin.")");
            $objWorkSheet->setCellValue('BX'.$fila, $SumaVertical1);
            //NOTAS CREDITO CREDITO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BY".$filainicio.":BY".$filafin.")");
            $objWorkSheet->setCellValue('BY'.$fila, $SumaVertical1);
            //NOTAS CREDITO MIXTAS
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BZ".$filainicio.":BZ".$filafin.")");
            $objWorkSheet->setCellValue('BZ'.$fila, $SumaVertical1);
            //NOTAS DEBITO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CA".$filainicio.":CA".$filafin.")");
            $objWorkSheet->setCellValue('CA'.$fila, $SumaVertical1);
            //NOTAS DEBITO COBRADAS
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CB".$filainicio.":CB".$filafin.")");
            $objWorkSheet->setCellValue('CB'.$fila, $SumaVertical1);
            //SUBTOTAL
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CC".$filainicio.":CC".$filafin.")");
            $objWorkSheet->setCellValue('CC'.$fila, $SumaVertical1);
            //suma distribolsa
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CD".$filainicio.":CD".$filafin.")");
            $objWorkSheet->setCellValue('CD'.$fila, $SumaVertical1);
            //suma total
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CE".$filainicio.":CE".$filafin.")");
            $objWorkSheet->setCellValue('CE'.$fila, $SumaVertical1);
            //suma LE FALTA
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CF".$filainicio.":CF".$filafin.")");
            $objWorkSheet->setCellValue('CF'.$fila, $SumaVertical1);
            //SUMA DIFERENCIA TOTAL
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CG".$filainicio.":CG".$filafin.")");
            $objWorkSheet->setCellValue('CG'.$fila, $SumaVertical1);
            //PORCENTAJE TOTAL
            $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(CE".$fila."/BP".$fila.",0)");
            $objWorkSheet->setCellValue('CH'.$fila, $Porc);
            
        //total
        //combinar celdas
        $objWorkSheet->mergeCells("A".$fila.":C".$fila."");
        $objWorkSheet->setCellValue('A'.$fila, 'TOTAL '.$msg);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //valor
        $objWorkSheet->setCellValue('D'.$fila, $Total);
        $objWorkSheet->setCellValue('BP'.$fila, $Total);
        //total total
        $objWorkSheet->setCellValue('BQ'.$fila, $TotTotGen);
        $TotalTotalAlmacen=$TotalTotalAlmacen+$TotTotGen;
        
        //porcentaje total por vendedor jairo
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        //totales laboratorios
        include('totalesLaboratorios.php');
        
        //TOTAL AREA
        $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$fila,'=(F'.$fila.'+I'.$fila.'+L'.$fila.'+O'.$fila.'+R'.$fila.'+U'.$fila.'+X'.$fila.'+AA'.$fila.'+AD'.$fila.'+AJ'.$fila.'+AM'.$fila.'+AS'.$fila.'+AV'.$fila.'+AY'.$fila.'+BE'.$fila.'+BH'.$fila.'+BK'.$fila.'+BN'.$fila.')');
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        $TotalT=$TotalT+$Total;
        
        //JORGE
        $VentaCont1=0;$VentaCred1=0;$VentaMixt1=0;$NotasCrCont1=0;$NotasCrCred1=0;$NotasCrMixt1=0;$NotaDebito1=0;$NotasdCobra1=0;$NotasdCobra1=0;$Subtotal1=0;$DistriBolsa1=0;$Total1=0;
        
        //IMPORTADOS*********************************************************************************************************************
        $fila++;
        $area='IMPORTADOS';
        $fila++;
        $queryv = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[cliVendedor] WHERE SectorLab = '$area' ORDER BY Codigo ASC;", $cLink);
        $num=mssql_num_rows($queryv);
        $tamfilArea=$fila+$num-1;
        $Total=0;
        //combina areas
        $objWorkSheet->mergeCells("A".$fila.":A".$tamfilArea."");
        $objWorkSheet->setCellValue('A'.$fila, $area);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':A'.$tamfilArea)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //SUBTOTALES
        $VentaCont1=0; $VentaCred1=0; $VentaMixt1=0; $NotasCrCont1=0; $NotasCrCred1=0; $NotasCrMixt1=0; $NotaDebito1=0; $NotasdCobra1=0; $Subtotal1=0; $DistriBolsa1=0;
        $filainicio=$fila;
        $TotalLab1=0;$TotalLab2=0;$TotalLab3=0;$TotalLab4=0;$TotalLab5=0;$TotalLab6=0;$TotalLab7=0;$TotalLab8=0;$TotalLab9=0;$TotalLab10=0;$TotalLab11=0;$TotalLab12=0;$TotalLab13=0;$TotalLab14=0;$TotalLab15=0;$TotalLab16=0;$TotalLab17=0;$TotalLab18=0;
        $TotalCuo1=0;$TotalCuo2=0;$TotalCuo3=0;$TotalCuo4=0;$TotalCuo5=0;$TotalCuo6=0;$TotalCuo7=0;$TotalCuo8=0;$TotalCuo9=0;$TotalCuo10=0;$TotalCuo11=0;$TotalCuo12=0;$TotalCuo13=0;$TotalCuo14=0;$TotalCuo15=0;$TotalCuo16=0;$TotalCuo17=0;$TotalCuo18=0;
        $TotTotGen=0;
        while($rowVend = mssql_fetch_array($queryv)){
            $vend = trim($rowVend['Codigo']);
            $nomb = trim($rowVend['Apellidos'])." ".trim($rowVend['Nombres']);
            //cod vendedores
            $objWorkSheet->setCellValue('B'.$fila, $vend);  
            $objWorkSheet->setCellValue('C'.$fila, utf8_encode($nomb));
            $objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //valores
            $queryval = mssql_query("SELECT cuotagen FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND codVend='$vend' AND Periodo='$periodo' AND tipoCuota != 'Cuota Laboratorio';", $cLink);
            if($rowVendVal = mssql_fetch_array($queryval)){
                $cuotag = trim($rowVendVal['cuotagen']);
                $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
                $Total=$Total+$cuotag;         
            }else{
                $cuotag = 0;
                $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
            }
            $queryvalv = mssql_query("SELECT Venta FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND codVend='$vend' AND Periodo='$periodo' AND SectorLab='TODO' AND tipoCuota = 'Cuota Laboratorio';", $cLink);
            if($rowVendVenta = mssql_fetch_array($queryvalv)){
                $VentaTot = trim($rowVendVenta['Venta']);
                $objWorkSheet->setCellValue('BQ'.$fila, $VentaTot);
                $TotTotGen=$TotTotGen+$VentaTot;
                //$Total=$Total+$cuotag;         
            }else{
                $VentaTot = 0;
                $objWorkSheet->setCellValue('D'.$fila, $VentaTot);
            }
            
            //porcentaje total*******
            $P=0;
            if($cuotag > 0){
                // $P=round(($VentaTot/$cuotag));
                $P=round(($VentaTot/$cuotag));
            }
            $objWorkSheet->setCellValue('BR'.$fila, $P);
            $objPHPExcel->getActiveSheet()->getStyle('BR'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            //LABORATORIOS
            $queryval = mssql_query("SELECT Cuota, Venta, SectorLab FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND tipoCuota='Cuota Laboratorio' AND codVend='$vend' AND Periodo='$periodo';", $cLink);
            while($rowVendValab = mssql_fetch_array($queryval)){
                $cuotaLab = trim($rowVendValab['Cuota']);
                $ventaLab = trim($rowVendValab['Venta']);
                $sectorLab = trim($rowVendValab['SectorLab']);
                include('valoresVC.php');
                $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$fila,'=(F'.$fila.'+I'.$fila.'+L'.$fila.'+O'.$fila.'+R'.$fila.'+U'.$fila.'+X'.$fila.'+AA'.$fila.'+AD'.$fila.'+AJ'.$fila.'+AM'.$fila.'+AS'.$fila.'+AV'.$fila.'+AY'.$fila.'+BE'.$fila.'+BH'.$fila.'+BK'.$fila.'+BN'.$fila.')');
                $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
                $objWorkSheet->setCellValue('BR'.$fila, $Porc);
            }//FIN LABORATORIOS
            
            //CUADRO 2 JORGE
            $querysumCom = mssql_query("SELECT SUM(VentaCont) as VentaCont, sum(VentaCred) as VentaCred, sum(VentaMixt) as VentaMixt, sum(NotasCrCont) as NotasCrCont, sum(NotasCrCred) as NotasCrCred, sum(NotasCrMixt) as NotasCrMixt, sum(NotaDebito) as NotaDebito,sum(NotasdCobra) as NotasdCobra,sum(Subtotal) as Subtotal,sum(DistriBolsa) as DistriBolsa,sum(Total) as Total,sum(Falta) as Falta,sum(DifTotMix) as DifTotMix FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='$vend' and Periodo='$periodo';", $cLink);
            if($rowVendValab = mssql_fetch_array($querysumCom)){
                
                $VentaCont = trim($rowVendValab['VentaCont']);
                $VentaCred = trim($rowVendValab['VentaCred']);
                $VentaMixt = trim($rowVendValab['VentaMixt']);
                $NotasCrCont = trim($rowVendValab['NotasCrCont']);
                $NotasCrCred = trim($rowVendValab['NotasCrCred']);
                $NotasCrMixt = trim($rowVendValab['NotasCrMixt']);
                $NotaDebito = trim($rowVendValab['NotaDebito']);
                $NotasdCobra = trim($rowVendValab['NotasdCobra']);
                $Subtotal = trim($rowVendValab['Subtotal']);
                $DistriBolsa = trim($rowVendValab['DistriBolsa']);
                $Totalkl = trim($rowVendValab['Total']);
                //$Total="=CC7+CD7"."aqui";
                //$Falta = trim($rowVendValab['Falta']);
                $Falta="=BQ".$fila."-BP".$fila;
                //$DifTotMix = trim($rowVendValab['DifTotMix']);
                $DifTotMix="=CE".$fila."-BW".$fila."+BZ".$fila;
                //$Porc="=CE".$fila."/BP".$fila;
                $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(CE".$fila."/BP".$fila.",0)");
                
                
                //filas
                if($VentaCont=='-'){$VentaCont=0;}
                $objWorkSheet->setCellValue('BU'.$fila, $VentaCont);
                if($VentaCred=='-'){$VentaCred=0;}
                $objWorkSheet->setCellValue('BV'.$fila, $VentaCred);
                if($VentaMixt=='-'){$VentaMixt=0;}
                $objWorkSheet->setCellValue('BW'.$fila, $VentaMixt);
                if($NotasCrCont=='-'){$NotasCrCont=0;}
                $objWorkSheet->setCellValue('BX'.$fila, $NotasCrCont);
                if($NotasCrCred=='-'){$NotasCrCred=0;}
                $objWorkSheet->setCellValue('BY'.$fila, $NotasCrCred);
                if($NotasCrMixt=='-'){$NotasCrMixt=0;}
                $objWorkSheet->setCellValue('BZ'.$fila, $NotasCrMixt);
                if($NotaDebito=='-'){$NotaDebito=0;}
                $objWorkSheet->setCellValue('CA'.$fila, $NotaDebito);
                if($NotasdCobra=='-'){$NotasdCobra=0;}
                $objWorkSheet->setCellValue('CB'.$fila, $NotasdCobra);
                if($DistriBolsa=='-'){$DistriBolsa=0;}
                $objWorkSheet->setCellValue('CD'.$fila, $DistriBolsa);
                if($Totalkl=='-'){$Totalkl=0;}
                $objWorkSheet->setCellValue('CE'.$fila, $Totalkl);
                if($Falta=='-'){$Falta=0;}
                $objWorkSheet->setCellValue('CF'.$fila, $Falta);
                if($DifTotMix=='-'){$DifTotMix=0;}
                $objWorkSheet->setCellValue('CG'.$fila, $DifTotMix);
                if($Porc=='-'){$Porc=0;}
                $objWorkSheet->setCellValue('CH'.$fila, $Porc);
            }
            
            //SUBTOTAL CUADRO DERECHA
            $objPHPExcel->getActiveSheet()->setCellValue('CC'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')');
            
            //SUBTOTAL CUADRO DERECHA
            $objPHPExcel->getActiveSheet()->setCellValue('CC'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')');
            $objPHPExcel->getActiveSheet()->setCellValue('CE'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')-CD'.$fila);
            $objPHPExcel->getActiveSheet()->setCellValue('CF'.$fila,'=(BQ'.$fila.'-BP'.$fila.')');
            
            //FIN JORGE
            
            $fila++;          
        }
            //borde cuadro derecha
            $objWorkSheet->setCellValue('BT'.$fila, 'TOTAL '.$area);
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
            //centrar horizontal
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //centrar V
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getFont()->setBold(true);
            
            //tama�o} cuadro derecha
            $objPHPExcel->getActiveSheet()->getColumnDimension('BT')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BU')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BV')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BW')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BX')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BY')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BZ')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CA')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CB')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CC')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CD')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CE')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CF')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CG')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CH')->setWidth(22);
            //total 
         
        
            //SUMA VERTICAL
            $filafin=$fila-1;
            //contado
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BU".$filainicio.":BU".$filafin.")");
            $objWorkSheet->setCellValue('BU'.$fila, $SumaVertical1);
            //credito
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BV".$filainicio.":BV".$filafin.")");
            $objWorkSheet->setCellValue('BV'.$fila, $SumaVertical1);
            //MIXTA
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BW".$filainicio.":BW".$filafin.")");
            $objWorkSheet->setCellValue('BW'.$fila, $SumaVertical1);
            //NOTAS CREDITO CONTADO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BX".$filainicio.":BX".$filafin.")");
            $objWorkSheet->setCellValue('BX'.$fila, $SumaVertical1);
            //NOTAS CREDITO CREDITO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BY".$filainicio.":BY".$filafin.")");
            $objWorkSheet->setCellValue('BY'.$fila, $SumaVertical1);
            //NOTAS CREDITO MIXTAS
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BZ".$filainicio.":BZ".$filafin.")");
            $objWorkSheet->setCellValue('BZ'.$fila, $SumaVertical1);
            //NOTAS DEBITO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CA".$filainicio.":CA".$filafin.")");
            $objWorkSheet->setCellValue('CA'.$fila, $SumaVertical1);
            //NOTAS DEBITO COBRADAS
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CB".$filainicio.":CB".$filafin.")");
            $objWorkSheet->setCellValue('CB'.$fila, $SumaVertical1);
            //SUBTOTAL
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CC".$filainicio.":CC".$filafin.")");
            $objWorkSheet->setCellValue('CC'.$fila, $SumaVertical1);
            //suma distribolsa
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CD".$filainicio.":CD".$filafin.")");
            $objWorkSheet->setCellValue('CD'.$fila, $SumaVertical1);
            //suma total
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CE".$filainicio.":CE".$filafin.")");
            $objWorkSheet->setCellValue('CE'.$fila, $SumaVertical1);
            //suma LE FALTA
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CF".$filainicio.":CF".$filafin.")");
            $objWorkSheet->setCellValue('CF'.$fila, $SumaVertical1);
            //SUMA DIFERENCIA TOTAL
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CG".$filainicio.":CG".$filafin.")");
            $objWorkSheet->setCellValue('CG'.$fila, $SumaVertical1);
            //PORCENTAJE TOTAL
            $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(CE".$fila."/BP".$fila.",0)");
            $objWorkSheet->setCellValue('CH'.$fila, $Porc);
            
        //total
        //combinar celdas
        $objWorkSheet->mergeCells("A".$fila.":C".$fila."");
        $objWorkSheet->setCellValue('A'.$fila, 'TOTAL '.$area);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //valor
        $objWorkSheet->setCellValue('D'.$fila, $Total);
        $objWorkSheet->setCellValue('BP'.$fila, $Total);
        //total total
        $objWorkSheet->setCellValue('BQ'.$fila, $TotTotGen);
        $TotalTotalAlmacen=$TotalTotalAlmacen+$TotTotGen;
        
        //porcentaje total por vendedor jairo
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        //totales laboratorios
        include('totalesLaboratorios.php');
        
        //TOTAL AREA
        $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$fila,'=(F'.$fila.'+I'.$fila.'+L'.$fila.'+O'.$fila.'+R'.$fila.'+U'.$fila.'+X'.$fila.'+AA'.$fila.'+AD'.$fila.'+AJ'.$fila.'+AM'.$fila.'+AS'.$fila.'+AV'.$fila.'+AY'.$fila.'+BE'.$fila.'+BH'.$fila.'+BK'.$fila.'+BN'.$fila.')');
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        $TotalT=$TotalT+$Total;
        
        //JORGE
        $VentaCont1=0;$VentaCred1=0;$VentaMixt1=0;$NotasCrCont1=0;$NotasCrCred1=0;$NotasCrMixt1=0;$NotaDebito1=0;$NotasdCobra1=0;$NotasdCobra1=0;$Subtotal1=0;$DistriBolsa1=0;$Total1=0;
        
        //SEMILLAS Y FERRETERIA*********************************************************************************************************************
        $fila++;
        $area='SEMILLAS  Y FERRETERIA';
        $fila++;
        $queryv = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[cliVendedor] WHERE SectorLab = '$area' ORDER BY Codigo ASC;", $cLink);
        $num=mssql_num_rows($queryv);
        $tamfilArea=$fila+$num-1;
        $Total=0;
        //combina areas
        $objWorkSheet->mergeCells("A".$fila.":A".$tamfilArea."");
        $objWorkSheet->setCellValue('A'.$fila, $area);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':A'.$tamfilArea)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //SUBTOTALES
        $VentaCont1=0; $VentaCred1=0; $VentaMixt1=0; $NotasCrCont1=0; $NotasCrCred1=0; $NotasCrMixt1=0; $NotaDebito1=0; $NotasdCobra1=0; $Subtotal1=0; $DistriBolsa1=0;
        $filainicio=$fila;
        $TotalLab1=0;$TotalLab2=0;$TotalLab3=0;$TotalLab4=0;$TotalLab5=0;$TotalLab6=0;$TotalLab7=0;$TotalLab8=0;$TotalLab9=0;$TotalLab10=0;$TotalLab11=0;$TotalLab12=0;$TotalLab13=0;$TotalLab14=0;$TotalLab15=0;$TotalLab16=0;$TotalLab17=0;$TotalLab18=0;
        $TotalCuo1=0;$TotalCuo2=0;$TotalCuo3=0;$TotalCuo4=0;$TotalCuo5=0;$TotalCuo6=0;$TotalCuo7=0;$TotalCuo8=0;$TotalCuo9=0;$TotalCuo10=0;$TotalCuo11=0;$TotalCuo12=0;$TotalCuo13=0;$TotalCuo14=0;$TotalCuo15=0;$TotalCuo16=0;$TotalCuo17=0;$TotalCuo18=0;
        $TotTotGen=0;
        while($rowVend = mssql_fetch_array($queryv)){
            $vend = trim($rowVend['Codigo']);
            $nomb = trim($rowVend['Apellidos'])." ".trim($rowVend['Nombres']);
            //cod vendedores
            $objWorkSheet->setCellValue('B'.$fila, $vend);  
            $objWorkSheet->setCellValue('C'.$fila, utf8_encode($nomb));
            $objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //valores
            $queryval = mssql_query("SELECT cuotagen FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND codVend='$vend' AND Periodo='$periodo' AND tipoCuota != 'Cuota Laboratorio';", $cLink);
            if($rowVendVal = mssql_fetch_array($queryval)){
                $cuotag = trim($rowVendVal['cuotagen']);
                $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
                $Total=$Total+$cuotag;         
            }else{
                $cuotag = 0;
                $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
            }
            $queryvalv = mssql_query("SELECT Venta FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND codVend='$vend' AND Periodo='$periodo' AND SectorLab='TODO' AND tipoCuota = 'Cuota Laboratorio';", $cLink);
            if($rowVendVenta = mssql_fetch_array($queryvalv)){
                $VentaTot = trim($rowVendVenta['Venta']);
                $objWorkSheet->setCellValue('BQ'.$fila, $VentaTot);
                $TotTotGen=$TotTotGen+$VentaTot;
                //$Total=$Total+$cuotag;         
            }else{
                $VentaTot = 0;
                $objWorkSheet->setCellValue('D'.$fila, $VentaTot);
            }
            
            //porcentaje total*******
            $P=0;
            if($cuotag > 0){
                // $P=round(($VentaTot/$cuotag));
                $P=round(($VentaTot/$cuotag));
            }
            $objWorkSheet->setCellValue('BR'.$fila, $P);
            $objPHPExcel->getActiveSheet()->getStyle('BR'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            //LABORATORIOS
            $queryval = mssql_query("SELECT Cuota, Venta, SectorLab FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND tipoCuota='Cuota Laboratorio' AND codVend='$vend' AND Periodo='$periodo';", $cLink);
            while($rowVendValab = mssql_fetch_array($queryval)){
                $cuotaLab = trim($rowVendValab['Cuota']);
                $ventaLab = trim($rowVendValab['Venta']);
                $sectorLab = trim($rowVendValab['SectorLab']);
                include('valoresVC.php');
                $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$fila,'=(F'.$fila.'+I'.$fila.'+L'.$fila.'+O'.$fila.'+R'.$fila.'+U'.$fila.'+X'.$fila.'+AA'.$fila.'+AD'.$fila.'+AJ'.$fila.'+AM'.$fila.'+AS'.$fila.'+AV'.$fila.'+AY'.$fila.'+BE'.$fila.'+BH'.$fila.'+BK'.$fila.'+BN'.$fila.')');
                $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
                $objWorkSheet->setCellValue('BR'.$fila, $Porc);
            }//FIN LABORATORIOS
            
            //CUADRO 2 JORGE
            $querysumCom = mssql_query("SELECT SUM(VentaCont) as VentaCont, sum(VentaCred) as VentaCred, sum(VentaMixt) as VentaMixt, sum(NotasCrCont) as NotasCrCont, sum(NotasCrCred) as NotasCrCred, sum(NotasCrMixt) as NotasCrMixt, sum(NotaDebito) as NotaDebito,sum(NotasdCobra) as NotasdCobra,sum(Subtotal) as Subtotal,sum(DistriBolsa) as DistriBolsa,sum(Total) as Total,sum(Falta) as Falta,sum(DifTotMix) as DifTotMix FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='$vend' and Periodo='$periodo';", $cLink);
            if($rowVendValab = mssql_fetch_array($querysumCom)){
                
                $VentaCont = trim($rowVendValab['VentaCont']);
                $VentaCred = trim($rowVendValab['VentaCred']);
                $VentaMixt = trim($rowVendValab['VentaMixt']);
                $NotasCrCont = trim($rowVendValab['NotasCrCont']);
                $NotasCrCred = trim($rowVendValab['NotasCrCred']);
                $NotasCrMixt = trim($rowVendValab['NotasCrMixt']);
                $NotaDebito = trim($rowVendValab['NotaDebito']);
                $NotasdCobra = trim($rowVendValab['NotasdCobra']);
                $Subtotal = trim($rowVendValab['Subtotal']);
                $DistriBolsa = trim($rowVendValab['DistriBolsa']);
                $Totalkl = trim($rowVendValab['Total']);
                //$Total="=CC7+CD7"."aqui";
                //$Falta = trim($rowVendValab['Falta']);
                $Falta="=BQ".$fila."-BP".$fila;
                //$DifTotMix = trim($rowVendValab['DifTotMix']);
                $DifTotMix="=CE".$fila."-BW".$fila."+BZ".$fila;
                //$Porc="=CE".$fila."/BP".$fila;
                $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(CE".$fila."/BP".$fila.",0)");
                
                
                //filas
                if($VentaCont=='-'){$VentaCont=0;}
                $objWorkSheet->setCellValue('BU'.$fila, $VentaCont);
                if($VentaCred=='-'){$VentaCred=0;}
                $objWorkSheet->setCellValue('BV'.$fila, $VentaCred);
                if($VentaMixt=='-'){$VentaMixt=0;}
                $objWorkSheet->setCellValue('BW'.$fila, $VentaMixt);
                if($NotasCrCont=='-'){$NotasCrCont=0;}
                $objWorkSheet->setCellValue('BX'.$fila, $NotasCrCont);
                if($NotasCrCred=='-'){$NotasCrCred=0;}
                $objWorkSheet->setCellValue('BY'.$fila, $NotasCrCred);
                if($NotasCrMixt=='-'){$NotasCrMixt=0;}
                $objWorkSheet->setCellValue('BZ'.$fila, $NotasCrMixt);
                if($NotaDebito=='-'){$NotaDebito=0;}
                $objWorkSheet->setCellValue('CA'.$fila, $NotaDebito);
                if($NotasdCobra=='-'){$NotasdCobra=0;}
                $objWorkSheet->setCellValue('CB'.$fila, $NotasdCobra);
                if($DistriBolsa=='-'){$DistriBolsa=0;}
                $objWorkSheet->setCellValue('CD'.$fila, $DistriBolsa);
                if($Totalkl=='-'){$Totalkl=0;}
                $objWorkSheet->setCellValue('CE'.$fila, $Totalkl);
                if($Falta=='-'){$Falta=0;}
                $objWorkSheet->setCellValue('CF'.$fila, $Falta);
                if($DifTotMix=='-'){$DifTotMix=0;}
                $objWorkSheet->setCellValue('CG'.$fila, $DifTotMix);
                if($Porc=='-'){$Porc=0;}
                $objWorkSheet->setCellValue('CH'.$fila, $Porc);
            }
            
            //SUBTOTAL CUADRO DERECHA
            $objPHPExcel->getActiveSheet()->setCellValue('CC'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')');
            
            //SUBTOTAL CUADRO DERECHA
            $objPHPExcel->getActiveSheet()->setCellValue('CC'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')');
            $objPHPExcel->getActiveSheet()->setCellValue('CE'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')-CD'.$fila);
            $objPHPExcel->getActiveSheet()->setCellValue('CF'.$fila,'=(BQ'.$fila.'-BP'.$fila.')');
            
            //FIN JORGE
            
            $fila++;          
        }
            //borde cuadro derecha
            $objWorkSheet->setCellValue('BT'.$fila, 'TOTAL '.$area);
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
            //centrar horizontal
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //centrar V
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getFont()->setBold(true);
            
            //tama�o} cuadro derecha
            $objPHPExcel->getActiveSheet()->getColumnDimension('BT')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BU')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BV')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BW')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BX')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BY')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BZ')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CA')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CB')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CC')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CD')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CE')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CF')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CG')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CH')->setWidth(22);
            //total 
         
        
            //SUMA VERTICAL
            $filafin=$fila-1;
            //contado
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BU".$filainicio.":BU".$filafin.")");
            $objWorkSheet->setCellValue('BU'.$fila, $SumaVertical1);
            //credito
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BV".$filainicio.":BV".$filafin.")");
            $objWorkSheet->setCellValue('BV'.$fila, $SumaVertical1);
            //MIXTA
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BW".$filainicio.":BW".$filafin.")");
            $objWorkSheet->setCellValue('BW'.$fila, $SumaVertical1);
            //NOTAS CREDITO CONTADO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BX".$filainicio.":BX".$filafin.")");
            $objWorkSheet->setCellValue('BX'.$fila, $SumaVertical1);
            //NOTAS CREDITO CREDITO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BY".$filainicio.":BY".$filafin.")");
            $objWorkSheet->setCellValue('BY'.$fila, $SumaVertical1);
            //NOTAS CREDITO MIXTAS
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BZ".$filainicio.":BZ".$filafin.")");
            $objWorkSheet->setCellValue('BZ'.$fila, $SumaVertical1);
            //NOTAS DEBITO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CA".$filainicio.":CA".$filafin.")");
            $objWorkSheet->setCellValue('CA'.$fila, $SumaVertical1);
            //NOTAS DEBITO COBRADAS
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CB".$filainicio.":CB".$filafin.")");
            $objWorkSheet->setCellValue('CB'.$fila, $SumaVertical1);
            //SUBTOTAL
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CC".$filainicio.":CC".$filafin.")");
            $objWorkSheet->setCellValue('CC'.$fila, $SumaVertical1);
            //suma distribolsa
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CD".$filainicio.":CD".$filafin.")");
            $objWorkSheet->setCellValue('CD'.$fila, $SumaVertical1);
            //suma total
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CE".$filainicio.":CE".$filafin.")");
            $objWorkSheet->setCellValue('CE'.$fila, $SumaVertical1);
            //suma LE FALTA
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CF".$filainicio.":CF".$filafin.")");
            $objWorkSheet->setCellValue('CF'.$fila, $SumaVertical1);
            //SUMA DIFERENCIA TOTAL
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CG".$filainicio.":CG".$filafin.")");
            $objWorkSheet->setCellValue('CG'.$fila, $SumaVertical1);
            //PORCENTAJE TOTAL
            $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(CE".$fila."/BP".$fila.",0)");
            $objWorkSheet->setCellValue('CH'.$fila, $Porc);
            
        //total
        //combinar celdas
        $objWorkSheet->mergeCells("A".$fila.":C".$fila."");
        $objWorkSheet->setCellValue('A'.$fila, 'TOTAL '.$area);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //valor
        $objWorkSheet->setCellValue('D'.$fila, $Total);
        $objWorkSheet->setCellValue('BP'.$fila, $Total);
        //total total
        $objWorkSheet->setCellValue('BQ'.$fila, $TotTotGen);
        $TotalTotalAlmacen=$TotalTotalAlmacen+$TotTotGen;
        
        //porcentaje total por vendedor jairo
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        //totales laboratorios
        include('totalesLaboratorios.php');
        
        //TOTAL AREA
        $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$fila,'=(F'.$fila.'+I'.$fila.'+L'.$fila.'+O'.$fila.'+R'.$fila.'+U'.$fila.'+X'.$fila.'+AA'.$fila.'+AD'.$fila.'+AJ'.$fila.'+AM'.$fila.'+AS'.$fila.'+AV'.$fila.'+AY'.$fila.'+BE'.$fila.'+BH'.$fila.'+BK'.$fila.'+BN'.$fila.')');
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        $TotalT=$TotalT+$Total;
        
        
        //JORGE
        $VentaCont1=0;$VentaCred1=0;$VentaMixt1=0;$NotasCrCont1=0;$NotasCrCred1=0;$NotasCrMixt1=0;$NotaDebito1=0;$NotasdCobra1=0;$NotasdCobra1=0;$Subtotal1=0;$DistriBolsa1=0;$Total1=0;
        
        //VACUNACION*********************************************************************************************************************
        $fila++;
        $area='VACUNACION';
        $fila++;
        $queryv = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[cliVendedor] WHERE SectorLab = '$area' ORDER BY Codigo ASC;", $cLink);
        $num=mssql_num_rows($queryv);
        $tamfilArea=$fila+$num-1;
        $Total=0;
        //combina areas
        $objWorkSheet->mergeCells("A".$fila.":A".$tamfilArea."");
        $objWorkSheet->setCellValue('A'.$fila, $area);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':A'.$tamfilArea)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //SUBTOTALES
        $VentaCont1=0; $VentaCred1=0; $VentaMixt1=0; $NotasCrCont1=0; $NotasCrCred1=0; $NotasCrMixt1=0; $NotaDebito1=0; $NotasdCobra1=0; $Subtotal1=0; $DistriBolsa1=0;
        $filainicio=$fila;
        $TotalLab1=0;$TotalLab2=0;$TotalLab3=0;$TotalLab4=0;$TotalLab5=0;$TotalLab6=0;$TotalLab7=0;$TotalLab8=0;$TotalLab9=0;$TotalLab10=0;$TotalLab11=0;$TotalLab12=0;$TotalLab13=0;$TotalLab14=0;$TotalLab15=0;$TotalLab16=0;$TotalLab17=0;$TotalLab18=0;
        $TotalCuo1=0;$TotalCuo2=0;$TotalCuo3=0;$TotalCuo4=0;$TotalCuo5=0;$TotalCuo6=0;$TotalCuo7=0;$TotalCuo8=0;$TotalCuo9=0;$TotalCuo10=0;$TotalCuo11=0;$TotalCuo12=0;$TotalCuo13=0;$TotalCuo14=0;$TotalCuo15=0;$TotalCuo16=0;$TotalCuo17=0;$TotalCuo18=0;
        $TotTotGen=0;
        while($rowVend = mssql_fetch_array($queryv)){
            $vend = trim($rowVend['Codigo']);
            $nomb = trim($rowVend['Apellidos'])." ".trim($rowVend['Nombres']);
            //cod vendedores
            $objWorkSheet->setCellValue('B'.$fila, $vend);  
            $objWorkSheet->setCellValue('C'.$fila, utf8_encode($nomb));
            $objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //valores
            $queryval = mssql_query("SELECT cuotagen FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND codVend='$vend' AND Periodo='$periodo' AND tipoCuota != 'Cuota Laboratorio';", $cLink);
            if($rowVendVal = mssql_fetch_array($queryval)){
                $cuotag = trim($rowVendVal['cuotagen']);
                $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
                $Total=$Total+$cuotag;         
            }else{
                $cuotag = 0;
                $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
            }
            $queryvalv = mssql_query("SELECT Venta FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND codVend='$vend' AND Periodo='$periodo' AND SectorLab='TODO' AND tipoCuota = 'Cuota Laboratorio';", $cLink);
            if($rowVendVenta = mssql_fetch_array($queryvalv)){
                $VentaTot = trim($rowVendVenta['Venta']);
                $objWorkSheet->setCellValue('BQ'.$fila, $VentaTot);
                $TotTotGen=$TotTotGen+$VentaTot;
                //$Total=$Total+$cuotag;         
            }else{
                $VentaTot = 0;
                $objWorkSheet->setCellValue('D'.$fila, $VentaTot);
            }
            
            //porcentaje total*******
            $P=0;
            if($cuotag > 0){
                // $P=round(($VentaTot/$cuotag));
                $P=round(($VentaTot/$cuotag));
            }
            $objWorkSheet->setCellValue('BR'.$fila, $P);
            $objPHPExcel->getActiveSheet()->getStyle('BR'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            //LABORATORIOS
            $queryval = mssql_query("SELECT Cuota, Venta, SectorLab FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND tipoCuota='Cuota Laboratorio' AND codVend='$vend' AND Periodo='$periodo';", $cLink);
            while($rowVendValab = mssql_fetch_array($queryval)){
                $cuotaLab = trim($rowVendValab['Cuota']);
                $ventaLab = trim($rowVendValab['Venta']);
                $sectorLab = trim($rowVendValab['SectorLab']);
                include('valoresVC.php');
                $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$fila,'=(F'.$fila.'+I'.$fila.'+L'.$fila.'+O'.$fila.'+R'.$fila.'+U'.$fila.'+X'.$fila.'+AA'.$fila.'+AD'.$fila.'+AJ'.$fila.'+AM'.$fila.'+AS'.$fila.'+AV'.$fila.'+AY'.$fila.'+BE'.$fila.'+BH'.$fila.'+BK'.$fila.'+BN'.$fila.')');
                $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
                $objWorkSheet->setCellValue('BR'.$fila, $Porc);
            }//FIN LABORATORIOS
            
            //CUADRO 2 JORGE
            $querysumCom = mssql_query("SELECT SUM(VentaCont) as VentaCont, sum(VentaCred) as VentaCred, sum(VentaMixt) as VentaMixt, sum(NotasCrCont) as NotasCrCont, sum(NotasCrCred) as NotasCrCred, sum(NotasCrMixt) as NotasCrMixt, sum(NotaDebito) as NotaDebito,sum(NotasdCobra) as NotasdCobra,sum(Subtotal) as Subtotal,sum(DistriBolsa) as DistriBolsa,sum(Total) as Total,sum(Falta) as Falta,sum(DifTotMix) as DifTotMix FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='$vend' and Periodo='$periodo';", $cLink);
            if($rowVendValab = mssql_fetch_array($querysumCom)){
                
                $VentaCont = trim($rowVendValab['VentaCont']);
                $VentaCred = trim($rowVendValab['VentaCred']);
                $VentaMixt = trim($rowVendValab['VentaMixt']);
                $NotasCrCont = trim($rowVendValab['NotasCrCont']);
                $NotasCrCred = trim($rowVendValab['NotasCrCred']);
                $NotasCrMixt = trim($rowVendValab['NotasCrMixt']);
                $NotaDebito = trim($rowVendValab['NotaDebito']);
                $NotasdCobra = trim($rowVendValab['NotasdCobra']);
                $Subtotal = trim($rowVendValab['Subtotal']);
                $DistriBolsa = trim($rowVendValab['DistriBolsa']);
                $Totalkl = trim($rowVendValab['Total']);
                //$Total="=CC7+CD7"."aqui";
                //$Falta = trim($rowVendValab['Falta']);
                $Falta="=BQ".$fila."-BP".$fila;
                //$DifTotMix = trim($rowVendValab['DifTotMix']);
                $DifTotMix="=CE".$fila."-BW".$fila."+BZ".$fila;
                //$Porc="=CE".$fila."/BP".$fila;
                $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(CE".$fila."/BP".$fila.",0)");
                
                
                //filas
                if($VentaCont=='-'){$VentaCont=0;}
                $objWorkSheet->setCellValue('BU'.$fila, $VentaCont);
                if($VentaCred=='-'){$VentaCred=0;}
                $objWorkSheet->setCellValue('BV'.$fila, $VentaCred);
                if($VentaMixt=='-'){$VentaMixt=0;}
                $objWorkSheet->setCellValue('BW'.$fila, $VentaMixt);
                if($NotasCrCont=='-'){$NotasCrCont=0;}
                $objWorkSheet->setCellValue('BX'.$fila, $NotasCrCont);
                if($NotasCrCred=='-'){$NotasCrCred=0;}
                $objWorkSheet->setCellValue('BY'.$fila, $NotasCrCred);
                if($NotasCrMixt=='-'){$NotasCrMixt=0;}
                $objWorkSheet->setCellValue('BZ'.$fila, $NotasCrMixt);
                if($NotaDebito=='-'){$NotaDebito=0;}
                $objWorkSheet->setCellValue('CA'.$fila, $NotaDebito);
                if($NotasdCobra=='-'){$NotasdCobra=0;}
                $objWorkSheet->setCellValue('CB'.$fila, $NotasdCobra);
                if($DistriBolsa=='-'){$DistriBolsa=0;}
                $objWorkSheet->setCellValue('CD'.$fila, $DistriBolsa);
                if($Totalkl=='-'){$Totalkl=0;}
                $objWorkSheet->setCellValue('CE'.$fila, $Totalkl);
                if($Falta=='-'){$Falta=0;}
                $objWorkSheet->setCellValue('CF'.$fila, $Falta);
                if($DifTotMix=='-'){$DifTotMix=0;}
                $objWorkSheet->setCellValue('CG'.$fila, $DifTotMix);
                if($Porc=='-'){$Porc=0;}
                $objWorkSheet->setCellValue('CH'.$fila, $Porc);
            }
            
            //SUBTOTAL CUADRO DERECHA
            $objPHPExcel->getActiveSheet()->setCellValue('CC'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')');
            
            //SUBTOTAL CUADRO DERECHA
            $objPHPExcel->getActiveSheet()->setCellValue('CC'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')');
            $objPHPExcel->getActiveSheet()->setCellValue('CE'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')-CD'.$fila);
            $objPHPExcel->getActiveSheet()->setCellValue('CF'.$fila,'=(BQ'.$fila.'-BP'.$fila.')');
            
            //FIN JORGE
            
            $fila++;          
        }
            //borde cuadro derecha
            $objWorkSheet->setCellValue('BT'.$fila, 'TOTAL '.$area);
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
            //centrar horizontal
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //centrar V
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getFont()->setBold(true);
            
            //tama�o} cuadro derecha
            $objPHPExcel->getActiveSheet()->getColumnDimension('BT')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BU')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BV')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BW')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BX')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BY')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BZ')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CA')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CB')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CC')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CD')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CE')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CF')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CG')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CH')->setWidth(22);
            //total 
         
        
            //SUMA VERTICAL
            $filafin=$fila-1;
            //contado
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BU".$filainicio.":BU".$filafin.")");
            $objWorkSheet->setCellValue('BU'.$fila, $SumaVertical1);
            //credito
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BV".$filainicio.":BV".$filafin.")");
            $objWorkSheet->setCellValue('BV'.$fila, $SumaVertical1);
            //MIXTA
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BW".$filainicio.":BW".$filafin.")");
            $objWorkSheet->setCellValue('BW'.$fila, $SumaVertical1);
            //NOTAS CREDITO CONTADO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BX".$filainicio.":BX".$filafin.")");
            $objWorkSheet->setCellValue('BX'.$fila, $SumaVertical1);
            //NOTAS CREDITO CREDITO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BY".$filainicio.":BY".$filafin.")");
            $objWorkSheet->setCellValue('BY'.$fila, $SumaVertical1);
            //NOTAS CREDITO MIXTAS
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BZ".$filainicio.":BZ".$filafin.")");
            $objWorkSheet->setCellValue('BZ'.$fila, $SumaVertical1);
            //NOTAS DEBITO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CA".$filainicio.":CA".$filafin.")");
            $objWorkSheet->setCellValue('CA'.$fila, $SumaVertical1);
            //NOTAS DEBITO COBRADAS
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CB".$filainicio.":CB".$filafin.")");
            $objWorkSheet->setCellValue('CB'.$fila, $SumaVertical1);
            //SUBTOTAL
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CC".$filainicio.":CC".$filafin.")");
            $objWorkSheet->setCellValue('CC'.$fila, $SumaVertical1);
            //suma distribolsa
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CD".$filainicio.":CD".$filafin.")");
            $objWorkSheet->setCellValue('CD'.$fila, $SumaVertical1);
            //suma total
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CE".$filainicio.":CE".$filafin.")");
            $objWorkSheet->setCellValue('CE'.$fila, $SumaVertical1);
            //suma LE FALTA
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CF".$filainicio.":CF".$filafin.")");
            $objWorkSheet->setCellValue('CF'.$fila, $SumaVertical1);
            //SUMA DIFERENCIA TOTAL
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CG".$filainicio.":CG".$filafin.")");
            $objWorkSheet->setCellValue('CG'.$fila, $SumaVertical1);
            //PORCENTAJE TOTAL
            $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(CE".$fila."/BP".$fila.",0)");
            $objWorkSheet->setCellValue('CH'.$fila, $Porc);
            
        //total
        //combinar celdas
        $objWorkSheet->mergeCells("A".$fila.":C".$fila."");
        $objWorkSheet->setCellValue('A'.$fila, 'TOTAL '.$area);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //valor
        $objWorkSheet->setCellValue('D'.$fila, $Total);
        $objWorkSheet->setCellValue('BP'.$fila, $Total);
        //total total
        $objWorkSheet->setCellValue('BQ'.$fila, $TotTotGen);
        $TotalTotalAlmacen=$TotalTotalAlmacen+$TotTotGen;
        
        //porcentaje total por vendedor jairo
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        //totales laboratorios
        include('totalesLaboratorios.php');
        
        //TOTAL AREA
        $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$fila,'=(F'.$fila.'+I'.$fila.'+L'.$fila.'+O'.$fila.'+R'.$fila.'+U'.$fila.'+X'.$fila.'+AA'.$fila.'+AD'.$fila.'+AJ'.$fila.'+AM'.$fila.'+AS'.$fila.'+AV'.$fila.'+AY'.$fila.'+BE'.$fila.'+BH'.$fila.'+BK'.$fila.'+BN'.$fila.')');
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        $TotalT=$TotalT+$Total;
        
        //JORGE
        $VentaCont1=0;$VentaCred1=0;$VentaMixt1=0;$NotasCrCont1=0;$NotasCrCred1=0;$NotasCrMixt1=0;$NotaDebito1=0;$NotasdCobra1=0;$NotasdCobra1=0;$Subtotal1=0;$DistriBolsa1=0;$Total1=0;
        
        //CANALES DIGITALES*********************************************************************************************************************
        $fila++;
        $area="CANALES DIGITALES";
        $areaB="CANALES DIGITALES";  //,'TELEOPERADOR'
        $fila++;
        $queryv = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[cliVendedor] WHERE SectorLab ='$area' ORDER BY Codigo ASC;", $cLink);
        $num=mssql_num_rows($queryv);
        $tamfilArea=$fila+$num-1;
        $Total=0;
        //combina areas
        $objWorkSheet->mergeCells("A".$fila.":A".$tamfilArea."");
        $objWorkSheet->setCellValue('A'.$fila, $area);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':A'.$tamfilArea)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //SUBTOTALES
        $VentaCont1=0; $VentaCred1=0; $VentaMixt1=0; $NotasCrCont1=0; $NotasCrCred1=0; $NotasCrMixt1=0; $NotaDebito1=0; $NotasdCobra1=0; $Subtotal1=0; $DistriBolsa1=0;
        $filainicio=$fila;
        $TotalLab1=0;$TotalLab2=0;$TotalLab3=0;$TotalLab4=0;$TotalLab5=0;$TotalLab6=0;$TotalLab7=0;$TotalLab8=0;$TotalLab9=0;$TotalLab10=0;$TotalLab11=0;$TotalLab12=0;$TotalLab13=0;$TotalLab14=0;$TotalLab15=0;$TotalLab16=0;$TotalLab17=0;$TotalLab18=0;
        $TotalCuo1=0;$TotalCuo2=0;$TotalCuo3=0;$TotalCuo4=0;$TotalCuo5=0;$TotalCuo6=0;$TotalCuo7=0;$TotalCuo8=0;$TotalCuo9=0;$TotalCuo10=0;$TotalCuo11=0;$TotalCuo12=0;$TotalCuo13=0;$TotalCuo14=0;$TotalCuo15=0;$TotalCuo16=0;$TotalCuo17=0;$TotalCuo18=0;
        $TotTotGen=0;
        while($rowVend = mssql_fetch_array($queryv)){
            $vend = trim($rowVend['Codigo']);
            $nomb = trim($rowVend['Apellidos'])." ".trim($rowVend['Nombres']);
            //cod vendedores
            $objWorkSheet->setCellValue('B'.$fila, $vend);  
            $objWorkSheet->setCellValue('C'.$fila, utf8_encode($nomb));
            $objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            //venta general
            //$TotTotGen=0;
            $sqlQueryValb="SELECT sum(Venta) as VentaT FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area ='$areaB' AND codVend='$vend' AND Periodo='$periodo' AND tipoCuota = 'Cuota Laboratorio'";
            //SELECT sum(Venta) FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = 'CANALES DIGITALES' AND codVend='VEND536' AND Periodo='202108' AND tipoCuota = 'Cuota Laboratorio'
            $queryvalv = mssql_query($sqlQueryValb);
            
            if($rowVendVenta = mssql_fetch_array($queryvalv)){
                $VentaTot = trim($rowVendVenta['VentaT']);
                
                
                $objWorkSheet->setCellValue('BQ'.$fila, $VentaTot);
                //CUOTA ES IGUAL A LA VENTA
                $cuotag=$VentaTot;
                //DEJA LA MISMA VENTA COMO CUOTA
                $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
                
                $TotTotGen=$TotTotGen+$VentaTot;
                //$Total=$Total+$cuotag;         
            }else{
                $VentaTot = 0;
                $cuotag=$VentaTot;
                $objWorkSheet->setCellValue('D'.$fila, $VentaTot);
                $objWorkSheet->setCellValue('BP'.$fila, $VentaTot);
            }
            
                        
            //porcentaje total*******
            $P=0;
            if($cuotag > 0){
                // $P=round(($VentaTot/$cuotag));
                $P=round(($VentaTot/$cuotag));
            }
            $objWorkSheet->setCellValue('BR'.$fila, $P);
            $objPHPExcel->getActiveSheet()->getStyle('BR'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            //cuotas ventas LABORATORIOS*****************************
            $queryval = mssql_query("SELECT SUM(Cuota) as Cuota, SUM(Venta) as Venta, SectorLab FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area ='$areaB' AND tipoCuota='Cuota Laboratorio' AND codVend='$vend' AND Periodo='$periodo' GROUP BY SectorLab;");
            while($rowVendValab = mssql_fetch_array($queryval)){
                $cuotaLab = trim($rowVendValab['Cuota']);
                $ventaLab = trim($rowVendValab['Venta']);
                $sectorLab = trim($rowVendValab['SectorLab']);
                include('valoresVC.php');
                $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$fila,'=(F'.$fila.'+I'.$fila.'+L'.$fila.'+O'.$fila.'+R'.$fila.'+U'.$fila.'+X'.$fila.'+AA'.$fila.'+AD'.$fila.'+AJ'.$fila.'+AM'.$fila.'+AS'.$fila.'+AV'.$fila.'+AY'.$fila.'+BE'.$fila.'+BH'.$fila.'+BK'.$fila.'+BN'.$fila.')');
                $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
                $objWorkSheet->setCellValue('BR'.$fila, $Porc);
            }//FIN LABORATORIOS
            
            //CUADRO 2 JORGE***
            $querysumCom="SELECT SUM(VentaCont) as VentaCont, sum(VentaCred) as VentaCred, sum(VentaMixt) as VentaMixt, sum(NotasCrCont) as NotasCrCont, sum(NotasCrCred) as NotasCrCred, sum(NotasCrMixt) as NotasCrMixt, sum(NotaDebito) as NotaDebito,sum(NotasdCobra) as NotasdCobra,sum(Subtotal) as Subtotal,sum(DistriBolsa) as DistriBolsa,sum(Total) as Total,sum(Falta) as Falta,sum(DifTotMix) as DifTotMix FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='$vend' and Periodo='$periodo';";
            $querysumCom2 = mssql_query($querysumCom, $cLink);
            
            if($rowVendValab = mssql_fetch_array($querysumCom2)){
                
                $VentaCont = trim($rowVendValab['VentaCont']);
                $VentaCred = trim($rowVendValab['VentaCred']);
                $VentaMixt = trim($rowVendValab['VentaMixt']);
                $NotasCrCont = trim($rowVendValab['NotasCrCont']);
                $NotasCrCred = trim($rowVendValab['NotasCrCred']);
                $NotasCrMixt = trim($rowVendValab['NotasCrMixt']);
                $NotaDebito = trim($rowVendValab['NotaDebito']);
                $NotasdCobra = trim($rowVendValab['NotasdCobra']);
                $Subtotal = trim($rowVendValab['Subtotal']);
                $DistriBolsa = trim($rowVendValab['DistriBolsa']);
                $Totalkl = trim($rowVendValab['Total']);
              
                $Falta="=BQ".$fila."-BP".$fila;
               
                $DifTotMix="=CE".$fila."-BW".$fila."+BZ".$fila;
               
                $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(CE".$fila."/BP".$fila.",0)");
                
                
                //filas
                if($VentaCont=='-'){$VentaCont=0;}
                $objWorkSheet->setCellValue('BU'.$fila, $VentaCont);
                if($VentaCred=='-'){$VentaCred=0;}
                $objWorkSheet->setCellValue('BV'.$fila, $VentaCred);
                if($VentaMixt=='-'){$VentaMixt=0;}
                $objWorkSheet->setCellValue('BW'.$fila, $VentaMixt);
                if($NotasCrCont=='-'){$NotasCrCont=0;}
                $objWorkSheet->setCellValue('BX'.$fila, $NotasCrCont);
                if($NotasCrCred=='-'){$NotasCrCred=0;}
                $objWorkSheet->setCellValue('BY'.$fila, $NotasCrCred);
                if($NotasCrMixt=='-'){$NotasCrMixt=0;}
                $objWorkSheet->setCellValue('BZ'.$fila, $NotasCrMixt);
                if($NotaDebito=='-'){$NotaDebito=0;}
                $objWorkSheet->setCellValue('CA'.$fila, $NotaDebito);
                if($NotasdCobra=='-'){$NotasdCobra=0;}
                $objWorkSheet->setCellValue('CB'.$fila, $NotasdCobra);
                if($DistriBolsa=='-'){$DistriBolsa=0;}
                $objWorkSheet->setCellValue('CD'.$fila, $DistriBolsa);
                if($Totalkl=='-'){$Totalkl=0;}
                $objWorkSheet->setCellValue('CE'.$fila, $Totalkl);
                if($Falta=='-'){$Falta=0;}
                $objWorkSheet->setCellValue('CF'.$fila, $Falta);
                if($DifTotMix=='-'){$DifTotMix=0;}
                $objWorkSheet->setCellValue('CG'.$fila, $DifTotMix);
                if($Porc=='-'){$Porc=0;}
                $objWorkSheet->setCellValue('CH'.$fila, $Porc);
            }
            
            //subtotal cuadro derecha
            $objPHPExcel->getActiveSheet()->setCellValue('CC'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')');
            
            //SUBTOTAL CUADRO DERECHA
            $objPHPExcel->getActiveSheet()->setCellValue('CC'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')');
            $objPHPExcel->getActiveSheet()->setCellValue('CE'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')-CD'.$fila);
            $objPHPExcel->getActiveSheet()->setCellValue('CF'.$fila,'=(BQ'.$fila.'-BP'.$fila.')');
            
            
            //FIN JORGE
            
            $fila++;          
        }
            //borde cuadro derecha
            $objWorkSheet->setCellValue('BT'.$fila, 'TOTAL '.$area);
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
            //centrar horizontal
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //centrar V
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getFont()->setBold(true);
            
            //tama�o} cuadro derecha
            $objPHPExcel->getActiveSheet()->getColumnDimension('BT')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BU')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BV')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BW')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BX')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BY')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BZ')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CA')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CB')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CC')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CD')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CE')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CF')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CG')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CH')->setWidth(22);
            //total 
         
                   
            //SUMA VERTICAL
            $filafin=$fila-1;
            //contado
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BU".$filainicio.":BU".$filafin.")");
            $objWorkSheet->setCellValue('BU'.$fila, $SumaVertical1);
            //credito
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BV".$filainicio.":BV".$filafin.")");
            $objWorkSheet->setCellValue('BV'.$fila, $SumaVertical1);
            //MIXTA
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BW".$filainicio.":BW".$filafin.")");
            $objWorkSheet->setCellValue('BW'.$fila, $SumaVertical1);
            //NOTAS CREDITO CONTADO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BX".$filainicio.":BX".$filafin.")");
            $objWorkSheet->setCellValue('BX'.$fila, $SumaVertical1);
            //NOTAS CREDITO CREDITO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BY".$filainicio.":BY".$filafin.")");
            $objWorkSheet->setCellValue('BY'.$fila, $SumaVertical1);
            //NOTAS CREDITO MIXTAS
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BZ".$filainicio.":BZ".$filafin.")");
            $objWorkSheet->setCellValue('BZ'.$fila, $SumaVertical1);
            //NOTAS DEBITO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CA".$filainicio.":CA".$filafin.")");
            $objWorkSheet->setCellValue('CA'.$fila, $SumaVertical1);
            //NOTAS DEBITO COBRADAS
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CB".$filainicio.":CB".$filafin.")");
            $objWorkSheet->setCellValue('CB'.$fila, $SumaVertical1);
            //SUBTOTAL
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CC".$filainicio.":CC".$filafin.")");
            $objWorkSheet->setCellValue('CC'.$fila, $SumaVertical1);
            //suma distribolsa
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CD".$filainicio.":CD".$filafin.")");
            $objWorkSheet->setCellValue('CD'.$fila, $SumaVertical1);
            //suma total
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CE".$filainicio.":CE".$filafin.")");
            $objWorkSheet->setCellValue('CE'.$fila, $SumaVertical1);
            //suma LE FALTA
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CF".$filainicio.":CF".$filafin.")");
            $objWorkSheet->setCellValue('CF'.$fila, $SumaVertical1);
            //SUMA DIFERENCIA TOTAL
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CG".$filainicio.":CG".$filafin.")");
            $objWorkSheet->setCellValue('CG'.$fila, $SumaVertical1);
            //PORCENTAJE TOTAL
            $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(CE".$fila."/BP".$fila.",0)");
            $objWorkSheet->setCellValue('CH'.$fila, $Porc);
            
        //total
        //combinar celdas
        $objWorkSheet->mergeCells("A".$fila.":C".$fila."");
        $objWorkSheet->setCellValue('A'.$fila, 'TOTAL '.$area);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //valor
        //EL TOTAL CUOTA ES EL MISMO DE LA VENTA
        $Total=$TotTotGen;
        $objWorkSheet->setCellValue('D'.$fila, $Total);
        $objWorkSheet->setCellValue('BP'.$fila, $Total);
        //total total
        $objWorkSheet->setCellValue('BQ'.$fila, $TotTotGen);
        
        
        $TotalTotalAlmacen=$TotalTotalAlmacen+$TotTotGen;
        
        //porcentaje total por vendedor jairo
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        //totales laboratorios
        include('totalesLaboratorios.php');
        
        //TOTAL AREA
        $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$fila,'=(F'.$fila.'+I'.$fila.'+L'.$fila.'+O'.$fila.'+R'.$fila.'+U'.$fila.'+X'.$fila.'+AA'.$fila.'+AD'.$fila.'+AJ'.$fila.'+AM'.$fila.'+AS'.$fila.'+AV'.$fila.'+AY'.$fila.'+BE'.$fila.'+BH'.$fila.'+BK'.$fila.'+BN'.$fila.')');
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        $TotalT=$TotalT+$Total;
        
        //JORGE
        $VentaCont1=0;$VentaCred1=0;$VentaMixt1=0;$NotasCrCont1=0;$NotasCrCred1=0;$NotasCrMixt1=0;$NotaDebito1=0;$NotasdCobra1=0;$NotasdCobra1=0;$Subtotal1=0;$DistriBolsa1=0;$Total1=0;
        
        //OTROS*********************************************************************************************************************
        $fila++;
        $area='OTROS';
        $fila++;
        $queryv = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[cliVendedor] WHERE SectorLab = '$area' ORDER BY Codigo ASC;", $cLink);
        $num=mssql_num_rows($queryv);
        $tamfilArea=$fila+$num-1;
        $Total=0;
        //combina areas
        $objWorkSheet->mergeCells("A".$fila.":A".$tamfilArea."");
        $objWorkSheet->setCellValue('A'.$fila, $area);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':A'.$tamfilArea)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //SUBTOTALES
        $VentaCont1=0; $VentaCred1=0; $VentaMixt1=0; $NotasCrCont1=0; $NotasCrCred1=0; $NotasCrMixt1=0; $NotaDebito1=0; $NotasdCobra1=0; $Subtotal1=0; $DistriBolsa1=0;
        $filainicio=$fila;
        $TotalLab1=0;$TotalLab2=0;$TotalLab3=0;$TotalLab4=0;$TotalLab5=0;$TotalLab6=0;$TotalLab7=0;$TotalLab8=0;$TotalLab9=0;$TotalLab10=0;$TotalLab11=0;$TotalLab12=0;$TotalLab13=0;$TotalLab14=0;$TotalLab15=0;$TotalLab16=0;$TotalLab17=0;$TotalLab18=0;
        $TotalCuo1=0;$TotalCuo2=0;$TotalCuo3=0;$TotalCuo4=0;$TotalCuo5=0;$TotalCuo6=0;$TotalCuo7=0;$TotalCuo8=0;$TotalCuo9=0;$TotalCuo10=0;$TotalCuo11=0;$TotalCuo12=0;$TotalCuo13=0;$TotalCuo14=0;$TotalCuo15=0;$TotalCuo16=0;$TotalCuo17=0;$TotalCuo18=0;
        $TotTotGen=0;
        while($rowVend = mssql_fetch_array($queryv)){
            $vend = trim($rowVend['Codigo']);
            $nomb = trim($rowVend['Apellidos'])." ".trim($rowVend['Nombres']);
            //cod vendedores
            $objWorkSheet->setCellValue('B'.$fila, $vend);  
            $objWorkSheet->setCellValue('C'.$fila, utf8_encode($nomb));
            $objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //valores
            $queryval = mssql_query("SELECT cuotagen FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND codVend='$vend' AND Periodo='$periodo' AND tipoCuota != 'Cuota Laboratorio';", $cLink);
            if($rowVendVal = mssql_fetch_array($queryval)){
                $cuotag = trim($rowVendVal['cuotagen']);
                $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
                $Total=$Total+$cuotag;         
            }else{
                $cuotag = 0;
                $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
            }
            $queryvalv = mssql_query("SELECT SUM(Venta) AS TotalFilV FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = 'OTROS' AND codVend='$vend' AND Periodo='$periodo' AND tipoCuota = 'Cuota Laboratorio';", $cLink);
            if($rowVendVenta = mssql_fetch_array($queryvalv)){
                $VentaTot = trim($rowVendVenta['TotalFilV']);
                $objWorkSheet->setCellValue('BQ'.$fila, $VentaTot);
                $TotTotGen = $TotTotGen + $VentaTot;
                //$Total=$Total+$cuotag;         
            }else{
                $VentaTot = 0;
                $objWorkSheet->setCellValue('D'.$fila, $VentaTot);
            }
            
            //porcentaje total*******
            $P=0;
            if($cuotag > 0){
                // $P=round(($VentaTot/$cuotag));
                $P=round(($VentaTot/$cuotag));
            }
            $objWorkSheet->setCellValue('BR'.$fila, $P);
            $objPHPExcel->getActiveSheet()->getStyle('BR'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            //LABORATORIOS
            $queryvalx = mssql_query("SELECT Cuota, Venta, SectorLab FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE tipoCuota='Cuota Laboratorio' AND Area = '$area' AND codVend='$vend' AND Periodo='$periodo';", $cLink);
            //$sql="</br></br>SELECT Cuota, Venta, SectorLab FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE tipoCuota='Cuota Laboratorio' AND Area = '$area' AND codVend='$vend' AND Periodo='$periodo';";
            //echo $sql;
            while($rowVendValab = mssql_fetch_array($queryvalx)){
                $cuotaLab = trim($rowVendValab['Cuota']);
                $ventaLab = trim($rowVendValab['Venta']);
                $sectorLab = trim($rowVendValab['SectorLab']);
                include('valoresVC.php');
                $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$fila,'=(F'.$fila.'+I'.$fila.'+L'.$fila.'+O'.$fila.'+R'.$fila.'+U'.$fila.'+X'.$fila.'+AA'.$fila.'+AD'.$fila.'+AJ'.$fila.'+AM'.$fila.'+AS'.$fila.'+AV'.$fila.'+AY'.$fila.'+BE'.$fila.'+BH'.$fila.'+BK'.$fila.'+BN'.$fila.')');
                $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
                $objWorkSheet->setCellValue('BR'.$fila, $Porc);
            }//FIN LABORATORIOS
            
            //CUADRO 2 JORGE
            $querysumCom = mssql_query("SELECT SUM(VentaCont) as VentaCont, sum(VentaCred) as VentaCred, sum(VentaMixt) as VentaMixt, sum(NotasCrCont) as NotasCrCont, sum(NotasCrCred) as NotasCrCred, sum(NotasCrMixt) as NotasCrMixt, sum(NotaDebito) as NotaDebito,sum(NotasdCobra) as NotasdCobra,sum(Subtotal) as Subtotal,sum(DistriBolsa) as DistriBolsa,sum(Total) as Total,sum(Falta) as Falta,sum(DifTotMix) as DifTotMix FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='$vend' and Periodo='$periodo';", $cLink);
            if($rowVendValab = mssql_fetch_array($querysumCom)){
                
                $VentaCont = trim($rowVendValab['VentaCont']);
                $VentaCred = trim($rowVendValab['VentaCred']);
                $VentaMixt = trim($rowVendValab['VentaMixt']);
                $NotasCrCont = trim($rowVendValab['NotasCrCont']);
                $NotasCrCred = trim($rowVendValab['NotasCrCred']);
                $NotasCrMixt = trim($rowVendValab['NotasCrMixt']);
                $NotaDebito = trim($rowVendValab['NotaDebito']);
                $NotasdCobra = trim($rowVendValab['NotasdCobra']);
                $Subtotal = trim($rowVendValab['Subtotal']);
                $DistriBolsa = trim($rowVendValab['DistriBolsa']);
                $Totalkl = trim($rowVendValab['Total']);
                $Falta="=BQ".$fila."-BP".$fila;
                
                $DifTotMix="=CE".$fila."-BW".$fila."+BZ".$fila;
               
                $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(CE".$fila."/BP".$fila.",0)");
                
                
                //filas
                if($VentaCont=='-'){$VentaCont=0;}
                $objWorkSheet->setCellValue('BU'.$fila, $VentaCont);
                if($VentaCred=='-'){$VentaCred=0;}
                $objWorkSheet->setCellValue('BV'.$fila, $VentaCred);
                if($VentaMixt=='-'){$VentaMixt=0;}
                $objWorkSheet->setCellValue('BW'.$fila, $VentaMixt);
                if($NotasCrCont=='-'){$NotasCrCont=0;}
                $objWorkSheet->setCellValue('BX'.$fila, $NotasCrCont);
                if($NotasCrCred=='-'){$NotasCrCred=0;}
                $objWorkSheet->setCellValue('BY'.$fila, $NotasCrCred);
                if($NotasCrMixt=='-'){$NotasCrMixt=0;}
                $objWorkSheet->setCellValue('BZ'.$fila, $NotasCrMixt);
                if($NotaDebito=='-'){$NotaDebito=0;}
                $objWorkSheet->setCellValue('CA'.$fila, $NotaDebito);
                if($NotasdCobra=='-'){$NotasdCobra=0;}
                $objWorkSheet->setCellValue('CB'.$fila, $NotasdCobra);
                if($DistriBolsa=='-'){$DistriBolsa=0;}
                $objWorkSheet->setCellValue('CD'.$fila, $DistriBolsa);
                if($Totalkl=='-'){$Totalkl=0;}
                $objWorkSheet->setCellValue('CE'.$fila, $Totalkl);
                if($Falta=='-'){$Falta=0;}
                $objWorkSheet->setCellValue('CF'.$fila, $Falta);
                if($DifTotMix=='-'){$DifTotMix=0;}
                $objWorkSheet->setCellValue('CG'.$fila, $DifTotMix);
                if($Porc=='-'){$Porc=0;}
                $objWorkSheet->setCellValue('CH'.$fila, $Porc);
            }
            
            //SUBTOTAL CUADRO DERECHA
            $objPHPExcel->getActiveSheet()->setCellValue('CC'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')');
            
            //SUBTOTAL CUADRO DERECHA
            $objPHPExcel->getActiveSheet()->setCellValue('CC'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')');
            $objPHPExcel->getActiveSheet()->setCellValue('CE'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')-CD'.$fila);
            $objPHPExcel->getActiveSheet()->setCellValue('CF'.$fila,'=(BQ'.$fila.'-BP'.$fila.')');
            
            //FIN JORGE
            
            $fila++;          
        }
        
            //borde cuadro derecha
            $objWorkSheet->setCellValue('BT'.$fila, 'TOTAL '.$area);
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
            //centrar horizontal
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //centrar V
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('BT'.$fila.':CH'.$fila)->getFont()->setBold(true);
            
            //tama�o} cuadro derecha
            $objPHPExcel->getActiveSheet()->getColumnDimension('BT')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BU')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BV')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BW')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BX')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BY')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('BZ')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CA')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CB')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CC')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CD')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CE')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CF')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CG')->setWidth(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('CH')->setWidth(22);
            //total 
         
        
            //SUMA VERTICAL
            $filafin=$fila-1;
            //contado
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BU".$filainicio.":BU".$filafin.")");
            $objWorkSheet->setCellValue('BU'.$fila, $SumaVertical1);
            //credito
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BV".$filainicio.":BV".$filafin.")");
            $objWorkSheet->setCellValue('BV'.$fila, $SumaVertical1);
            //MIXTA
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BW".$filainicio.":BW".$filafin.")");
            $objWorkSheet->setCellValue('BW'.$fila, $SumaVertical1);
            //NOTAS CREDITO CONTADO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BX".$filainicio.":BX".$filafin.")");
            $objWorkSheet->setCellValue('BX'.$fila, $SumaVertical1);
            //NOTAS CREDITO CREDITO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BY".$filainicio.":BY".$filafin.")");
            $objWorkSheet->setCellValue('BY'.$fila, $SumaVertical1);
            //NOTAS CREDITO MIXTAS
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BZ".$filainicio.":BZ".$filafin.")");
            $objWorkSheet->setCellValue('BZ'.$fila, $SumaVertical1);
            //NOTAS DEBITO
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CA".$filainicio.":CA".$filafin.")");
            $objWorkSheet->setCellValue('CA'.$fila, $SumaVertical1);
            //NOTAS DEBITO COBRADAS
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CB".$filainicio.":CB".$filafin.")");
            $objWorkSheet->setCellValue('CB'.$fila, $SumaVertical1);
            //SUBTOTAL
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CC".$filainicio.":CC".$filafin.")");
            $objWorkSheet->setCellValue('CC'.$fila, $SumaVertical1);
            //suma distribolsa
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CD".$filainicio.":CD".$filafin.")");
            $objWorkSheet->setCellValue('CD'.$fila, $SumaVertical1);
            //suma total
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CE".$filainicio.":CE".$filafin.")");
            $objWorkSheet->setCellValue('CE'.$fila, $SumaVertical1);
            //suma LE FALTA
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CF".$filainicio.":CF".$filafin.")");
            $objWorkSheet->setCellValue('CF'.$fila, $SumaVertical1);
            //SUMA DIFERENCIA TOTAL
            $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(CG".$filainicio.":CG".$filafin.")");
            $objWorkSheet->setCellValue('CG'.$fila, $SumaVertical1);
            //PORCENTAJE TOTAL
            $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(CE".$fila."/BP".$fila.",0)");
            $objWorkSheet->setCellValue('CH'.$fila, $Porc);
            
        //total
        //combinar celdas
        $objWorkSheet->mergeCells("A".$fila.":C".$fila."");
        $objWorkSheet->setCellValue('A'.$fila, 'TOTAL '.$area);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //valor
        $objWorkSheet->setCellValue('D'.$fila, $Total);
        $objWorkSheet->setCellValue('BP'.$fila, $Total);
        //total total
        $objWorkSheet->setCellValue('BQ'.$fila, $TotTotGen);
        $TotalTotalAlmacen=$TotalTotalAlmacen+$TotTotGen;
        
        //porcentaje total por vendedor jairo
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        //totales laboratorios
        include('totalesLaboratorios.php');
        
        //TOTAL AREA
        $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$fila,'=(F'.$fila.'+I'.$fila.'+L'.$fila.'+O'.$fila.'+R'.$fila.'+U'.$fila.'+X'.$fila.'+AA'.$fila.'+AD'.$fila.'+AJ'.$fila.'+AM'.$fila.'+AS'.$fila.'+AV'.$fila.'+AY'.$fila.'+BE'.$fila.'+BH'.$fila.'+BK'.$fila.'+BN'.$fila.')');
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        $TotalT=$TotalT+$Total;
        
        //TOTAL ALMACEN
        //combinar celdas
        $fila++;
        $filaInicioTotalesTeleoperadores=$fila+4;
        $objWorkSheet->mergeCells("A".$fila.":C".$fila."");
        $objWorkSheet->setCellValue('A'.$fila, 'TOTAL ALMACEN');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        //color de fondo
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7');
        //valor total cuota
        $objWorkSheet->setCellValue('D'.$fila, $TotalT);
        $objWorkSheet->setCellValue('BP'.$fila, $TotalT);
        //total total almacen  - VENTA EXTERNA
        $objWorkSheet->setCellValue('BQ'.$fila, $TotalTotalAlmacen);
        
        //VARIABLE TOTAL FINAL
        $TotCuotaFinal=$TotCuotaFinal+$TotalT;
        
        
        //porcentaje total total almacen*******
        $P=0;
        if($TotalT > 0){
            $P=round(($TotalTotalAlmacen/$TotalT));
        }
        $objWorkSheet->setCellValue('BR'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('BR'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //TOTAL ALMACEN + PROCENTAJE
        $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$fila,'=(F'.$fila.'+I'.$fila.'+L'.$fila.'+O'.$fila.'+R'.$fila.'+U'.$fila.'+X'.$fila.'+AA'.$fila.'+AD'.$fila.'+AJ'.$fila.'+AM'.$fila.'+AS'.$fila.'+AV'.$fila.'+AY'.$fila.'+BE'.$fila.'+BH'.$fila.'+BK'.$fila.'+BN'.$fila.')');
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        //TOTAL LABORATORIOS ALMACEN
        //FERRETERIA
        $objWorkSheet->setCellValue('E'.$fila, $TotalTCuo18);
        $objWorkSheet->setCellValue('F'.$fila, $TotalTLab18);
        //TOTAL FINAL
        //$Laboratoriostot[0]="Ferreteria"; //$area
        $TotCuotaFinaLab[0]=$TotCuotaFinaLab[0]+$TotalTCuo18;
        $TotVentaFinaLab[0]=$TotVentaFinaLab[0]+$TotalTLab18;
        //VARIOS
        $objWorkSheet->setCellValue('H'.$fila, $TotalTCuo17);
        $objWorkSheet->setCellValue('I'.$fila, $TotalTLab17);
        //$Laboratoriostot[1]="Varios"; //$area
        $TotCuotaFinaLab[1]=$TotCuotaFinaLab[1]+$TotalTCuo17;
        $TotVentaFinaLab[1]=$TotVentaFinaLab[1]+$TotalTLab17;
        //CONCENTRADOS
        $objWorkSheet->setCellValue('K'.$fila, $TotalTCuo16);
        $objWorkSheet->setCellValue('L'.$fila, $TotalTLab16);
        //$Laboratoriostot[2]="Concentrados"; //$area
        $TotCuotaFinaLab[2]=$TotCuotaFinaLab[2]+$TotalTCuo16;
        $TotVentaFinaLab[2]=$TotVentaFinaLab[2]+$TotalTLab16;
        //PETS
        $objWorkSheet->setCellValue('N'.$fila, $TotalTCuo15);
        $objWorkSheet->setCellValue('O'.$fila, $TotalTLab15);
        //$Laboratoriostot[3]="Pets"; //$area
        $TotCuotaFinaLab[3]=$TotCuotaFinaLab[3]+$TotalTCuo15;
        $TotVentaFinaLab[3]=$TotVentaFinaLab[3]+$TotalTLab15;
        //GANADERIA
        $objWorkSheet->setCellValue('Q'.$fila, $TotalTCuo14);
        $objWorkSheet->setCellValue('R'.$fila, $TotalTLab14);
        //$Laboratoriostot[4]="Ganaderia"; //$area
        $TotCuotaFinaLab[4]=$TotCuotaFinaLab[4]+$TotalTCuo14;
        $TotVentaFinaLab[4]=$TotVentaFinaLab[4]+$TotalTLab14;
        //INSECTICIDAS Y OTROS
        $objWorkSheet->setCellValue('T'.$fila, $TotalTCuo13);
        $objWorkSheet->setCellValue('U'.$fila, $TotalTLab13);
        //$Laboratoriostot[5]="Insecticidas"; //$area
        $TotCuotaFinaLab[5]=$TotCuotaFinaLab[5]+$TotalTCuo13;
        $TotVentaFinaLab[5]=$TotVentaFinaLab[5]+$TotalTLab13;
        //INVET
        $objWorkSheet->setCellValue('W'.$fila, $TotalTCuo1);
        $objWorkSheet->setCellValue('X'.$fila, $TotalTLab1);
        //$Laboratoriostot[6]="Invet"; //$area
        $TotCuotaFinaLab[6]=$TotCuotaFinaLab[6]+$TotalTCuo1;
        $TotVentaFinaLab[6]=$TotVentaFinaLab[6]+$TotalTLab1;
        //ICOFARMA
        $objWorkSheet->setCellValue('Z'.$fila, $TotalTCuo2);
        $objWorkSheet->setCellValue('AA'.$fila, $TotalTLab2);
        //$Laboratoriostot[7]="Icofarma"; //$area
        $TotCuotaFinaLab[7]=$TotCuotaFinaLab[7]+$TotalTCuo2;
        $TotVentaFinaLab[7]=$TotVentaFinaLab[7]+$TotalTLab2;
        //COMERVET
        $objWorkSheet->setCellValue('AC'.$fila, $TotalTCuo3);
        $objWorkSheet->setCellValue('AD'.$fila, $TotalTLab3);
        //$Laboratoriostot[8]="Comervet"; //$area
        $TotCuotaFinaLab[8]=$TotCuotaFinaLab[8]+$TotalTCuo3;
        $TotVentaFinaLab[8]=$TotVentaFinaLab[8]+$TotalTLab3;
        //GABRICA
        $objWorkSheet->setCellValue('AI'.$fila, $TotalTCuo4);
        $objWorkSheet->setCellValue('AJ'.$fila, $TotalTLab4);
        //$Laboratoriostot[9]="Gabrica"; //$area
        $TotCuotaFinaLab[9]=$TotCuotaFinaLab[9]+$TotalTCuo4;
        $TotVentaFinaLab[9]=$TotVentaFinaLab[9]+$TotalTLab4;
        //BIOSTAR
        $objWorkSheet->setCellValue('AL'.$fila, $TotalTCuo5);
        $objWorkSheet->setCellValue('AM'.$fila, $TotalTLab5);
        //$Laboratoriostot[10]="Biostar"; //$area
        $TotCuotaFinaLab[10]=$TotCuotaFinaLab[10]+$TotalTCuo5;
        $TotVentaFinaLab[10]=$TotVentaFinaLab[10]+$TotalTLab5;
        //COHASFARMA
        $objWorkSheet->setCellValue('AR'.$fila, $TotalTCuo6);
        $objWorkSheet->setCellValue('AS'.$fila, $TotalTLab6);
        //$Laboratoriostot[11]="Coaspharma"; //$area
        $TotCuotaFinaLab[11]=$TotCuotaFinaLab[11]+$TotalTCuo6;
        $TotVentaFinaLab[11]=$TotVentaFinaLab[11]+$TotalTLab6;
        //IMPORTADOS
        $objWorkSheet->setCellValue('AU'.$fila, $TotalTCuo7);
        $objWorkSheet->setCellValue('AV'.$fila, $TotalTLab7);
        //$Laboratoriostot[12]="Importados"; //$area
        $TotCuotaFinaLab[12]=$TotCuotaFinaLab[12]+$TotalTCuo7;
        $TotVentaFinaLab[12]=$TotVentaFinaLab[12]+$TotalTLab7;
        //INTERVET
        $objWorkSheet->setCellValue('AX'.$fila, $TotalTCuo8);
        $objWorkSheet->setCellValue('AY'.$fila, $TotalTLab8);
        //$Laboratoriostot[13]="Intervet"; //$area
        $TotCuotaFinaLab[13]=$TotCuotaFinaLab[13]+$TotalTCuo8;
        $TotVentaFinaLab[13]=$TotVentaFinaLab[13]+$TotalTLab8;
        //LINEA AGIL
        $objWorkSheet->setCellValue('BD'.$fila, $TotalTCuo10);
        $objWorkSheet->setCellValue('BE'.$fila, $TotalTLab10);
        //$Laboratoriostot[14]="LineaAgil"; //$area
        $TotCuotaFinaLab[14]=$TotCuotaFinaLab[14]+$TotalTCuo10;
        $TotVentaFinaLab[14]=$TotVentaFinaLab[14]+$TotalTLab10;
        //LINEA AGIL IMPORTADOS
        $objWorkSheet->setCellValue('BG'.$fila, $TotalTCuo11);
        $objWorkSheet->setCellValue('BH'.$fila, $TotalTLab11);
        //$Laboratoriostot[15]="LineaAgilImportados"; //$area
        $TotCuotaFinaLab[15]=$TotCuotaFinaLab[15]+$TotalTCuo11;
        $TotVentaFinaLab[15]=$TotVentaFinaLab[15]+$TotalTLab11;
        //LABORATORIOS BAI
        $objWorkSheet->setCellValue('BJ'.$fila, $TotalTCuo12);
        $objWorkSheet->setCellValue('BK'.$fila, $TotalTLab12);
        //$Laboratoriostot[16]="LaboratoriosBai"; //$area
        $TotCuotaFinaLab[16]=$TotCuotaFinaLab[16]+$TotalTCuo12;
        $TotVentaFinaLab[16]=$TotVentaFinaLab[16]+$TotalTLab12;
        //TECNOCALIDAD
        $objWorkSheet->setCellValue('BM'.$fila, $TotalTCuo9);
        $objWorkSheet->setCellValue('BN'.$fila, $TotalTLab9);
        //$Laboratoriostot[17]="Tecnocalidad"; //$area
        $TotCuotaFinaLab[17]=$TotCuotaFinaLab[17]+$TotalTCuo9;
        $TotVentaFinaLab[17]=$TotVentaFinaLab[17]+$TotalTLab9;
        //CUOTA Y VENTA FINAL
        $Laboratoriostot[18]="TOTALCV"; //$area 
        $TotCuotaFinaLab[18]=$TotCuotaFinaLab[18]+$TotalT;
        $TotVentaFinaLab[18]=$TotVentaFinaLab[18]+$TotalTotalAlmacen;
        
          
        //TELEOPERADORES CALLCENTER
        //*********************************************************************************************************************
        $fila++;
        $area='TELEOPERADOR';
        $fila++;
        //array
        $arrayVend= new ArrayIterator();
        $arrayLabs= new ArrayIterator();
        $arraySubt= new ArrayIterator();
        //variables totales
        $TotGenIndividual=0;
        $TotGenObjetivo=0;
        $totcuotaGen=0;
        $TotalTCuo1=0;$TotalTCuo2=0;$TotalTCuo3=0;$TotalTCuo4=0;$TotalTCuo5=0;$TotalTCuo6=0;$TotalTCuo7=0;$TotalTCuo8=0;$TotalTCuo9=0;$TotalTCuo10=0;$TotalTCuo11=0;$TotalTCuo12=0;$TotalTCuo13=0;$TotalTCuo14=0;$TotalTCuo15=0;$TotalTCuo16=0;$TotalTCuo17=0;$TotalTCuo18=0;
        $TotalTLab1=0;$TotalTLab2=0;$TotalTLab3=0;$TotalTLab4=0;$TotalTLab5=0;$TotalTLab6=0;$TotalTLab7=0;$TotalTLab8=0;$TotalTLab9=0;$TotalTLab10=0;$TotalTLab11=0;$TotalTLab12=0;$TotalTLab13=0;$TotalTLab14=0;$TotalTLab15=0;$TotalTLab16=0;$TotalTLab17=0;$TotalTLab18=0;
        
        $VentaCont1=0; $VentaCred1=0; $VentaMixt1=0; $NotasCrCont1=0; $NotasCrCred1=0; $NotasCrMixt1=0; $NotaDebito1=0; $NotasdCobra1=0; $Subtotal1=0; $DistriBolsa1=0;
        $filainicio=$fila;
        //INDIVIDUAL
        $TotalTCuo1I=0;$TotalTCuo2I=0;$TotalTCuo3I=0;$TotalTCuo4I=0;$TotalTCuo5I=0;$TotalTCuo6I=0;$TotalTCuo7I=0;$TotalTCuo8I=0;$TotalTCuo9I=0;$TotalTCuo10I=0;$TotalTCuo11I=0;$TotalTCuo12I=0;$TotalTCuo13I=0;$TotalTCuo14I=0;$TotalTCuo15I=0;$TotalTCuo16I=0;$TotalTCuo17I=0;$TotalTCuo18I=0;
        $TotalTLab1I=0;$TotalTLab2I=0;$TotalTLab3I=0;$TotalTLab4I=0;$TotalTLab5I=0;$TotalTLab6I=0;$TotalTLab7I=0;$TotalTLab8I=0;$TotalTLab9I=0;$TotalTLab10I=0;$TotalTLab11I=0;$TotalTLab12I=0;$TotalTLab13I=0;$TotalTLab14I=0;$TotalTLab15I=0;$TotalTLab16I=0;$TotalTLab17I=0;$TotalTLab18I=0;
        
        //OBJETIVO
        $TotalTCuo1O=0;$TotalTCuo2O=0;$TotalTCuo3O=0;$TotalTCuo4O=0;$TotalTCuo5O=0;$TotalTCuo6O=0;$TotalTCuo7O=0;$TotalTCuo8O=0;$TotalTCuo9O=0;$TotalTCuo10O=0;$TotalTCuo11O=0;$TotalTCuo12O=0;$TotalTCuo13O=0;$TotalTCuo14O=0;$TotalTCuo15O=0;$TotalTCuo16O=0;$TotalTCuo17O=0;$TotalTCuo18O=0;
        $TotalTLab1O=0;$TotalTLab2O=0;$TotalTLab3O=0;$TotalTLab4O=0;$TotalTLab5O=0;$TotalTLab6O=0;$TotalTLab7O=0;$TotalTLab8O=0;$TotalTLab9O=0;$TotalTLab10O=0;$TotalTLab11O=0;$TotalTLab12O=0;$TotalTLab13O=0;$TotalTLab14O=0;$TotalTLab15O=0;$TotalTLab16O=0;$TotalTLab17O=0;$TotalTLab18O=0;
        
        //laboratorios regulares
        $Labsr = array("INT", "ICO", "COMERVET", "HOL", "BIS", "CPH", "IMPORTADOS", "INTERVET MSD", "TEC", "AGI", "AMI", "BAI");
        //laboratorios irregulares
        $Labsi = array("AGROQUIMICOS / VENENOS", "MEDICAMENTOS", "MASCOTAS", "CONCENTRADOS", "VARIOS", "FERRETERIA");
        //AND Codigo in('VEND475','VEND443')
        $queryv = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[cliVendedor] WHERE SectorLab = '$area' AND Codigo!='VENDWEB' AND Activo='1' ORDER BY Codigo ASC;", $cLink);
        $num=mssql_num_rows($queryv);
        $cantidadTeleoperadores=mssql_num_rows($queryv);
        //$num=$num+2;
        //$tamfilArea=($fila*3)+$num-1;
        $tamfilArea=$fila + (($num*3) + $num -2);
        $Total=0;
        $filav=0;
        //combina areas
        $objWorkSheet->mergeCells("A".$fila.":A".$tamfilArea."");
        $objWorkSheet->setCellValue('A'.$fila, $area);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':A'.$tamfilArea)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //subtotales
                
        //$TotalCuo1=0;$TotalCuo2=0;$TotalCuo3=0;$TotalCuo4=0;$TotalCuo5=0;$TotalCuo6=0;$TotalCuo7=0;$TotalCuo8=0;$TotalCuo9=0;$TotalCuo10=0;$TotalCuo11=0;$TotalCuo12=0;$TotalCuo13=0;$TotalCuo14=0;$TotalCuo15=0;$TotalCuo16=0;$TotalCuo17=0;$TotalCuo18=0;
        //$TotalLab1=0;$TotalLab2=0;$TotalLab3=0;$TotalLab4=0;$TotalLab5=0;$TotalLab6=0;$TotalLab7=0;$TotalLab8=0;$TotalLab9=0;$TotalLab10=0;$TotalLab11=0;$TotalLab12=0;$TotalLab13=0;$TotalLab14=0;$TotalLab15=0;$TotalLab16=0;$TotalLab17=0;$TotalLab18=0;
        //$TotalLab1b=0;$TotalLab2b=0;$TotalLab3b=0;$TotalLab4b=0;$TotalLab5b=0;$TotalLab6b=0;$TotalLab7b=0;$TotalLab8b=0;$TotalLab9b=0;$TotalLab10b=0;$TotalLab11b=0;$TotalLab12b=0;$TotalLab13b=0;$TotalLab14b=0;$TotalLab15b=0;$TotalLab16b=0;$TotalLab17b=0;$TotalLab18b=0;
        $vendLabI = new ArrayIterator();
        $TotalLabI = new ArrayIterator();
        $TotalLabO = new ArrayIterator();
        $filavend=0;
        while($rowVend = mssql_fetch_array($queryv)){
            $vend = trim($rowVend['Codigo']);
            $nomb = trim($rowVend['Apellidos'])." ".trim($rowVend['Nombres']);
            
            
            //cod vendedores
            $filaf=$fila+2;
            $acumulado=0;
            $objWorkSheet->mergeCells("B".$fila.":B".$filaf."");
            $objPHPExcel->getActiveSheet()->getStyle("B".$fila.":B".$filaf."")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
            $objWorkSheet->setCellValue('B'.$fila, $vend);  
            $objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //valores
            $queryval = mssql_query("SELECT tipoCuota, cuotagen, SectorLab  FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND codVend='$vend' AND Periodo='$periodo' AND tipoCuota != 'Cuota Laboratorio' AND tipoCuota != '';", $cLink);
            $num2=mssql_num_rows($queryval);
            //$num2=$num2-1;
            //echo "</br>eSTE ES 20211102Vendedor: ".$vend."---num: ".$num2."</br>";
            if($num2 == 1){
                while($rowVendVal = mssql_fetch_array($queryval)){
                    $tipocuo = trim($rowVendVal['tipoCuota']);
                    $cuotag = trim($rowVendVal['cuotagen']);
                    
                    $sectorLab = trim($rowVendVal['SectorLab']);
                    
                    if($tipocuo=='Cuota Individual' && $cuotag > 0){
                        $tipocuo2='Cuota Objetivo Individual';
                        $cuotag2=0;
                    } else if(($tipocuo=='-' || $tipocuo=='')){
                        $tipocuo='Cuota Individual';
                        $tipocuo2='Cuota Objetivo Individual';
                        $cuotag2=0;
                    } else {
                        $tipocuo='Cuota Individual';
                        $tipocuo2='Cuota Objetivo Individual';
                        $cuotag2=0;
                    } 
                    
                                   
                    $objPHPExcel->getActiveSheet()->getStyle("C".$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                    $objWorkSheet->setCellValue('C'.$fila, $tipocuo);
                    $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                    $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
                    $fila++;
                    $objPHPExcel->getActiveSheet()->getStyle("C".$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                    $objWorkSheet->setCellValue('C'.$fila, $tipocuo2);
                    $objWorkSheet->setCellValue('D'.$fila, $cuotag2);
                    $objWorkSheet->setCellValue('BP'.$fila, $cuotag2);
                    $filav++;
                    $Totalv=$Totalv+$cuotag;
                    if($filav==1){
                        $fila++;
                        $objPHPExcel->getActiveSheet()->getStyle("C".$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                        $objWorkSheet->setCellValue('C'.$fila, utf8_encode($nomb));
                        //CUOTA GENERAL
                        $objPHPExcel->getActiveSheet()->getStyle("D".$fila.":BR".$filaf."")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                        $objWorkSheet->setCellValue('D'.$fila, $Totalv);
                        $objWorkSheet->setCellValue('BP'.$fila, $Totalv);
                        $Total=$Total+$Totalv;
                        $Totalv=0;
                        
                        
                        //total venta por vendedor (total derecho) TOTAL DERECHA EN ARRAYS -- SE PUBLICA DENDRO DE LABORATORIOS
                        $queryTVLabs = mssql_query("SELECT sum(Venta) as VentaI, sum(VentaObj) as VentaO FROM [sqlFacturas].[dbo].[facInfcomercial] where codVend='".$vend."' and tipoCuota='Cuota Laboratorio' and Periodo='".$periodo."';", $cLink);
                        if($rowVendTDer = mssql_fetch_array($queryTVLabs)){
                            if (! in_array($vend, $vendLabI[$filavend])) {
                                $vendLabI[$filavend]=trim($vend);
                                $TotalLabI[$filavend]=trim($rowVendTDer['VentaI']);
                                $TotalLabO[$filavend]=trim($rowVendTDer['VentaO']);
                                //echo "TotalLabI$filavend:".$vend."--->".$TotalLabI[$filavend]."</br>";  
                                $filavend++;
                            }      
                        }
                        //LABORATORIOS
                        $queryval = mssql_query("SELECT Cuota, Venta, VentaObj, SectorLab FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND tipoCuota='Cuota Laboratorio' AND codVend='$vend' AND Periodo='$periodo';", $cLink);
                 
                        //este ciclo recorre 3 veces por cada lab
                        while($rowVendValab = mssql_fetch_array($queryval)){
                            $cuotaLab = trim($rowVendValab['Cuota']);
                            $ventaInd = trim($rowVendValab['Venta']);
                            $ventaObj = trim($rowVendValab['VentaObj']);
                            $sectorLab = trim($rowVendValab['SectorLab']);
                            $filaX=$fila-2;
                            $filaY=$filaX+1;
                            //PARA TOTALES VENTA POR VEND -- DERECHA
                            $filaXX=$filaX;
                            $filaYY=$filaY;
                            //echo "</br>-----".$vend."-----".$sectorLab."------</br>";
                           
                            //sutotales LABORATORIOS
                            include('valoresCALL.php');
                           
                            //venta total por vendedor DERECHA
                            $m=0;
                            $cV=count($vendLabI);
                            while($m<=$cV){
                                if(trim($vendLabI[$m])==trim($vend)){
                                    $objWorkSheet->setCellValue('BQ'.$filaXX, $TotalLabI[$m]);
                                    $objWorkSheet->setCellValue('BQ'.$filaYY, $TotalLabO[$m]);
                                    $m=$cV;
                                }
                                $m++;
                            }
                            
                        
                        }//FIN LABORATORIOS
                        
                        //CUADRO 2 JORGE
                        $querysumCom = mssql_query("SELECT SUM(VentaCont) as VentaCont, sum(VentaCred) as VentaCred, sum(VentaMixt) as VentaMixt, sum(NotasCrCont) as NotasCrCont, sum(NotasCrCred) as NotasCrCred, sum(NotasCrMixt) as NotasCrMixt, sum(NotaDebito) as NotaDebito,sum(NotasdCobra) as NotasdCobra,sum(Subtotal) as Subtotal,sum(DistriBolsa) as DistriBolsa,sum(Total) as Total,sum(Falta) as Falta,sum(DifTotMix) as DifTotMix FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='$vend' and Periodo='$periodo';", $cLink);
                        if($rowVendValab = mssql_fetch_array($querysumCom)){
                            
                            $VentaCont = trim($rowVendValab['VentaCont']);
                            $VentaCred = trim($rowVendValab['VentaCred']);
                            $VentaMixt = trim($rowVendValab['VentaMixt']);
                            $NotasCrCont = trim($rowVendValab['NotasCrCont']);
                            $NotasCrCred = trim($rowVendValab['NotasCrCred']);
                            $NotasCrMixt = trim($rowVendValab['NotasCrMixt']);
                            $NotaDebito = trim($rowVendValab['NotaDebito']);
                            $NotasdCobra = trim($rowVendValab['NotasdCobra']);
                            $Subtotal = trim($rowVendValab['Subtotal']);
                            $DistriBolsa = trim($rowVendValab['DistriBolsa']);
                            $Totalkl = trim($rowVendValab['Total']);
                            //$Falta = trim($rowVendValab['Falta']);
                            //$DifTotMix = trim($rowVendValab['DifTotMix']);
                            $Falta="=BQ".$fila."-BP".$fila;
                            //$DifTotMix="=CE".$fila;
                            //$Porc="=CE".$fila."/BP".$fila;
                            $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(CE".$fila."/BP".$fila.",0)");
                            
                            //filas
                            if($VentaCont=='-'){$VentaCont=0;}
                            $objWorkSheet->setCellValue('BU'.$fila, $VentaCont);
                            if($VentaCred=='-'){$VentaCred=0;}
                            $objWorkSheet->setCellValue('BV'.$fila, $VentaCred);
                            if($VentaMixt=='-'){$VentaMixt=0;}
                            $objWorkSheet->setCellValue('BW'.$fila, $VentaMixt);
                            if($NotasCrCont=='-'){$NotasCrCont=0;}
                            $objWorkSheet->setCellValue('BX'.$fila, $NotasCrCont);
                            if($NotasCrCred=='-'){$NotasCrCred=0;}
                            $objWorkSheet->setCellValue('BY'.$fila, $NotasCrCred);
                            if($NotasCrMixt=='-'){$NotasCrMixt=0;}
                            $objWorkSheet->setCellValue('BZ'.$fila, $NotasCrMixt);
                            if($NotaDebito=='-'){$NotaDebito=0;}
                            $objWorkSheet->setCellValue('CA'.$fila, $NotaDebito);
                            if($NotasdCobra=='-'){$NotasdCobra=0;}
                            $objWorkSheet->setCellValue('CB'.$fila, $NotasdCobra);
                            if($DistriBolsa=='-'){$DistriBolsa=0;}
                            $objWorkSheet->setCellValue('CD'.$fila, $DistriBolsa);
                            if($Totalkl=='-'){$Totalkl=0;}
                            $objWorkSheet->setCellValue('CE'.$fila, $Totalkl);
                            if($Falta=='-'){$Falta=0;}
                            $objWorkSheet->setCellValue('CF'.$fila, $Falta);
                            if($DifTotMix=='-'){$DifTotMix=0;}
                            $objWorkSheet->setCellValue('CG'.$fila, $DifTotMix);
                            if($Porc=='-'){$Porc=0;}
                            $objWorkSheet->setCellValue('CH'.$fila, $Porc);
                        }
                        
                        //SUBTOTAL CUADRO DERECHA
                        //$objPHPExcel->getActiveSheet()->setCellValue('CC'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')');
                        //$objPHPExcel->getActiveSheet()->setCellValue('CE'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')-CD'.$fila);
                        //$objPHPExcel->getActiveSheet()->setCellValue('CF'.$fila,'=(BQ'.$fila.'-BP'.$fila.')');
                      
                        $filav=0;
                        
                    }
                    
                    $fila++;         
                }
            } else if($num2 == 2){
                while($rowVendVal = mssql_fetch_array($queryval)){
                    $tipocuo = trim($rowVendVal['tipoCuota']);
                    $cuotag = trim($rowVendVal['cuotagen']);
                    
                    $sectorLab = trim($rowVendVal['SectorLab']);
                    
                                       
                    if($filav==0){
                        $tipocuo='Cuota Individual';
                    }else if($filav==1){
                        $tipocuo='Cuota Objetivo Individual';
                    }
                    
                    //echo "</br>".$filav."--".$vend."--".$tipocuo;
                    
                    $filav++;
                    
                   
                    
                    $objPHPExcel->getActiveSheet()->getStyle("C".$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                    $objWorkSheet->setCellValue('C'.$fila, $tipocuo);
                    $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                    $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
                                       
                    
                    $Totalv=$Totalv+$cuotag;
                    if($filav==2){
                        $fila++;
                        $objPHPExcel->getActiveSheet()->getStyle("C".$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                        $objWorkSheet->setCellValue('C'.$fila, utf8_encode($nomb));
                        //->getAllBorders()
                        $objPHPExcel->getActiveSheet()->getStyle("D".$fila.":BR".$filaf."")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                        $objWorkSheet->setCellValue('D'.$fila, $Totalv);
                        $objWorkSheet->setCellValue('BP'.$fila, $Totalv);
                        $Total=$Total+$Totalv;
                        
                        //total venta por vendedor (total derecho) TOTAL DERECHA EN ARRAYS -- SE PUBLICA DENDRO DE LABORATORIOS
                        //echo "</br>".$vend."---".$periodo."</br>";
                        $queryTVLabs = mssql_query("SELECT sum(Venta) as VentaI, sum(VentaObj) as VentaO FROM [sqlFacturas].[dbo].[facInfcomercial] where codVend='".$vend."' and tipoCuota='Cuota Laboratorio' and Periodo='".$periodo."';", $cLink);
                        if($rowVendTDer = mssql_fetch_array($queryTVLabs)){
                            if (! in_array($vend, $vendLabI[$filavend])) {
                                $vendLabI[$filavend]=trim($vend);
                                $TotalLabI[$filavend]=trim($rowVendTDer['VentaI']);
                                $TotalLabO[$filavend]=trim($rowVendTDer['VentaO']);
                                //echo "TotalLabI$filavend:".$vend."--->".$TotalLabI[$filavend]."</br>";  
                                $filavend++;
                            }
                        }  
                        
                        $Totalv=0;
                        
                                               
                        //LABORATORIOS*******************************************************
                        $queryval = mssql_query("SELECT Cuota, Venta, VentaObj, SectorLab FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND tipoCuota='Cuota Laboratorio' AND codVend='$vend' AND Periodo='$periodo';", $cLink);
                        
                        while($rowVendValab = mssql_fetch_array($queryval)){
                            $cuotaLab = trim($rowVendValab['Cuota']);
                            $ventaInd = trim($rowVendValab['Venta']);
                            $ventaObj = trim($rowVendValab['VentaObj']);
                            $sectorLab = trim($rowVendValab['SectorLab']);
                            $filaX=$fila-2;
                            $filaY=$filaX+1;
                            //PARA TOTALES VENTA POR VEND DERECHA
                            $filaXX=$filaX;
                            $filaYY=$filaY;
                            
                                                         
                            //sutotales LABORATORIOS
                            include('valoresCALL.php'); 
                            
                            //venta total por vendedor DERECHA
                            $m=0;
                            $cV=count($vendLabI);
                            while($m<=$cV){
                                if(trim($vendLabI[$m])==trim($vend)){
                                    $objWorkSheet->setCellValue('BQ'.$filaXX, $TotalLabI[$m]);
                                    $objWorkSheet->setCellValue('BQ'.$filaYY, $TotalLabO[$m]);
                                    $m=$cV;
                                }
                                $m++;
                            }
                           
                            
                        
                        }//FIN LABORATORIOS
                        
                        
                        //CUADRO 2 JORGE
                        $querysumCom = mssql_query("SELECT SUM(VentaCont) as VentaCont, sum(VentaCred) as VentaCred, sum(VentaMixt) as VentaMixt, sum(NotasCrCont) as NotasCrCont, sum(NotasCrCred) as NotasCrCred, sum(NotasCrMixt) as NotasCrMixt, sum(NotaDebito) as NotaDebito,sum(NotasdCobra) as NotasdCobra,sum(Subtotal) as Subtotal,sum(DistriBolsa) as DistriBolsa,sum(Total) as Total,sum(Falta) as Falta,sum(DifTotMix) as DifTotMix FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE codVend='$vend' and Periodo='$periodo';", $cLink);
                        if($rowVendValab = mssql_fetch_array($querysumCom)){
                            
                            $VentaCont = trim($rowVendValab['VentaCont']);
                            $VentaCred = trim($rowVendValab['VentaCred']);
                            $VentaMixt = trim($rowVendValab['VentaMixt']);
                            $NotasCrCont = trim($rowVendValab['NotasCrCont']);
                            $NotasCrCred = trim($rowVendValab['NotasCrCred']);
                            $NotasCrMixt = trim($rowVendValab['NotasCrMixt']);
                            $NotaDebito = trim($rowVendValab['NotaDebito']);
                            $NotasdCobra = trim($rowVendValab['NotasdCobra']);
                            $Subtotal = trim($rowVendValab['Subtotal']);
                            $DistriBolsa = trim($rowVendValab['DistriBolsa']);
                            $Totalkl = trim($rowVendValab['Total']);
                            //$Total="aqui_5";
                            //$Falta = trim($rowVendValab['Falta']);
                            //$DifTotMix = trim($rowVendValab['DifTotMix']);
                            $Falta="=BQ".$fila."-BP".$fila;
                            //$DifTotMix="=CE".$fila;
                            //$Porc="=CE".$fila."/BP".$fila;
                            $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(CE".$fila."/BP".$fila.",0)");
                            
                            //filas
                            if($VentaCont=='-'){$VentaCont=0;}
                            $objWorkSheet->setCellValue('BU'.$fila, $VentaCont);
                            if($VentaCred=='-'){$VentaCred=0;}
                            $objWorkSheet->setCellValue('BV'.$fila, $VentaCred);
                            if($VentaMixt=='-'){$VentaMixt=0;}
                            $objWorkSheet->setCellValue('BW'.$fila, $VentaMixt);
                            if($NotasCrCont=='-'){$NotasCrCont=0;}
                            $objWorkSheet->setCellValue('BX'.$fila, $NotasCrCont);
                            if($NotasCrCred=='-'){$NotasCrCred=0;}
                            $objWorkSheet->setCellValue('BY'.$fila, $NotasCrCred);
                            if($NotasCrMixt=='-'){$NotasCrMixt=0;}
                            $objWorkSheet->setCellValue('BZ'.$fila, $NotasCrMixt);
                            if($NotaDebito=='-'){$NotaDebito=0;}
                            $objWorkSheet->setCellValue('CA'.$fila, $NotaDebito);
                            if($NotasdCobra=='-'){$NotasdCobra=0;}
                            $objWorkSheet->setCellValue('CB'.$fila, $NotasdCobra);
                            if($DistriBolsa=='-'){$DistriBolsa=0;}
                            $objWorkSheet->setCellValue('CD'.$fila, $DistriBolsa);
                            if($Totalkl=='-'){$Totalkl=0;}
                            $objWorkSheet->setCellValue('CE'.$fila, $Totalkl);
                            if($Falta=='-'){$Falta=0;}
                            $objWorkSheet->setCellValue('CF'.$fila, $Falta);
                            if($DifTotMix=='-'){$DifTotMix=0;}
                            $objWorkSheet->setCellValue('CG'.$fila, $DifTotMix);
                            if($Porc=='-'){$Porc=0;}
                            $objWorkSheet->setCellValue('CH'.$fila, $Porc);
                        }
                       
                        //SUBTOTAL CUADRO DERECHA
                        //$objPHPExcel->getActiveSheet()->setCellValue('CC'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')');
                        //$objPHPExcel->getActiveSheet()->setCellValue('CE'.$fila,'=(BU'.$fila.'+BV'.$fila.'+BW'.$fila.'+BX'.$fila.'+BY'.$fila.'+BZ'.$fila.'+CA'.$fila.'+CB'.$fila.')-CD'.$fila);
                        //$objPHPExcel->getActiveSheet()->setCellValue('CF'.$fila,'=(BQ'.$fila.'-BP'.$fila.')');
                                                
                        $filav=0;
                        
                    }
                    $fila++;         
                }
            } else {
                $cuotag = 0;
                $ventaInd=0;
                $ventaObj=0;
                $objWorkSheet->setCellValue('C'.$fila, "Cuota Individual");
                //$objWorkSheet->setCellValue('C'.$fila+1, "Cuota Objetivo Individual");
                $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
                $filaf=$fila+2;
                $objPHPExcel->getActiveSheet()->getStyle("C".$fila.":C".$filaf."")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                $objPHPExcel->getActiveSheet()->getStyle("D".$filaf.":BR".$filaf."")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                //VENTAS
                $filaX=$fila;
                $objWorkSheet->setCellValue('X'.$filaX, $ventaInd);
                $objWorkSheet->setCellValue('Y'.$filaX, "0%");
                $objPHPExcel->getActiveSheet()->getStyle('Y'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objWorkSheet->setCellValue('AA'.$filaX, $ventaInd);
                $objWorkSheet->setCellValue('AB'.$filaX, "0%");
                $objPHPExcel->getActiveSheet()->getStyle('AB'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objWorkSheet->setCellValue('AD'.$filaX, $ventaInd);
                $objWorkSheet->setCellValue('AE'.$filaX, "0%");
                $objPHPExcel->getActiveSheet()->getStyle('AE'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objWorkSheet->setCellValue('AJ'.$filaX, $ventaInd);
                $objWorkSheet->setCellValue('AK'.$filaX, "0%");
                $objPHPExcel->getActiveSheet()->getStyle('AK'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objWorkSheet->setCellValue('AM'.$filaX, $ventaInd);
                $objWorkSheet->setCellValue('AN'.$filaX, "0%");
                $objPHPExcel->getActiveSheet()->getStyle('AN'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objWorkSheet->setCellValue('AS'.$filaX, $ventaInd);
                $objWorkSheet->setCellValue('AT'.$filaX, "0%");
                $objPHPExcel->getActiveSheet()->getStyle('AT'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objWorkSheet->setCellValue('AV'.$filaX, $ventaInd);
                $objWorkSheet->setCellValue('AW'.$filaX, "0%");
                $objPHPExcel->getActiveSheet()->getStyle('AW'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objWorkSheet->setCellValue('AY'.$filaX, $ventaInd);
                $objWorkSheet->setCellValue('AZ'.$filaX, "0%");
                $objPHPExcel->getActiveSheet()->getStyle('AZ'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objWorkSheet->setCellValue('BN'.$filaX, $ventaInd);
                $objWorkSheet->setCellValue('BO'.$filaX, "0%");
                $objPHPExcel->getActiveSheet()->getStyle('BO'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objWorkSheet->setCellValue('BE'.$filaX, $ventaInd);
                $objWorkSheet->setCellValue('BF'.$filaX, "0%");
                $objPHPExcel->getActiveSheet()->getStyle('BF'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objWorkSheet->setCellValue('BH'.$filaX, $ventaInd);
                $objWorkSheet->setCellValue('BI'.$filaX, "0%");
                $objPHPExcel->getActiveSheet()->getStyle('BI'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objWorkSheet->setCellValue('BK'.$filaX, $ventaInd);
                $objWorkSheet->setCellValue('BL'.$filaX, "0%");
                $objPHPExcel->getActiveSheet()->getStyle('BL'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objWorkSheet->setCellValue('U'.$filaX, $ventaInd);
                $objWorkSheet->setCellValue('V'.$filaX, "0%");
                $objPHPExcel->getActiveSheet()->getStyle('V'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objWorkSheet->setCellValue('R'.$filaX, $ventaInd);
                $objWorkSheet->setCellValue('S'.$filaX, "0%");
                $objPHPExcel->getActiveSheet()->getStyle('S'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objWorkSheet->setCellValue('O'.$filaX, $ventaInd);
                $objWorkSheet->setCellValue('P'.$filaX, "0%");
                $objPHPExcel->getActiveSheet()->getStyle('P'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objWorkSheet->setCellValue('L'.$filaX, $ventaInd);
                $objWorkSheet->setCellValue('M'.$filaX, "0%");
                $objPHPExcel->getActiveSheet()->getStyle('M'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objWorkSheet->setCellValue('I'.$filaX, $ventaInd);
                $objWorkSheet->setCellValue('J'.$filaX, "0%");
                $objPHPExcel->getActiveSheet()->getStyle('J'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objWorkSheet->setCellValue('F'.$filaX, $ventaInd);
                $objWorkSheet->setCellValue('G'.$filaX, "0%");
                $objPHPExcel->getActiveSheet()->getStyle('G'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $fila++;
                $objWorkSheet->setCellValue('C'.$fila, "Cuota Objetivo Individual");
                $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
                //VENTAS OBJ
                $filaX=$fila;
                $objWorkSheet->setCellValue('X'.$filaX, $ventaObj);
                $objWorkSheet->setCellValue('AA'.$filaX, $ventaObj);
                $objWorkSheet->setCellValue('AD'.$filaX, $ventaObj);
                $objWorkSheet->setCellValue('AJ'.$filaX, $ventaObj);
                $objWorkSheet->setCellValue('AM'.$filaX, $ventaObj);
                $objWorkSheet->setCellValue('AS'.$filaX, $ventaObj);
                $objWorkSheet->setCellValue('AV'.$filaX, $ventaObj);
                 $objWorkSheet->setCellValue('AY'.$filaX, $ventaObj);
                $objWorkSheet->setCellValue('BN'.$filaX, $ventaObj);
                $objWorkSheet->setCellValue('BE'.$filaX, $ventaObj);
                $objWorkSheet->setCellValue('BH'.$filaX, $ventaObj);
                $objWorkSheet->setCellValue('BK'.$filaX, $ventaObj);
                $objWorkSheet->setCellValue('U'.$filaX, $ventaObj);
                $objWorkSheet->setCellValue('R'.$filaX, $ventaObj);
                $objWorkSheet->setCellValue('O'.$filaX, $ventaObj);
                $objWorkSheet->setCellValue('L'.$filaX, $ventaObj);
                $objWorkSheet->setCellValue('I'.$filaX, $ventaObj);
                $objWorkSheet->setCellValue('F'.$filaX, $ventaObj);
                $fila++;
                $objWorkSheet->setCellValue('C'.$fila, utf8_encode($nomb));
                $fila++;
            }
                      
            //TOTAL POR LABORATORIOS CALLCENTER
            $Total=0;
            $cuotaGen=0;
            $queryTLabs = mssql_query("SELECT DISTINCT tipoCuota, Cuotagen, SectorLab, Cuota, codVend, Venta, VentaObj FROM [sqlFacturas].[dbo].[facInfcomercial] where codVend='".$vend."' and tipoCuota='Cuota Laboratorio' and Area='TELEOPERADOR' and SectorLab NOT IN('TODO');", $cLink);
            //echo "</br>SELECT DISTINCT SectorLab, codVend, Venta, VentaObj FROM [sqlFacturas].[dbo].[facInfcomercial] where codVend='".$vend."' and tipoCuota='Cuota Laboratorio' and Area='TELEOPERADOR' and SectorLab NOT IN('TODO');";
            while($rowVendTlab = mssql_fetch_array($queryTLabs)){
                $CuotaIndT = trim($rowVendTlab['Cuota']);
                $ventaIndT = trim($rowVendTlab['Venta']);
                $tipoCuotag = trim($rowVendTlab['tipoCuota']);
                $ventaObjT = trim($rowVendTlab['VentaObj']);
                $sectorLab = trim($rowVendTlab['SectorLab']);
                //$cuotaGen = $cuotaGen + trim($rowVendTlab['Cuotagen']);
                if($ventaIndT=='' || $ventaIndT=='-'){$ventaIndT=0;}
                if($ventaObjT=='' || $ventaObjT=='-'){$ventaObjT=0;}
                if($CuotaIndT=='' || $CuotaIndT=='-'){$CuotaIndT=0;}
                $Total=$ventaIndT + $ventaObjT;
                $TotalC = $CuotaIndT;
                //PARA TOTAL GENERAL INDIVIDUAL Y OBJETIVO               
                    switch ($sectorLab) {
                                case 'INT':
                                    //invet
                                    $TotalTCuo7=$TotalTCuo7+$TotalC;
                                    $TotalTLab7=$TotalTLab7+$Total;
                                    //cuotaind, vind, vobj
                                    $TotalTCuo7I = $TotalTCuo7I + $CuotaIndT;
                                    $TotalTLab7I = $TotalTLab7I + $ventaIndT;
                                    $TotalTLab7O = $TotalTLab7O + $ventaObjT;
                                    break;
                                case 'ICO':
                                    //icofarma
                                     $TotalTCuo8=$TotalTCuo8+$TotalC;
                                     $TotalTLab8=$TotalTLab8+$Total;
                                     //cuotaind, vind, vobj
                                    $TotalTCuo8I = $TotalTCuo8I + $CuotaIndT;
                                    $TotalTLab8I = $TotalTLab8I + $ventaIndT;
                                    $TotalTLab8O = $TotalTLab8O + $ventaObjT;
                                   break;
                                case 'COMERVET':
                                     //totalizar
                                    $TotalTCuo9=$TotalTCuo9+$TotalC;  
                                    $TotalTLab9=$TotalTLab9+$Total;
                                    //cuotaind, vind, vobj
                                    $TotalTCuo9I = $TotalTCuo9I + $CuotaIndT;
                                    $TotalTLab9I = $TotalTLab9I + $ventaIndT;
                                    $TotalTLab9O = $TotalTLab9O + $ventaObjT;
                                    break;
                                case 'HOL':
                                    //GABRICA
                                     //totalizar
                                    $TotalTCuo10=$TotalTCuo10+$TotalC;
                                    $TotalTLab10=$TotalTLab10+$Total;
                                    //cuotaind, vind, vobj
                                    $TotalTCuo10I = $TotalTCuo10I + $CuotaIndT;
                                    $TotalTLab10I = $TotalTLab10I + $ventaIndT;
                                    $TotalTLab10O = $TotalTLab10O + $ventaObjT;
                                    break;
                                case 'BIS':
                                    //BIOSTAR
                                     //totalizar
                                    $TotalTCuo11=$TotalTCuo11+$TotalC;   
                                    $TotalTLab11=$TotalTLab11+$Total;
                                    //cuotaind, vind, vobj
                                    $TotalTCuo11I = $TotalTCuo11I + $CuotaIndT;
                                    $TotalTLab11I = $TotalTLab11I + $ventaIndT;
                                    $TotalTLab11O = $TotalTLab11O + $ventaObjT;
                                    break;
                                case 'CPH':
                                    //COHASFARMA
                                     //totalizar
                                    $TotalTCuo12=$TotalTCuo12+$TotalC;
                                    $TotalTLab12=$TotalTLab12+$Total;
                                    //cuotaind, vind, vobj
                                    $TotalTCuo12I = $TotalTCuo12I + $CuotaIndT;
                                    $TotalTLab12I = $TotalTLab12I + $ventaIndT;
                                    $TotalTLab12O = $TotalTLab12O + $ventaObjT;
                                    break;
                                case 'IMPORTADOS':
                                     //totalizar
                                    $TotalTCuo13=$TotalTCuo13+$TotalC;   
                                    
                                    //cuotaind, vind, vobj  jairin
                                    $TotalTCuo13I = $TotalTCuo13I + $CuotaIndT;
                                    //echo "<br>Importados:".$vend."---".$CuotaIndT."<br>";
                                    $TotalTLab13I = $TotalTLab13I + $ventaIndT;
                                    $TotalTLab13O = $TotalTLab13O + $ventaObjT;
                                    
                                    //totaliza venddores importados - objetivo-carlos
                                    $TotalTLab13=$TotalTLab13+$Total-$ventaObjT;
                                    break;
                                case 'INTERVET MSD':
                                     //totalizar
                                    $TotalTCuo14=$TotalTCuo14+$TotalC;   
                                    $TotalTLab14=$TotalTLab14+$Total;
                                    //cuotaind, vind, vobj
                                    $TotalTCuo14I = $TotalTCuo14I + $CuotaIndT;
                                    $TotalTLab14I = $TotalTLab14I + $ventaIndT;
                                    $TotalTLab14O = $TotalTLab14O + $ventaObjT;
                                    break;
                                case 'TEC':
                                    //totalizar
                                    $TotalTCuo18=$TotalTCuo18+$TotalC;   
                                    $TotalTLab18=$TotalTLab18+$Total;
                                    //cuotaind, vind, vobj
                                    $TotalTCuo18I = $TotalTCuo18I + $CuotaIndT;
                                    $TotalTLab18I = $TotalTLab18I + $ventaIndT;
                                    $TotalTLab18O = $TotalTLab18O + $ventaObjT;
                                    break;
                                case 'AGI':
                                    //LINEA AGIL
                                    //totalizar
                                    $TotalTCuo15=$TotalTCuo15+$TotalC;   
                                    $TotalTLab15=$TotalTLab15+$Total;
                                    //cuotaind, vind, vobj
                                    $TotalTCuo15I = $TotalTCuo15I + $CuotaIndT;
                                    $TotalTLab15I = $TotalTLab15I + $ventaIndT;
                                    $TotalTLab15O = $TotalTLab15O + $ventaObjT;
                                    break;
                                case 'AMI':
                                    //LINEA AGIL IMPORTADOS
                                    //totalizar
                                    $TotalTCuo16=$TotalTCuo16+$TotalC;
                                    $TotalTLab16=$TotalTLab16+$Total;
                                    //cuotaind, vind, vobj
                                    $TotalTCuo16I = $TotalTCuo16I + $CuotaIndT;
                                    $TotalTLab16I = $TotalTLab16I + $ventaIndT;
                                    $TotalTLab16O = $TotalTLab16O + $ventaObjT;
                                    break;
                                case 'BAI':
                                    //laboratorios BAI
                                    //totalizar
                                    $TotalTCuo17=$TotalTCuo17+$TotalC;
                                    $TotalTLab17=$TotalTLab17+$Total;
                                    //cuotaind, vind, vobj
                                    $TotalTCuo17I = $TotalTCuo17I + $CuotaIndT;
                                    $TotalTLab17I = $TotalTLab17I + $ventaIndT;
                                    $TotalTLab17O = $TotalTLab17O + $ventaObjT;
                                    break;
                                case 'AGROQUIMICOS / VENENOS':
                                    //totalizar
                                    $TotalTCuo6=$TotalTCuo6+$TotalC;   
                                    $TotalTLab6=$TotalTLab6+$Total;
                                    //cuotaind, vind, vobj
                                    $TotalTCuo6I = $TotalTCuo6I + $CuotaIndT;
                                    $TotalTLab6I = $TotalTLab6I + $ventaIndT;
                                    $TotalTLab6O = $TotalTLab6O + $ventaObjT;
                                    break;
                                case 'MEDICAMENTOS':
                                    //totalizar
                                    $TotalTCuo5=$TotalTCuo5+$TotalC;  
                                    $TotalTLab5=$TotalTLab5+$Total;
                                    //cuotaind, vind, vobj
                                    $TotalTCuo5I = $TotalTCuo5I + $CuotaIndT;
                                    $TotalTLab5I = $TotalTLab5I + $ventaIndT;
                                    $TotalTLab5O = $TotalTLab5O + $ventaObjT;
                                    break;
                                case 'MASCOTAS':
                                    //totalizar
                                    $TotalTCuo4=$TotalTCuo4+$TotalC;
                                    $TotalTLab4=$TotalTLab4+$Total;
                                    //cuotaind, vind, vobj
                                    $TotalTCuo4I = $TotalTCuo4I + $CuotaIndT;
                                    $TotalTLab4I = $TotalTLab4I + $ventaIndT;
                                    $TotalTLab4O = $TotalTLab4O + $ventaObjT;
                                    break;
                                case 'CONCENTRADOS':
                                    //totalizar
                                    $TotalTCuo3=$TotalTCuo3+$TotalC;   
                                    $TotalTLab3=$TotalTLab3+$Total;
                                    //cuotaind, vind, vobj
                                    $TotalTCuo3I = $TotalTCuo3I + $CuotaIndT;
                                    $TotalTLab3I = $TotalTLab3I + $ventaIndT;
                                    $TotalTLab3O = $TotalTLab3O + $ventaObjT;
                                    break;
                                case 'VARIOS':
                                    //totalizar
                                    $TotalTCuo2=$TotalTCuo2+$TotalC; 
                                    $TotalTLab2=$TotalTLab2+$Total;
                                    //cuotaind, vind, vobj
                                    $TotalTCuo2I = $TotalTCuo2I + $CuotaIndT;
                                    $TotalTLab2I = $TotalTLab2I + $ventaIndT;
                                    $TotalTLab2O = $TotalTLab2O + $ventaObjT;
                                    break;
                                case 'FERRETERIA':                                   
                                    //totalizar
                                    $TotalTCuo1=$TotalTCuo1+$TotalC; 
                                    $TotalTLab1=$TotalTLab1+$Total;
                                    //cuotaind, vind, vobj
                                    $TotalTCuo1I = $TotalTCuo1I + $CuotaIndT;
                                    $TotalTLab1I = $TotalTLab1I + $ventaIndT;
                                    $TotalTLab1O = $TotalTLab1O + $ventaObjT;   
                                    break; 
                            }
                            
            }
            
            //fin ciclo incrementa vendedores
            $fila++;  
                   
        }
        
        //TOTAL x POR LABORATORIOS CALLCENTER CONT.....
        
        $fila--;
        
        
        
        //combinar celdas
        $objWorkSheet->mergeCells("A".$fila.":C".$fila."");
        $objWorkSheet->setCellValue('A'.$fila, 'TOTAL '.$area);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //color de fondo
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7');
        //valor
        
        $queryTLabs = mssql_query("SELECT SUM(Cuotagen) AS TotalCGO FROM [sqlFacturas].[dbo].[facInfcomercial] where tipoCuota IN('Cuota Individual','Cuota Objetivo Individual') and Area='TELEOPERADOR' and SectorLab NOT IN('TODO');", $cLink);
        //echo "</br>SELECT DISTINCT SectorLab, codVend, Venta, VentaObj FROM [sqlFacturas].[dbo].[facInfcomercial] where codVend='".$vend."' and tipoCuota='Cuota Laboratorio' and Area='TELEOPERADOR' and SectorLab NOT IN('TODO');";
        if($rowVendTlabC = mssql_fetch_array($queryTLabs)){
                //$tipoCuotag = trim($rowVendTlabC['tipoCuota']);
                $cuotaGenObj = trim($rowVendTlabC['TotalCGO']);
                if($cuotaGenObj=='' || $cuotaGenObj=='-'){$cuotaGenObj=0;}
                
        }
            
        $objWorkSheet->setCellValue('D'.$fila, $cuotaGenObj);
        $objWorkSheet->setCellValue('BP'.$fila, $cuotaGenObj);
        
        //TOTAL LABORATORIOS CALLCENTER      
        
        //FERRETERIA
        $objWorkSheet->setCellValue('E'.$fila, $TotalTCuo1);
        $objWorkSheet->setCellValue('F'.$fila, $TotalTLab1);
        $P=0;
        if($TotalTCuo1 > 0){
            // $P=round(($TotalTLab1/$TotalTCuo1));
            $P=round(($TotalTLab1/$TotalTCuo1));
        }
        // $objWorkSheet->setCellValue('G'.$fila, $P);
        $objWorkSheet->setCellValue('G'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //VARIOS
        $objWorkSheet->setCellValue('H'.$fila, $TotalTCuo2);
        $objWorkSheet->setCellValue('I'.$fila, $TotalTLab2);
        $P=0;
        if($TotalTCuo2 > 0){
            // $P=round(($TotalTLab2/$TotalTCuo2));
            $P=round(($TotalTLab2/$TotalTCuo2));
        }
        $objWorkSheet->setCellValue('J'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //CONCENTRADOS
        $objWorkSheet->setCellValue('K'.$fila, $TotalTCuo3);
        $objWorkSheet->setCellValue('L'.$fila, $TotalTLab3);
        $P=0;
        if($TotalTCuo3 > 0){
            $P=round(($TotalTLab3/$TotalTCuo3));
        }
        $objWorkSheet->setCellValue('M'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('M'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //PETS
        $objWorkSheet->setCellValue('N'.$fila, $TotalTCuo4);
        $objWorkSheet->setCellValue('O'.$fila, $TotalTLab4);
        $P=0;
        if($TotalTCuo4 > 0){
            $P=round(($TotalTLab4/$TotalTCuo4));
        }
        $objWorkSheet->setCellValue('P'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('P'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //GANADERIA
        $objWorkSheet->setCellValue('Q'.$fila, $TotalTCuo5);
        $objWorkSheet->setCellValue('R'.$fila, $TotalTLab5);
        $P=0;
        if($TotalTCuo5 > 0){
            $P=round(($TotalTLab5/$TotalTCuo5));
        }
        $objWorkSheet->setCellValue('S'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('S'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //INSECTICIDAS Y OTROS
        $objWorkSheet->setCellValue('T'.$fila, $TotalTCuo6);
        $objWorkSheet->setCellValue('U'.$fila, $TotalTLab6);
        $P=0;
        if($TotalTCuo6 > 0){
            $P=round(($TotalTLab6/$TotalTCuo6));
        }
        $objWorkSheet->setCellValue('V'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('V'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //INVET
        $objWorkSheet->setCellValue('W'.$fila, $TotalTCuo7);
        $objWorkSheet->setCellValue('X'.$fila, $TotalTLab7);
        $P=0;
        if($TotalTCuo7 > 0){
            $P=round(($TotalTLab7/$TotalTCuo7));
        }
        $objWorkSheet->setCellValue('Y'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('Y'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //ICOFARMA
        $objWorkSheet->setCellValue('Z'.$fila, $TotalTCuo8);
        $objWorkSheet->setCellValue('AA'.$fila, $TotalTLab8);
        $P=0;
        if($TotalTCuo8 > 0){
            $P=round(($TotalTLab8/$TotalTCuo8));
        }
        $objWorkSheet->setCellValue('AB'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('AB'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //COMERVET
        $objWorkSheet->setCellValue('AC'.$fila, $TotalTCuo9);
        $objWorkSheet->setCellValue('AD'.$fila, $TotalTLab9);
        $P=0;
        if($TotalTCuo9 > 0){
            $P=round(($TotalTLab9/$TotalTCuo9));
        }
        $objWorkSheet->setCellValue('AE'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('AE'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //GABRICA
        $objWorkSheet->setCellValue('AI'.$fila, $TotalTCuo10);
        $objWorkSheet->setCellValue('AJ'.$fila, $TotalTLab10);
        $P=0;
        if($TotalTCuo10 > 0){
            $P=round(($TotalTLab10/$TotalTCuo10));
        }
        $objWorkSheet->setCellValue('AK'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('AK'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //BIOSTAR
        $objWorkSheet->setCellValue('AL'.$fila, $TotalTCuo11);
        $objWorkSheet->setCellValue('AM'.$fila, $TotalTLab11);
        $P=0;
        if($TotalTCuo11 > 0){
            $P=round(($TotalTLab11/$TotalTCuo11));
        }
        $objWorkSheet->setCellValue('AN'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('AN'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //COHASFARMA
        $objWorkSheet->setCellValue('AR'.$fila, $TotalTCuo12);
        $objWorkSheet->setCellValue('AS'.$fila, $TotalTLab12);
        $P=0;
        if($TotalTCuo12 > 0){
            $P=round(($TotalTLab12/$TotalTCuo12));
        }
        $objWorkSheet->setCellValue('AT'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('AT'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //IMPORTADOS
        $objWorkSheet->setCellValue('AU'.$fila, $TotalTCuo13);
        
        $objWorkSheet->setCellValue('AV'.$fila, $TotalTLab13);
        $P=0;
        if($TotalTCuo13 > 0){
            $P=round(($TotalTLab13/$TotalTCuo13));
        }
        $objWorkSheet->setCellValue('AW'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('AW'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //INTERVET
        $objWorkSheet->setCellValue('AX'.$fila, $TotalTCuo14);
        $objWorkSheet->setCellValue('AY'.$fila, $TotalTLab14);
        $P=0;
        if($TotalTCuo14 > 0){
            $P=round(($TotalTLab14/$TotalTCuo14));
        }
        $objWorkSheet->setCellValue('AZ'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('AZ'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //LINEA AGIL
        $objWorkSheet->setCellValue('BD'.$fila, $TotalTCuo15);
        $objWorkSheet->setCellValue('BE'.$fila, $TotalTLab15);
        $P=0;
        if($TotalTCuo15 > 0){
            $P=round(($TotalTLab15/$TotalTCuo15));
        }
        $objWorkSheet->setCellValue('BF'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('BF'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //LINEA AGIL IMPORTADOS
        $objWorkSheet->setCellValue('BG'.$fila, $TotalTCuo16);
        $objWorkSheet->setCellValue('BH'.$fila, $TotalTLab16);
        $P=0;
        if($TotalTCuo16 > 0){
            $P=round(($TotalTLab16/$TotalTCuo16));
        }
        $objWorkSheet->setCellValue('BI'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('BI'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //LABORATORIOS BAI
        $objWorkSheet->setCellValue('BJ'.$fila, $TotalTCuo17);
        $objWorkSheet->setCellValue('BK'.$fila, $TotalTLab17);
        $P=0;
        if($TotalTCuo17 > 0){
            $P=round(($TotalTLab17/$TotalTCuo17));
        }
        $objWorkSheet->setCellValue('BL'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('BL'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //TECNOCALIDAD
        $objWorkSheet->setCellValue('BM'.$fila, $TotalTCuo18);
        $objWorkSheet->setCellValue('BN'.$fila, $TotalTLab18);
        $P=0;
        if($TotalTCuo18 > 0){
            $P=round(($TotalTLab18/$TotalTCuo18));
        }
        $objWorkSheet->setCellValue('BO'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('BO'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //TOTAL VENTAS TELEOPERADOR INFERIOR 
        $m=0;
        $sumaTCALL=0;
        $cV=count($vendLabI);
        while($m<=$cV){
            $sumaTCALL=$sumaTCALL+$TotalLabI[$m];
            $sumaTCALL=$sumaTCALL+$TotalLabO[$m];
            $m++;
        }
        //COLACA EL TOTAL VENTA TELEOPERADOR EN EXCEL
        $objWorkSheet->setCellValue('BQ'.$fila, $sumaTCALL);
        //PORCENTAJE VENTA TOTAL TELEOPERADOR
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        
        //OTROS2
        //*********************************************************************************************************************
        $fila++;
        $area='OTROS2';
        $fila++;
        $ventaTotOT2=0;
        $ventaTotOT3=0;
        //AND Codigo in('VEND475','VEND443')
        $queryv = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[cliVendedor] WHERE SectorLab = '$area' ORDER BY Codigo ASC;", $cLink);
        $num=mssql_num_rows($queryv);
        $tamfilArea=$fila + (($num*3) + $num -2);
        $Total=0;
        $filav=0;
        $VentaCont1=0; $VentaCred1=0; $VentaMixt1=0; $NotasCrCont1=0; $NotasCrCred1=0; $NotasCrMixt1=0; $NotaDebito1=0; $NotasdCobra1=0; $Subtotal1=0; $DistriBolsa1=0;
        $filainicio=$fila;
        //combina areas
        $objWorkSheet->mergeCells("A".$fila.":A".$tamfilArea."");
        $objWorkSheet->setCellValue('A'.$fila, $area);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':A'.$tamfilArea)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        
        //arrays para guardar los datos de Otros2 por cada laboratorio de los vendedores VEND157 y VENDPEST para el total individual de abajo
        $SumaOtros2ventas = new ArrayIterator();
        $SumaOtros2Labs = new ArrayIterator(); 
        
        while($rowVend = mssql_fetch_array($queryv)){
            $vend = trim($rowVend['Codigo']);
            $nomb = trim($rowVend['Apellidos'])." ".trim($rowVend['Nombres']);
            //cod vendedores
            $filaf=$fila+2;
            $objWorkSheet->mergeCells("B".$fila.":B".$filaf."");
            $objPHPExcel->getActiveSheet()->getStyle("B".$fila.":B".$filaf."")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
            $objWorkSheet->setCellValue('B'.$fila, $vend);  
            $objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //valores
            $queryval = mssql_query("SELECT tipoCuota, cuotagen FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND codVend='$vend' AND Periodo='$periodo' AND tipoCuota != 'Cuota Laboratorio';", $cLink);
            $num2=mssql_num_rows($queryval);
            //if($num2 == 1){
                while($rowVendVal = mssql_fetch_array($queryval)){
                    $tipocuo = trim($rowVendVal['tipoCuota']);
                    $cuotag = trim($rowVendVal['cuotagen']);
                    if($tipocuo=='Cuota Individual' && $cuotag > 0){
                        $tipocuo2='Cuota Objetivo Individual';
                        $cuotag2=0;
                    }
                    if(($tipocuo=='-' || $tipocuo=='')){
                        $tipocuo='Cuota Individual';
                        $tipocuo2='Cuota Objetivo Individual';
                        $cuotag2=0;
                    } 
                    $objPHPExcel->getActiveSheet()->getStyle("C".$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                    $objWorkSheet->setCellValue('C'.$fila, $tipocuo);
                    $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                    $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
                    
                    //VALOR TOTAL VENTA OTROS 2
                        if(substr($vend,-4,4)!='PEST'){
                            //FELIPE
                            $queryTLabsOT2 = mssql_query("SELECT CONVERT(INT, f.Venta) as VentaIndX FROM [sqlFacturas].[dbo].[facInfcomercial] f WHERE Area='$area' AND codVend='$vend' AND tipoCuota='Cuota Laboratorio' and SectorLab='TODO';", $cLink);
                            if($rowVendTlabOT2 = mssql_fetch_array($queryTLabsOT2)){
                                    //$tipoCuotag = trim($rowVendTlabCF['tipoCuota']);
                                $ventaTotOT2 = trim($rowVendTlabOT2['VentaIndX']);
                                if($ventaTotOT2=='' || $ventaTotOT2=='-'){$ventaTotOT2=0;}
                            }
                            $objWorkSheet->setCellValue('BP'.$fila, 0);
                            $objWorkSheet->setCellValue('BQ'.$fila, $ventaTotOT2);
                        }else{
                            //PESTAR
                            $queryTLabsOT3 = mssql_query("SELECT CONVERT(INT, f.Venta) as VentaIndX FROM [sqlFacturas].[dbo].[facInfcomercial] f WHERE Area='$area' AND codVend='$vend' AND tipoCuota='Cuota Laboratorio' and SectorLab='TODO';", $cLink);
                            if($rowVendTlabOT3 = mssql_fetch_array($queryTLabsOT3)){
                                    //$tipoCuotag = trim($rowVendTlabCF['tipoCuota']);
                                $ventaTotOT3 = trim($rowVendTlabOT3['VentaIndX']);
                                if($ventaTotOT3=='' || $ventaTotOT3=='-'){$ventaTotOT3=0;}
                            }
                            $objWorkSheet->setCellValue('BP'.$fila, $ventaTotOT3);
                            $objWorkSheet->setCellValue('BQ'.$fila, $ventaTotOT3);
                        }
                    
                    $fila++;
                    $objPHPExcel->getActiveSheet()->getStyle("C".$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                    $objWorkSheet->setCellValue('C'.$fila, $tipocuo2);
                    $objWorkSheet->setCellValue('D'.$fila, $cuotag2);
                    $objWorkSheet->setCellValue('BP'.$fila, $cuotag2);
                    
                    
                    
                    $filav++;
                    $Totalv=$Totalv+$cuotag;
                    if($filav==1){
                        $fila++;
                        $objPHPExcel->getActiveSheet()->getStyle("C".$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                        $objWorkSheet->setCellValue('C'.$fila, utf8_encode($nomb));
                        //->getAllBorders()
                        $objPHPExcel->getActiveSheet()->getStyle("D".$fila.":BR".$filaf."")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                        $objWorkSheet->setCellValue('D'.$fila, $Totalv);
                        $objWorkSheet->setCellValue('BP'.$fila, $Totalv);
                        $Total=$Total+$Totalv;
                        
                        
                        
                        $Totalv=0;
                        $filav=0;
                        //LABORATORIOS
                        /*$queryval = mssql_query("SELECT Cuota, Venta, VentaObj, SectorLab FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND tipoCuota='Cuota Laboratorio' AND codVend='$vend' AND Periodo='$periodo';", $cLink);
                        while($rowVendValab = mssql_fetch_array($queryval)){
                            $cuotaLab = trim($rowVendValab['Cuota']);
                            $ventaInd = trim($rowVendValab['Venta']);
                            $ventaObj = trim($rowVendValab['VentaObj']);
                            $sectorLab = trim($rowVendValab['SectorLab']);
                            $filaX=$fila-2;
                            switch ($sectorLab) {
                                case 'INT':
                                    $objWorkSheet->setCellValue('W'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('X'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('X'.$filaX, $ventaObj);
                                    break;
                                case 'ICO':
                                    $objWorkSheet->setCellValue('Z'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AA'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('AA'.$filaX, $ventaObj);
                                    break;
                                case 'COMERVET':
                                    $objWorkSheet->setCellValue('AC'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AD'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('AD'.$filaX, $ventaObj);
                                    break;
                                case 'HOL':
                                    $objWorkSheet->setCellValue('AI'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AJ'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('AJ'.$filaX, $ventaObj);
                                    break;
                                case 'BIS':
                                    $objWorkSheet->setCellValue('AL'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AM'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('AM'.$filaX, $ventaObj);
                                    break;
                                case 'CPH':
                                    $objWorkSheet->setCellValue('AR'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AS'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('AS'.$filaX, $ventaObj);
                                    break;
                                case 'IMPORTADOS':
                                    $objWorkSheet->setCellValue('AU'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AV'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('AV'.$filaX, $ventaObj);
                                    break;
                                case 'INTERVET MSD':
                                    $objWorkSheet->setCellValue('AX'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AY'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('AY'.$filaX, $ventaObj);
                                    break;
                                case 'TEC':
                                    $objWorkSheet->setCellValue('BM'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('BN'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('BN'.$filaX, $ventaObj);
                                    break;
                                case 'AGI':
                                    $objWorkSheet->setCellValue('BD'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('BE'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('BE'.$filaX, $ventaObj);
                                    break;
                                case 'AMI':
                                    $objWorkSheet->setCellValue('BG'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('BH'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('BH'.$filaX, $ventaObj);
                                    break;
                                case 'BAI':
                                    $objWorkSheet->setCellValue('BJ'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('BK'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('BK'.$filaX, $ventaObj);
                                    break;
                                case 'AGROQUIMICOS / VENENOS':
                                    $objWorkSheet->setCellValue('T'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('U'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('U'.$filaX, $ventaObj);
                                    break;
                                case 'MEDICAMENTOS':
                                    $objWorkSheet->setCellValue('Q'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('R'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('R'.$filaX, $ventaObj);
                                    break;
                                case 'MASCOTAS':
                                    $objWorkSheet->setCellValue('N'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('O'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('O'.$filaX, $ventaObj);
                                    break;
                                case 'CONCENTRADOS':
                                    $objWorkSheet->setCellValue('K'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('L'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('L'.$filaX, $ventaObj);
                                    break;
                                case 'VARIOS':
                                    $objWorkSheet->setCellValue('H'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('I'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('I'.$filaX, $ventaObj);
                                    break;
                                case 'FERRETERIA':
                                    $objWorkSheet->setCellValue('E'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('F'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('F'.$filaX, $ventaObj);
                                    break;
                                
                            }
                        }*/  //FIN LABORATORIOS
                    }
                    $fila++;         
                }
                
                //VENTAS OTROS 2*******************************************************************
                //LABORATORIOS
                        
                        $queryval = mssql_query("SELECT Cuota, Venta, VentaObj, SectorLab FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND tipoCuota='Cuota Laboratorio' AND codVend='$vend' AND Periodo='$periodo' AND sectorLab!='TODO';", $cLink);
                                            
                        while($rowVendValab = mssql_fetch_array($queryval)){
                            $cuotaLab = trim($rowVendValab['Cuota']);
                            $ventaInd = trim($rowVendValab['Venta']);
                            $ventaObj = trim($rowVendValab['VentaObj']);
                            $sectorLab = trim($rowVendValab['SectorLab']);
                            
                            $filaX=$fila-3;
                            $filaXT1=$filaX;
                            $filaXT2=$filaX+1;
                            $filaXT3=$filaX+2;
                            switch ($sectorLab) {
                                case 'INT':
                                    //$objWorkSheet->setCellValue('W'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('X'.$filaX, $ventaInd);
                                    $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(X".$filaXT1.":X".$filaXT2.")");
                                    $objWorkSheet->setCellValue('X'.$filaXT3, $SumaVertical1);
                                    //Array de ventas para otros2 para sumar en total venta ind
                                    $SumaOtros2ventas[0]=(int)$SumaOtros2ventas[0]+$ventaInd;
                                    $SumaOtros2Labs[0]="INT";
                                    //$objWorkSheet->setCellValue('X'.$filaX, $ventaObj);
                                    break;
                                case 'ICO':
                                    //$objWorkSheet->setCellValue('Z'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AA'.$filaX, $ventaInd);
                                    $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(AA".$filaXT1.":AA".$filaXT2.")");
                                    $objWorkSheet->setCellValue('AA'.$filaXT3, $SumaVertical1);
                                    //Array de ventas para otros2 para sumar en total venta ind
                                    $SumaOtros2ventas[1]=(int)$SumaOtros2ventas[1]+$ventaInd;
                                    $SumaOtros2Labs[1]="ICO";
                                    //$objWorkSheet->setCellValue('AA'.$filaX, $ventaObj);
                                    break;
                                case 'COMERVET':
                                    //$objWorkSheet->setCellValue('AC'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AD'.$filaX, $ventaInd);
                                    $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(AD".$filaXT1.":AD".$filaXT2.")");
                                    $objWorkSheet->setCellValue('AD'.$filaXT3, $SumaVertical1);
                                    //Array de ventas para otros2 para sumar en total venta ind
                                    $SumaOtros2ventas[2]=(int)$SumaOtros2ventas[2]+$ventaInd;
                                    $SumaOtros2Labs[2]="COMERVET";
                                    //$objWorkSheet->setCellValue('AD'.$filaX, $ventaObj);
                                    break;
                                case 'HOL':
                                    //$objWorkSheet->setCellValue('AI'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AJ'.$filaX, $ventaInd);
                                    $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(AJ".$filaXT1.":AJ".$filaXT2.")");
                                    $objWorkSheet->setCellValue('AJ'.$filaXT3, $SumaVertical1);
                                    //Array de ventas para otros2 para sumar en total venta ind
                                    $SumaOtros2ventas[3]=(int)$SumaOtros2ventas[3]+$ventaInd;
                                    $SumaOtros2Labs[3]="HOL";
                                    //$objWorkSheet->setCellValue('AJ'.$filaX, $ventaObj);
                                    break;
                                case 'BIS':
                                    //$objWorkSheet->setCellValue('AL'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AM'.$filaX, $ventaInd);
                                    $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(AM".$filaXT1.":AM".$filaXT2.")");
                                    $objWorkSheet->setCellValue('AM'.$filaXT3, $SumaVertical1);
                                    //Array de ventas para otros2 para sumar en total venta ind
                                    $SumaOtros2ventas[4]=(int)$SumaOtros2ventas[4]+$ventaInd;
                                    $SumaOtros2Labs[4]="BIS";
                                    //$objWorkSheet->setCellValue('AM'.$filaX, $ventaObj);
                                    break;
                                case 'CPH':
                                    //$objWorkSheet->setCellValue('AR'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AS'.$filaX, $ventaInd);
                                    $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(AS".$filaXT1.":AS".$filaXT2.")");
                                    $objWorkSheet->setCellValue('AS'.$filaXT3, $SumaVertical1);
                                    //Array de ventas para otros2 para sumar en total venta ind
                                    $SumaOtros2ventas[5]=(int)$SumaOtros2ventas[5]+$ventaInd;
                                    $SumaOtros2Labs[5]="CPH";
                                    //$objWorkSheet->setCellValue('AS'.$filaX, $ventaObj);
                                    break;
                                case 'IMPORTADOS':
                                    //$objWorkSheet->setCellValue('AU'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AV'.$filaX, $ventaInd);
                                    $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(AV".$filaXT1.":AV".$filaXT2.")");
                                    $objWorkSheet->setCellValue('AV'.$filaXT3, $SumaVertical1);
                                    //Array de ventas para otros2 para sumar en total venta ind
                                    $SumaOtros2ventas[6]=(int)$SumaOtros2ventas[6]+$ventaInd;
                                    $SumaOtros2Labs[6]="IMPORTADOS";
                                    //$objWorkSheet->setCellValue('AV'.$filaX, $ventaObj);
                                    break;
                                case 'INTERVET MSD':
                                    //$objWorkSheet->setCellValue('AX'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AY'.$filaX, $ventaInd);
                                    $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(AY".$filaXT1.":AY".$filaXT2.")");
                                    $objWorkSheet->setCellValue('AY'.$filaXT3, $SumaVertical1);
                                    //Array de ventas para otros2 para sumar en total venta ind
                                    $SumaOtros2ventas[7]=(int)$SumaOtros2ventas[7]+$ventaInd;
                                    $SumaOtros2Labs[7]="INTERVET MSD";
                                    //$objWorkSheet->setCellValue('AY'.$filaX, $ventaObj);
                                    break;
                                case 'TEC':
                                    //$objWorkSheet->setCellValue('BM'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('BN'.$filaX, $ventaInd);
                                    $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BN".$filaXT1.":BN".$filaXT2.")");
                                    $objWorkSheet->setCellValue('BN'.$filaXT3, $SumaVertical1);
                                    //Array de ventas para otros2 para sumar en total venta ind
                                    $SumaOtros2ventas[8]=(int)$SumaOtros2ventas[8]+$ventaInd;
                                    $SumaOtros2Labs[8]="TEC";
                                    //$objWorkSheet->setCellValue('BN'.$filaX, $ventaObj);
                                    break;
                                case 'AGI':
                                    //$objWorkSheet->setCellValue('BD'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('BE'.$filaX, $ventaInd);
                                    $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BE".$filaXT1.":BE".$filaXT2.")");
                                    $objWorkSheet->setCellValue('BE'.$filaXT3, $SumaVertical1);
                                    //Array de ventas para otros2 para sumar en total venta ind
                                    $SumaOtros2ventas[9]=(int)$SumaOtros2ventas[9]+$ventaInd;
                                    $SumaOtros2Labs[9]="AGI";
                                    //$objWorkSheet->setCellValue('BE'.$filaX, $ventaObj);
                                    break;
                                case 'AMI':
                                    //$objWorkSheet->setCellValue('BG'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('BH'.$filaX, $ventaInd);
                                    $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BH".$filaXT1.":BH".$filaXT2.")");
                                    $objWorkSheet->setCellValue('BH'.$filaXT3, $SumaVertical1);
                                    //Array de ventas para otros2 para sumar en total venta ind
                                    $SumaOtros2ventas[10]=(int)$SumaOtros2ventas[10]+$ventaInd;
                                    $SumaOtros2Labs[10]="AMI";
                                    //$objWorkSheet->setCellValue('BH'.$filaX, $ventaObj);
                                    break;
                                case 'BAI':
                                    //$objWorkSheet->setCellValue('BJ'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('BK'.$filaX, $ventaInd);
                                    $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(BK".$filaXT1.":BK".$filaXT2.")");
                                    $objWorkSheet->setCellValue('BK'.$filaXT3, $SumaVertical1);
                                    //Array de ventas para otros2 para sumar en total venta ind
                                    $SumaOtros2ventas[11]=(int)$SumaOtros2ventas[11]+$ventaInd;
                                    $SumaOtros2Labs[11]="BAI";
                                    //$objWorkSheet->setCellValue('BK'.$filaX, $ventaObj);
                                    break;
                                case 'AGROQUIMICOS / VENENOS':
                                    //$objWorkSheet->setCellValue('T'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('U'.$filaX, $ventaInd);
                                    $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(U".$filaXT1.":U".$filaXT2.")");
                                    $objWorkSheet->setCellValue('U'.$filaXT3, $SumaVertical1);
                                    //Array de ventas para otros2 para sumar en total venta ind
                                    $SumaOtros2ventas[12]=(int)$SumaOtros2ventas[12]+$ventaInd;
                                    $SumaOtros2Labs[12]="AGROQUIMICOS / VENENOS";
                                    //$objWorkSheet->setCellValue('U'.$filaX, $ventaObj);
                                    break;
                                case 'MEDICAMENTOS':
                                    //$objWorkSheet->setCellValue('Q'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('R'.$filaX, $ventaInd);
                                    $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(R".$filaXT1.":R".$filaXT2.")");
                                    $objWorkSheet->setCellValue('R'.$filaXT3, $SumaVertical1);
                                    //Array de ventas para otros2 para sumar en total venta ind
                                    $SumaOtros2ventas[13]=(int)$SumaOtros2ventas[13]+$ventaInd;
                                    $SumaOtros2Labs[13]="MEDICAMENTOS";
                                    //$objWorkSheet->setCellValue('R'.$filaX, $ventaObj);
                                    //echo "<hr><br>ganaderia:".$ventaInd;
                                    break;
                                case 'MASCOTAS':
                                    //$objWorkSheet->setCellValue('N'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('O'.$filaX, $ventaInd);
                                    $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(O".$filaXT1.":O".$filaXT2.")");
                                    $objWorkSheet->setCellValue('O'.$filaXT3, $SumaVertical1);
                                    //Array de ventas para otros2 para sumar en total venta ind
                                    $SumaOtros2ventas[14]=(int)$SumaOtros2ventas[14]+$ventaInd;
                                    $SumaOtros2Labs[14]="MASCOTAS";
                                    //$objWorkSheet->setCellValue('O'.$filaX, $ventaObj);
                                    break;
                                case 'CONCENTRADOS':
                                    //$objWorkSheet->setCellValue('K'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('L'.$filaX, $ventaInd);
                                    $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(L".$filaXT1.":L".$filaXT2.")");
                                    $objWorkSheet->setCellValue('L'.$filaXT3, $SumaVertical1);
                                    //Array de ventas para otros2 para sumar en total venta ind
                                    $SumaOtros2ventas[15]=(int)$SumaOtros2ventas[15]+$ventaInd;
                                    $SumaOtros2Labs[15]="CONCENTRADOS";
                                    //$objWorkSheet->setCellValue('L'.$filaX, $ventaObj);
                                    break;
                                case 'VARIOS':
                                    //$objWorkSheet->setCellValue('H'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('I'.$filaX, $ventaInd);
                                    $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(I".$filaXT1.":I".$filaXT2.")");
                                    $objWorkSheet->setCellValue('I'.$filaXT3, $SumaVertical1);
                                    //Array de ventas para otros2 para sumar en total venta ind
                                    $SumaOtros2ventas[16]=(int)$SumaOtros2ventas[16]+$ventaInd;
                                    $SumaOtros2Labs[16]="VARIOS";
                                    //$objWorkSheet->setCellValue('I'.$filaX, $ventaObj);
                                    break;
                                case 'FERRETERIA':
                                    //$objWorkSheet->setCellValue('E'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('F'.$filaX, $ventaInd);
                                    $SumaVertical1 = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=SUM(F".$filaXT1.":F".$filaXT2.")");
                                    $objWorkSheet->setCellValue('F'.$filaXT3, $SumaVertical1);
                                    //Array de ventas para otros2 para sumar en total venta ind
                                    $SumaOtros2ventas[17]=(int)$SumaOtros2ventas[17]+$ventaInd;
                                    $SumaOtros2Labs[17]="FERRETERIA";
                                    
                                    //$objWorkSheet->setCellValue('F'.$filaX, $ventaObj);
                                    break;
                                
                            }
                        }  //FIN LABORATORIOS
                
                //FIN VENTAS*******************************************************************
            //} /*else if($num2 == 2){
                /*while($rowVendVal = mssql_fetch_array($queryval)){
                    $tipocuo = trim($rowVendVal['tipoCuota']);
                    $cuotag = trim($rowVendVal['cuotagen']);
                    $objPHPExcel->getActiveSheet()->getStyle("C".$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                    $objWorkSheet->setCellValue('C'.$fila, $tipocuo);
                    $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                    $objWorkSheet->setCellValue('BP'.$fila, $cuotag);
                    
                    //TOTAL VENTA OTROS 2
                        
                        //VALOR TOTAL VENTA OTROS 2
                        if(substr($vend,-4,4)!='PEST'){
                            //FELIPE
                            $queryTLabsOT2 = mssql_query("SELECT CONVERT(INT, f.Venta) as VentaIndX FROM [sqlFacturas].[dbo].[facInfcomercial] f WHERE Area='$area' AND codVend='$vend' AND tipoCuota='Cuota Laboratorio' and SectorLab='TODO';", $cLink);
                            if($rowVendTlabOT2 = mssql_fetch_array($queryTLabsOT2)){
                                    //$tipoCuotag = trim($rowVendTlabCF['tipoCuota']);
                                $ventaTotOT2 = trim($rowVendTlabOT2['VentaIndX']);
                                if($ventaTotOT2=='' || $ventaTotOT2=='-'){$ventaTotOT2=0;}
                            }
                            $objWorkSheet->setCellValue('BP'.$fila, 0);
                            $objWorkSheet->setCellValue('BQ'.$fila, $ventaTotOT2);
                        }else{
                            //PESTAR
                            $queryTLabsOT3 = mssql_query("SELECT CONVERT(INT, f.Venta) as VentaIndX FROM [sqlFacturas].[dbo].[facInfcomercial] f WHERE Area='$area' AND codVend='$vend' AND tipoCuota='Cuota Laboratorio' and SectorLab='TODO';", $cLink);
                            if($rowVendTlabOT3 = mssql_fetch_array($queryTLabsOT3)){
                                    //$tipoCuotag = trim($rowVendTlabCF['tipoCuota']);
                                $ventaTotOT3 = trim($rowVendTlabOT3['VentaIndX']);
                                if($ventaTotOT3=='' || $ventaTotOT3=='-'){$ventaTotOT3=0;}
                            }
                            $objWorkSheet->setCellValue('BP'.$fila, $ventaTotOT3);
                            $objWorkSheet->setCellValue('BQ'.$fila, $ventaTotOT3);
                        }
                    
                    $filav++;
                    $Totalv=$Totalv+$cuotag;
                    if($filav==2){
                        $fila++;
                        $objPHPExcel->getActiveSheet()->getStyle("C".$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                        $objWorkSheet->setCellValue('C'.$fila, utf8_encode($nomb));
                        //->getAllBorders()
                        $objPHPExcel->getActiveSheet()->getStyle("D".$fila.":BR".$filaf."")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                        $objWorkSheet->setCellValue('D'.$fila, $Totalv);
                        $objWorkSheet->setCellValue('BP'.$fila, $Totalv);
                        $Total=$Total+$Totalv;
                        
                        
                        
                        $Totalv=0;
                        $filav=0;
                        //LABORATORIOS
                        $queryval = mssql_query("SELECT Cuota, Venta, VentaObj, SectorLab FROM [sqlFacturas].[dbo].[facInfcomercial] WHERE Area = '$area' AND tipoCuota='Cuota Laboratorio' AND codVend='$vend' AND Periodo='$periodo';", $cLink);
                        while($rowVendValab = mssql_fetch_array($queryval)){
                            $cuotaLab = trim($rowVendValab['Cuota']);
                            $ventaInd = trim($rowVendValab['Venta']);
                            $ventaObj = trim($rowVendValab['VentaObj']);
                            $sectorLab = trim($rowVendValab['SectorLab']);
                            $filaX=$fila-2;
                            switch ($sectorLab) {
                                case 'INT':
                                    $objWorkSheet->setCellValue('W'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('X'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('X'.$filaX, $ventaObj);
                                    break;
                                case 'ICO':
                                    $objWorkSheet->setCellValue('Z'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AA'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('AA'.$filaX, $ventaObj);
                                    break;
                                case 'COMERVET':
                                    $objWorkSheet->setCellValue('AC'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AD'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('AD'.$filaX, $ventaObj);
                                    break;
                                case 'HOL':
                                    $objWorkSheet->setCellValue('AI'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AJ'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('AJ'.$filaX, $ventaObj);
                                    break;
                                case 'BIS':
                                    $objWorkSheet->setCellValue('AL'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AM'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('AM'.$filaX, $ventaObj);
                                    break;
                                case 'CPH':
                                    $objWorkSheet->setCellValue('AR'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AS'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('AS'.$filaX, $ventaObj);
                                    break;
                                case 'IMPORTADOS':
                                    $objWorkSheet->setCellValue('AU'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AV'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('AV'.$filaX, $ventaObj);
                                    break;
                                case 'INTERVET MSD':
                                    $objWorkSheet->setCellValue('AX'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AY'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('AY'.$filaX, $ventaObj);
                                    break;
                                case 'TEC':
                                    $objWorkSheet->setCellValue('BM'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('BN'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('BN'.$filaX, $ventaObj);
                                    break;
                                case 'AGI':
                                    $objWorkSheet->setCellValue('BD'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('BE'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('BE'.$filaX, $ventaObj);
                                    break;
                                case 'AMI':
                                    $objWorkSheet->setCellValue('BG'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('BH'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('BH'.$filaX, $ventaObj);
                                    break;
                                case 'BAI':
                                    $objWorkSheet->setCellValue('BJ'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('BK'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('BK'.$filaX, $ventaObj);
                                    break;
                                case 'AGROQUIMICOS / VENENOS':
                                    $objWorkSheet->setCellValue('T'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('U'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('U'.$filaX, $ventaObj);
                                    break;
                                case 'MEDICAMENTOS':
                                    $objWorkSheet->setCellValue('Q'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('R'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('R'.$filaX, $ventaObj);
                                    break;
                                case 'MASCOTAS':
                                    $objWorkSheet->setCellValue('N'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('O'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('O'.$filaX, $ventaObj);
                                    break;
                                case 'CONCENTRADOS':
                                    $objWorkSheet->setCellValue('K'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('L'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('L'.$filaX, $ventaObj);
                                    break;
                                case 'VARIOS':
                                    $objWorkSheet->setCellValue('H'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('I'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('I'.$filaX, $ventaObj);
                                    break;
                                case 'FERRETERIA':
                                    $objWorkSheet->setCellValue('E'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('F'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('F'.$filaX, $ventaObj);
                                    break;
                                
                            }
                        }   //FIN LABORATORIOS
                    }
                    $fila++;         
                }*/
            /*} else {
                $cuotag = 0;
                $objWorkSheet->setCellValue('C'.$fila, "Cuota Individual");
                $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                $fila++;
                $objWorkSheet->setCellValue('C'.$fila, "Cuota Objetivo Individual");
                $objWorkSheet->setCellValue('D'.$fila, $cuotag);
                $fila++;
                $objWorkSheet->setCellValue('C'.$fila, utf8_encode($nomb));
                $fila++;
            }*/
            $fila++;          
        }
        $fila--;
        //total
        //combinar celdas
        $objWorkSheet->mergeCells("A".$fila.":C".$fila."");
        $objWorkSheet->setCellValue('A'.$fila, 'TOTAL '.$area);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //valor
        $objWorkSheet->setCellValue('D'.$fila, $Total);
        
        //porcentaje total por vendedor jairo
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        
        
        //TOTALES GENERALES*****************************************TOTALES GENERALES****************************************************************************
               
        $fila+=2;
        
        //echo "<hr><hr>".$fila;
        
        //1er TOTAL TELEOPERADOR INDIVIDUAL
        $objWorkSheet->mergeCells("A".$fila.":C".$fila."");
        $objWorkSheet->setCellValue('A'.$fila, 'TOTAL CONTACT CENTER VENTA INDIVIDUAL');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //color de fondo
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7');
      
        $queryTLabs = mssql_query("SELECT tipoCuota, SUM(Cuotagen) AS TotalCG FROM [sqlFacturas].[dbo].[facInfcomercial] where tipoCuota IN('Cuota Individual') and Area='TELEOPERADOR' and SectorLab NOT IN('TODO') GROUP BY tipoCuota;", $cLink);
            //echo "</br>SELECT DISTINCT SectorLab, codVend, Venta, VentaObj FROM [sqlFacturas].[dbo].[facInfcomercial] where codVend='".$vend."' and tipoCuota='Cuota Laboratorio' and Area='TELEOPERADOR' and SectorLab NOT IN('TODO');";
            if($rowVendTlabC = mssql_fetch_array($queryTLabs)){
                $tipoCuotag = trim($rowVendTlabC['tipoCuota']);
                $cuotaGenObj = trim($rowVendTlabC['TotalCG']);
                if($cuotaGenObj=='' || $cuotaGenObj=='-'){$cuotaGenObj=0;}   
            }
        
        //TOTAL CUOTA IZQ Y DERECHA
        //suma la cuota de otros2 pestar
        //$cuotaGenObj=$cuotaGenObj;  //+$ventaTotOT3,$ventaTotOT3
        
        //echo "<br>".$ventaTotOT3."----".$ventaTotOT2;
        
        $objWorkSheet->setCellValue('D'.$fila, $cuotaGenObj);
        
        //VARIABLE TOTAL FINAL
        $TotCuotaFinal=$TotCuotaFinal+$cuotaGenObj;
        
        
        //le suma la cuota del VENDPEST, que desde arriba es la misma de la venta
        $cuotaGenObj=$cuotaGenObj+$ventaTotOT3;    
            
        $objWorkSheet->setCellValue('BP'.$fila, $cuotaGenObj);
        
        //TOTAL VENTA INDIVIDUAL LABORATORIOS
        
        //suma al total venta final el vend157 y vendpest
        //$TotalOtros2=$ventaTotOT2+$ventaTotOT3;
        $tO2=count($SumaOtros2Labs);
        $TotalVentaIndv=0;
        //FERRETERIA
        $objWorkSheet->setCellValue('E'.$fila, $TotalTCuo1I);
        $objWorkSheet->setCellValue('F'.$fila, $TotalTLab1I);
        $TotalVentaIndv=$TotalVentaIndv+$TotalTLab1I;
        //$Laboratoriostot[0]="Ferreteria"; //$area
        
        //busca el valor individual de otros 2 y le suma el VEND157 VENDPEST
        $i2=0;  
        while($i2<=$tO2){
            if($SumaOtros2Labs[$i2]=='FERRETERIA'){
               $TotalTLab1I=$TotalTLab1I+$SumaOtros2ventas[$i2];
                $i2=$tO2;
            }
            $i2++;
        }
        
        $TotCuotaFinaLab[0]=$TotCuotaFinaLab[0]+$TotalTCuo1I;
        $TotVentaFinaLab[0]=$TotVentaFinaLab[0]+$TotalTLab1I;
        
        
        $P=0;
        if($TotalTCuo1I > 0){
            // $P=round(($TotalTLab1I/$TotalTCuo1I));
            $P=round(($TotalTLab1I/$TotalTCuo1I));
        }
        // $objWorkSheet->setCellValue('G'.$fila, $P);
        $objWorkSheet->setCellValue('G'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //VARIOS
        //busca el valor individual de otros 2 de VEND157 VENDPEST y se los suma a venta total individual
        $i2=0;  
        while($i2<=$tO2){
            if($SumaOtros2Labs[$i2]=='VARIOS'){
               $TotalTLab2I=$TotalTLab2I+$SumaOtros2ventas[$i2];
               $i2=$tO2;
            }
            $i2++;
        }
        $objWorkSheet->setCellValue('H'.$fila, $TotalTCuo2I);
        $objWorkSheet->setCellValue('I'.$fila, $TotalTLab2I);
        $TotalVentaIndv=$TotalVentaIndv+$TotalTLab2I;
        //$Laboratoriostot[1]="Varios"; //$area
        $TotCuotaFinaLab[1]=$TotCuotaFinaLab[1]+$TotalTCuo2I;
        $TotVentaFinaLab[1]=$TotVentaFinaLab[1]+$TotalTLab2I;
        
        $P=0;
        if($TotalTCuo2I > 0){
            // $P=round(($TotalTLab2I/$TotalTCuo2I));
            $P=round(($TotalTLab2I/$TotalTCuo2I));
        }
        $objWorkSheet->setCellValue('J'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //CONCENTRADOS
        //busca el valor individual de otros 2 de VEND157 VENDPEST y se los suma a venta total individual
        $i2=0;  
        while($i2<=$tO2){
            if($SumaOtros2Labs[$i2]=='CONCENTRADOS'){
               $TotalTLab3I=$TotalTLab3I+$SumaOtros2ventas[$i2];
               $i2=$tO2;
            }
            $i2++;
        }
        $objWorkSheet->setCellValue('K'.$fila, $TotalTCuo3I);
        $objWorkSheet->setCellValue('L'.$fila, $TotalTLab3I);
        $TotalVentaIndv=$TotalVentaIndv+$TotalTLab3I;
        //$Laboratoriostot[2]="Concentrados"; //$area
        $TotCuotaFinaLab[2]=$TotCuotaFinaLab[2]+$TotalTCuo3I;
        $TotVentaFinaLab[2]=$TotVentaFinaLab[2]+$TotalTLab3I;
        $P=0;
        if($TotalTCuo3I > 0){
            $P=round(($TotalTLab3I/$TotalTCuo3I));
        }
        $objWorkSheet->setCellValue('M'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('M'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //PETS
        //busca el valor individual de otros 2 de VEND157 VENDPEST y se los suma a venta total individual
        $i2=0;  
        while($i2<=$tO2){
            if($SumaOtros2Labs[$i2]=='MASCOTAS'){
               $TotalTLab4I=$TotalTLab4I+$SumaOtros2ventas[$i2];
               $i2=$tO2;
            }
            $i2++;
        }
        $objWorkSheet->setCellValue('N'.$fila, $TotalTCuo4I);
        $objWorkSheet->setCellValue('O'.$fila, $TotalTLab4I);
        $TotalVentaIndv=$TotalVentaIndv+$TotalTLab4I;
        //$Laboratoriostot[3]="Pets"; //$area
        $TotCuotaFinaLab[3]=$TotCuotaFinaLab[3]+$TotalTCuo4I;
        $TotVentaFinaLab[3]=$TotVentaFinaLab[3]+$TotalTLab4I;
        $P=0;
        if($TotalTCuo4I > 0){
            $P=round(($TotalTLab4I/$TotalTCuo4I));
        }
        $objWorkSheet->setCellValue('P'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('P'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //GANADERIA
        //busca el valor individual de otros 2 de VEND157 VENDPEST y se los suma a venta total individual
        $i2=0;  
        while($i2<=$tO2){
            if($SumaOtros2Labs[$i2]=='MEDICAMENTOS'){
               $TotalTLab5I=$TotalTLab5I+$SumaOtros2ventas[$i2];
               $i2=$tO2;
            }
            $i2++;
        }
        $objWorkSheet->setCellValue('Q'.$fila, $TotalTCuo5I);
        $objWorkSheet->setCellValue('R'.$fila, $TotalTLab5I);
        $TotalVentaIndv=$TotalVentaIndv+$TotalTLab5I;
        //$Laboratoriostot[4]="Ganaderia"; //$area
        $TotCuotaFinaLab[4]=$TotCuotaFinaLab[4]+$TotalTCuo5I;
        $TotVentaFinaLab[4]=$TotVentaFinaLab[4]+$TotalTLab5I;
        $P=0;
        if($TotalTCuo5I > 0){
            $P=round(($TotalTLab5I/$TotalTCuo5I));
        }
        $objWorkSheet->setCellValue('S'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('S'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //INSECTICIDAS Y OTROS
        //busca el valor individual de otros 2 de VEND157 VENDPEST y se los suma a venta total individual
        $i2=0;  
        while($i2<=$tO2){
            if($SumaOtros2Labs[$i2]=='AGROQUIMICOS / VENENOS'){
               $TotalTLab6I=$TotalTLab6I+$SumaOtros2ventas[$i2];
               $i2=$tO2;
            }
            $i2++;
        }
        $objWorkSheet->setCellValue('T'.$fila, $TotalTCuo6I);
        $objWorkSheet->setCellValue('U'.$fila, $TotalTLab6I);
        $TotalVentaIndv=$TotalVentaIndv+$TotalTLab6I;
        //$Laboratoriostot[5]="Insecticidas"; //$area
        $TotCuotaFinaLab[5]=$TotCuotaFinaLab[5]+$TotalTCuo6I;
        $TotVentaFinaLab[5]=$TotVentaFinaLab[5]+$TotalTLab6I;
        $P=0;
        if($TotalTCuo6I > 0){
            $P=round(($TotalTLab6I/$TotalTCuo6I));
        }
        $objWorkSheet->setCellValue('V'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('V'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //INVET
        //busca el valor individual de otros 2 de VEND157 VENDPEST y se los suma a venta total individual
        $i2=0;  
        while($i2<=$tO2){
            if($SumaOtros2Labs[$i2]=='INT'){
               $TotalTLab7I=$TotalTLab7I+$SumaOtros2ventas[$i2];
               $i2=$tO2;
            }
            $i2++;
        }
        $objWorkSheet->setCellValue('W'.$fila, $TotalTCuo7I);
        $objWorkSheet->setCellValue('X'.$fila, $TotalTLab7I);
        $TotalVentaIndv=$TotalVentaIndv+$TotalTLab7I;
        //$Laboratoriostot[6]="Invet"; //$area
        $TotCuotaFinaLab[6]=$TotCuotaFinaLab[6]+$TotalTCuo7I;
        $TotVentaFinaLab[6]=$TotVentaFinaLab[6]+$TotalTLab7I;
        $P=0;
        if($TotalTCuo7I > 0){
            $P=round(($TotalTLab7I/$TotalTCuo7I));
        }
        $objWorkSheet->setCellValue('Y'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('Y'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //ICOFARMA
        //busca el valor individual de otros 2 de VEND157 VENDPEST y se los suma a venta total individual
        $i2=0;  
        while($i2<=$tO2){
            if($SumaOtros2Labs[$i2]=='ICO'){
               $TotalTLab8I=$TotalTLab8I+$SumaOtros2ventas[$i2];
               $i2=$tO2;
            }
            $i2++;
        }
        $objWorkSheet->setCellValue('Z'.$fila, $TotalTCuo8I);
        $objWorkSheet->setCellValue('AA'.$fila, $TotalTLab8I);
        $TotalVentaIndv=$TotalVentaIndv+$TotalTLab8I;
        //$Laboratoriostot[7]="Icofarma"; //$area
        $TotCuotaFinaLab[7]=$TotCuotaFinaLab[7]+$TotalTCuo8I;
        $TotVentaFinaLab[7]=$TotVentaFinaLab[7]+$TotalTLab8I;
        $P=0;
        if($TotalTCuo8I > 0){
            $P=round(($TotalTLab8I/$TotalTCuo8I));
        }
        $objWorkSheet->setCellValue('AB'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('AB'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //COMERVET
        //busca el valor individual de otros 2 de VEND157 VENDPEST y se los suma a venta total individual
        $i2=0;  
        while($i2<=$tO2){
            if($SumaOtros2Labs[$i2]=='COMERVET'){
               $TotalTLab9I=$TotalTLab9I+$SumaOtros2ventas[$i2];
               $i2=$tO2;
            }
            $i2++;
        }
        $objWorkSheet->setCellValue('AC'.$fila, $TotalTCuo9I);
        $objWorkSheet->setCellValue('AD'.$fila, $TotalTLab9I);
        $TotalVentaIndv=$TotalVentaIndv+$TotalTLab9I;
        
        $TotCuotaFinaLab[8]=$TotCuotaFinaLab[8]+$TotalTCuo9I;
        $TotVentaFinaLab[8]=$TotVentaFinaLab[8]+$TotalTLab9I;
        $P=0;
        if($TotalTCuo9I > 0){
            $P=round(($TotalTLab9I/$TotalTCuo9I));
        }
        $objWorkSheet->setCellValue('AE'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('AE'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //GABRICA
        //busca el valor individual de otros 2 de VEND157 VENDPEST y se los suma a venta total individual
        $i2=0;  
        while($i2<=$tO2){
            if($SumaOtros2Labs[$i2]=='HOL'){
               $TotalTLab10I=$TotalTLab10I+$SumaOtros2ventas[$i2];
               $i2=$tO2;
            }
            $i2++;
        }
        $objWorkSheet->setCellValue('AI'.$fila, $TotalTCuo10I);
        $objWorkSheet->setCellValue('AJ'.$fila, $TotalTLab10I);
        $TotalVentaIndv=$TotalVentaIndv+$TotalTLab10I;
        //$Laboratoriostot[9]="Gabrica"; //$area
        $TotCuotaFinaLab[9]=$TotCuotaFinaLab[9]+$TotalTCuo10I;
        $TotVentaFinaLab[9]=$TotVentaFinaLab[9]+$TotalTLab10I;
        $P=0;
        if($TotalTCuo10I > 0){
            $P=round(($TotalTLab10I/$TotalTCuo10I));
        }
        $objWorkSheet->setCellValue('AK'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('AK'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //BIOSTAR
        //busca el valor individual de otros 2 de VEND157 VENDPEST y se los suma a venta total individual
        $i2=0;  
        while($i2<=$tO2){
            if($SumaOtros2Labs[$i2]=='BIS'){
               $TotalTLab11I=$TotalTLab11I+$SumaOtros2ventas[$i2];
               $i2=$tO2;
            }
            $i2++;
        }
        $objWorkSheet->setCellValue('AL'.$fila, $TotalTCuo11I);
        $objWorkSheet->setCellValue('AM'.$fila, $TotalTLab11I);
        $TotalVentaIndv=$TotalVentaIndv+$TotalTLab11I;
        //$Laboratoriostot[10]="Biostar"; //$area
        $TotCuotaFinaLab[10]=$TotCuotaFinaLab[10]+$TotalTCuo11I;
        $TotVentaFinaLab[10]=$TotVentaFinaLab[10]+$TotalTLab11I;
        $P=0;
        if($TotalTCuo11I > 0){
            $P=round(($TotalTLab11I/$TotalTCuo11I));
        }
        $objWorkSheet->setCellValue('AN'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('AN'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //COHASFARMA
        //busca el valor individual de otros 2 de VEND157 VENDPEST y se los suma a venta total individual
        $i2=0;  
        while($i2<=$tO2){
            if($SumaOtros2Labs[$i2]=='CPH'){
               $TotalTLab12I=$TotalTLab12I+$SumaOtros2ventas[$i2];
               $i2=$tO2;
            }
            $i2++;
        }
        $objWorkSheet->setCellValue('AR'.$fila, $TotalTCuo12I);
        $objWorkSheet->setCellValue('AS'.$fila, $TotalTLab12I);
        $TotalVentaIndv=$TotalVentaIndv+$TotalTLab12I;
        
        $TotCuotaFinaLab[11]=$TotCuotaFinaLab[11]+$TotalTCuo12I;
        $TotVentaFinaLab[11]=$TotVentaFinaLab[11]+$TotalTLab12I;
        $P=0;
        if($TotalTCuo12I > 0){
            $P=round(($TotalTLab12I/$TotalTCuo12I));
        }
        $objWorkSheet->setCellValue('AT'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('AT'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //IMPORTADOS
        //busca el valor individual de otros 2 de VEND157 VENDPEST y se los suma a venta total individual
        $i2=0;  
        while($i2<=$tO2){
            if($SumaOtros2Labs[$i2]=='IMPORTADOS'){
               $TotalTLab13I=$TotalTLab13I+$SumaOtros2ventas[$i2];
               //echo "<br><br>".$vend."--".$TotalTLab13I."--sumo:".$SumaOtros2ventas[$i2];
               $i2=$tO2;
            }
            $i2++;
        }
        $objWorkSheet->setCellValue('AU'.$fila, $TotalTCuo13I);
        $objWorkSheet->setCellValue('AV'.$fila, $TotalTLab13I);
        $TotalVentaIndv=$TotalVentaIndv+$TotalTLab13I;
        
              
        $TotCuotaFinaLab[12]=$TotCuotaFinaLab[12]+$TotalTCuo13I;
        $TotVentaFinaLab[12]=$TotVentaFinaLab[12]+$TotalTLab13I;
        $P=0;
        if($TotalTCuo13I > 0){
            $P=round(($TotalTLab13I/$TotalTCuo13I));
        }
        $objWorkSheet->setCellValue('AW'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('AW'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //INTERVET
        //busca el valor individual de otros 2 de VEND157 VENDPEST y se los suma a venta total individual
        $i2=0;  
        while($i2<=$tO2){
            if($SumaOtros2Labs[$i2]=='INTERVET MSD'){
               $TotalTLab14I=$TotalTLab14I+$SumaOtros2ventas[$i2];
               $i2=$tO2;
            }
            $i2++;
        }
        $objWorkSheet->setCellValue('AX'.$fila, $TotalTCuo14I);
        $objWorkSheet->setCellValue('AY'.$fila, $TotalTLab14I);
        $TotalVentaIndv=$TotalVentaIndv+$TotalTLab14I;
        //$Laboratoriostot[13]="Intervet"; //$area
        $TotCuotaFinaLab[13]=$TotCuotaFinaLab[13]+$TotalTCuo14I;
        $TotVentaFinaLab[13]=$TotVentaFinaLab[13]+$TotalTLab14I;
        $P=0;
        if($TotalTCuo14I > 0){
            $P=round(($TotalTLab14I/$TotalTCuo14I));
        }
        $objWorkSheet->setCellValue('AZ'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('AZ'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //LINEA AGIL
        //busca el valor individual de otros 2 de VEND157 VENDPEST y se los suma a venta total individual
        $i2=0;  
        while($i2<=$tO2){
            if($SumaOtros2Labs[$i2]=='AGI'){
               $TotalTLab15I=$TotalTLab15I+$SumaOtros2ventas[$i2];
               $i2=$tO2;
            }
            $i2++;
        }
        $objWorkSheet->setCellValue('BD'.$fila, $TotalTCuo15I);
        $objWorkSheet->setCellValue('BE'.$fila, $TotalTLab15I);
        $TotalVentaIndv=$TotalVentaIndv+$TotalTLab15I;
        //$Laboratoriostot[14]="LineaAgil"; //$area
        $TotCuotaFinaLab[14]=$TotCuotaFinaLab[14]+$TotalTCuo15I;
        $TotVentaFinaLab[14]=$TotVentaFinaLab[14]+$TotalTLab15I;
        $P=0;
        if($TotalTCuo15I > 0){
            $P=round(($TotalTLab15I/$TotalTCuo15I));
        }
        $objWorkSheet->setCellValue('BF'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('BF'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //LINEA AGIL IMPORTADOS
        //busca el valor individual de otros 2 de VEND157 VENDPEST y se los suma a venta total individual
        $i2=0;  
        while($i2<=$tO2){
            if($SumaOtros2Labs[$i2]=='AMI'){
               $TotalTLab16I=$TotalTLab16I+$SumaOtros2ventas[$i2];
               $i2=$tO2;
            }
            $i2++;
        }
        $objWorkSheet->setCellValue('BG'.$fila, $TotalTCuo16I);
        $objWorkSheet->setCellValue('BH'.$fila, $TotalTLab16I);
        $TotalVentaIndv=$TotalVentaIndv+$TotalTLab16I;
        //$Laboratoriostot[15]="LineaAgilImportados"; //$area
        $TotCuotaFinaLab[15]=$TotCuotaFinaLab[15]+$TotalTCuo16I;
        $TotVentaFinaLab[15]=$TotVentaFinaLab[15]+$TotalTLab16I;
        $P=0;
        if($TotalTCuo16I > 0){
            $P=round(($TotalTLab16I/$TotalTCuo16I));
        }
        $objWorkSheet->setCellValue('BI'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('BI'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //LABORATORIOS BAI
        //busca el valor individual de otros 2 de VEND157 VENDPEST y se los suma a venta total individual
        $i2=0;  
        while($i2<=$tO2){
            if($SumaOtros2Labs[$i2]=='BAI'){
               $TotalTLab17I=$TotalTLab17I+$SumaOtros2ventas[$i2];
               $i2=$tO2;
            }
            $i2++;
        }
        $objWorkSheet->setCellValue('BJ'.$fila, $TotalTCuo17I);
        $objWorkSheet->setCellValue('BK'.$fila, $TotalTLab17I);
        $TotalVentaIndv=$TotalVentaIndv+$TotalTLab17I;
        //$Laboratoriostot[16]="LaboratoriosBai"; //$area
        $TotCuotaFinaLab[16]=$TotCuotaFinaLab[16]+$TotalTCuo17I;
        $TotVentaFinaLab[16]=$TotVentaFinaLab[16]+$TotalTLab17I;
        $P=0;
        if($TotalTCuo17I > 0){
            $P=round(($TotalTLab17I/$TotalTCuo17I));
        }
        $objWorkSheet->setCellValue('BL'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('BL'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //TECNOCALIDAD
        //busca el valor individual de otros 2 de VEND157 VENDPEST y se los suma a venta total individual
        $i2=0;  
        while($i2<=$tO2){
            if($SumaOtros2Labs[$i2]=='TEC'){
               $TotalTLab18I=$TotalTLab18I+$SumaOtros2ventas[$i2];
               $i2=$tO2;
            }
            $i2++;
        }
        $objWorkSheet->setCellValue('BM'.$fila, $TotalTCuo18I);
        $objWorkSheet->setCellValue('BN'.$fila, $TotalTLab18I);
        $TotalVentaIndv=$TotalVentaIndv+$TotalTLab18I;
        //$Laboratoriostot[17]="Tecnocalidad"; //$area
        $TotCuotaFinaLab[17]=$TotCuotaFinaLab[17]+$TotalTCuo18I;
        $TotVentaFinaLab[17]=$TotVentaFinaLab[17]+$TotalTLab18I;
        $P=0;
        if($TotalTCuo18I > 0){
            $P=round(($TotalTLab18I/$TotalTCuo18I));
        }
        $objWorkSheet->setCellValue('BO'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('BO'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //TOTAL VENTA INDIVIDUAL INF PRINCIPAL FINAL DERECHA
        
        //echo "<br>".$TotalVentaIndv."---".$ventaTotOT3."----".$ventaTotOT2;
            
        //suma las ventas de VENDPEST y VEND157 para OTROS2 vendedores VEND157 Y VENDPEST
        //$TotalVentaIndv=$TotalVentaIndv+$ventaTotOT2;
        //$TotalVentaIndv=$TotalVentaIndv+$ventaTotOT3;
        
        //echo "<br>".$TotalVentaIndv."---".$ventaTotOT3."----".$ventaTotOT2;
        
        //CUOTA Y VENTA FINAL venta individual call carlos2
        $Laboratoriostot[18]="TOTALCV"; //$area 
        //$TotCuotaFinaLab[18]=$TotCuotaFinaLab[18]+$TotalT;
        $TotVentaFinaLab[18]=$TotVentaFinaLab[18]+$TotalVentaIndv;
        
        $objWorkSheet->setCellValue('BQ'.$fila, $TotalVentaIndv);
        
        //PORCENTAJE VENTA TOTAL INDIVICUAL DERECHA
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        
        $TotalVentaObjv=0;
        
        //2do TOTAL TELEOPERADOR OBJETIVO******************************************************
        $fila+=1;
        $objWorkSheet->mergeCells("A".$fila.":C".$fila."");
        $objWorkSheet->setCellValue('A'.$fila, 'TOTAL CONTACT CENTER VENTA OBJETIVO INDIVIDUAL');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //color de fondo
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7');
       
        $queryTLabs = mssql_query("SELECT tipoCuota, SUM(Cuotagen) AS TotalCO FROM [sqlFacturas].[dbo].[facInfcomercial] where tipoCuota IN('Cuota Objetivo Individual') and Area='TELEOPERADOR' and SectorLab NOT IN('TODO') GROUP BY tipoCuota;", $cLink);
            //echo "</br>SELECT DISTINCT SectorLab, codVend, Venta, VentaObj FROM [sqlFacturas].[dbo].[facInfcomercial] where codVend='".$vend."' and tipoCuota='Cuota Laboratorio' and Area='TELEOPERADOR' and SectorLab NOT IN('TODO');";
            if($rowVendTlabC = mssql_fetch_array($queryTLabs)){
                $tipoCuotag = trim($rowVendTlabC['tipoCuota']);
                $cuotaGenObj = trim($rowVendTlabC['TotalCO']);
                if($cuotaGenObj=='' || $cuotaGenObj=='-'){$cuotaGenObj=0;}
            }
            
        //TOTAL CUOTA OBJETIVO INDIVIDUAL IZQ-DERECHA
        $objWorkSheet->setCellValue('D'.$fila, $cuotaGenObj);
        $objWorkSheet->setCellValue('BP'.$fila, $cuotaGenObj);
        
        //FERRETERIA
        $objWorkSheet->setCellValue('E'.$fila, $TotalTCuo1O);
        $objWorkSheet->setCellValue('F'.$fila, $TotalTLab1O);
        $TotalVentaObjv=$TotalVentaObjv+$TotalTLab1O;
        $P=0;
        if($TotalTCuo1O > 0){
            // $P=round(($TotalTLab1O/$TotalTCuo1O));
            $P=round(($TotalTLab1O/$TotalTCuo1O));
        }
        // $objWorkSheet->setCellValue('G'.$fila, $P);
        $objWorkSheet->setCellValue('G'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //VARIOS
        $objWorkSheet->setCellValue('H'.$fila, $TotalTCuo2O);
        $objWorkSheet->setCellValue('I'.$fila, $TotalTLab2O);
        $TotalVentaObjv=$TotalVentaObjv+$TotalTLab2O;
        $P=0;
        if($TotalTCuo2O > 0){
            // $P=round(($TotalTLab2O/$TotalTCuo2O));
            $P=round(($TotalTLab2O/$TotalTCuo2O));
        }
        $objWorkSheet->setCellValue('J'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //CONCENTRADOS
        $objWorkSheet->setCellValue('K'.$fila, $TotalTCuo3O);
        $objWorkSheet->setCellValue('L'.$fila, $TotalTLab3O);
        $TotalVentaObjv=$TotalVentaObjv+$TotalTLab3O;
        $P=0;
        if($TotalTCuo3O > 0){
            $P=round(($TotalTLab3O/$TotalTCuo3O));
        }
        $objWorkSheet->setCellValue('M'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('M'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //PETS
        $objWorkSheet->setCellValue('N'.$fila, $TotalTCuo4O);
        $objWorkSheet->setCellValue('O'.$fila, $TotalTLab4O);
        $TotalVentaObjv=$TotalVentaObjv+$TotalTLab4O;
        $P=0;
        if($TotalTCuo4O > 0){
            $P=round(($TotalTLab4O/$TotalTCuo4O));
        }
        $objWorkSheet->setCellValue('P'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('P'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //GANADERIA
        $objWorkSheet->setCellValue('Q'.$fila, $TotalTCuo5O);
        $objWorkSheet->setCellValue('R'.$fila, $TotalTLab5O);
        $TotalVentaObjv=$TotalVentaObjv+$TotalTLab5O;
        $P=0;
        if($TotalTCuo5O > 0){
            $P=round(($TotalTLab5O/$TotalTCuo5O));
        }
        $objWorkSheet->setCellValue('S'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('S'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //INSECTICIDAS Y OTROS
        $objWorkSheet->setCellValue('T'.$fila, $TotalTCuo6O);
        $objWorkSheet->setCellValue('U'.$fila, $TotalTLab6O);
        $TotalVentaObjv=$TotalVentaObjv+$TotalTLab6O;
        $P=0;
        if($TotalTCuo6O > 0){
            $P=round(($TotalTLab6O/$TotalTCuo6O));
        }
        $objWorkSheet->setCellValue('V'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('V'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //INVET
        $objWorkSheet->setCellValue('W'.$fila, $TotalTCuo7O);
        $objWorkSheet->setCellValue('X'.$fila, $TotalTLab7O);
        $TotalVentaObjv=$TotalVentaObjv+$TotalTLab7O;
        $P=0;
        if($TotalTCuo7O > 0){
            $P=round(($TotalTLab7O/$TotalTCuo7O));
        }
        $objWorkSheet->setCellValue('Y'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('Y'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //ICOFARMA
        $objWorkSheet->setCellValue('Z'.$fila, $TotalTCuo8O);
        $objWorkSheet->setCellValue('AA'.$fila, $TotalTLab8O);
        $TotalVentaObjv=$TotalVentaObjv+$TotalTLab8O;
        $P=0;
        if($TotalTCuo8O > 0){
            $P=round(($TotalTLab8O/$TotalTCuo8O));
        }
        $objWorkSheet->setCellValue('AB'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('AB'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //COMERVET
        $objWorkSheet->setCellValue('AC'.$fila, $TotalTCuo9O);
        $objWorkSheet->setCellValue('AD'.$fila, $TotalTLab9O);
        $TotalVentaObjv=$TotalVentaObjv+$TotalTLab9O;
        $P=0;
        if($TotalTCuo9O > 0){
            $P=round(($TotalTLab9O/$TotalTCuo9O));
        }
        $objWorkSheet->setCellValue('AE'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('AE'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //GABRICA
        $objWorkSheet->setCellValue('AI'.$fila, $TotalTCuo10O);
        $objWorkSheet->setCellValue('AJ'.$fila, $TotalTLab10O);
        $TotalVentaObjv=$TotalVentaObjv+$TotalTLab10O;
        $P=0;
        if($TotalTCuo10O > 0){
            $P=round(($TotalTLab10O/$TotalTCuo10O));
        }
        $objWorkSheet->setCellValue('AK'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('AK'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //BIOSTAR
        $objWorkSheet->setCellValue('AL'.$fila, $TotalTCuo11O);
        $objWorkSheet->setCellValue('AM'.$fila, $TotalTLab11O);
        $TotalVentaObjv=$TotalVentaObjv+$TotalTLab11O;
        $P=0;
        if($TotalTCuo11O > 0){
            $P=round(($TotalTLab11O/$TotalTCuo11O));
        }
        $objWorkSheet->setCellValue('AN'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('AN'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //COHASFARMA
        $objWorkSheet->setCellValue('AR'.$fila, $TotalTCuo12O);
        $objWorkSheet->setCellValue('AS'.$fila, $TotalTLab12O);
        $TotalVentaObjv=$TotalVentaObjv+$TotalTLab12O;
        $P=0;
        if($TotalTCuo12O > 0){
            $P=round(($TotalTLab12O/$TotalTCuo12O));
        }
        $objWorkSheet->setCellValue('AT'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('AT'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //IMPORTADOS
        $objWorkSheet->setCellValue('AU'.$fila, $TotalTCuo13O);
        $objWorkSheet->setCellValue('AV'.$fila, $TotalTLab13O);
        $TotalVentaObjv=$TotalVentaObjv+$TotalTLab13O;
        
        $P=0;
        if($TotalTCuo13O > 0){
            $P=round(($TotalTLab13O/$TotalTCuo13O));
        }
        $objWorkSheet->setCellValue('AW'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('AW'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //INTERVET
        $objWorkSheet->setCellValue('AX'.$fila, $TotalTCuo14O);
        $objWorkSheet->setCellValue('AY'.$fila, $TotalTLab14O);
        $TotalVentaObjv=$TotalVentaObjv+$TotalTLab14O;
        $P=0;
        if($TotalTCuo14O > 0){
            $P=round(($TotalTLab14O/$TotalTCuo14O));
        }
        $objWorkSheet->setCellValue('AZ'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('AZ'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //LINEA AGIL
        $objWorkSheet->setCellValue('BD'.$fila, $TotalTCuo15O);
        $objWorkSheet->setCellValue('BE'.$fila, $TotalTLab15O);
        $TotalVentaObjv=$TotalVentaObjv+$TotalTLab15O;
        $P=0;
        if($TotalTCuo15O > 0){
            $P=round(($TotalTLab15O/$TotalTCuo15O));
        }
        $objWorkSheet->setCellValue('BF'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('BF'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //LINEA AGIL IMPORTADOS
        $objWorkSheet->setCellValue('BG'.$fila, $TotalTCuo16O);
        $objWorkSheet->setCellValue('BH'.$fila, $TotalTLab16O);
        $TotalVentaObjv=$TotalVentaObjv+$TotalTLab16O;
        $P=0;
        if($TotalTCuo16O > 0){
            $P=round(($TotalTLab16O/$TotalTCuo16O));
        }
        $objWorkSheet->setCellValue('BI'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('BI'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //LABORATORIOS BAI
        $objWorkSheet->setCellValue('BJ'.$fila, $TotalTCuo17O);
        $objWorkSheet->setCellValue('BK'.$fila, $TotalTLab17O);
        $TotalVentaObjv=$TotalVentaObjv+$TotalTLab17O;
        $P=0;
        if($TotalTCuo17O > 0){
            $P=round(($TotalTLab17O/$TotalTCuo17O));
        }
        $objWorkSheet->setCellValue('BL'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('BL'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //TECNOCALIDAD
        $objWorkSheet->setCellValue('BM'.$fila, $TotalTCuo18O);
        $objWorkSheet->setCellValue('BN'.$fila, $TotalTLab18O);
        $TotalVentaObjv=$TotalVentaObjv+$TotalTLab18O;
        $P=0;
        if($TotalTCuo18O > 0){
            $P=round(($TotalTLab18O/$TotalTCuo18O));
        }
        $objWorkSheet->setCellValue('BO'.$fila, $P);
        $objPHPExcel->getActiveSheet()->getStyle('BO'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //TOTAL VENTA INDIVIDUAL FINAL DERECHA
        $objWorkSheet->setCellValue('BQ'.$fila, $TotalVentaObjv);
        //PORCENTAJE VENTA TOTAL INDIVICUAL DERECHA
        // $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        
        //TERCER TOTAL INFERIOR VEND114,VEND214
        $queryTLabsF = mssql_query("SELECT SUM(ValorSinIVA) as VentaTot
          FROM [sqlFacturas].[dbo].[facDetalleFacturanew] f
          join [sqlFacturas].[dbo].[agrPeriodo] p ON f.FechaOrden >=CONVERT(VARCHAR, p.FechaIni) AND FechaOrden <=CONVERT(VARCHAR, p.FechaFin) 
         WHERE p.Codigo IN('$periodo') AND f.Vendedor IN('VEND114','VEND214') AND f.Call NOT IN('VANANDELL')
        ", $cLink);            
            if($rowVendTlabCF = mssql_fetch_array($queryTLabsF)){
                $ventaLabsF = trim($rowVendTlabCF['VentaTot']);
                if($ventaLabsF=='' || $ventaLabsF=='-'){$ventaLabsF=0;}
            }
        
        $fila+=1;
        $objWorkSheet->mergeCells("A".$fila.":C".$fila."");
        $objWorkSheet->setCellValue('A'.$fila, 'TOTAL VENTAS CALL A VENDEDORES (VEND114, VEND214)');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //color de fondo
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7');
        
        $objWorkSheet->setCellValue('BP'.$fila, $ventaLabsF);
        $objWorkSheet->setCellValue('BQ'.$fila, $ventaLabsF);
        
        //TOTAL FINAL ULTIMA LINEA 
        
        $fila+=2;
        $objWorkSheet->mergeCells("A".$fila.":C".$fila."");
        $objWorkSheet->setCellValue('A'.$fila, 'TOTAL GENERAL (VEXT +ALM + CALL IND) - (CALL VEND114 Y VEND214)');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
        //color de fondo
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':BR'.$fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7');
        
        $objWorkSheet->setCellValue('D'.$fila, $TotCuotaFinal);
        
        $t=0;
        $ct=count($Laboratoriostot);
        while($t<=$ct){
            switch($Laboratoriostot[$t]){
                case 'Ferreteria':
                    $objWorkSheet->setCellValue('E'.$fila, $TotCuotaFinaLab[$t]);
                    $objWorkSheet->setCellValue('F'.$fila, $TotVentaFinaLab[$t]);
                    //PORCENTAJE VENTA TOTAL INDIVICUAL DERECHA
                    // $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(F".$fila."/E".$fila.",0)");
                    $Porc ="=IFERROR(F".$fila."/E".$fila.",0)";
                    $objWorkSheet->setCellValue('G'.$fila, $Porc);
                    break;
                case 'Varios':
                    $objWorkSheet->setCellValue('H'.$fila, $TotCuotaFinaLab[$t]);
                    $objWorkSheet->setCellValue('I'.$fila, $TotVentaFinaLab[$t]);
                    //PORCENTAJE VENTA TOTAL INDIVICUAL DERECHA
                    // $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(I".$fila."/H".$fila.",0)");
                    $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(I".$fila."/H".$fila.",0)");
                    $objWorkSheet->setCellValue('J'.$fila, $Porc);
                    break;
                case 'Concentrados':
                    $objWorkSheet->setCellValue('K'.$fila, $TotCuotaFinaLab[$t]);
                    $objWorkSheet->setCellValue('L'.$fila, $TotVentaFinaLab[$t]);
                    //PORCENTAJE VENTA TOTAL INDIVICUAL DERECHA
                    $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(L".$fila."/K".$fila.",0)");
                    $objWorkSheet->setCellValue('M'.$fila, $Porc);
                    break;
                case 'Pets':
                    $objWorkSheet->setCellValue('N'.$fila, $TotCuotaFinaLab[$t]);
                    $objWorkSheet->setCellValue('O'.$fila, $TotVentaFinaLab[$t]);
                    //PORCENTAJE VENTA TOTAL INDIVICUAL DERECHA
                    $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(O".$fila."/N".$fila.",0)");
                    $objWorkSheet->setCellValue('P'.$fila, $Porc);
                    break;
                case 'Ganaderia':
                    $objWorkSheet->setCellValue('Q'.$fila, $TotCuotaFinaLab[$t]);
                    $objWorkSheet->setCellValue('R'.$fila, $TotVentaFinaLab[$t]);
                    //PORCENTAJE VENTA TOTAL INDIVICUAL DERECHA
                    $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(R".$fila."/Q".$fila.",0)");
                    $objWorkSheet->setCellValue('S'.$fila, $Porc);
                    break;
                case 'Insecticidas':
                    $objWorkSheet->setCellValue('T'.$fila, $TotCuotaFinaLab[$t]);
                    $objWorkSheet->setCellValue('U'.$fila, $TotVentaFinaLab[$t]);
                    //PORCENTAJE VENTA TOTAL INDIVICUAL DERECHA
                    $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(U".$fila."/T".$fila.",0)");
                    $objWorkSheet->setCellValue('V'.$fila, $Porc);
                    break;
                case 'Invet':
                    $objWorkSheet->setCellValue('W'.$fila, $TotCuotaFinaLab[$t]);
                    $objWorkSheet->setCellValue('X'.$fila, $TotVentaFinaLab[$t]);
                    //PORCENTAJE VENTA TOTAL INDIVICUAL DERECHA
                    $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(X".$fila."/W".$fila.",0)");
                    $objWorkSheet->setCellValue('Y'.$fila, $Porc);
                    break;
                case 'Icofarma':
                    $objWorkSheet->setCellValue('Z'.$fila, $TotCuotaFinaLab[$t]);
                    $objWorkSheet->setCellValue('AA'.$fila, $TotVentaFinaLab[$t]);
                    //PORCENTAJE VENTA TOTAL INDIVICUAL DERECHA
                    $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(AA".$fila."/Z".$fila.",0)");
                    $objWorkSheet->setCellValue('AB'.$fila, $Porc);
                    break;
                case 'Comervet':
                    $objWorkSheet->setCellValue('AC'.$fila, $TotCuotaFinaLab[$t]);
                    $objWorkSheet->setCellValue('AD'.$fila, $TotVentaFinaLab[$t]);
                    //PORCENTAJE VENTA TOTAL INDIVICUAL DERECHA
                    $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(AD".$fila."/AC".$fila.",0)");
                    $objWorkSheet->setCellValue('AE'.$fila, $Porc);
                    break;
                case 'Gabrica':
                    $objWorkSheet->setCellValue('AI'.$fila, $TotCuotaFinaLab[$t]);
                    $objWorkSheet->setCellValue('AJ'.$fila, $TotVentaFinaLab[$t]);
                    //PORCENTAJE VENTA TOTAL INDIVICUAL DERECHA
                    $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(AJ".$fila."/AI".$fila.",0)");
                    $objWorkSheet->setCellValue('AK'.$fila, $Porc);
                    break;
                case 'Biostar':
                    $objWorkSheet->setCellValue('AL'.$fila, $TotCuotaFinaLab[$t]);
                    $objWorkSheet->setCellValue('AM'.$fila, $TotVentaFinaLab[$t]);
                    //PORCENTAJE VENTA TOTAL INDIVICUAL DERECHA
                    $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(AM".$fila."/AL".$fila.",0)");
                    $objWorkSheet->setCellValue('AN'.$fila, $Porc);
                    break;
                 case 'Coaspharma':
                    $objWorkSheet->setCellValue('AR'.$fila, $TotCuotaFinaLab[$t]);
                    $objWorkSheet->setCellValue('AS'.$fila, $TotVentaFinaLab[$t]);
                    //PORCENTAJE VENTA TOTAL INDIVICUAL DERECHA
                    $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(AS".$fila."/AR".$fila.",0)");
                    $objWorkSheet->setCellValue('AT'.$fila, $Porc);
                    break;
                 case 'Importados':
                    $objWorkSheet->setCellValue('AU'.$fila, $TotCuotaFinaLab[$t]);
                    $objWorkSheet->setCellValue('AV'.$fila, $TotVentaFinaLab[$t]);
                    //PORCENTAJE VENTA TOTAL INDIVICUAL DERECHA
                    $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(AV".$fila."/AU".$fila.",0)");
                    $objWorkSheet->setCellValue('AW'.$fila, $Porc);
                    break;
                 case 'Intervet':
                    $objWorkSheet->setCellValue('AX'.$fila, $TotCuotaFinaLab[$t]);
                    $objWorkSheet->setCellValue('AY'.$fila, $TotVentaFinaLab[$t]);
                    //PORCENTAJE VENTA TOTAL INDIVICUAL DERECHA
                    $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(AY".$fila."/AX".$fila.",0)");
                    $objWorkSheet->setCellValue('AZ'.$fila, $Porc);
                    break;
                 case 'LineaAgil':
                    $objWorkSheet->setCellValue('BD'.$fila, $TotCuotaFinaLab[$t]);
                    $objWorkSheet->setCellValue('BE'.$fila, $TotVentaFinaLab[$t]);
                    //PORCENTAJE VENTA TOTAL INDIVICUAL DERECHA
                    $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BE".$fila."/BD".$fila.",0)");
                    $objWorkSheet->setCellValue('BF'.$fila, $Porc);
                    break;
                 case 'LineaAgilImportados':
                    $objWorkSheet->setCellValue('BG'.$fila, $TotCuotaFinaLab[$t]);
                    $objWorkSheet->setCellValue('BH'.$fila, $TotVentaFinaLab[$t]);
                    //PORCENTAJE VENTA TOTAL INDIVICUAL DERECHA
                    $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BH".$fila."/BG".$fila.",0)");
                    $objWorkSheet->setCellValue('BI'.$fila, $Porc);
                    break;
                 case 'LaboratoriosBai':
                    $objWorkSheet->setCellValue('BJ'.$fila, $TotCuotaFinaLab[$t]);
                    $objWorkSheet->setCellValue('BK'.$fila, $TotVentaFinaLab[$t]);
                    //PORCENTAJE VENTA TOTAL INDIVICUAL DERECHA
                    $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BK".$fila."/BJ".$fila.",0)");
                    $objWorkSheet->setCellValue('BL'.$fila, $Porc);
                    break;
                 case 'Tecnocalidad':
                    $objWorkSheet->setCellValue('BM'.$fila, $TotCuotaFinaLab[$t]);
                    $objWorkSheet->setCellValue('BN'.$fila, $TotVentaFinaLab[$t]);
                    //PORCENTAJE VENTA TOTAL INDIVICUAL DERECHA
                    // $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BN".$fila."/BM".$fila.",0)");
                    $Porc = "=IFERROR(BN".$fila."/BM".$fila.",0)";
                    $objWorkSheet->setCellValue('BO'.$fila, $Porc);
                    break;
                 case 'TOTALCV':
                    $objWorkSheet->setCellValue('BP'.$fila, $TotCuotaFinaLab[$t]);
                    
                    //$ventaLabsF DESCUENTA VENTAS DEL TOTAL DEL VEND114 Y VEND214
                    $TotVentaFinaLab[$t]=$TotVentaFinaLab[$t]-$ventaLabsF;
                                                            
                    $objWorkSheet->setCellValue('BQ'.$fila, $TotVentaFinaLab[$t]);
                    //PORCENTAJE VENTA TOTAL INDIVICUAL DERECHA
                    $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
                    $objWorkSheet->setCellValue('BR'.$fila, $Porc);
                    break;
                
            }
        $t++;
        }
        
        //TOTAL FINAL
        //.'+BQ'.($fila-13).'+BQ'.($fila-9)
        
        //suma al total venta final el vend157 y vendpest
        $TotalOtros2=0;//$ventaTotOT2+$ventaTotOT3;
        
        $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$fila,'=(F'.$fila.'+I'.$fila.'+L'.$fila.'+O'.$fila.'+R'.$fila.'+U'.$fila.'+X'.$fila.'+AA'.$fila.'+AD'.$fila.'+AJ'.$fila.'+AM'.$fila.'+AS'.$fila.'+AV'.$fila.'+AY'.$fila.'+BE'.$fila.'+BH'.$fila.'+BK'.$fila.'+BN'.$fila.'+'.$TotalOtros2.')');
        // $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $Porc = iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".$fila."/BP".$fila.",0)");
        $objWorkSheet->setCellValue('BR'.$fila, $Porc);
        //CUOTA FINAL
        
        //le suma la cuota del VENDPEST, que desde arriba es la misma de la venta
        $TotCuotaFinal=$TotCuotaFinal+$ventaTotOT3; 
        $objWorkSheet->setCellValue('BP'.$fila, $TotCuotaFinal);
        
}  //fin ruta
     $objWorkSheet->freezePaneByColumnAndRow(3,6);
     
//OJO cuadro jorge CUDRAR FILA AUTOMATICA****************************************
//$filanose=94;
$filanose=$filaInicioTotalesTeleoperadores;
for($to=0;$to<=$cantidadTeleoperadores-1 ;$to++){
    $nose=("=BQ".($filanose-1)."+BQ".($filanose-2));
        //TOTAL
        $objWorkSheet->setCellValue('BQ'.$filanose, $nose);
    //=SI.ERROR(BQ121/BP121;333)
        //BQ205/BP205;
        //$nose1=("=BQ".($filanose-2)."/BP".($filanose-2));
        // $nose1= iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".($filanose-2)."/BP".($filanose-2).",0)");
        $nose1= iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".($filanose-2)."/BP".($filanose-2).",0)");
        $filanose1=$filanose-2;
        $objWorkSheet->setCellValue('BR'.$filanose1, $nose1);
        
        $filanose2=$filanose-1;
        //$nose2=("=BQ".($filanose-1)."/BP".($filanose-1));
        // $nose2= iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".($filanose-1)."/BP".($filanose-1).",0)");
        $nose2= iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".($filanose-1)."/BP".($filanose-1).",0)");
        $objWorkSheet->setCellValue('BR'.$filanose2, $nose2);
        
        // $nose3= iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".($filanose)."/BP".($filanose).",0)");
        $nose3= iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".($filanose)."/BP".($filanose).",0)");
        //$nose3=("=BQ".($filanose)."/BP".($filanose));
        $objWorkSheet->setCellValue('BR'.$filanose, $nose3);
        $filanose=$filanose+4;
}

//OTROS2
            $filanose++;
            for($to=0;$to<2 ;$to++){
                $nose=("=BQ".($filanose-1)."+BQ".($filanose-2));
                //TOTAL
                $objWorkSheet->setCellValue('BQ'.$filanose, $nose);
                //=SI.ERROR(BQ121/BP121;333)
                //BQ205/BP205;
                //$nose1=("=BQ".($filanose-2)."/BP".($filanose-2));
                // $nose1= iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".($filanose-2)."/BP".($filanose-2).",0)");
                $nose1= iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".($filanose-2)."/BP".($filanose-2).",0)");
                $filanose1=$filanose-2;
                $objWorkSheet->setCellValue('BR'.$filanose1, $nose1);
                
                $filanose2=$filanose-1;
                //$nose2=("=BQ".($filanose-1)."/BP".($filanose-1));
                // $nose2= iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".($filanose-1)."/BP".($filanose-1).",0)");
                $nose2= iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".($filanose-1)."/BP".($filanose-1).",0)");
                $objWorkSheet->setCellValue('BR'.$filanose2, $nose2);
                
                //$nose3=("=BQ".($filanose)."/BP".($filanose));
                // $nose3= iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".($filanose)."/BP".($filanose).",0)");
                $nose3= iconv('ISO-8859-2', 'UTF-8//IGNORE//TRANSLIT', "=IFERROR(BQ".($filanose)."/BP".($filanose).",0)");
                $objWorkSheet->setCellValue('BR'.$filanose, $nose3);
                $filanose=$filanose+4;
            }
            
        //HOJAS PARA RH
        $FilaRH=2;
        $objWorkSheet = $objPHPExcel->createSheet(1);
        $objPHPExcel->setActiveSheetIndex(1);
        $objWorkSheet->setTitle("Informe RH");
        $Mes=substr($periodo,3,2);
        $mesAnt=$Mes-1;
        $Ane=substr($periodo,0,4);
        $Mesper= array("0","ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
        $msg=$Mesper[$mesAnt]." - ".$Mesper[$Mes];
        $objWorkSheet->mergeCells("B2:D2");
        $objWorkSheet->setCellValue('B2', $msg);
        $objPHPExcel->getActiveSheet()->getStyle('B2:D2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
        //PRIMER CUADRO GENERAL
        $FilaRH+=2;
        $objWorkSheet->mergeCells("B".$FilaRH.":D".$FilaRH);
        $objWorkSheet->setCellValue('B'.$FilaRH, "GENERAL");
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH)->getFont()->setBold(true);
        $FilaRH++;
        $objWorkSheet->setCellValue('B'.$FilaRH, "AREA");
        $objWorkSheet->setCellValue('C'.$FilaRH, "Suma de VLR_EXC_IVA");
        $objWorkSheet->setCellValue('D'.$FilaRH, "Suma de VLR_INC_IVA");
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH.':D'.$FilaRH)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7');
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$FilaRH)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$FilaRH)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$FilaRH)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$FilaRH)->getFont()->setBold(true);
        //consulta RH
        $queryTLabsR = mssql_query("SELECT Grupo, Area, Coniva, Siniva 
          FROM [sqlFacturas].[dbo].[facInfcomResumen] where Grupo='AREAS'
        ", $cLink);
        while($rowVendTlabCR = mssql_fetch_array($queryTLabsR)){
                $grupo = trim($rowVendTlabCR['Grupo']);
                $areax = trim($rowVendTlabCR['Area']);
                $siniva = trim($rowVendTlabCR['Siniva']);
                $coniva = trim($rowVendTlabCR['Coniva']);
                
                $FilaRH++;
                $objWorkSheet->setCellValue('B'.$FilaRH, $areax);
                
                $objWorkSheet->setCellValue('C'.$FilaRH, $siniva);
                
                $objWorkSheet->setCellValue('D'.$FilaRH, $coniva);  
        }
        //TOTAL
        $FilaRH++;
        $objWorkSheet->setCellValue('B'.$FilaRH, "TOTAL $"); 
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$FilaRH)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$FilaRH)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$FilaRH,'=(C'.($FilaRH-1).'+C'.($FilaRH-2).'+C'.($FilaRH-3).')');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$FilaRH,'=(D'.($FilaRH-1).'+D'.($FilaRH-2).'+D'.($FilaRH-3).')');
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7');
        $objPHPExcel->getActiveSheet()->getStyle('C'.$FilaRH)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7');
        $objPHPExcel->getActiveSheet()->getStyle('D'.$FilaRH)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7');
        //SEGUNDO CUADRO IMPORTADOS
        $FilaRH+=2;
        $objWorkSheet->mergeCells("B".$FilaRH.":D".$FilaRH);
        $objWorkSheet->setCellValue('B'.$FilaRH, "IMPORTADOS");
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH)->getFont()->setBold(true);
        $FilaRH++;
        $objWorkSheet->setCellValue('B'.$FilaRH, "AREA");
        $objWorkSheet->setCellValue('C'.$FilaRH, "Suma de VLR_EXC_IVA");
        $objWorkSheet->setCellValue('D'.$FilaRH, "Suma de VLR_INC_IVA");
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH.':D'.$FilaRH)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7');
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$FilaRH)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$FilaRH)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$FilaRH)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$FilaRH)->getFont()->setBold(true);
        //consulta RH
        $queryTLabsR = mssql_query("SELECT Grupo, Area, Coniva, Siniva 
          FROM [sqlFacturas].[dbo].[facInfcomResumen] where Grupo='IMPORTADOS'
        ", $cLink);
        while($rowVendTlabCR = mssql_fetch_array($queryTLabsR)){
                $grupo = trim($rowVendTlabCR['Grupo']);
                $areax = trim($rowVendTlabCR['Area']);
                $siniva = trim($rowVendTlabCR['Siniva']);
                $coniva = trim($rowVendTlabCR['Coniva']);
                
                $FilaRH++;
                $objWorkSheet->setCellValue('B'.$FilaRH, $areax);
                $objWorkSheet->setCellValue('C'.$FilaRH, $siniva);
                $objWorkSheet->setCellValue('D'.$FilaRH, $coniva);   
        }
        //TOTAL
        $FilaRH++;
        $objWorkSheet->setCellValue('B'.$FilaRH, "TOTAL $"); 
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$FilaRH)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$FilaRH)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$FilaRH,'=(C'.($FilaRH-1).'+C'.($FilaRH-2).'+C'.($FilaRH-3).'+C'.($FilaRH-4).')');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$FilaRH,'=(D'.($FilaRH-1).'+D'.($FilaRH-2).'+D'.($FilaRH-3).'+D'.($FilaRH-4).')');
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7');
        $objPHPExcel->getActiveSheet()->getStyle('C'.$FilaRH)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7');
        $objPHPExcel->getActiveSheet()->getStyle('D'.$FilaRH)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7');
        
        //TERCER CUADRO IMPORTADOS POR GRUPO
        $FilaRH+=2;
        $objWorkSheet->mergeCells("B".$FilaRH.":D".$FilaRH);
        $objWorkSheet->setCellValue('B'.$FilaRH, "IMPORTADOS GRP");
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH)->getFont()->setBold(true);
        $FilaRH++;
        $objWorkSheet->setCellValue('B'.$FilaRH, "AREA");
        $objWorkSheet->setCellValue('C'.$FilaRH, "Suma de VLR_EXC_IVA");
        $objWorkSheet->setCellValue('D'.$FilaRH, "Suma de VLR_INC_IVA");
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH.':D'.$FilaRH)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7');
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$FilaRH)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$FilaRH)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$FilaRH)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$FilaRH)->getFont()->setBold(true);
        //consulta RH
        $queryTLabsR = mssql_query("SELECT Grupo, Area, Coniva, Siniva 
          FROM [sqlFacturas].[dbo].[facInfcomResumen] where Grupo='GRUPOIMP'
        ", $cLink);
        while($rowVendTlabCR = mssql_fetch_array($queryTLabsR)){
                $grupo = trim($rowVendTlabCR['Grupo']);
                $areax = trim($rowVendTlabCR['Area']);
                $siniva = trim($rowVendTlabCR['Siniva']);
                $coniva = trim($rowVendTlabCR['Coniva']);
                
                $FilaRH++;
                $objWorkSheet->setCellValue('B'.$FilaRH, $areax);
                $objWorkSheet->setCellValue('C'.$FilaRH, $siniva);
                $objWorkSheet->setCellValue('D'.$FilaRH, $coniva);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
        }
        //TOTAL
        $FilaRH++;
        $objWorkSheet->setCellValue('B'.$FilaRH, "TOTAL $"); 
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$FilaRH)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$FilaRH)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$FilaRH,'=(C'.($FilaRH-1).'+C'.($FilaRH-2).'+C'.($FilaRH-3).')');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$FilaRH,'=(D'.($FilaRH-1).'+D'.($FilaRH-2).'+D'.($FilaRH-3).')');
        $objPHPExcel->getActiveSheet()->getStyle('B'.$FilaRH)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7');
        $objPHPExcel->getActiveSheet()->getStyle('C'.$FilaRH)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7');
        $objPHPExcel->getActiveSheet()->getStyle('D'.$FilaRH)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7');
             
//CREA ARCHIVO************************************************************
    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
       //Guardar el achivo: 
    $objWriter->save($mipath2);
    
    //enviar a mail
//odbc_close($result);
mssql_close();
echo $mipath;
?>