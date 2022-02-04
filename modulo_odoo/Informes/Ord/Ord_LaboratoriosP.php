<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

//$anio=trim($_GET['a']);
//$mes=trim($_GET['m']);
$tipo=trim($_GET['t']);

//CALCULAR FECHA CON MES EN LETRAS
$diaA = date('d');
$mesA = date('m');
//$mesA=$mesA-1;
setlocale(LC_TIME, 'es_ES');
$fecha = DateTime::createFromFormat('!m', $mesA);
$mesN = strftime("%B", $fecha->getTimestamp());
$anioA = date('Y');
$fechaActual=$diaA." - ".$mesN." - ".$anioA;

//fecha inicio fecha din de la consulta x mes
$dia = cal_days_in_month(CAL_GREGORIAN, $mes, $anio); // 31
$feini=$anio."-".$mes."-01";
$fefin=$anio."-".$mes."-".$dia;

$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Esta visualizando el informe: ".$tipo."</p>";
$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Ordenes en Estado Pendiente. Compras Pendientes Por Entregar a Corte: ".$fechaActual."</p>";//Fecha Inicio: ".$feini." - hasta: ".$fefin.".
//echo "dias: {$dia} <br>"."Fecha inicial: ".$feini."<br>"."fecha Fin: ".$fefin;
        $r=$r."<table style=\"border: 1px solid #000; width:100%; \" class=\"#439049 green darken-1\">";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.6em;\">";
        $r=$r."<td style=\"font-weight: bold;text-align: left; padding: 5px;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">ORDEN</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">TIPO ORDEN</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">FECHA ORDEN</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">DESCR. PROVEEEDOR</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">DESCRICPION</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CANTIDAD SOLICITADA</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CANTIDAD RECIBIDA</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CANTIDAD DEVUELTAS</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">OLITIT</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">VALOR X UND.</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">TOTAL</td>
        <td><a href='Informexls/ORDENES_LABORATORIOS_008.xlsx' class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>";
        $r=$r."</tr>";
        //Informe_Ingreso008.xlsx'>Descargar</a><Strong></td>";




