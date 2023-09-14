<?php
require_once('user_con.php');
//require_once('user_con_xampp.php');
$diaA = date('d');

/*
$i=0;
    $resultSQLItemsm = mssql_query("SELECT sum(VLR_EXC_IVA) as suma
    FROM [AcumuladoVentas].[dbo].[AcumuladoVentas]
    WHERE VENDEDOR='VEND304' AND FECHA_ORDEN='202104' AND FAMILIA='CONCENTRADOS'",$cLink);
    while($resultadoitems = mssql_fetch_array($resultSQLItemsm)){                            
        $UFac=$resultadoitems["suma"];
        //$CFac[$i]=$resultadoitems["FacturasDespachadasMes"];
        $i++;    
    }
*/

$array = array("VEND014","VEND039","VEND040","VEND045","VEND078","VEND079","VEND081","VEND114","VEND165","VEND183","VEND214","VEND252","VEND260","VEND310","VEND313","VEND314","VEND334","VEND338","VEND217","SUAREZC","VENDOTC");
//$UFac=trim($array[2]);

$mesA = date('m');
//$mesA=$mesA-1;
setlocale(LC_TIME, 'es_ES');
$fecha = DateTime::createFromFormat('!m', $mesA);
$mesN = strftime("%B", $fecha->getTimestamp());

$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Informe de ventas a Corte 1: ".$fechaActual." consulta= ".$UFac."</p>";//Fecha Inicio: ".$feini." - hasta: ".$fefin.".

$anioA = date('Y');
$fechaActual=$diaA." - ".$mesN." - ".$anioA;
//echo "dias: {$dia} <br>"."Fecha inicial: ".$feini."<br>"."fecha Fin: ".$fefin;
        $r=$r."<table style=\"border: 1px solid #000; width:100%; \" class=\"#439049 green darken-1\" >";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.6em;\">";
        $r=$r."<td><a href='Informexls/Inf_Ven.xlsx' class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>";
        $r=$r."</tr>";
$ibs="";
// se comenta para efectos de pruebas
/*$sql="SELECT TIPO_ORDEN,FECHA_ORDEN,FECHA_FACTURA,NUMERO_ORDEN,LINEA_ORDEN,ESTADO_ORDEN,
    \"Codigo T_Mercancia\",\"Des T_Mercancia\",GRUPO,ITEM,CANTIDAD,UNIDAD,FOC,VENDEDOR,NOMBRE_VENDEDOR,
    CALL,MANEJADOR,PLANEADOR,CLIENTE,NOMBRECLIENTE,CELULAR,TELEFONO,CATEGORIA5,CODIGO_CATEGORIA5,
    VLR_EXC_IVA,VLR_INC_IVA
    FROM VISVENTASORDEN1 WHERE FECHA_ORDEN BETWEEN '20210715' AND '20210715' and NUMERO_ORDEN='6981596'";*/
