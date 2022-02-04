<?php
$Sede=$_GET['sede'];
$fi=$_GET['fi'];
$ff=$_GET['ff'];
require_once('conectarbase.php');
//require_once('user_con.php');


//echo "<span style='color: black; font-weight: bold;' >ORDENES FALTANTES EN IBS</span><hr>";
/*$r="<table style=\"border: 1px solid #000; width:100%;\">";
$r=$r . "<tr style=\"border-bottom: 1pt solid black;\">";
    $r=$r . "<td style=\"font-weight: bold;width: 5%;text-align: left;\">#</td>";
    $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;\">C. C.</td>";
    $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;\">Apellidos</td>";
    $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;\">Nombres</td>";
    $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;\">Sexo</td>";
    $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;\">F.Nacimiento</td>";
    $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;\">Temperatura</td>";
    $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;\">Fecha</td>";
    $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;\">Hora</td>";
    $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;\">Sede</td>";
    $r=$r . "</tr>";
   */
   $miruta='Informe/';
  
   if(file_exists($miruta)) { 
        $nombre_fichero = 'Informe_Ingreso';
        $mipath=$miruta.$nombre_fichero.'.xlsx';  
        include('Classes/PHPExcel.php');
        include('Classes/PHPExcel/Reader/Excel2007.php');
            //Crear el objeto Excel: 
            $objPHPExcel = new PHPExcel();
            //crea hojas
            //$i=1;
            $mipath2=$miruta.$nombre_fichero.'.xlsx';
            
            //if(!file_exists($mipath2)) {
                $objPHPExcel->getProperties()->setCreator("Autor: Agrocampo");
                $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo");
                $objPHPExcel->getProperties()->setTitle("Informe de Ordenes");
                $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
                $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
                $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
                $objPHPExcel->getProperties()->setCategory("Resultado de Informe"); 
                
                $objWorkSheet = $objPHPExcel->createSheet(0);
                    
                    $objWorkSheet->setCellValue('A2', '#')
                        ->setCellValue('B2', 'C.C.')
                        ->setCellValue('C2', 'Nombres')
                        ->setCellValue('D2', 'Apellidos')
                        ->setCellValue('E2', 'Sexo')
                        ->setCellValue('F2', 'Fecha Nacimiento')
                        ->setCellValue('G2', 'Temperatura')
                        ->setCellValue('H2', 'Fecha')
                        ->setCellValue('I2', 'Hora')
                        ->setCellValue('J2', 'Sede');
                     
                    
                    $objWorkSheet->setTitle("Reporte de Temperaturas");   
                
                //borra datos hoja
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
                    $fil++;
                }
                
            //ANCHOS
        $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        
        $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1', "Reporte de Ingreso");
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        
        $sql ="SELECT cc, ape1, ape2, nom1, nom2, sex, nto, temp, fecha, hora, sede FROM seg_ingreso WHERE (fecha BETWEEN '$fi' AND '$ff') AND sede='$Sede' order by id DESC";
        $result = mysqli_query($mysqliL,$sql) or die(mysqli_error($mysqliL)." no encotro <br>$sql");
        $fd=3;  
        $Reg=1;
        while($row = mysqli_fetch_assoc($result)){
           $d1=$row['cc'];
           $d2=$row['ape1'];
           $d3=$row['ape2'];
           $d4=$row['nom1'];
           $d5=$row['nom2'];
           $d6=$row['sex'];
           $d7=$row['nto'];
           $d8=$row['temp'];
           $d9=$row['fecha'];
           $d10=$row['hora'];
           $d11=$row['sede'];
           $Nom=$d4." ".$d5;
           $Ape=$d2." ".$d3;
           
           $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$fd, $Reg)
                    ->setCellValue('B'.$fd, $d1)            
                    ->setCellValue('C'.$fd, $Ape)
                    ->setCellValue('D'.$fd, $Nom)
                    ->setCellValue('E'.$fd, $d6)
                    ->setCellValue('F'.$fd, $d7)
                    ->setCellValue('G'.$fd, $d8)
                    ->setCellValue('H'.$fd, $d9)
                    ->setCellValue('I'.$fd, $d10)
                    ->setCellValue('J'.$fd, $d11);
                
                $fd++;
           $Reg++;
        }
        
        $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
        //Guardar el achivo: 
        $objWriter->save($mipath2);
        
   }

$ruta="../modulo_seguridad/Reportes/".$mipath2;
mysqli_close($result);
echo $ruta;
?>