//echo "valo_1: ".$anio." Valor_2: ".$mes;
//".$feini."' and '".$fefin."';"
//$query = "select * from stock_control_receipt where date between '".$anio."-".$mes."-01' and '".$anio."-".$mes."-20';";
$query1 = "select rp.ref as proveedor, rp.name from purchase_order as po
left join res_partner as rp on po.partner_id=rp.id
group by rp.ref, rp.name;";
                                
                                //colocar color a las celdas de excel
                                function cellColor($cells,$color){
                                    global $objPHPExcel;
                                
                                    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'startcolor' => array(
                                             'rgb' => $color
                                        )
                                    ));
                                }
                                $i=1;

                $fd=3;
                // $r="Informexls/Informe_Inventario008.xlsx"
                $miruta='../Informexls/';
                $nombre_fichero = 'ORDENES_LABORATORIOS_008';
                $mipath=$miruta.$nombre_fichero.'.xlsx';
                if(file_exists($miruta)) {
                    include('../Classes/PHPExcel.php');
                    include('..*Classes/PHPExcel/Reader/Excel2007.php');
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
                        $hoja=0;
                        // Add new sheet
                        $objWorkSheet = $objPHPExcel->createSheet(0);
                            $objWorkSheet->setCellValue('A2', 'No.')
                                ->setCellValue('B2', 'ORDEN')
                                ->setCellValue('C2', 'TIPO ORDEN')
                                ->setCellValue('D2', 'FECHA ORDEN')
                                ->setCellValue('E2', 'DESCR. PROVEEEDOR')
                                ->setCellValue('F2', 'DESCRICPION')
                                ->setCellValue('G2', 'CANTIDAD SOLICITADA')
                                ->setCellValue('H2', 'CANTIDAD RECIBIDA')
                                ->setCellValue('I2', 'CANTIDAD DEVUELTAS')
                                ->setCellValue('J2', 'OLITIT')
                                ->setCellValue('K2', 'VALOR X UND.')
                                ->setCellValue('L2', 'TOTAL');
                             //colocar titulos a las hojas de excel
                            //$objWorkSheet->setTitle("$i");
                                $objWorkSheet->setTitle('LABORATORIOS_008');
                                $objPHPExcel->setActiveSheetIndex(0);
                                $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
                                $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
                                $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
                                $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
                                $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
                                $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
                                $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
                                $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
                                $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setBold(true);
                                $objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
                                $objPHPExcel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
                                $objPHPExcel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
                                
                                cellColor('A2:L2', 'C2C5CC');
                               
                $styleThinBlackBorderOutline = array(
                    'borders' => array (
                       'outline' => array (
                                     'style' => PHPExcel_Style_Border :: BORDER_THIN, // Establecer estilo de borde
                                     // 'estilo' => PHPExcel_Style_Border :: BORDER_THICK, otro estilo
                                     'color' => array ('argb' => 'FF000000'), // Establecer el color del borde
                      ),
                   ),
                );
                //$objPHPExcel->getActiveSheet()->getStyle( 'A2:L2')->applyFromArray($styleThinBlackBorderOutline);
                //$objPHPExcel->getActiveSheet()->getStyle( 'A3:L18')->applyFromArray($styleThinBlackBorderOutline);  
                }
                $objPHPExcel->getProperties()->setCreator("Autor: Agrocampo");
                $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo");
                $objPHPExcel->getProperties()->setTitle("Informe Agrocampo");
                $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
                $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
                $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
                $objPHPExcel->getProperties()->setCategory("Resultado de Informe"); 
                    ///////// revisar 
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
                        $fil++;
                    }
                //ANCHOS
                $objPHPExcel->setActiveSheetIndex(0);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
                
                $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('C1', "Ordenes en Estado Pendiente. Compras Pendientes Por Entregar a Corte: ".$fechaActual);
                $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
                
                $resultado1= $Conn->prepare($query1);
                $resultado1->execute();
                $datos1=$resultado1->fetchAll();
                $salto=0;
                $j=0;
                    foreach($datos1 as $dato1){
                        //proveedor
                        $pro=$dato1['proveedor'];
                        $array[$j]=$pro;
                        
                        //$r=$r."<p>".$query2."Ordenes de Compra Pendientes Por Entregar a Corte1: ".$pro."</p>";
                            $query2 = "select scrld.qty,scrld.state,
                            po.name as orden,pot.type_type as tipo_orden,po.state as estado_orden,po.date_order as fecha_orden,rp.ref as proveedor,rp.name as descr_proveedor,
                            pp.default_code as item,scrl.barcode as codigo_barras,pp.name_template as descripcion,
                            scrld.qty as cant_solicitada,scrld.qty as cant_recibida,
                            scrld.state as validar,scrld.state as estado_linea,po.amount_total as olitit,pol.price_unit as valor_und,
                            scr.state as contr_recepcion_state,scr.date as fecha_recepcion,
                            sw.name as nom_bodega,scrl.name as num_linea,
                            po.amount_total as total,po.origin as doc_origen,pol.price_unit as pre_unitario,sp.name as referencia
                            from stock_control_receipt as scr
                            left join stock_warehouse as sw on scr.warehouse_id=sw.id
                            left join stock_control_receipt_line as scrl on scr.id=scrl.receipt_id
                            left join stock_control_receipt_line_detail as scrld on scrl.id=scrld.line_id
                            left join product_product as pp on scrld.product_id=pp.id
                            left join product_template as pt on pp.product_tmpl_id=pt.id
                            left join purchase_order as po on scrld.purchase_id=po.id
                            left join purchase_order_line as pol on scrld.purchase_id=pol.id
                            left join res_partner as rp on po.partner_id=rp.id
                            left join stock_picking as sp on scrld.picking_id=sp.id
                            left join purchase_order_type as pot on scrld.purchase_type_id=pot.id
                            where sw.code='008' and sp.name like '%IN%' and scrld.state in ('transferred','returned') and rp.ref='$pro';";
                            
                            $resultado2= $Conn->prepare($query2);
                            $resultado2->execute();
                            $datos2=$resultado2->fetchAll();
                            $TOT='TOTAL';
                            foreach($datos2 as $dato2){
                                                    
                                if($d1!=''){
                                    if($array[$j]==$pro){
                                        for($e=0;$e<=1;$e++){
                                            if($e=1){//background-color: #7189C9;
                                                $r=$r."<tr style='background-color: #8598C8; border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                                                $r=$r."<td COLSPAN=10; style='width: 10%; font-size: 0.5em; border: 1px solid rgb(113,137,201);height: 10px;padding: 5px;'></td>
                                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>TOTAL</td>
                                                <td COLSPAN=10; style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$totalS."</td>";
                                            //EXCEL
                                            $objPHPExcel->setActiveSheetIndex(0)
                                            ->setCellValue('A'.$fd, '')            
                                            ->setCellValue('B'.$fd, '')
                                            ->setCellValueExplicitByColumnAndRow(2, $fd, '', PHPExcel_Cell_DataType::TYPE_STRING)
                                            ->setCellValueExplicitByColumnAndRow(3, $fd, '', PHPExcel_Cell_DataType::TYPE_STRING)
                                            ->setCellValue('E'.$fd, '')
                                            ->setCellValue('F'.$fd, '')
                                            ->setCellValue('F'.$fd, '')
                                            ->setCellValue('G'.$fd, '')
                                            ->setCellValue('H'.$fd, '')
                                            ->setCellValueExplicitByColumnAndRow(9, $fd, '', PHPExcel_Cell_DataType::TYPE_STRING)
                                            //->setCellValue('J'.$fd, $d8)
                                            ->setCellValueExplicitByColumnAndRow(10, $fd, $TOT, PHPExcel_Cell_DataType::TYPE_STRING)
                                            ->setCellValueExplicitByColumnAndRow(11, $fd, $totalS, PHPExcel_Cell_DataType::TYPE_STRING);
                                            //->setCellValue('K'.$fd, $d9)
                                            //->setCellValue('K'.$fd, $d10);
                                            $objPHPExcel->getActiveSheet()->getStyle('K'.$fd)->getFont()->setBold(true);
                                            $objPHPExcel->getActiveSheet()->getStyle('L'.$fd)->getFont()->setBold(true);
                                            $Colcel1='K'.$fd;
                                            $Colcel2='L'.$fd;
                                            cellColor($Colcel1, 'C2C5CC');
                                            cellColor($Colcel2, 'C2C5CC');
                                            //$objPHPExcel->getActiveSheet()->getStyle( $Colcel1)->applyFromArray($styleThinBlackBorderOutline);
                                            //$objPHPExcel->getActiveSheet()->getStyle( $Colcel2)->applyFromArray($styleThinBlackBorderOutline);  
                                              $fd++;
                                            }
                                            if($e=2){
                                                $totalS=0;
                                                $r=$r."<tr style='background-color: #EEF2FC;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                                                $r=$r."<td COLSPAN=10; style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'></td>
                                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'></td>
                                                <td COLSPAN=10; style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'></td>"; 
                                            //EXCEL
                                            $objPHPExcel->setActiveSheetIndex(0)
                                            ->setCellValue('A'.$fd, '')            
                                            ->setCellValue('B'.$fd, '')
                                            ->setCellValueExplicitByColumnAndRow(2, $fd, '', PHPExcel_Cell_DataType::TYPE_STRING)
                                            ->setCellValueExplicitByColumnAndRow(3, $fd, '', PHPExcel_Cell_DataType::TYPE_STRING)
                                            ->setCellValue('E'.$fd, '')
                                            ->setCellValue('F'.$fd, '')
                                            ->setCellValue('F'.$fd, '')
                                            ->setCellValue('G'.$fd, '')
                                            ->setCellValue('H'.$fd, '')
                                            ->setCellValueExplicitByColumnAndRow(9, $fd, '', PHPExcel_Cell_DataType::TYPE_STRING)
                                            //->setCellValue('J'.$fd, $d8)
                                            ->setCellValueExplicitByColumnAndRow(10, $fd, '', PHPExcel_Cell_DataType::TYPE_STRING)
                                            ->setCellValueExplicitByColumnAndRow(11, $fd, '', PHPExcel_Cell_DataType::TYPE_STRING);
                                            //->setCellValue('K'.$fd, $d9)
                                            //->setCellValue('K'.$fd, $d10);
                                              $fd++;
                                            }
                                        }
                                    }
                                 }  
                                 
                                //$r=$r."<p>Ordenes de Compra Pendientes Por Entregar a Corte2: ".$query2."</p>";
                                if(($i%2)==0){
                                        $color="#AED6F1";
                                    }else{
                                        $color="#E8F6F3";
                                    }
                                $d1=$dato2['orden'];
                                $d2=$dato2['tipo_orden'];
                                $d3=$dato2['fecha_orden'];
                                $d4=$dato2['descr_proveedor'];
                                $d5=$dato2['descripcion'];
                                $d6=$dato2['cant_solicitada'];
                                if ($dato2['validar']=='transferred'){
                                    $d7r=$dato2['cant_recibida'];
                                    //$d10=$dato1['cant_solicitada'];
                                }else if ($dato2['validar']=='returned'){
                                    $d7d=$dato2['cant_recibida'];
                                    //$d10=$dato1['cant_solicitada'];
                                }else{
                                    $d7r=0;
                                    $d7d=0;
                                }
                                $d8=$dato2['olitit'];
                                $d9=$dato2['valor_und'];
                                $d10=$dato2['total'];
                                
                                $totalS=$totalS+$d10;
                                
                                
                                            $r=$r."<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                                            $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$i."</td>
                                            <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d1."</td>
                                            <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d2."</td>
                                            <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d3."</td>
                                            <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d4."</td>
                                            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d5."</td>
                                            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d6."</td>
                                            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d7r."</td>
                                            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d7d."</td>
                                            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d8."</td>
                                            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d9."</td>
                                            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d10."</td>
                                            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'></td>";
                                            $r=$r."</tr>";
                                
                                                                            
                                //EXCEL
                                $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('A'.$fd, $i)            
                                    ->setCellValue('B'.$fd, $d1)
                                    ->setCellValueExplicitByColumnAndRow(2, $fd, $d2, PHPExcel_Cell_DataType::TYPE_STRING)
                                    ->setCellValueExplicitByColumnAndRow(3, $fd, $d3, PHPExcel_Cell_DataType::TYPE_STRING)
                                    ->setCellValue('E'.$fd, $d4)
                                    ->setCellValue('F'.$fd, $d5)
                                    ->setCellValue('F'.$fd, $d6)
                                    ->setCellValue('G'.$fd, $d7r)
                                    ->setCellValue('H'.$fd, $d7d)
                                    ->setCellValueExplicitByColumnAndRow(9, $fd, $d8, PHPExcel_Cell_DataType::TYPE_STRING)
                                    //->setCellValue('J'.$fd, $d8)
                                    ->setCellValueExplicitByColumnAndRow(10, $fd, $d9, PHPExcel_Cell_DataType::TYPE_STRING)
                                    ->setCellValueExplicitByColumnAndRow(11, $fd, $d10, PHPExcel_Cell_DataType::TYPE_STRING);
                                    //->setCellValue('K'.$fd, $d9)
                                    //->setCellValue('K'.$fd, $d10);
                                    $Exc1='A'.$fd;
                                    $Exc2='L'.$fd;
                                $i++;
                                $fd++;
                                $j++;
                                //$objPHPExcel->getActiveSheet()->getStyle( $Exc1)->applyFromArray($styleThinBlackBorderOutline);  
                                
                            }
                            
                    }
                    $ValorT=$totalS;
                    $TOT='TOTAL';
                    if($d1!=''){
                        if($array[$j]==$pro){
                            for($a=0;$a<=1;$a++){
                                if($a=1){
                                            $r=$r."<tr style='background-color: #8598C8;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                                            $r=$r."<td COLSPAN=10; style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'></td>
                                            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>TOTAL</td>
                                            <td COLSPAN=10; style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$ValorT."</td>";
                                //EXCEL
                                $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('A'.$fd, '')            
                                    ->setCellValue('B'.$fd, '')
                                    ->setCellValueExplicitByColumnAndRow(2, $fd, '', PHPExcel_Cell_DataType::TYPE_STRING)
                                    ->setCellValueExplicitByColumnAndRow(3, $fd, '', PHPExcel_Cell_DataType::TYPE_STRING)
                                    ->setCellValue('E'.$fd, '')
                                    ->setCellValue('F'.$fd, '')
                                    ->setCellValue('F'.$fd, '')
                                    ->setCellValue('G'.$fd, '')
                                    ->setCellValue('H'.$fd, '')
                                    ->setCellValueExplicitByColumnAndRow(9, $fd, '', PHPExcel_Cell_DataType::TYPE_STRING)
                                    //->setCellValue('J'.$fd, $d8)
                                    ->setCellValueExplicitByColumnAndRow(10, $fd, $TOT, PHPExcel_Cell_DataType::TYPE_STRING)
                                    ->setCellValueExplicitByColumnAndRow(11, $fd, $totalS, PHPExcel_Cell_DataType::TYPE_STRING);
                                    //->setCellValue('K'.$fd, $d9)
                                    //->setCellValue('K'.$fd, $d10);
                                    $Colcel3='K'.$fd;
                                    $Colcel4='L'.$fd;
                                    cellColor($Colcel3, 'C2C5CC');
                                    cellColor($Colcel4, 'C2C5CC');
                                    $fd++;
                                } 
                                if($a=2){
                                    $totalS=0;
                                            $r=$r."<tr style='background-color: #EEF2FC;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                                            $r=$r."<td COLSPAN=10; style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'></td>
                                            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'></td>
                                            <td COLSPAN=10; style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'></td>";
                                //EXCEL
                                $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('A'.$fd, '')          
                                    ->setCellValue('B'.$fd, '')
                                    ->setCellValueExplicitByColumnAndRow(2, $fd, '', PHPExcel_Cell_DataType::TYPE_STRING)
                                    ->setCellValueExplicitByColumnAndRow(3, $fd, '', PHPExcel_Cell_DataType::TYPE_STRING)
                                    ->setCellValue('E'.$fd, '')
                                    ->setCellValue('F'.$fd, '')
                                    ->setCellValue('F'.$fd, '')
                                    ->setCellValue('G'.$fd, '')
                                    ->setCellValue('H'.$fd, '')
                                    ->setCellValueExplicitByColumnAndRow(9, $fd, '', PHPExcel_Cell_DataType::TYPE_STRING)
                                    //->setCellValue('J'.$fd, $d8)
                                    ->setCellValueExplicitByColumnAndRow(10, $fd, '', PHPExcel_Cell_DataType::TYPE_STRING)
                                    ->setCellValueExplicitByColumnAndRow(11, $fd, '', PHPExcel_Cell_DataType::TYPE_STRING);
                                    //->setCellValue('K'.$fd, $d9)
                                    //->setCellValue('K'.$fd, $d10);
                                      $fd++;
                                }
                            }
                        }
                    }
                }
                    

$r=$r . "</table>";
Conexion::cerrarConexion();
//CREA ARCHIVO************************************************************
    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    //Guardar el achivo: 
    $objWriter->save($mipath2);
echo $r;
//echo $fecha;
?>