$fd=3;
$miruta='../Informexls/';
$nombre_fichero = 'Inf_Ven';
$mipath=$miruta.$nombre_fichero.'.xlsx';
if(file_exists($miruta)) {
    include('../Classes/PHPExcel.php');
    include('../Classes/PHPExcel/Reader/Excel2007.php');
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
        // Add new sheet
        $objWorkSheet = $objPHPExcel->createSheet(0);
        $objPHPExcel->getActiveSheet()->mergeCells('A4:C4');
        $objWorkSheet->setCellValue('A2', '25')
            ->setCellValue('B2', '25')
            ->setCellValue('C2', 'DIAS DEL PERIODO');        
        $objWorkSheet->setTitle('Informe De Ventas');                    
    }
    $objPHPExcel->getProperties()->setCreator("Autor: Agrocampo");
    $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo");
    $objPHPExcel->getProperties()->setTitle("Informe Agrocampo");
    $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
    $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
    $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
    $objPHPExcel->getProperties()->setCategory("Resultado de Informe");  
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
        $objPHPExcel->getActiveSheet()->SetCellValue('R'.$fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('S'.$fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('T'.$fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('U'.$fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('V'.$fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('W'.$fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('X'.$fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('Y'.$fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('Z'.$fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('AA'.$fil, '');
        $fil++;
    }
    //ANCHOS
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(35);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(15);
    
    //TEXTO EN CELDAS
    $objWorkSheet->setCellValue('A5','Area')
            ->setCellValue('B5','Codigo')
            ->setCellValue('C5','Nombre')
            ->setCellValue('A4','Vendedor')->mergeCells('A4:C4')
            ->setCellValue('D4','Cuota General')->mergeCells('D4:D5')
            ->setCellValue('E4','Ferreteria')->mergeCells('E4:G4')
            ->setCellValue('H4','Varios')->mergeCells('H4:J4')
            ->setCellValue('K4','Concentrados')->mergeCells('K4:M4')
            ->setCellValue('N4','Pets')->mergeCells('N4:P4')
            ->setCellValue('Q4','Ganaderia')->mergeCells('Q4:S4')
            ->setCellValue('T4','Insecticidas y Otros')->mergeCells('T4:V4')
            ->setCellValue('W4','Invet')->mergeCells('W4:Y4')
            ->setCellValue('Z4','Icofarma')->mergeCells('Z4:AB4')
            ->setCellValue('AC4','Comervet')->mergeCells('AC4:AE4')
            ->setCellValue('AF4','Gabrica')->mergeCells('AF4:AH4')
            ->setCellValue('AI4','Biostar')->mergeCells('AI4:AK4')
            ->setCellValue('AL4','Genfar')->mergeCells('AL4:AN4')
            ->setCellValue('AO4','Coaspharma')->mergeCells('AO4:AQ4')
            ->setCellValue('AR4','Importados')->mergeCells('AR4:AT4')
            ->setCellValue('AU4','Intervet')->mergeCells('AU4:AW4')
            ->setCellValue('AX4','Pharmek')->mergeCells('AX4:AZ4')
            ->setCellValue('BA4','Linea Agil')->mergeCells('BA4:BC4')
            ->setCellValue('BD4','Linea Agil Importados')->mergeCells('BD4:BF4')
            ->setCellValue('BG4','Laboratorio BAI')->mergeCells('BG4:BI4')
            ->setCellValue('BJ4','Tecnocalidad')->mergeCells('BJ4:BL4')
            ->setCellValue('BM4','Total')->mergeCells('BM4:BO4')
            ->setCellValue('A28','TOTAL VENTA EXTERNA')->mergeCells('A28:C28')
            ->setCellValue('A30','CONCENTRADOS')->mergeCells('A30:A36')
            ->setCellValue('A37','TOTAL CONCENTRADOS')->mergeCells('A37:C37')
            ->setCellValue('A39','GATOS')->mergeCells('A39:A41')
            ->setCellValue('A42','TOTAL FERRETERIA')->mergeCells('A42:C42')
            ->setCellValue('A44','MOSTRADOR')->mergeCells('A44:A54')
            ->setCellValue('A55','TOTAL MOSTRADOR')->mergeCells('A55:C55')
            ->setCellValue('A57','PEQUENOS')->mergeCells('A57:A60')
            ->setCellValue('A61','TOTAL PEQUENOS')->mergeCells('A61:C61')
            ->setCellValue('A63','IMPORTADOS')
            ->setCellValue('A64','TOTAL IMPORTADOS')->mergeCells('A64:C64')
            ->setCellValue('A66','SEMILLAS  Y FERRETERIA')->mergeCells('A66:A68')
            ->setCellValue('A69','TOTAL SEMILLAS')->mergeCells('A69:C69')
            ->setCellValue('A71','VACUNACION')
            ->setCellValue('A72','TOTAL VACUNACION')->mergeCells('A72:C72')
            ->setCellValue('A74','CANALES DIGITALES')->mergeCells('A74:A82')
            ->setCellValue('A83','TOTAL RAPI')->mergeCells('A83:C83')
            ->setCellValue('A85','OTROS')->mergeCells('A85:A86')
            ->setCellValue('A87','TOTAL OTROS')->mergeCells('A87:C87')
            ->setCellValue('A88','TOTAL ALMACEN')->mergeCells('A88:C88')
            ->mergeCells('A90:A109')
            ->setCellValue('A110','TOTAL TELEOPERADOR ALMACEN')->mergeCells('A110:C110')
            ->setCellValue('A111','TELEOPERADOR VENTA EXTERNA')->mergeCells('A111:A265')
            ->setCellValue('A266','TOTAL CUOTA TELEOPERADOR VENTA EXTERNA')->mergeCells('A266:C266')
            ->setCellValue('A267','OTROS')->mergeCells('A267:A278')
            ->setCellValue('A280','TOTAL CONTACT CENTER VENTA INDIVIDUAL')->mergeCells('A280:C280')
            ->setCellValue('A281','TOTAL CONTACT CENTER VENTA OBJETIVO INDIVIDUAL')->mergeCells('A281:C281')
            ->setCellValue('A282','TOTAL VENTAS CALL A VENDEDORES (VEND114, VEND214)')->mergeCells('A282:C282')
            ->setCellValue('A288','TOTAL GENERAL (VEXT +ALM + CALL IND) - (CALL VEND114 Y VEND214)')->mergeCells('A288:C288')
            ->mergeCells('A89:BO89');
    
    $objPHPExcel->setActiveSheetIndex(0)
    ->getStyle('A1:BP5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->setActiveSheetIndex(0)
    ->getStyle('A1:B300')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    //->getStyle('D4:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    
    //marcar borde de cuadricula
    $borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('argb' => 'FF000000'),
        )
      ),
    );
    //marcar bordes externos 
    $BStyle = array(
      'borders' => array(
        'outline' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
        )
      )
    );
    //cuadricula por total de la columna A
    $objPHPExcel->getActiveSheet()->getStyle('A4:BO5')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A2:C2')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A7:A27')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A28:BO28')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A30:A36')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A37:BO37')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A39:A41')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A42:BO42')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A44:A54')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A55:BO55')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A57:A60')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A61:BO61')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A63')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A64:BO64')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A66:A68')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A69:BO69')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A71')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A72:BO72')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A74:A82')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A83:BO83')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A85:A86')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A87:BO87')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A88:BO88')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A90:A109')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A111:A265')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A267:A278')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A110:BO110')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A266:BO266')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A280:BO280')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A281:BO281')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A282:BO282')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A288:BO288')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A89:BO89')->applyFromArray($borders);
    $neg="B";
    $neg_col=94;
    $neg_Cont=0;
    //campo otros bordes cuadro total cuota
    while ($neg_Cont < 35) {
        $neg_cel=$neg.$neg_col.":".$neg."O".$neg_col;
        $objPHPExcel->getActiveSheet()->getStyle($neg_cel)->applyFromArray($borders);
        if($neg_col==109){
            $neg_col++;
        }else if($neg_col==265){
            $neg_col++;
        }
        $neg_col=$neg_col+5;
        $neg_Cont++;
        
    }
    //campo otros bordes de cuadro
    $neg_Cont1=0;
    $neg_cont2=270;
    while ($neg_Cont1 <= 2) {
        $neg_cel=$neg.$neg_cont2.":".$neg."O".$neg_cont2;
        $objPHPExcel->getActiveSheet()->getStyle($neg_cel)->applyFromArray($borders);
        $neg_cont2=$neg_cont2+4;
        $neg_Cont1++;
    }
    
    //color de celda GRIS OSCURO
    function cellColor($cells,$color){ 
        global $objPHPExcel; $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill() ->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => $color) )); } 
    cellColor('A2', 'B1ADAD');
    cellColor('A28:BO28', 'B1ADAD');
    cellColor('A37:BO37', 'B1ADAD');
    cellColor('A42:BO42', 'B1ADAD');
    cellColor('A55:BO55', 'B1ADAD');
    cellColor('A61:BO61', 'B1ADAD');
    cellColor('A64:BO64', 'B1ADAD');
    cellColor('A69:BO69', 'B1ADAD');
    cellColor('A72:BO72', 'B1ADAD');
    cellColor('A83:BO83', 'B1ADAD');
    cellColor('A87:BO87', 'B1ADAD');
    cellColor('A88:BO88', 'C8C5C5');
    cellColor('A110:BO110', 'B1ADAD');
    cellColor('A266:BO266', 'B1ADAD');
    cellColor('A280:BO280', 'B1ADAD');
    cellColor('A281:BO281', 'B1ADAD');
    cellColor('A282:BO282', 'B1ADAD');
    cellColor('A288:BO288', 'B1ADAD');
    cellColor('A7:A27', 'D3D2D2');
    cellColor('A30:A36', 'D3D2D2');
    cellColor('A39:A41', 'D3D2D2');
    cellColor('A44:A54', 'D3D2D2');
    cellColor('A57:A60', 'D3D2D2');
    cellColor('A63', 'D3D2D2');
    cellColor('A66:A68', 'D3D2D2');
    cellColor('A71', 'D3D2D2');
    cellColor('A74:A82', 'D3D2D2');
    cellColor('A85:A86', 'D3D2D2');
    cellColor('A90:A109', 'D3D2D2');
    cellColor('A111:A265', 'D3D2D2');
    cellColor('A267:A278', 'D3D2D2');

    $a=69;
    $b="";
    $l=5;
    $cont=0;
    $cascii1=chr($a);
    $cascii1=$b.$cascii1.$l;
    //genera horizontalmente los cuadros de cuota venta y %
    while ($cont <= 20) {
        $cont1=0;
        while ($cont1 < 3) {
            $cascii1=chr($a);
            $cascii1=$b.$cascii1.$l;
            if($a >= 91 && $b == ""){
                $a=65;
                $b="A";
                $cascii1=chr($a);
                $cascii1=$b.$cascii1.$l;
                if($cont1==0 && $a < 91){
                    $objWorkSheet->setCellValue($cascii1, 'CUOTA');
                }else if($cont1==1 && $a < 91){
                    $objWorkSheet->setCellValue($cascii1, 'VENTA');
                }else if($cont1==2 && $a < 91){
                    $objWorkSheet->setCellValue($cascii1, '%');//.$a.' ascii: '.$cascii1
                }
            }else if($a >= 91 && $b != ""){
                $a=65;
                $b="B";
                $cascii1=chr($a);
                $cascii1=$b.$cascii1.$l;
                if($cont1==0 && $a < 91){
                    $objWorkSheet->setCellValue($cascii1, 'CUOTA');
                }else if($cont1==1 && $a < 91){
                    $objWorkSheet->setCellValue($cascii1, 'VENTA');
                }else if($cont1==2 && $a < 91){
                    $objWorkSheet->setCellValue($cascii1, '%');//.$a.' ascii: '.$cascii1
                }
            }else if($cont1==0 && $a < 91){
                $objWorkSheet->setCellValue($cascii1, 'CUOTA');
            }else if($cont1==1 && $a < 91){
                $objWorkSheet->setCellValue($cascii1, 'VENTA');
            }else if($cont1==2 && $a < 91){
                $objWorkSheet->setCellValue($cascii1, '%');//.$a.' ascii: '.$cascii1
            }
            $a++;
            $cont1++;
        }
        $cont++;
    }
    $cuo_con=0;
    $cuo="C";
    $cuo1="B";
    $cuo_cam=90;
    $cuo_cel=$cuo.$cuo_cam;
    $d_ven="VEND";
    $d_nom="Nombre";
    //datos verticales de la columna de vendedores 
    while ($cuo_con < 35) {
         if($d_ven!="" && $d_nom!=""){
            $cuo_cel=$cuo.$cuo_cam;
            $objWorkSheet->setCellValue($cuo_cel, $d_nom);
            $objPHPExcel->getActiveSheet()->getStyle($cuo_cel)->applyFromArray($borders)->getFont()->setBold(true);
            $cuo_cam++;
            $cuo_cel=$cuo.$cuo_cam;
            $objWorkSheet->setCellValue($cuo_cel, 'Cuota Individual');
            $objPHPExcel->getActiveSheet()->getStyle($cuo_cel)->getFont()->setBold(true);
            $v1 = str_split($d_ven, 4);
            if($v1[0]=="VEND"){
                $cuo_cel1=$cuo1.$cuo_cam;
                $objWorkSheet->setCellValue($cuo_cel1, 'VENC');
            }
            $cuo_cam++;
            $cuo_cel=$cuo.$cuo_cam;
            $objWorkSheet->setCellValue($cuo_cel, 'Cuota Objetivo Individual ');
            $objPHPExcel->getActiveSheet()->getStyle($cuo_cel)->getFont()->setBold(true);
            $v2 = str_split($d_ven, 4);
            if($v2[0]=="VEND"){
                $cuo_cel1=$cuo1.$cuo_cam;
                $objWorkSheet->setCellValue($cuo_cel1, 'VENB');
            }
            $cuo_cam++;
            $cuo_cel=$cuo.$cuo_cam;
            $objWorkSheet->setCellValue($cuo_cel, 'Cuota Domicilios');
            $objPHPExcel->getActiveSheet()->getStyle($cuo_cel)->getFont()->setBold(true);
            $v3 = str_split($d_ven, 4);
            if($v3[0]=="VEND"){
                $cuo_cel1=$cuo1.$cuo_cam;
                $objWorkSheet->setCellValue($cuo_cel1, 'VENA');
            }
            $cuo_cam++;
            $cuo_cel=$cuo.$cuo_cam;
            $objWorkSheet->setCellValue($cuo_cel, 'Total Cuota:');
            $objPHPExcel->getActiveSheet()->getStyle($cuo_cel)->applyFromArray($borders)->getFont()->setBold(true);
            $cuo_cel1=$cuo1.$cuo_cam;
            $objWorkSheet->setCellValue($cuo_cel1, $d_ven);
            $objPHPExcel->getActiveSheet()->getStyle($cuo_cel1)->applyFromArray($borders)->getFont()->setBold(true);
            if($cuo_cam==109){
                $cuo_cam++;
            }
         }
         $cuo_cam++;
         $cuo_con++;
    }
    //GENERA CUADROS INTERNOS EN CADA VENDEDOR
    $cu_int_le="C";
    $cu_int_nu=91;
    $cu_int_nu1=93;
    $cu_int=0;
    while ($cu_int < 35) {
        $cu_int_cel=$cu_int_le.$cu_int_nu.":".$cu_int_le.$cu_int_nu1;
        $objPHPExcel->getActiveSheet()->getStyle($cu_int_cel)->applyFromArray($BStyle);
        if($cu_int_nu1==108){
            $cu_int_nu++;
            $cu_int_nu1++;
        }
        if($cu_int_nu1==264){
            $otr_tot_ven=0;
            while ($otr_tot_ven < 6) {
                $otr_int_le="C";
                $otr_int_nu=267;
                $otr_int_nu1=269;
                $otr_int1=0;
                while ($otr_int1 < 3) {
                    $otr_int_cel=$otr_int_le.$otr_int_nu.":".$otr_int_le.$otr_int_nu1;
                    $objPHPExcel->getActiveSheet()->getStyle($otr_int_cel)->applyFromArray($BStyle);
                    $otr_int_nu=$otr_int_nu+4;
                    $otr_int_nu1=$otr_int_nu1+4;
                    $otr_int1++;
                }
                $otr_tot_ven++;
            }
        }
        if($cu_int_nu1!=264){
            $cu_int_nu=$cu_int_nu+5;
            $cu_int_nu1=$cu_int_nu1+5;
        }
        $cu_int++;
    }
    $objWorkSheet->setCellValue('D107', $valim[0]);
    
    //campo otros por celdas de texto 
    $otr="C";
    $otr1="B";
    $otr_nom="Nombre";
    $otr_ven="VEND";
    $otr_Cont=0;
    $otr_cont1=267;
    while ($otr_Cont <= 2) {
        $otr_cel=$otr.$otr_cont1;
        $objWorkSheet->setCellValue($otr_cel, $otr_nom);
        $objPHPExcel->getActiveSheet()->getStyle($otr_cel)->applyFromArray($borders)->getFont()->setBold(true);
        $otr_cont1++;
        $otr_cel=$otr.$otr_cont1;
        $objWorkSheet->setCellValue($otr_cel, 'Cuota Individual');
        $objPHPExcel->getActiveSheet()->getStyle($otr_cel)->getFont()->setBold(true);
        $o1 = str_split($otr_ven, 4);
        if($o1[0]=="VEND"){
            $otr_cel=$otr1.$otr_cont1;
            $objWorkSheet->setCellValue($otr_cel, 'VENC');
        }
        $otr_cont1++;
        $otr_cel=$otr.$otr_cont1;
        $objWorkSheet->setCellValue($otr_cel, 'Cuota Objetivo Individual');
        $objPHPExcel->getActiveSheet()->getStyle($otr_cel)->getFont()->setBold(true);
        $o2 = str_split($otr_ven, 4);
        if($o2[0]=="VEND"){
            $otr_cel=$otr1.$otr_cont1;
            $objWorkSheet->setCellValue($otr_cel, 'VENB');
        }
        $otr_cont1++;
        $otr_cel=$otr.$otr_cont1;
        $objWorkSheet->setCellValue($otr_cel, 'Total Cuota:');
        $objPHPExcel->getActiveSheet()->getStyle($otr_cel)->getFont()->setBold(true);
        $o3 = str_split($otr_ven, 4);
        if($o3[0]=="VEND"){
            $otr_cel=$otr1.$otr_cont1;
            $objWorkSheet->setCellValue($otr_cel, $otr_ven);
            $objPHPExcel->getActiveSheet()->getStyle($otr_cel)->getFont()->setBold(true);
        }
        $otr_cont1++;
        $otr_Cont++;
    }
    
    $objPHPExcel->setActiveSheetIndex(0) ->mergeCells('A7:A27');
    $objPHPExcel->getActiveSheet()->setCellValue('A7','VENTA EXTERNA');
    
    $re=0;
    $re_num=7;
    for($x;$x<=21;$x++){
        $UFac=trim($array[$re]);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$re_num, $UFac);
        $re++;
        $re_num++;
    }
    $i=1;
	$result = odbc_exec($db2con, $ibs);
    while($row = odbc_fetch_array($result)){
        $d2 = utf8_encode($row['TIPO_ORDEN']);
        $d3 = utf8_encode($row['FECHA_ORDEN']);
        //$Val_Exc=number_format($d26);
        //$Val_Inc=number_format($d27);

        //EXCEL
            $objPHPExcel->setActiveSheetIndex(0)
            /*->setCellValue('A'.$fd, $i)
            ->setCellValueExplicitByColumnAndRow(1, $fd, $d2, PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicitByColumnAndRow(2, $fd, $d3, PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicitByColumnAndRow(3, $fd, $d4, PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValue('E'.$fd, $d5)
            ->setCellValue('F'.$fd, $d6)
            ->setCellValueExplicitByColumnAndRow(6, $fd, $d7, PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValue('H'.$fd, $d8)
            ->setCellValue('I'.$fd, $d9)
            ->setCellValue('J'.$fd, $d10)
            ->setCellValue('K'.$fd, $d11)
            ->setCellValue('L'.$fd, $d12)
            ->setCellValue('M'.$fd, $d13)
            ->setCellValue('N'.$fd, $d14)
            ->setCellValue('O'.$fd, $d15)
            ->setCellValue('P'.$fd, $d16)
            ->setCellValue('Q'.$fd, $d17)
            ->setCellValue('R'.$fd, $d18)
            ->setCellValue('S'.$fd, $d19)
            ->setCellValue('T'.$fd, $d20)
            ->setCellValue('U'.$fd, $d21)
            ->setCellValue('V'.$fd, $d22)
            ->setCellValue('W'.$fd, $d23)
            ->setCellValue('X'.$fd, $d24)
            ->setCellValue('Y'.$fd, $d25)
            ->setCellValue('Z'.$fd, $Val_Exc)
            ->setCellValue('AA'.$fd, $Val_Inc)*/;
        //echo $d8." -- ** -- ".$d9."<br />";
        //echo $i."//".$d2."//".$d3."//".$d4."//".$d5."//".$d6."//".$d7."//".$d8."//".$d9."//".$d10."//".$d11."//".$d12."//".$d13."//".$d14."//".$d15."//".$d16."//".$d17."//".$d18."//".$d19."//".$d20."//".$d21."//".$d22."//".$d23."//".$d24."//".$d25."//".$d26."//".$d27."<br /><br />";
        $i++;
        $fd++; 
    }
 }
    $r=$r . "</table>";
    //CREA ARCHIVO************************************************************
    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    //Guardar el achivo: 
    $objWriter->save($mipath2);
    //echo $i."//".$d2."//".$d3."//".$d4."//".$d5."//".$d6."//".$d7."//".$d8."//".$d9."//".$d10."//".$d11."//".$d12."//".$d13."//".$d14."//".$d15."//".$d16."//".$d17."//".$d18."//".$d19."//".$d20."//".$d21."//".$d22."//".$d23."//".$d24."//".$d25."//".$d26."//".$d27."<br />";
    odbc_close($result);
    echo $r;
?>