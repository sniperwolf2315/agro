<?php
include('conectarbase.php');
            //consulta el usuario
            //$d5=$_POST['refer'];
            //$d3=$_POST['fechai'];
            //$d4=$_POST['fechaf'];
            
            //$resultado = $mysqli->query("SELECT * FROM inventario_general WHERE (fecha_in >= '$d3' && fecha_in <= '$d4') || num_orden='$d5' ORDER BY num_orden ASC");
            $query2 = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infVentaSinIvaIbs]");
            if($resultado = mssql_fetch_array($query2)){
                
                //$numero = $resultado->num_rows;
                if($resultado){
                
                //path
                //$fecha=date("d_m_Y");
                $fecha=date('M', strtotime('-1 month')).date('Y');
                //$miruta='/var/www/html/modulo_plan/infventasiniva/';
                $miruta='/var/www/html/modulo_plan/infventasiniva/';
                $nombre_fichero = 'Ventasiniva_'.$fecha;
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
                    $objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
                    //titulos
                    $titulo='INFORME DE VENTAS SIN IVA: AGROCAMPO '.$fecha;
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
                    
                    // Color rojo al texto
                    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                   
                    //$objPHPExcel->getActiveSheet()->getStyle('A2')->getFill()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
                    //negilla
                    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                    //titulos
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A2', 'ITEM')
                            ->setCellValue('B2', 'DESCRIPCION')
		                    ->setCellValue('C2', 'FACTURA')
                            ->setCellValue('D2', 'FECHA')
                            ->setCellValue('E2', 'CANTIDAD')
		                    ->setCellValue('F2', 'VLR_EXC_IVA');
                            
                    //negilla
                    $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
                    
                    //ANCHOR
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                   
                    //$objPHPExcel->getActiveSheet()->getDimension('1')->setHeight(20);
                    //renombre de la hoja
                    $objPHPExcel->getActiveSheet()->setTitle("Informe Ventas sin Iva");
                    //datos
                    $f=3;
                    $query3 = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infVentaSinIvaIbs]");
                    
                    while($row = mssql_fetch_array($query3)){
                           
                            $d1=$row['ITEM'];   //item
                            $d2=utf8_encode($row['DESCRIP']);   //desecrip
                            $d3=$row['FACTURA'];   //factura
                            $d4=$row['FECHA'];    //fecha
                            $d5=$row['CANTIDAD'];    //cantidad
                            $d6=$row['VLR_EXC_IVA'];    //valor-ex-iva
                           
                                $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A'.$f, $d1)
                                ->setCellValue('B'.$f, $d2)
		                        ->setCellValue('C'.$f, $d3)
		                        ->setCellValue('D'.$f, $d4)
                                ->setCellValue('E'.$f, $d5)
		                        ->setCellValue('F'.$f, $d6);
                                
                        //Alineacion
                        $objPHPExcel->getActiveSheet()->getStyle('A'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('B'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('C'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('D'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('E'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('F'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        //$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize('true');
                        $f++;
                        //}	
                    }   //fin while
                    
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
                    //echo("<script language='JavaScript'>verLink('$descarga');alert('Informe generado correctamente. Puede descargarlo mediante el link');</script>");
                }//fin si exists
                
        }//fin si
}
mssql_close();

?>