<?php
                        switch ($sectorLab) {
                                case 'INT':
                                    //INVET
                                    $objWorkSheet->setCellValue('W'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('X'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('X'.$filaY, $ventaObj);
                                    if($ventaInd=='-' || $ventaInd=='' || $ventaInd==null){$ventaInd='0';}
                                    if($ventaObj=='-' || $ventaObj=='' || $ventaInd==null){$ventaObj='0';}
                                    $TotalLab1=$ventaInd+$ventaObj;
                                    //porcentaje individual $TotalLab2
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($ventaInd/$cuotaLab)*100);
                                        //$TotalTCuo7=$TotalTCuo7+$cuotaLab;
                                    }
                                    $objWorkSheet->setCellValue('Y'.$filaX, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('Y'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    //subtotales
                                    $objWorkSheet->setCellValue('W'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('X'.$fila, $TotalLab1);
                                                                      
                                    //porcentaje total
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($TotalLab1/$cuotaLab)*100);
                                    }
                                    $objWorkSheet->setCellValue('Y'.$fila, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('Y'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    break;
                                case 'ICO':
                                    //ICOFARMA
                                    $objWorkSheet->setCellValue('Z'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AA'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('AA'.$filaY, $ventaObj);
                                    if($ventaInd=='-' || $ventaInd=='' || $ventaInd==null){$ventaInd='0';}
                                    if($ventaObj=='-' || $ventaObj=='' || $ventaInd==null){$ventaObj='0';}
                                    $TotalLab1=$ventaInd+$ventaObj;
                                    //porcentaje individual
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($ventaInd/$cuotaLab)*100);
                                        //$TotalTCuo8=$TotalTCuo8+$cuotaLab;
                                        
                                    }
                                    
                                    $objWorkSheet->setCellValue('AB'.$filaX, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('AB'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    //subtotales
                                    $objWorkSheet->setCellValue('Z'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('AA'.$fila, $TotalLab1);
                                    
                                    /*$arrayVend[$x]= $vend;
                                    $arrayLabs[$x]= $TotalLab1;
                                    $x++;
                                    echo $vend."---".$sectorLab."---".$TotalLab1."</br>";*/
                                    //TOTAL LABORATORIOS
                                    //$TotalTLab8=$TotalTLab8+$TotalLab2;
                                    
                                    //porcentaje total
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($TotalLab1/$cuotaLab)*100);
                                    }
                                    $objWorkSheet->setCellValue('AB'.$fila, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('AB'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    break;
                                case 'COMERVET':
                                    $objWorkSheet->setCellValue('AC'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AD'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('AD'.$filaY, $ventaObj);
                                    if($ventaInd=='-' || $ventaInd=='' || $ventaInd==null){$ventaInd='0';}
                                    if($ventaObj=='-' || $ventaObj=='' || $ventaInd==null){$ventaObj='0';}
                                    $TotalLab1=$ventaInd+$ventaObj;
                                    //porcentaje
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($ventaInd/$cuotaLab)*100);
                                        //$TotalTCuo9=$TotalTCuo9+$cuotaLab;
                                    }
                                    $objWorkSheet->setCellValue('AE'.$filaX, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('AE'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    //subtotales
                                    $objWorkSheet->setCellValue('AC'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('AD'.$fila, $TotalLab1);
                                    
                                    /*$arrayVend[$x]= $vend;
                                    $arrayLabs[$x]= $TotalLab1;
                                    $x++;
                                    echo $vend."---".$sectorLab."---".$TotalLab1."</br>";*/
                                    //TOTAL CALL LABORATORIOS
                                    //$TotalTLab9=$TotalTLab9+$TotalLab1;
                                    //porcentaje total
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($TotalLab1/$cuotaLab)*100);
                                    }
                                    $objWorkSheet->setCellValue('AE'.$fila, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('AE'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    break;
                                case 'HOL':
                                    //GABRICA
                                    $objWorkSheet->setCellValue('AI'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AJ'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('AJ'.$filaY, $ventaObj);
                                    if($ventaInd=='-' || $ventaInd=='' || $ventaInd==null){$ventaInd='0';}
                                    if($ventaObj=='-' || $ventaObj=='' || $ventaInd==null){$ventaObj='0';}
                                    $TotalLab1=$ventaInd+$ventaObj;
                                    //porcentaje
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($ventaInd/$cuotaLab)*100);
                                        //$TotalTCuo10=$TotalTCuo10+$cuotaLab;
                                    }
                                    $objWorkSheet->setCellValue('AK'.$filaX, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('AK'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    //subtotales
                                    $objWorkSheet->setCellValue('AI'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('AJ'.$fila, $TotalLab1);
                                    
                                    /*$arrayVend[$x]= $vend;
                                    $arrayLabs[$x]= $TotalLab1;
                                    $x++;
                                    echo $vend."---".$sectorLab."---".$TotalLab1."</br>";*/
                                    //TOTAL CALL LABORATORIOS
                                    //$TotalTLab10=$TotalTLab10+$TotalLab1;
                                    //porcentaje total
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($TotalLab1/$cuotaLab)*100);
                                    }
                                    $objWorkSheet->setCellValue('AK'.$fila, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('AK'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    break;
                                case 'BIS':
                                    //BIOSTAR
                                    $objWorkSheet->setCellValue('AL'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AM'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('AM'.$filaY, $ventaObj);
                                    if($ventaInd=='-' || $ventaInd=='' || $ventaInd==null){$ventaInd='0';}
                                    if($ventaObj=='-' || $ventaObj=='' || $ventaInd==null){$ventaObj='0';}
                                    $TotalLab1=$ventaInd+$ventaObj;
                                    //porcentaje
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($ventaInd/$cuotaLab)*100);
                                        //$TotalTCuo11=$TotalTCuo11+$cuotaLab;
                                    }
                                    $objWorkSheet->setCellValue('AN'.$filaX, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('AN'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    //subtotales
                                    $objWorkSheet->setCellValue('AL'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('AM'.$fila, $TotalLab1);
                                    
                                    /*$arrayVend[$x]= $vend;
                                    $arrayLabs[$x]= $TotalLab1;
                                    $x++;
                                    echo $vend."---".$sectorLab."---".$TotalLab1."</br>";*/
                                    //TOTAL CALL LABORATORIOS
                                    //$TotalTLab11=$TotalTLab11+$TotalLab1;
                                    //porcentaje total
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($TotalLab1/$cuotaLab)*100);
                                    }
                                    $objWorkSheet->setCellValue('AN'.$fila, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('AN'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    break;
                                case 'CPH':
                                    //COHASFARMA
                                    $objWorkSheet->setCellValue('AR'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AS'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('AS'.$filaY, $ventaObj);
                                    if($ventaInd=='-' || $ventaInd=='' || $ventaInd==null){$ventaInd='0';}
                                    if($ventaObj=='-' || $ventaObj=='' || $ventaInd==null){$ventaObj='0';}
                                    $TotalLab1=$ventaInd+$ventaObj;
                                    //porcentaje
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($ventaInd/$cuotaLab)*100);
                                        //$TotalTCuo12=$TotalTCuo12+$cuotaLab;
                                    }
                                    $objWorkSheet->setCellValue('AT'.$filaX, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('AT'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    //subtotales
                                    $objWorkSheet->setCellValue('AR'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('AS'.$fila, $TotalLab1);
                                    
                                    /*$arrayVend[$x]= $vend;
                                    $arrayLabs[$x]= $TotalLab1;
                                    $x++;
                                    echo $vend."---".$sectorLab."---".$TotalLab1."</br>";*/
                                    //TOTAL CALL LABORATORIOS
                                    //$TotalTLab12=$TotalTLab12+$TotalLab1;
                                    //porcentaje total
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($TotalLab1/$cuotaLab)*100);
                                    }
                                    $objWorkSheet->setCellValue('AT'.$fila, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('AT'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    break;
                                case 'IMPORTADOS':
                                    $objWorkSheet->setCellValue('AU'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AV'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('AV'.$filaY, $ventaObj);
                                    if($ventaInd=='-' || $ventaInd=='' || $ventaInd==null){$ventaInd='0';}
                                    if($ventaObj=='-' || $ventaObj=='' || $ventaInd==null){$ventaObj='0';}
                                                                        
                                    $TotalLab1=$ventaInd;//+$ventaObj;
                                    //porcentaje
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($ventaInd/$cuotaLab)*100);
                                        //$TotalTCuo13=$TotalTCuo13+$cuotaLab;
                                    }
                                    $objWorkSheet->setCellValue('AW'.$filaX, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('AW'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    //subtotales
                                    $objWorkSheet->setCellValue('AU'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('AV'.$fila, $TotalLab1);
                                    
                                    /*$arrayVend[$x]= $vend;
                                    $arrayLabs[$x]= $TotalLab1;
                                    $x++;
                                    echo $vend."---".$sectorLab."---".$TotalLab1."</br>";*/
                                    //TOTAL CALL LABORATORIOS
                                    //$TotalTLab13=$TotalTLab13+$TotalLab1;
                                    //porcentaje total
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($TotalLab1/$cuotaLab)*100);
                                    }
                                    $objWorkSheet->setCellValue('AW'.$fila, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('AW'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    break;
                                case 'INTERVET MSD':
                                    $objWorkSheet->setCellValue('AX'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('AY'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('AY'.$filaY, $ventaObj);
                                    if($ventaInd=='-' || $ventaInd=='' || $ventaInd==null){$ventaInd='0';}
                                    if($ventaObj=='-' || $ventaObj=='' || $ventaInd==null){$ventaObj='0';}
                                    $TotalLab1=$ventaInd+$ventaObj;
                                    //porcentaje
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($ventaInd/$cuotaLab)*100);
                                        //$TotalTCuo14=$TotalTCuo14+$cuotaLab;
                                    }
                                    $objWorkSheet->setCellValue('AZ'.$filaX, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('AZ'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    //subtotales
                                    $objWorkSheet->setCellValue('AX'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('AY'.$fila, $TotalLab1);
                                    
                                    /*$arrayVend[$x]= $vend;
                                    $arrayLabs[$x]= $TotalLab1;
                                    $x++;
                                    echo $vend."---".$sectorLab."---".$TotalLab1."</br>";*/
                                    //TOTAL CALL LABORATORIOS
                                    //$TotalTLab14=$TotalTLab14+$TotalLab1;
                                    //echo $vend.",".$ventaInd.",".$ventaObj.",".$TotalLab1.",".$TotalTLab14."</br>";
                                    //porcentaje total
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($TotalLab1/$cuotaLab)*100);
                                    }
                                    $objWorkSheet->setCellValue('AZ'.$fila, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('AZ'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    break;
                                case 'TEC':
                                    $objWorkSheet->setCellValue('BM'.$filaX, $cuotaLab);
                                    $objWorkSheet->setCellValue('BN'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('BN'.$filaY, $ventaObj);
                                    if($ventaInd=='-' || $ventaInd=='' || $ventaInd==null){$ventaInd='0';}
                                    if($ventaObj=='-' || $ventaObj=='' || $ventaInd==null){$ventaObj='0';}
                                    $TotalLab1=$ventaInd+$ventaObj;
                                    //porcentaje
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($ventaInd/$cuotaLab)*100);
                                        //$TotalTCuo18=$TotalTCuo18+$cuotaLab;
                                    }
                                    $objWorkSheet->setCellValue('BO'.$filaX, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('BO'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    //subtotales
                                    $objWorkSheet->setCellValue('BM'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('BN'.$fila, $TotalLab1);
                                    
                                    /*$arrayVend[$x]= $vend;
                                    $arrayLabs[$x]= $TotalLab1;
                                    $x++;
                                    echo $vend."---".$sectorLab."---".$TotalLab1."</br>";*/
                                    //TOTAL CALL LABORATORIOS
                                    //$TotalTLab18=$TotalTLab18+$TotalLab1;
                                    //porcentaje total
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($TotalLab1/$cuotaLab)*100);
                                    }
                                    $objWorkSheet->setCellValue('BO'.$fila, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('BO'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    break;
                                case 'AGI':
                                    //LINEA AGIL
                                    $objWorkSheet->setCellValue('BD'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('BE'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('BE'.$filaY, $ventaObj);
                                    if($ventaInd=='-' || $ventaInd=='' || $ventaInd==null){$ventaInd='0';}
                                    if($ventaObj=='-' || $ventaObj=='' || $ventaInd==null){$ventaObj='0';}
                                    $TotalLab1=$ventaInd+$ventaObj;
                                    //porcentaje
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($ventaInd/$cuotaLab)*100);
                                        //$TotalTCuo15=$TotalTCuo15+$cuotaLab;
                                    }
                                    $objWorkSheet->setCellValue('BF'.$filaX, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('BF'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    //subtotales
                                    $objWorkSheet->setCellValue('BD'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('BE'.$fila, $TotalLab1);
                                    
                                    /*$arrayVend[$x]= $vend;
                                    $arrayLabs[$x]= $TotalLab1;
                                    $x++;
                                    echo $vend."---".$sectorLab."---".$TotalLab1."</br>";*/
                                    //TOTAL CALL LABORATORIOS
                                    //$TotalTLab15=$TotalTLab15+$TotalLab1;
                                    //porcentaje total
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($TotalLab1/$cuotaLab)*100);
                                    }
                                    $objWorkSheet->setCellValue('BF'.$fila, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('BF'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    break;
                                case 'AMI':
                                    //LINEA AGIL IMPORTADOS
                                    $objWorkSheet->setCellValue('BG'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('BH'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('BH'.$filaY, $ventaObj);
                                    if($ventaInd=='-' || $ventaInd=='' || $ventaInd==null){$ventaInd='0';}
                                    if($ventaObj=='-' || $ventaObj=='' || $ventaInd==null){$ventaObj='0';}
                                    $TotalLab1=$ventaInd+$ventaObj;
                                    //porcentaje
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($ventaInd/$cuotaLab)*100);
                                        //$TotalTCuo16=$TotalTCuo16+$cuotaLab;
                                    }
                                    $objWorkSheet->setCellValue('BI'.$filaX, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('BI'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    //subtotales
                                    $objWorkSheet->setCellValue('BG'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('BH'.$fila, $TotalLab1);
                                    
                                    /*$arrayVend[$x]= $vend;
                                    $arrayLabs[$x]= $TotalLab1;
                                    $x++;
                                    echo $vend."---".$sectorLab."---".$TotalLab1."</br>";*/
                                    //TOTAL CALL LABORATORIOS
                                    //$TotalTLab16=$TotalTLab16+$TotalLab1;
                                    //porcentaje total
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($TotalLab1/$cuotaLab)*100);
                                    }
                                    $objWorkSheet->setCellValue('BI'.$fila, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('BI'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    break;
                                case 'BAI':
                                    //laboratorios BAI
                                    $objWorkSheet->setCellValue('BJ'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('BK'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('BK'.$filaY, $ventaObj);
                                    if($ventaInd=='-' || $ventaInd=='' || $ventaInd==null){$ventaInd='0';}
                                    if($ventaObj=='-' || $ventaObj=='' || $ventaInd==null){$ventaObj='0';}
                                    $TotalLab1=$ventaInd+$ventaObj;
                                    //porcentaje
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($ventaInd/$cuotaLab)*100);
                                        //$TotalTCuo17=$TotalTCuo17+$cuotaLab;
                                    }
                                    $objWorkSheet->setCellValue('BL'.$filaX, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('BL'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    //subtotales
                                    $objWorkSheet->setCellValue('BJ'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('BK'.$fila, $TotalLab1);
                                    
                                    /*$arrayVend[$x]= $vend;
                                    $arrayLabs[$x]= $TotalLab1;
                                    $x++;
                                    echo $vend."---".$sectorLab."---".$TotalLab1."</br>";*/
                                    //TOTAL CALL LABORATORIOS
                                    //$TotalTLab17=$TotalTLab17+$TotalLab1;
                                    //porcentaje total
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($TotalLab1/$cuotaLab)*100);
                                    }
                                    $objWorkSheet->setCellValue('BL'.$fila, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('BL'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    break;
                                case 'AGROQUIMICOS / VENENOS':
                                    $objWorkSheet->setCellValue('T'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('U'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('U'.$filaY, $ventaObj);
                                    if($ventaInd=='-' || $ventaInd=='' || $ventaInd==null){$ventaInd='0';}
                                    if($ventaObj=='-' || $ventaObj=='' || $ventaInd==null){$ventaObj='0';}
                                    $TotalLab1=$ventaInd+$ventaObj;
                                    //porcentaje
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($ventaInd/$cuotaLab)*100);
                                        //$TotalTCuo6=$TotalTCuo6+$cuotaLab;
                                    }
                                    $objWorkSheet->setCellValue('V'.$filaX, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('V'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    //subtotales
                                    $objWorkSheet->setCellValue('T'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('U'.$fila, $TotalLab1);
                                    
                                    /*$arrayVend[$x]= $vend;
                                    $arrayLabs[$x]= $TotalLab1;
                                    $x++;
                                    echo $vend."---".$sectorLab."---".$TotalLab1."</br>";*/
                                    //TOTAL CALL LABORATORIOS
                                    /*if($TotalLab1 > 0){
                                        $TotalTLab6=$TotalTLab6+$TotalLab1;
                                    }*/
                                    //porcentaje total
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($TotalLab1/$cuotaLab)*100);
                                    }
                                    $objWorkSheet->setCellValue('V'.$fila, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('V'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    break;
                                case 'MEDICAMENTOS':
                                    $objWorkSheet->setCellValue('Q'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('R'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('R'.$filaY, $ventaObj);
                                    if($ventaInd=='-' || $ventaInd=='' || $ventaInd==null){$ventaInd='0';}
                                    if($ventaObj=='-' || $ventaObj=='' || $ventaInd==null){$ventaObj='0';}
                                    $TotalLab1=$ventaInd+$ventaObj;
                                    //porcentaje
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($ventaInd/$cuotaLab)*100);
                                        //$TotalTCuo5=$TotalTCuo5+$cuotaLab;
                                    }
                                    $objWorkSheet->setCellValue('S'.$filaX, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('S'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    //subtotales
                                    $objWorkSheet->setCellValue('Q'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('R'.$fila, $TotalLab1);
                                    
                                    /*$arrayVend[$x]= $vend;
                                    $arrayLabs[$x]= $TotalLab1;
                                    $x++;
                                    echo $vend."---".$sectorLab."---".$TotalLab1."</br>";*/
                                    //TOTAL CALL LABORATORIOS
                                    /* if($TotalLab1 > 0){
                                        $TotalTLab5=$TotalTLab5+$TotalLab1;
                                    }*/
                                    //porcentaje total
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($TotalLab1/$cuotaLab)*100);
                                    }
                                    $objWorkSheet->setCellValue('S'.$fila, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('S'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    break;
                                case 'MASCOTAS':
                                    $objWorkSheet->setCellValue('N'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('O'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('O'.$filaY, $ventaObj);
                                    if($ventaInd=='-' || $ventaInd=='' || $ventaInd==null){$ventaInd='0';}
                                    if($ventaObj=='-' || $ventaObj=='' || $ventaInd==null){$ventaObj='0';}
                                    $TotalLab1=$ventaInd+$ventaObj;
                                    //porcentaje
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($ventaInd/$cuotaLab)*100);
                                        //$TotalTCuo4=$TotalTCuo4+$cuotaLab;
                                    }
                                    $objWorkSheet->setCellValue('P'.$filaX, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('P'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    //subtotales
                                    $objWorkSheet->setCellValue('N'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('O'.$fila, $TotalLab1);
                                    
                                    /*$arrayVend[$x]= $vend;
                                    $arrayLabs[$x]= $TotalLab1;
                                    $x++;
                                    echo $vend."---".$sectorLab."---".$TotalLab1."</br>";*/
                                    //TOTAL CALL LABORATORIOS
                                    /*if($TotalLab1 > 0){
                                        $TotalTLab4=$TotalTLab4+$TotalLab1;
                                    }*/
                                    //porcentaje total
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($TotalLab1/$cuotaLab)*100);
                                    }
                                    $objWorkSheet->setCellValue('P'.$fila, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('P'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    break;
                                case 'CONCENTRADOS':
                                    $objWorkSheet->setCellValue('K'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('L'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('L'.$filaY, $ventaObj);
                                    if($ventaInd=='-' || $ventaInd=='' || $ventaInd==null){$ventaInd='0';}
                                    if($ventaObj=='-' || $ventaObj=='' || $ventaInd==null){$ventaObj='0';}
                                    $TotalLab1=$ventaInd+$ventaObj;
                                    //porcentaje
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($ventaInd/$cuotaLab)*100);
                                        //$TotalTCuo3=$TotalTCuo3+$cuotaLab;
                                    }
                                    $objWorkSheet->setCellValue('M'.$filaX, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('M'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    //subtotales
                                    $objWorkSheet->setCellValue('K'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('L'.$fila, $TotalLab1);
                                    
                                    /*$arrayVend[$x]= $vend;
                                    $arrayLabs[$x]= $TotalLab1;
                                    $x++;
                                    echo $vend."---".$sectorLab."---".$TotalLab1."</br>";*/
                                    //TOTAL CALL LABORATORIOS
                                    /*if($TotalLab1 > 0){
                                        $TotalTLab3=$TotalTLab3+$TotalLab1;
                                    }*/
                                    //porcentaje total
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($TotalLab1/$cuotaLab)*100);
                                    }
                                    $objWorkSheet->setCellValue('M'.$fila, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('M'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    break;
                                case 'VARIOS':
                                    $objWorkSheet->setCellValue('H'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('I'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('I'.$filaY, $ventaObj);
                                    if($ventaInd=='-' || $ventaInd=='' || $ventaInd==null){$ventaInd='0';}
                                    if($ventaObj=='-' || $ventaObj=='' || $ventaInd==null){$ventaObj='0';}
                                    $TotalLab1=$ventaInd+$ventaObj;
                                    //porcentaje
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($ventaInd/$cuotaLab)*100);
                                        //$TotalTCuo2=$TotalTCuo2+$cuotaLab;
                                    }
                                    $objWorkSheet->setCellValue('J'.$filaX, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('J'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    //subtotales
                                    $objWorkSheet->setCellValue('H'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('I'.$fila, $TotalLab1);
                                    
                                    /*$arrayVend[$x]= $vend;
                                    $arrayLabs[$x]= $TotalLab1;
                                    $x++;
                                    echo $vend."---".$sectorLab."---".$TotalLab1."</br>";*/
                                    //TOTAL CALL LABORATORIOS
                                    /*if($TotalLab1 > 0){
                                        $TotalTLab2=$TotalTLab2+$TotalLab1;
                                    }*/
                                    //porcentaje total
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($TotalLab1/$cuotaLab)*100);
                                    }
                                    $objWorkSheet->setCellValue('J'.$fila, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    break;
                                case 'FERRETERIA':
                                    $objWorkSheet->setCellValue('E'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('F'.$filaX, $ventaInd);
                                    $objWorkSheet->setCellValue('F'.$filaY, $ventaObj);
                                    if($ventaInd=='-' || $ventaInd=='' || $ventaInd==null){$ventaInd='0';}
                                    if($ventaObj=='-' || $ventaObj=='' || $ventaInd==null){$ventaObj='0';}
                                    $TotalLab1=$ventaInd+$ventaObj;
                                    //porcentaje
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($ventaInd/$cuotaLab)*100);
                                        //$TotalTCuo1=$TotalTCuo1+$cuotaLab;
                                    }
                                    $objWorkSheet->setCellValue('G'.$filaX, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('G'.$filaX)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    //subtotales
                                    $objWorkSheet->setCellValue('E'.$fila, $cuotaLab);
                                    $objWorkSheet->setCellValue('F'.$fila, $TotalLab1);
                                    
                                    /*$arrayVend[$x]= $vend;
                                    $arrayLabs[$x]= $TotalLab1;
                                    $x++;
                                    echo $vend."---".$sectorLab."---".$TotalLab1."</br>";*/
                                    //TOTAL CALL LABORATORIOS
                                    //echo $vend."---".$cuotaLab."-----".$TotalLab1."====".($TotalTLab1/3)."</br>";
                                    //porcentaje total
                                    $P=0;
                                    if($cuotaLab > 0){
                                        $P=round(($TotalLab1/$cuotaLab)*100);
                           
                                    }
                                    
                                    $objWorkSheet->setCellValue('G'.$fila, $P."%");
                                    $objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    break;
                                
                            }
?>