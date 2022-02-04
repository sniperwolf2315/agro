<?php
        //concentrados
        $objWorkSheet->setCellValue('K'.$fila, $TotalCuo16);
        $objWorkSheet->setCellValue('L'.$fila, $TotalLab16);
        //porcentaje
        $P=0;
        if($TotalCuo16 > 0){
            $P=round(($TotalLab16/$TotalCuo16)*100);
        }
        $objWorkSheet->setCellValue('M'.$fila, $P."%");
        $objPHPExcel->getActiveSheet()->getStyle('M'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //varios
        $objWorkSheet->setCellValue('H'.$fila, $TotalCuo17);
        $objWorkSheet->setCellValue('I'.$fila, $TotalLab17);
        //porcentaje
        $P=0;
        if($TotalCuo17 > 0){
            $P=round(($TotalLab17/$TotalCuo17)*100);
        }
        $objWorkSheet->setCellValue('J'.$fila, $P."%");
        $objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //ferreteria
        $objWorkSheet->setCellValue('E'.$fila, $TotalCuo18);
        $objWorkSheet->setCellValue('F'.$fila, $TotalLab18);
        //porcentaje
        $P=0;
        if($TotalCuo18 > 0){
            $P=round(($TotalLab18/$TotalCuo18)*100);
        }
        $objWorkSheet->setCellValue('G'.$fila, $P."%");
        $objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //ganaderia
        $objWorkSheet->setCellValue('Q'.$fila, $TotalCuo14);
        $objWorkSheet->setCellValue('R'.$fila, $TotalLab14);
        //porcentaje
        $P=0;
        if($TotalCuo14 > 0){
            $P=round(($TotalLab14/$TotalCuo14)*100);
        }
        $objWorkSheet->setCellValue('S'.$fila, $P."%");
        $objPHPExcel->getActiveSheet()->getStyle('S'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //pets
        $objWorkSheet->setCellValue('N'.$fila, $TotalCuo15);
        $objWorkSheet->setCellValue('O'.$fila, $TotalLab15);
        //porcentaje
        $P=0;
        if($TotalCuo15 > 0){
            $P=round(($TotalLab15/$TotalCuo15)*100);
        }
        $objWorkSheet->setCellValue('P'.$fila, $P."%");
        $objPHPExcel->getActiveSheet()->getStyle('P'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //insecticidas
        $objWorkSheet->setCellValue('T'.$fila, $TotalCuo13);
        $objWorkSheet->setCellValue('U'.$fila, $TotalLab13);
        //porcentaje
        $P=0;
        if($TotalCuo13 > 0){
            $P=round(($TotalLab13/$TotalCuo13)*100);
        }
        $objWorkSheet->setCellValue('V'.$fila, $P."%");
        $objPHPExcel->getActiveSheet()->getStyle('V'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //invet 
        $objWorkSheet->setCellValue('W'.$fila, $TotalCuo1);
        $objWorkSheet->setCellValue('X'.$fila, $TotalLab1);
        //porcentaje
        $P=0;
        if($TotalCuo1 > 0){
            $P=round(($TotalLab1/$TotalCuo1)*100);
        }
        $objWorkSheet->setCellValue('Y'.$fila, $P."%");
        $objPHPExcel->getActiveSheet()->getStyle('Y'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //icofarma
        $objWorkSheet->setCellValue('Z'.$fila, $TotalCuo2);
        $objWorkSheet->setCellValue('AA'.$fila, $TotalLab2);
        //porcentaje
        $P=0;
        if($TotalCuo2 > 0){
            $P=round(($TotalLab2/$TotalCuo2)*100);
        }
        $objWorkSheet->setCellValue('AB'.$fila, $P."%");
        $objPHPExcel->getActiveSheet()->getStyle('AB'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //comervet
        $objWorkSheet->setCellValue('AC'.$fila, $TotalCuo3);
        $objWorkSheet->setCellValue('AD'.$fila, $TotalLab3);
        //porcentaje
        $P=0;
        if($TotalCuo3 > 0){
            $P=round(($TotalLab3/$TotalCuo3)*100);
        }
        $objWorkSheet->setCellValue('AE'.$fila, $P."%");
        $objPHPExcel->getActiveSheet()->getStyle('AE'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //gabrica
        $objWorkSheet->setCellValue('AI'.$fila, $TotalCuo4);
        $objWorkSheet->setCellValue('AJ'.$fila, $TotalLab4);
        //porcentaje
        $P=0;
        if($TotalCuo4 > 0){
            $P=round(($TotalLab4/$TotalCuo4)*100);
        }
        $objWorkSheet->setCellValue('AK'.$fila, $P."%");
        $objPHPExcel->getActiveSheet()->getStyle('AK'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //biostar
        $objWorkSheet->setCellValue('AL'.$fila, $TotalCuo5);
        $objWorkSheet->setCellValue('AM'.$fila, $TotalLab5);
        //porcentaje
        $P=0;
        if($TotalCuo5 > 0){
            $P=round(($TotalLab5/$TotalCuo5)*100);
        }
        $objWorkSheet->setCellValue('AN'.$fila, $P."%");
        $objPHPExcel->getActiveSheet()->getStyle('AN'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //cohasfarma
        $objWorkSheet->setCellValue('AR'.$fila, $TotalCuo6);
        $objWorkSheet->setCellValue('AS'.$fila, $TotalLab6);
        //porcentaje
        $P=0;
        if($TotalCuo6 > 0){
            $P=round(($TotalLab6/$TotalCuo6)*100);
        }
        $objWorkSheet->setCellValue('AT'.$fila, $P."%");
        $objPHPExcel->getActiveSheet()->getStyle('AT'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //importados************
        $objWorkSheet->setCellValue('AU'.$fila, $TotalCuo7);
        $objWorkSheet->setCellValue('AV'.$fila, $TotalLab7);
        //porcentaje
        $P=0;
        if($TotalCuo7 > 0){
            $P=round(($TotalLab7/$TotalCuo7)*100);
        }
        $objWorkSheet->setCellValue('AW'.$fila, $P."%");
        $objPHPExcel->getActiveSheet()->getStyle('AW'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //intervet
        $objWorkSheet->setCellValue('AX'.$fila, $TotalCuo8);
        $objWorkSheet->setCellValue('AY'.$fila, $TotalLab8);
        //porcentaje
        $P=0;
        if($TotalCuo8 > 0){
            $P=round(($TotalLab8/$TotalCuo8)*100);
        }
        $objWorkSheet->setCellValue('AZ'.$fila, $P."%");
        $objPHPExcel->getActiveSheet()->getStyle('AZ'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //Linea agil
        $objWorkSheet->setCellValue('BD'.$fila, $TotalCuo10);
        $objWorkSheet->setCellValue('BE'.$fila, $TotalLab10);
        //porcentaje
        $P=0;
        if($TotalCuo10 > 0){
            $P=round(($TotalLab10/$TotalCuo10)*100);
        }
        $objWorkSheet->setCellValue('BF'.$fila, $P."%");
        $objPHPExcel->getActiveSheet()->getStyle('BF'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //linea agil importados
        $objWorkSheet->setCellValue('BG'.$fila, $TotalCuo11);
        $objWorkSheet->setCellValue('BH'.$fila, $TotalLab11);
        //porcentaje
        $P=0;
        if($TotalCuo11 > 0){
            $P=round(($TotalLab11/$TotalCuo11)*100);
        }
        $objWorkSheet->setCellValue('BI'.$fila, $P."%");
        $objPHPExcel->getActiveSheet()->getStyle('BI'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //laboratorios BAI
        $objWorkSheet->setCellValue('BJ'.$fila, $TotalCuo12);
        $objWorkSheet->setCellValue('BK'.$fila, $TotalLab12);
        //porcentaje
        $P=0;
        if($TotalCuo12 > 0){
            $P=round(($TotalLab12/$TotalCuo12)*100);
        }
        $objWorkSheet->setCellValue('BL'.$fila, $P."%");
        $objPHPExcel->getActiveSheet()->getStyle('BL'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //tecnocalidad
        $objWorkSheet->setCellValue('BM'.$fila, $TotalCuo9);
        $objWorkSheet->setCellValue('BN'.$fila, $TotalLab9);
        //porcentaje
        $P=0;
        if($TotalCuo9 > 0){
            $P=round(($TotalLab9/$TotalCuo9)*100);
        }
        $objWorkSheet->setCellValue('BO'.$fila, $P."%");
        $objPHPExcel->getActiveSheet()->getStyle('BO'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //TOTALES LABORATORIOS ALMACEN
        //concentrados
        $TotalTCuo16=$TotalTCuo16+$TotalCuo16;
        $TotalTLab16=$TotalTLab16+$TotalLab16;
        //varios
        $TotalTCuo17=$TotalTCuo17+$TotalCuo17;
        $TotalTLab17=$TotalTLab17+$TotalLab17;
        //ferreteria
        $TotalTCuo18=$TotalTCuo18+$TotalCuo18;
        $TotalTLab18=$TotalTLab18+$TotalLab18;
        //ganaderia
        $TotalTCuo14=$TotalTCuo14+$TotalCuo14;
        $TotalTLab14=$TotalTLab14+$TotalLab14;
        //pets
        $TotalTCuo15=$TotalTCuo15+$TotalCuo15;
        $TotalTLab15=$TotalTLab15+$TotalLab15;
        //insecticidas
        $TotalTCuo13=$TotalTCuo13+$TotalCuo13;
        $TotalTLab13=$TotalTLab13+$TotalLab13;
        //invet
        $TotalTCuo1=$TotalTCuo1+$TotalCuo1;
        $TotalTLab1=$TotalTLab1+$TotalLab1;
        //icofarma
        $TotalTCuo2=$TotalTCuo2+$TotalCuo2;
        $TotalTLab2=$TotalTLab2+$TotalLab2;
        //comervet
        $TotalTCuo3=$TotalTCuo3+$TotalCuo3;
        $TotalTLab3=$TotalTLab3+$TotalLab3;
        //gabrica
        $TotalTCuo4=$TotalTCuo4+$TotalCuo4;
        $TotalTLab4=$TotalTLab4+$TotalLab4;
        //biostar
        $TotalTCuo5=$TotalTCuo5+$TotalCuo5;
        $TotalTLab5=$TotalTLab5+$TotalLab5;
        //cohasfarma
        $TotalTCuo6=$TotalTCuo6+$TotalCuo6;
        $TotalTLab6=$TotalTLab6+$TotalLab6;
        //importados
        $TotalTCuo7=$TotalTCuo7+$TotalCuo7;
        $TotalTLab7=$TotalTLab7+$TotalLab7;
        //intervet
        $TotalTCuo8=$TotalTCuo8+$TotalCuo8;
        $TotalTLab8=$TotalTLab8+$TotalLab8;
        //linea agil
        $TotalTCuo10=$TotalTCuo10+$TotalCuo10;
        $TotalTLab10=$TotalTLab10+$TotalLab10;
        //linea agil importados
        $TotalTCuo11=$TotalTCuo11+$TotalCuo11;
        $TotalTLab11=$TotalTLab11+$TotalLab11;
        //laboratorios BAI
        $TotalTCuo12=$TotalTCuo12+$TotalCuo12;
        $TotalTLab12=$TotalTLab12+$TotalLab12;
        //tecnocalidad
        $TotalTCuo9=$TotalTCuo9+$TotalCuo9;
        $TotalTLab9=$TotalTLab9+$TotalLab9;
?>