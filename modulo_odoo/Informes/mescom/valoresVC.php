<?php
                    switch ($sectorLab) {
                    case 'INT':
                        //invet
                        $objWorkSheet->setCellValue('W'.$fila, $cuotaLab);
                        $objWorkSheet->setCellValue('X'.$fila, $ventaLab);
                        $TotalCuo1=$TotalCuo1+$cuotaLab;
                        $TotalLab1=$TotalLab1+$ventaLab;
                        //porcentaje
                        $P=0;
                        if($cuotaLab > 0){
                            $P=round(($ventaLab/$cuotaLab)*100);
                        }
                        $objWorkSheet->setCellValue('Y'.$fila, $P."%");
                        $objPHPExcel->getActiveSheet()->getStyle('Y'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        break;
                    case 'ICO':
                        //icofarma
                        $objWorkSheet->setCellValue('Z'.$fila, $cuotaLab);
                        $objWorkSheet->setCellValue('AA'.$fila, $ventaLab);
                        $TotalCuo2=$TotalCuo2+$cuotaLab;
                        $TotalLab2=$TotalLab2+$ventaLab;
                        //porcentaje
                        $P=0;
                        if($cuotaLab > 0){
                            $P=round(($ventaLab/$cuotaLab)*100);
                        }
                        $objWorkSheet->setCellValue('AB'.$fila, $P."%");
                        $objPHPExcel->getActiveSheet()->getStyle('AB'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        break;
                    case 'COMERVET':
                        $objWorkSheet->setCellValue('AC'.$fila, $cuotaLab);
                        $objWorkSheet->setCellValue('AD'.$fila, $ventaLab);
                        $TotalCuo3=$TotalCuo3+$cuotaLab;
                        $TotalLab3=$TotalLab3+$ventaLab;
                        //porcentaje
                        $P=0;
                        if($cuotaLab > 0){
                            $P=round(($ventaLab/$cuotaLab)*100);
                        }
                        $objWorkSheet->setCellValue('AE'.$fila, $P."%");
                        $objPHPExcel->getActiveSheet()->getStyle('AE'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        break;
                    case 'HOL':
                        //gabrica
                        $objWorkSheet->setCellValue('AI'.$fila, $cuotaLab);
                        $objWorkSheet->setCellValue('AJ'.$fila, $ventaLab);
                        $TotalCuo4=$TotalCuo4+$cuotaLab;
                        $TotalLab4=$TotalLab4+$ventaLab;
                        //porcentaje
                        $P=0;
                        if($cuotaLab > 0){
                            $P=round(($ventaLab/$cuotaLab)*100);
                        }
                        $objWorkSheet->setCellValue('AK'.$fila, $P."%");
                        $objPHPExcel->getActiveSheet()->getStyle('AK'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        break;
                    case 'BIS':
                        //biostar
                        $objWorkSheet->setCellValue('AL'.$fila, $cuotaLab);
                        $objWorkSheet->setCellValue('AM'.$fila, $ventaLab);
                        $TotalCuo5=$TotalCuo5+$cuotaLab;
                        $TotalLab5=$TotalLab5+$ventaLab;
                        //porcentaje
                        $P=0;
                        if($cuotaLab > 0){
                            $P=round(($ventaLab/$cuotaLab)*100);
                        }
                        $objWorkSheet->setCellValue('AN'.$fila, $P."%");
                        $objPHPExcel->getActiveSheet()->getStyle('AN'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        break;
                    case 'CPH':
                        //cohasfarma
                        $objWorkSheet->setCellValue('AR'.$fila, $cuotaLab);
                        $objWorkSheet->setCellValue('AS'.$fila, $ventaLab);
                        $TotalCuo6=$TotalCuo6+$cuotaLab;
                        $TotalLab6=$TotalLab6+$ventaLab;
                        //porcentaje
                        $P=0;
                        if($cuotaLab > 0){
                            $P=round(($ventaLab/$cuotaLab)*100);
                        }
                        $objWorkSheet->setCellValue('AT'.$fila, $P."%");
                        $objPHPExcel->getActiveSheet()->getStyle('AT'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        break;
                    case 'IMPORTADOS':
                        $objWorkSheet->setCellValue('AU'.$fila, $cuotaLab);
                        $objWorkSheet->setCellValue('AV'.$fila, $ventaLab);
                        $TotalCuo7=$TotalCuo7+$cuotaLab;
                        $TotalLab7=$TotalLab7+$ventaLab;
                        //porcentaje
                        $P=0;
                        if($cuotaLab > 0){
                            $P=round(($ventaLab/$cuotaLab)*100);
                        }
                        $objWorkSheet->setCellValue('AW'.$fila, $P."%");
                        $objPHPExcel->getActiveSheet()->getStyle('AW'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        break;
                    case 'INTERVET MSD':
                        $objWorkSheet->setCellValue('AX'.$fila, $cuotaLab);
                        $objWorkSheet->setCellValue('AY'.$fila, $ventaLab);
                        $TotalCuo8=$TotalCuo8+$cuotaLab;
                        $TotalLab8=$TotalLab8+$ventaLab;
                        //porcentaje
                        $P=0;
                        if($cuotaLab > 0){
                            $P=round(($ventaLab/$cuotaLab)*100);
                        }
                        $objWorkSheet->setCellValue('AZ'.$fila, $P."%");
                        $objPHPExcel->getActiveSheet()->getStyle('AZ'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        break;
                    case 'TEC':
                        //tecnocalidad
                        $objWorkSheet->setCellValue('BM'.$fila, $cuotaLab);
                        $objWorkSheet->setCellValue('BN'.$fila, $ventaLab);
                        $TotalCuo9=$TotalCuo9+$cuotaLab;
                        $TotalLab9=$TotalLab9+$ventaLab;
                        //porcentaje
                        $P=0;
                        if($cuotaLab > 0){
                            $P=round(($ventaLab/$cuotaLab)*100);
                        }
                        $objWorkSheet->setCellValue('BO'.$fila, $P."%");
                        $objPHPExcel->getActiveSheet()->getStyle('BO'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        break;
                    case 'AGI':
                        //Línea Agil
                        $objWorkSheet->setCellValue('BD'.$fila, $cuotaLab);
                        $objWorkSheet->setCellValue('BE'.$fila, $ventaLab);
                        $TotalCuo10=$TotalCuo10+$cuotaLab;
                        $TotalLab10=$TotalLab10+$ventaLab;
                        //porcentaje
                        $P=0;
                        if($cuotaLab > 0){
                            $P=round(($ventaLab/$cuotaLab)*100);
                        }
                        $objWorkSheet->setCellValue('BF'.$fila, $P."%");
                        $objPHPExcel->getActiveSheet()->getStyle('BF'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        break;
                    case 'AMI':
                        //LINEA AGIL IMPORTADOS
                        $objWorkSheet->setCellValue('BG'.$fila, $cuotaLab);
                        $objWorkSheet->setCellValue('BH'.$fila, $ventaLab);
                        $TotalCuo11=$TotalCuo11+$cuotaLab;
                        $TotalLab11=$TotalLab11+$ventaLab;
                        //porcentaje
                        $P=0;
                        if($cuotaLab > 0){
                            $P=round(($ventaLab/$cuotaLab)*100);
                        }
                        $objWorkSheet->setCellValue('BI'.$fila, $P."%");
                        $objPHPExcel->getActiveSheet()->getStyle('BI'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        break;
                    case 'BAI':
                        //LABORATORIOS BAI
                        $objWorkSheet->setCellValue('BJ'.$fila, $cuotaLab);
                        $objWorkSheet->setCellValue('BK'.$fila, $ventaLab);
                        $TotalCuo12=$TotalCuo12+$cuotaLab;
                        $TotalLab12=$TotalLab12+$ventaLab;
                        //porcentaje
                        $P=0;
                        if($cuotaLab > 0){
                            $P=round(($ventaLab/$cuotaLab)*100);
                        }
                        $objWorkSheet->setCellValue('BL'.$fila, $P."%");
                        $objPHPExcel->getActiveSheet()->getStyle('BL'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        break;
                    case 'AGROQUIMICOS / VENENOS':
                        $objWorkSheet->setCellValue('T'.$fila, $cuotaLab);
                        $objWorkSheet->setCellValue('U'.$fila, $ventaLab);
                        $TotalCuo13=$TotalCuo13+$cuotaLab;
                        $TotalLab13=$TotalLab13+$ventaLab;
                        //porcentaje
                        $P=0;
                        if($cuotaLab > 0){
                            $P=round(($ventaLab/$cuotaLab)*100);
                        }
                        $objWorkSheet->setCellValue('V'.$fila, $P."%");
                        $objPHPExcel->getActiveSheet()->getStyle('V'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        break;
                    case 'MEDICAMENTOS':
                        $objWorkSheet->setCellValue('Q'.$fila, $cuotaLab);
                        $objWorkSheet->setCellValue('R'.$fila, $ventaLab);
                        $TotalCuo14=$TotalCuo14+$cuotaLab;
                        $TotalLab14 = $TotalLab14 + $ventaLab;
                        //porcentaje
                        $P=0;
                        if($cuotaLab > 0){
                            $P=round(($ventaLab/$cuotaLab)*100);
                        }
                        $objWorkSheet->setCellValue('S'.$fila, $P."%");
                        $objPHPExcel->getActiveSheet()->getStyle('S'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        break;
                    case 'MASCOTAS':
                        $objWorkSheet->setCellValue('N'.$fila, $cuotaLab);
                        $objWorkSheet->setCellValue('O'.$fila, $ventaLab);
                        $TotalCuo15=$TotalCuo15+$cuotaLab;
                        $TotalLab15=$TotalLab15+$ventaLab;
                        //porcentaje
                        $P=0;
                        if($cuotaLab > 0){
                            $P=round(($ventaLab/$cuotaLab)*100);
                        }
                        $objWorkSheet->setCellValue('P'.$fila, $P."%");
                        $objPHPExcel->getActiveSheet()->getStyle('P'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        break;
                    case 'CONCENTRADOS':
                        $objWorkSheet->setCellValue('K'.$fila, $cuotaLab);
                        $objWorkSheet->setCellValue('L'.$fila, $ventaLab);
                        $TotalCuo16=$TotalCuo16+$cuotaLab;
                        $TotalLab16=$TotalLab16+$ventaLab;
                        //porcentaje
                        $P=0;
                        if($cuotaLab > 0){
                            $P=round(($ventaLab/$cuotaLab)*100);
                        }
                        $objWorkSheet->setCellValue('M'.$fila, $P."%");
                        $objPHPExcel->getActiveSheet()->getStyle('M'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        break;
                    case 'VARIOS':
                        $objWorkSheet->setCellValue('H'.$fila, $cuotaLab);
                        $objWorkSheet->setCellValue('I'.$fila, $ventaLab);
                        $TotalCuo17=$TotalCuo17+$cuotaLab;
                        $TotalLab17=$TotalLab17+$ventaLab;
                        //echo "</br>aqui:".$vend."---".$TotalLab17;
                        //porcentaje
                        $P=0;
                        if($cuotaLab > 0){
                            $P=round(($ventaLab/$cuotaLab)*100);
                        }
                        $objWorkSheet->setCellValue('J'.$fila, $P."%");
                        $objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        break;
                    case 'FERRETERIA':
                        $objWorkSheet->setCellValue('E'.$fila, $cuotaLab);
                        $objWorkSheet->setCellValue('F'.$fila, $ventaLab);
                        $TotalCuo18=$TotalCuo18+$cuotaLab;
                        $TotalLab18=$TotalLab18+$ventaLab;
                        //porcentaje
                        $P=0;
                        if($cuotaLab > 0){
                            $P=round(($ventaLab/$cuotaLab)*100);
                        }
                        $objWorkSheet->setCellValue('G'.$fila, $P."%");
                        $objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        break;
                    }
?>