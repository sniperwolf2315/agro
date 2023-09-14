<?php
include('conectarbase.php');
            //consulta el usuario
            //$d5=$_POST['refer'];
            //$d3=$_POST['fechai'];
            //$d4=$_POST['fechaf'];
            function cellColor($cells,$color){
               global $objPHPExcel;
        
               $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
                   'type' => PHPExcel_Style_Fill::FILL_SOLID,
                   'startcolor' => array(
                        'rgb' => $color
                   )
                 ));
            }
            //$resultado = $mysqli->query("SELECT * FROM inventario_general WHERE (fecha_in >= '$d3' && fecha_in <= '$d4') || num_orden='$d5' ORDER BY num_orden ASC");
            //$query2 = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infVentaSinIvaIbs]");
            $query2 = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[MinAgriculturaInforme]");
            if($resultado = mssql_fetch_array($query2)){
                
                //$numero = $resultado->num_rows;
                //if($resultado){
                
                //path
                //$fecha=date("d_m_Y");
                $fecha=date('M', strtotime('-1 month')).date('Y');
                //$miruta='/var/www/html/modulo_plan/infventasiniva/';
                $miruta='/var/www/html/modulo_plan/infminagricultura/';
                $nombre_fichero = 'Informe_MinAgricultura_'.$fecha;
                $mipath=$miruta.'/'.$nombre_fichero.'.xlsx';
                
                if(file_exists($miruta)) {
                    //Obteniendo el dato desde la celda:
                    //Para conseguir resultado usar la función getCalculatedValue() en reemplazo de getValue(
                    //$dato=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(x,y)->getValue();
                    
                    //*************************creando nuevo*****************************************
                    include('Classes/PHPExcel.php');
                    include('Classes/PHPExcel/Reader/Excel2007.php');
                    //Crear el objeto Excel: 
                    $objPHPExcel = new PHPExcel();
                    //Configurando el archivo: 
                    $objPHPExcel->getProperties()->setCreator("Autor: IngJairo");
                    $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo");
                    $objPHPExcel->getProperties()->setTitle("Informe de Productos sin iva");
                    $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
                    $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
                    $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
                    $objPHPExcel->getProperties()->setCategory("Resultado de Informe");
                    //Seleccionamos la hoja sobre la que queremos escribir 
                    //combinar celdas
                    $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
                    
                    cellColor('A1:I1', 'EAE27A');
                    //titulos 
                    $titulo='INFORME MINAGRICULTURA: AGROCAMPO '.$fecha;
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A1', $titulo);
                    //Alineacion
                    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    
                    // Color rojo al texto
                    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                   
                    //$objPHPExcel->getActiveSheet()->getStyle('A2')->getFill()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
                    //negilla
                    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                    //titulos
                    $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A2', 'FANNY RODROGUEZ');
                                
                    $objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
                    $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    cellColor('A2', 'D4EE8C');
                    cellColor('B2', 'D4EE8C');
                    cellColor('C2', 'D4EE8C');
                    cellColor('D2', 'D4EE8C');
                    cellColor('E2', 'D4EE8C');
                    cellColor('F2', 'D4EE8C');
                    cellColor('G2', 'D4EE8C');
                    cellColor('H2', 'D4EE8C');
                    cellColor('I2', 'D4EE8C');
                    //$objPHPExcel->getActiveSheet()->getStyle('A2')->getFill()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
                    
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A3', 'ITEM')
                            ->setCellValue('B3', 'MANEJADOR')
		                    ->setCellValue('C3', 'INV FINAL')
                            ->setCellValue('D3', 'CANT VEND')
                            ->setCellValue('E3', 'PROM VENTA')
		                    ->setCellValue('F3', '')
                            ->setCellValue('G3', 'INV FINAL')
                            ->setCellValue('H3', 'CANT VEND')
		                    ->setCellValue('I3', 'PROM VENTA');
                    $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('H3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('I3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    cellColor('A3', 'BAD17B');
                    cellColor('B3', 'BAD17B');
                    cellColor('C3', 'BAD17B');
                    cellColor('D3', 'BAD17B');
                    cellColor('E3', 'BAD17B');
                    cellColor('F3', 'BAD17B');
                    cellColor('G3', 'BAD17B');
                    cellColor('H3', 'BAD17B');
                    cellColor('I3', 'BAD17B');
                    
                    $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('D4', 'ALMACEN');
                    $objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    cellColor('C4', '7BC3D1');
                    cellColor('D4', '7BC3D1');
                    cellColor('E4', '7BC3D1');     
                                
                    $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('H4', 'PORTOS');  
                    $objPHPExcel->getActiveSheet()->getStyle('H4')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    cellColor('G4', '7BC3D1');
                    cellColor('H4', '7BC3D1');
                    cellColor('I4', '7BC3D1');
                    //negilla
                    $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setBold(true);
                    
                    //ANCHOR
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
                   
                    //$objPHPExcel->getActiveSheet()->getDimension('1')->setHeight(20);
                    //renombre de la hoja
                    $objPHPExcel->getActiveSheet()->setTitle("Informe MinAgricultura");
                    //datos
                    $f=5;
                    $C=0;
                    
                    /*
                    if($d2=='PINILLOSM' && $C==0){
                            //if($C==0){
                                ////$objPHPExcel->getActiveSheet()->mergeCells('A'.$f.':'.'I'.$f);
                                //$objPHPExcel->setActiveSheetIndex(0)
                                //          ->setCellValue('A'.$f, 'MARTA PINILLOS');
                                $datosf73[$f]='MARTA PINILLOS';
                                  
                                //$objPHPExcel->getActiveSheet()->getStyle('A'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);          
                                //$objPHPExcel->getActiveSheet()->getStyle('A'.$f)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                                $f++;
                                /*$objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('A'.$f, $d1)
                                    ->setCellValue('B'.$f, $d2);*/
                                /*$datosf73[$f]='$d1';
                                $C++;
                            }else{*/
                                /*$objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('A'.$f, $d1)
                                    ->setCellValue('B'.$f, $d2);*/
                                /*$datosf73[$f]='$d1';
                            }*/
                    
                    $datosf73=new ArrayIterator();
                    //$datosf80=new ArrayIterator();
                    $datosm73=new ArrayIterator();
                    
                    //pinta los items   DISTINCT([Item]), Manejador
                    $f1=0;
                    $f2=0;
                    $f3=0;
                    $C=0;
                    //llena vectores
                    $queryItem = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[MinAgriculturaInforme] order by Manejador desc");
                    while($row = mssql_fetch_array($queryItem)){
                            $d1=$row['Item'];   //item
                            $d1=trim($d1);
                            $d2=$row['Manejador'];
                            $d3=$row['Bodega'];
                            $d4=$row['InvFinal'];    
                            $d5=$row['CantVendida'];    
                            $d6=$row['PromVenta'];
                            if($d2=='RODRIGUEZF' && $d3=='005'){
                                
                                    $datosf73[$f1]=$d1;
                                    $f1++;
                                
                            }
                            if($d2=='PINILLOSM' && $d3=='005'){
                                
                                    $datosm73[$f3]=$d1;
                                    $f3++;
                                
                            }
                                         
                    }
                    
                  
                    $tama1=count($datosf73);
                    //$tama2=count($datosf80);
                    $tama3=count($datosm73);
                    
                    //fanny005
                    $fila=0;
                    $C2=0;
                    $f=5;
                    while($fila < $tama1){
                        $item=$datosf73[$fila];
                        //query
                        $queryItem = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[MinAgriculturaInforme] WHERE Item='".$item."'");
                        while($row = mssql_fetch_array($queryItem)){
                            $d1=$row['Item'];   
                            $d1=trim($d1);
                            $d2=$row['Manejador'];
                            $d3=$row['Bodega'];
                            $d4=$row['InvFinal'];    
                            $d5=$row['CantVendida'];    
                            $d6=$row['PromVenta'];
                            if($d3=='005'){
                                $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A'.$f, $d1)
                                ->setCellValue('B'.$f, $d2)
		                        ->setCellValue('C'.$f, $d4)
		                        ->setCellValue('D'.$f, $d5)
                                ->setCellValue('E'.$f, $d6);
                                $C2++;
                            } else if($d3=='008'){
                                $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A'.$f, $d1)
                                ->setCellValue('B'.$f, $d2)
		                        ->setCellValue('G'.$f, $d4)
		                        ->setCellValue('H'.$f, $d5)
                                ->setCellValue('I'.$f, $d6);
                                $C2++;
                            }
                            if($C2==2){
                                $f++;
                                $C2=0;
                            }   
                        }    
                        //fila general
                        $fila++;
                    } //fin while
                    
                      //marta pinillos 005
                      $objPHPExcel->getActiveSheet()->mergeCells('A'.$f.':'.'I'.$f);
                      $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A'.$f, 'MARTA PINILLOS');
                      
                      $objPHPExcel->getActiveSheet()->getStyle('A'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);          
                      $objPHPExcel->getActiveSheet()->getStyle('A'.$f)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                      cellColor('A'.$f, 'D4EE8C');
                      cellColor('B'.$f, 'D4EE8C');
                      cellColor('C'.$f, 'D4EE8C');
                      cellColor('D'.$f, 'D4EE8C');
                      cellColor('E'.$f, 'D4EE8C');
                      cellColor('F'.$f, 'D4EE8C');
                      cellColor('G'.$f, 'D4EE8C');
                      cellColor('H'.$f, 'D4EE8C');
                      cellColor('I'.$f, 'D4EE8C');
                      $f++;
                    
                    $fila=0;
                    while($fila < $tama3){
                        $item=$datosm73[$fila];
                        //query
                        $queryItem = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[MinAgriculturaInforme] WHERE Item='".$item."' AND Bodega='005'");
                        while($row = mssql_fetch_array($queryItem)){
                            $d1=$row['Item'];   
                            $d1=trim($d1);
                            $d2=$row['Manejador'];
                            $d3=$row['Bodega'];
                            $d4=$row['InvFinal'];    
                            $d5=$row['CantVendida'];    
                            $d6=$row['PromVenta'];
                            if($d3=='005'){
                                $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A'.$f, $d1)
                                ->setCellValue('B'.$f, $d2)
		                        ->setCellValue('C'.$f, $d4)
		                        ->setCellValue('D'.$f, $d5)
                                ->setCellValue('E'.$f, $d6);
                            } 
                            $f++;   
                        }    
                        //fila general
                        $fila++;
                    } //fin while
                    
         
                    //***************guarda
                    //crear objeto writer
                    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
                    //Guardar el achivo: 
                    $objWriter->save($mipath);
                    //echo "<br /><br />";
                    $descarga=$nombre_fichero.".xlsx";
                    //echo "<a href=\"http://www.funddreams.co/Informes/$descarga\"><h3>Descargar Informe</h3></a>";
                    //echo "<a href=\"informes/$descarga\"><h3>Descargar Informe</h3></a>";
                    echo $descarga;
                    //echo $datosf73[0]."--".$datosf80[0]."--".$datosm73[0];
                    //echo $tama1."--".$tama2."--".$tama3;
                    //echo("<script language='JavaScript'>verLink('$descarga');alert('Informe generado correctamente. Puede descargarlo mediante el link');</script>");
                }//fin si exists
                
        //}//fin si
}
mssql_close();

?>