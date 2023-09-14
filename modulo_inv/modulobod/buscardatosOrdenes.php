<?php
$anio=trim($_GET['a']);
$mes=trim($_GET['m']);
include('conectarbase.php');
$dato="";
    $fecha=date("d_m_Y");
    $miruta='informes/';
    $nombre_fichero = 'Informe_Ordenes_Cargadas';
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
                
                $objWorkSheet->setCellValue('A2', 'Factura')
                    ->setCellValue('B2', 'Orden')
                    ->setCellValue('C2', 'Tipo')
                    ->setCellValue('D2', 'Item')
                    ->setCellValue('E2', 'Descripcion')
                    ->setCellValue('F2', 'Cantidad')
                    ->setCellValue('G2', 'Fecha');
                
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
                
                $objWorkSheet->setCellValue('A2', 'Factura')
                    ->setCellValue('B2', 'Orden')
                    ->setCellValue('C2', 'Tipo')
                    ->setCellValue('D2', 'Item')
                    ->setCellValue('E2', 'Descripcion')
                    ->setCellValue('F2', 'Cantidad')
                    ->setCellValue('G2', 'Fecha');
                
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
        while ($fil <= $totalreg) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$fil, '');
            $fil++;
        }
        /*while ($i <= 12) {

            // Add new sheet
            //$objWorkSheet = $objPHPExcel->createSheet($i);
            
            $objWorkSheet->setCellValue('A2', 'Factura')
                ->setCellValue('B2', 'Orden')
                ->setCellValue('C2', 'Tipo')
                ->setCellValue('D2', 'Item')
                ->setCellValue('E2', 'Descripcion')
                ->setCellValue('F2', 'Cantidad');
            
            $objWorkSheet->setTitle("$i");

            $i++;
            
        }*/
        
        //cuenta filas
        //$totalregistros = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        //if($totalregistros < 3){
            //Configurando el archivo: 
            /*$objPHPExcel->getProperties()->setCreator("Autor: Agrocampo");
            $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo");
            $objPHPExcel->getProperties()->setTitle("Informe de Ordenes");
            $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
            $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
            $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
            $objPHPExcel->getProperties()->setCategory("Resultado de Informe");   
            
            $objPHPExcel->getActiveSheet()->setTitle("OrdenesDespachadas");      
            //combinar celdas
            $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
            //titulos
            $titulo='INFORME ORDENES DESPACHADAS '.date("d/m/Y");
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', $titulo);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
            //titulos
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Orden')
            ->setCellValue('B2', 'Factura')
            ->setCellValue('C2', 'Fecha')
            ->setCellValue('D2', 'Mes');
            //negrilla
            $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
            //anchor
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);*/
        //}
        //if($objPHPExcel->setActiveSheetIndex(0)->getValue('D4'))
        $resultSQL = mssql_query("SELECT rf.Orden,rf.Factura,rf.Fecha FROM [sqlFacturas].[dbo].[facRegistroFactura] rf WHERE (YEAR(rf.Fecha)='".$anio."' AND MONTH(rf.Fecha)='".$mes."') AND rf.Carga='1' AND rf.Tipo IN ('07','S2','FD','F1','D4') group by rf.Orden,rf.Factura,rf.Fecha",$cLink);
        $j=0;
        //ultima orden pagina 0
        $f=$totalregistros+1;
        $cant=0;
        //$objPHPExcel->setActiveSheetIndex($m);
        while($resultado = mssql_fetch_array($resultSQL)){
            //$x=$objPHPExcel->getActiveSheet()->getCell('D'.$f)->getValue();
            //if($x != $mes){
                $d1=$resultado["Orden"];
                //$d2=$resultado["Factura"];
                //$d3=$resultado["Fecha"];
                //vector de ordenes
                $Odenes[$j++]=$d1;
                //$resultSQL = mssql_query("SELECT i.FechaRegistro,o.NumeroFactura,o.Orden,o.TipoFactura as Tipo,'-'+i.Item as Item,i.Descripcion,i.Cantidad FROM [sqlFacturas].[dbo].[facRegistroValidacion] o LEFT JOIN [sqlFacturas].[dbo].[facRegistroItemValidacion] i ON o.IdRegistroValidacion=i.IdRegistroValidacion WHERE o.bodega='008' AND o.TipoFactura IN ('07','S2','FD','F1','D4') AND (YEAR(o.HoraFinal)='".$anio."' AND MONTH(o.HoraFinal)='".$mes."') AND o.Orden='".$d1."'",$cLink);
               
                /*$objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$f, $d1)
                    ->setCellValue('B'.$f, $d2)
                    ->setCellValue('C'.$f, $d3)
                    ->setCellValue('D'.$f, $mes);
                       */       
              //$f++;
              $cant++;
          //}        
        }
        //vuelve a ver cuantas filas agrego
        //$totalregistros = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        //$cant=$totalregistros;
        //ITEMS
        
        
        
        $objPHPExcel->setActiveSheetIndex($m);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
        //consulta
        $j=0;
        //$cont=cout($Odenes);
        //'-'+
        $f=3;
        $Mess=array('1' => "ENERO",'2' => "FEBRERO",'3' => "MARZO",'4' => "ABRIL",'5' => "MAYO",'6' => "JUNIO",'7' => "JULIO",'8' => "AGOSTO",'9' => "SEPTIEMBRE",'10' => "OCTUBRE",'11' => "NOVIEMBRE",'12' => "DICIEMBRE");
        $objPHPExcel->setActiveSheetIndex($m)
                ->setCellValue('A1', $Mess[$m]." ".$anio);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        while($j < $cant){
            $resultSQLItems = mssql_query("SELECT i.FechaRegistro,o.NumeroFactura,o.Orden,o.TipoFactura as Tipo,' '+i.Item as Item,i.Descripcion,i.Cantidad, o.HoraFinal, et.Transportadora, et.[Destino] FROM [sqlFacturas].[dbo].[facRegistroValidacion] o LEFT JOIN [sqlFacturas].[dbo].[facRegistroItemValidacion] i ON o.IdRegistroValidacion=i.IdRegistroValidacion LEFT JOIN [sqlFacturas].[dbo].[facRegistroEtiqueta] et ON et.Orden=o.Orden WHERE o.bodega='008' AND o.TipoFactura IN ('07','S2','FD','F1','D4') AND (YEAR(o.HoraFinal)='".$anio."' AND MONTH(o.HoraFinal)='".$mes."') AND o.Orden='".$Odenes[$j]."'",$cLink);
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
                    if($d4 != ""){
                        $objPHPExcel
                             ->getActiveSheet()->getStyle('D'.$f)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);     
                    }
                    if($d5 != null){ 
                    $objPHPExcel->setActiveSheetIndex($m)
                        ->setCellValue('A'.$f, $d1) 
                        ->setCellValue('B'.$f, $d2)
                        ->setCellValue('C'.$f, $d3)
                        ->setCellValue('D'.$f, $d4)
                        ->setCellValue('E'.$f, $d5)
                        ->setCellValue('F'.$f, $d6)
                        ->setCellValue('G'.$f, $d7)
                        ->setCellValue('H'.$f, $d8)
                        ->setCellValue('I'.$f, $d9);
                    }
                    
                        
                                  
                  $f++;        
                }
            }
            $j++;
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
echo $mipath2;


?>

