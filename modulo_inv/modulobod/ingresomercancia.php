<?php
$anio=trim($_GET['a']);
$mes=trim($_GET['m']);
//$dia=trim($_GET['d']);
$tipo=trim($_GET['tipo']);
$company=trim($_GET['comp']);
include('conectarbase.php');
$dato="";
if($company=="AG"){
    $cp="Agrocampo";
    }
if($company=="X1"){
    $cp="Pestar";
    }
if($company=="ZZ"){
    $cp="Comervet";
    }
    $fecha=date("d_m_Y");
    $miruta='informes/';
    $nombre_fichero = 'Informe_'.$tipo.'_'.$cp.'_';
    $mipath=$miruta.'.'.$nombre_fichero.'.xlsx';
    $Odenes=new ArrayIterator();
    if(file_exists($miruta)) {
        include('Classes/PHPExcel.php');
        include('Classes/PHPExcel/Reader/Excel2007.php');
        //Crear el objeto Excel: 
        $objPHPExcel = new PHPExcel();
        //crea hojas
        $i=1;
        $mipath2=$nombre_fichero.$anio.'.xlsx';
        if(file_exists($mipath2)) {
            $archivo = $mipath2;
            $inputFileType = PHPExcel_IOFactory::identify($archivo);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($archivo);
            $objPHPExcel->getProperties()->setCreator("Autor: Agrocampo");
            $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo");
            $objPHPExcel->getProperties()->setTitle("Informe de Ordenes");
            $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
            $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
            $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
            $objPHPExcel->getProperties()->setCategory("Resultado de Informe");
        }else{
            while ($i <= 12) {
                // Add new sheet
                $objWorkSheet = $objPHPExcel->createSheet($i);
                $objWorkSheet->setCellValue('A2', 'CONSECUTIVO')
                    ->setCellValue('B2', 'BODEGA')
                    ->setCellValue('C2', 'FECHA')
                    ->setCellValue('D2', 'CODIGO')
                    ->setCellValue('E2', 'DESCRIPCION')
                    ->setCellValue('F2', 'GRUPO')
                    ->setCellValue('G2', 'RECIBIDOS')
                    ->setCellValue('H2', 'FACTURADOS')
                    ->setCellValue('I2', 'BONIFICADOS')
                    ->setCellValue('J2', 'VENCIMIENTO')
                    ->setCellValue('K2', 'LOTE')
                    ->setCellValue('L2', 'PROVEEDOR')
                    ->setCellValue('M2', 'PROCESADO')
                    ->setCellValue('N2', 'DEVOLUCION');
                $objWorkSheet->setTitle("$i");
                $i++;
            }
            $objPHPExcel->getProperties()->setCreator("Autor: Agrocampo");
            $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo");
            $objPHPExcel->getProperties()->setTitle("Informe de Ordenes");
            $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
            $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
            $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
            $objPHPExcel->getProperties()->setCategory("Resultado de Informe"); 
            while ($i <= 12) {
                // Add new sheet
                $objWorkSheet = $objPHPExcel->createSheet($i);
                
                $objWorkSheet->setCellValue('A2', 'CONSECUTIVO')
                    ->setCellValue('B2', 'BODEGA')
                    ->setCellValue('C2', 'FECHA')
                    ->setCellValue('D2', 'CODIGO')
                    ->setCellValue('E2', 'DESCRIPCION')
                    ->setCellValue('F2', 'GRUPO')
                    ->setCellValue('G2', 'RECIBIDOS')
                    ->setCellValue('H2', 'FACTURADOS')
                    ->setCellValue('I2', 'BONIFICADOS')
                    ->setCellValue('J2', 'VENCIMIENTO')
                    ->setCellValue('K2', 'LOTE')
                    ->setCellValue('L2', 'PROVEEDOR')
                    ->setCellValue('M2', 'PROCESADO')
                    ->setCellValue('N2', 'DEVOLUCION');
                 
                    //->setCellValue('C2', 'FacturasDespachadasMes');
                $objWorkSheet->setTitle("$i");
                $i++;
            }
        }
        
        $m=intval($mes);
        //borra datos hoja
        $fil=3;
        $objPHPExcel->setActiveSheetIndex($m);
        $totalreg = $objPHPExcel->setActiveSheetIndex($m)->getHighestRow();
        $totalreg=$totalreg+1;
        /*while ($fil <= $totalreg) {
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
            $fil++;
        }*/
        
        //agrupamiento por funcionario
               //$resultSQLItemsm = mssql_query("SELECT DISTINCT rv.Funcionario as Funcionario, count(rv.[Orden]) as PedidosEmpacadosMes, count(rf.[Factura]) as FacturasDespachadasMes FROM [sqlFacturas].[dbo].[facRegistroValidacion] as rv left join [sqlFacturas].[dbo].[facRegistroFactura] as rf ON rv.NumeroFactura=rf.Factura and rv.Orden=rf.Orden and (YEAR(rf.Fecha)='".$anio."' AND MONTH(rf.Fecha)='".$mes."') left join [sqlFacturas].[dbo].[facRegistroValidacion] as rv2 ON rf.Factura=rv2.NumeroFactura and rf.Orden=rv2.Orden and rv.IdRegistroValidacion=rv2.IdRegistroValidacion where (YEAR(rv.HoraFinal)='".$anio."' AND MONTH(rv.HoraFinal)='".$mes."') AND rv.TipoFactura IN ('07','S2','FD','F1','D4') group by rv.Funcionario",$cLink);
               /*if($company=="AG"){
                    $resultSQLItemsm = mssql_query("SELECT Consecutivo,Bodega,Fecha,CodItem,Descripcion,Estiba,CantidadRegistrada,CantidadFacturada,CantidadBonificada,FechaVencimiento,Lote,Proveedor,Procesado,Devolucion FROM [sqlRecepcion008].[dbo].[rcpRegistro]  where (YEAR(Fecha)='".$anio."' AND MONTH(Fecha)='".$mes."')",$cLink);
               }*/
               /*
               if($company=="X1"){
                    $resultSQLItemsm = mssql_query("SELECT s.Responsable as Funcionario, sum(v.LineasProcesadas) AS LineasSeparadas FROM [sqlFacturasPestar].[dbo].[facRegistroSeparacion] s left join [sqlFacturasPestar].[dbo].[facRegistroValidacion] v ON s.Orden=v.Orden WHERE (YEAR(v.HoraFinal)='".$anio."' AND MONTH(v.HoraFinal)='".$mes."') AND v.TipoFactura IN ('01','02','04','ZB') GROUP BY s.Responsable",$cLink);
               }
               if($company=="ZZ"){
                    $resultSQLItemsm = mssql_query("SELECT s.Responsable as Funcionario, sum(v.LineasProcesadas) AS LineasSeparadas FROM [sqlFacturasComervet].[dbo].[facRegistroSeparacion] s left join [sqlFacturasComervet].[dbo].[facRegistroValidacion] v ON s.Orden=v.Orden WHERE (YEAR(v.HoraFinal)='".$anio."' AND MONTH(v.HoraFinal)='".$mes."') AND v.TipoFactura IN ('01','02') GROUP BY s.Responsable",$cLink);
               }*/
            $j=0;
            $cant=0;
                        
            $objPHPExcel->setActiveSheetIndex($m);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(45);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
         
            $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('M2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
            
            $resultSQLItemsm = mssql_query("SELECT Consecutivo,Bodega,Fecha,CodItem,Descripcion,Estiba,CantidadRegistrada,CantidadFacturada,CantidadBonificada,FechaVencimiento,Lote,Proveedor,Procesado,Devolucion FROM [sqlRecepcion008].[dbo].[rcpRegistro]  where (YEAR(Fecha)='".$anio."' AND MONTH(Fecha)='".$mes."')",$cLink);
            //consulta
            $j=0;
            $fd=3;
            $fn=3;
            $Mess=array('1' => "ENERO",'2' => "FEBRERO",'3' => "MARZO",'4' => "ABRIL",'5' => "MAYO",'6' => "JUNIO",'7' => "JULIO",'8' => "AGOSTO",'9' => "SEPTIEMBRE",'10' => "OCTUBRE",'11' => "NOVIEMBRE",'12' => "DICIEMBRE");
            $objPHPExcel->setActiveSheetIndex($m)
                        ->setCellValue('A1', $Mess[$m]." ".$anio);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            setlocale(LC_TIME,"es_ES");
          
            $datos=new ArrayIterator();
            $cd=0;
            $cn=0;
            $fd=3;
            //$i=0;
            //$Usuarios=new ArrayIterator();
            /*
                    $i=0;
                    $cantP=count($PedSale);
                    while($i<$cantP){
                        $c=mssql_num_rows($resultSQLItems);
                        if($c > 0){
                            while($resultadoitems = mssql_fetch_array($resultSQLItems)){
                                $d1=$resultadoitems["NumeroFactura"];
                                $d2=$resultadoitems["Orden"];
                                $d3=$resultadoitems["Tipo"];
                                $d4=$resultadoitems["Item"];
                                $d5=$resultadoitems["Descripcion"];
                                $d6=$resultadoitems["Cantidad"];
                                $d7=$resultadoitems["HoraFinal"];
                                $d8=$resultadoitems["Transportadora"];
                                $d9=$resultadoitems["Destino"];
                            }    
                        }
                                
                        $i++;    
                         
                     }
            */
            
            while($resultadoitems = mssql_fetch_array($resultSQLItemsm)){
                        
                        $d1=utf8_encode($resultadoitems["Consecutivo"]);
                        $d2=$resultadoitems["Bodega"];
                        $d3=$resultadoitems["Fecha"];
                        //$d3=$resultadoitems["LineasValidadasMes"];
                        $d4=$resultadoitems["CodItem"];
                        $d5=$resultadoitems["Descripcion"];
                        $d6=$resultadoitems["Estiba"];
                        $d7=$resultadoitems["CantidadRegistrada"];
                        $d8=$resultadoitems["CantidadFacturada"];
                        $d9=$resultadoitems["CantidadBonificada"];
                        $d10=$resultadoitems["FechaVencimiento"];
                        $d11=$resultadoitems["Lote"];
                        $d12=$resultadoitems["Proveedor"];
                        $d13=$resultadoitems["Procesado"];
                        $d14=$resultadoitems["Devolucion"];
                        //$d5=$resultadoitems["CajasEmpacadasMes"];
                        //$d6=$resultadoitems["FacturasDespachadasMes"];
                        
                       
                            $objPHPExcel->setActiveSheetIndex($m)
                                ->setCellValue('A'.$fd, $d1)
                                //->setCellValueExplicitByColumnAndRow('B', $fd, $d2, PHPExcel_Cell_DataType::TYPE_STRING)
                                ->setCellValue('B'.$fd, $d2)
                                ->setCellValue('C'.$fd, $d3)
                                ->setCellValue('D'.$fd, $d4)
                                ->setCellValue('E'.$fd, $d5)
                                ->setCellValue('F'.$fd, $d6)
                                ->setCellValue('G'.$fd, $d7)
                                ->setCellValue('H'.$fd, $d8)
                                ->setCellValue('I'.$fd, $d9)
                                ->setCellValue('J'.$fd, $d10)
                                ->setCellValue('K'.$fd, $d11)
                                ->setCellValue('L'.$fd, $d12)
                                ->setCellValue('M'.$fd, $d13)
                                ->setCellValue('N'.$fd, $d14);
                             
                                //->setCellValue('C'.$fd, $d6);
                                
                                //$Usuarios[$i++]=$d1;
                            //$i++; 
                            //$fd++;
             }
 
        //CREA ARCHIVO************************************************************
        //crear objeto writer
        $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
        //Guardar el achivo: 
        $objWriter->save($mipath2);
        //$descarga=$nombre_fichero.$anio.".xlsx";
    }
    // items
    
    
mssql_close();
echo $mipath2;//$datos2diaus[1].",".$datos2diav1[1].",".$datos2diav2[1].",".$datosnohrd[1]." h=".$Hora;

?>