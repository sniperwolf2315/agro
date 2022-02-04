<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

//$anio=trim($_GET['a']);
//$mes=trim($_GET['m']);
$tipo=trim($_GET['t']);

$diaA = date('d');
$mesA = date('m');
//$mesA=$mesA-1;
setlocale(LC_TIME, 'es_ES');
$fecha = DateTime::createFromFormat('!m', $mesA);
$mesN = strftime("%B", $fecha->getTimestamp());
$anioA = date('Y');
$fechaActual=$diaA." - ".$mesN." - ".$anioA;

//colocar color a las celdas de excel
function cellColor($cells,$color){
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
    'startcolor' => array('rgb' => $color)));
}

$query1 = "select scrld.qty,scrld.state,
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
                    where sw.code='008' and sp.name like '%IN%' and scrld.state in ('transferred','returned') and scr.state='progress';";
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
                    left join product_category_level pcl ON pt.category_1_id=pcl.id
                    where sw.code='008' and sp.name like '%IN%' and scrld.state in ('transferred','returned') and pcl.code='GANADERIA';";
$query3 = "select scrld.qty,scrld.state,
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
                    where sw.code='008' and sp.name like '%IN%' and scrld.state in ('transferred','returned') and scr.state='cancel';";
$query4 = "select scrld.qty,scrld.state,
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
                    where sw.code='008' and sp.name like '%IN%' and scrld.state in ('transferred','returned') and scr.state='done';";
$query6 = "select rp.ref as proveedor, rp.name from purchase_order as po
                    left join res_partner as rp on po.partner_id=rp.id
                    group by rp.ref, rp.name;";
                    
$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Esta visualizando el informe: ".$tipo."</p>";
$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Ordenes en Estado Pendiente. Compras Pendientes Por Entregar a Corte: ".$fechaActual."</p>";//Fecha Inicio: ".$feini." - hasta: ".$fefin.".

//echo "dias: {$dia} <br>"."Fecha inicial: ".$feini."<br>"."fecha Fin: ".$fefin;
        $r=$r."<table style=\"border: 1px solid #000; width:100%;\" class=\"#439049 green darken-1\">";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.6em;\">";
        $r=$r."<td style=\"font-weight: bold;text-align: left; padding: 5px; \" class=\"z-depth-1 white-text text-darken-2\">No.</td>
        <td style=\"font-weight: bold;text-align: left; \" class=\"z-depth-1 white-text text-darken-2\">ORDEN</td>
        <td style=\"font-weight: bold;text-align: left; \" class=\"z-depth-1 white-text text-darken-2\">TIPO ORDEN</td>
        <td style=\"font-weight: bold;text-align: left; \" class=\"z-depth-1 white-text text-darken-2\">FECHA ORDEN</td>
        <td style=\"font-weight: bold;text-align: left; \" class=\"z-depth-1 white-text text-darken-2\">DESCR. PROVEEEDOR</td>
        <td style=\"font-weight: bold;text-align: left; \" class=\"z-depth-1 white-text text-darken-2\">DESCRICPION</td>
        <td style=\"font-weight: bold;text-align: left; \" class=\"z-depth-1 white-text text-darken-2\">CANTIDAD SOLICITADA</td>
        <td style=\"font-weight: bold;text-align: left; \" class=\"z-depth-1 white-text text-darken-2\">CANTIDAD RECIBIDA</td>
        <td style=\"font-weight: bold;text-align: left; \" class=\"z-depth-1 white-text text-darken-2\">CANTIDAD DEVUELTAS</td>
        <td style=\"font-weight: bold;text-align: left; \" class=\"z-depth-1 white-text text-darken-2\">OLITIT</td>
        <td style=\"font-weight: bold;text-align: left; \" class=\"z-depth-1 white-text text-darken-2\">VALOR X UND.</td>
        <td style=\"font-weight: bold;text-align: left; \" class=\"z-depth-1 white-text text-darken-2\">TOTAL</td><td>
        <a href='Informexls/ORDENES_PENDIENTES_008.xlsx' class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>";
        $r=$r."</tr>";

        $fd=3;
        // $r="Informexls/Informe_Inventario008.xlsx"
        $miruta='../Informexls/';
        $nombre_fichero = 'ORDENES_PENDIENTES_008';
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
                $conH=0;
                for($hojH=0; $hojH<6; $hojH++){
                    $objPHPExcel->getProperties()->setCreator("Autor: Agrocampo");
                    $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo");
                    $objPHPExcel->getProperties()->setTitle("Informe Agrocampo");
                    $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
                    $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
                    $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
                    $objPHPExcel->getProperties()->setCategory("Resultado de Informe"); 
                    // Add new sheet
                    
                    if($conH==0){
                        $objWorkSheet = $objPHPExcel->createSheet(0);
                        $objWorkSheet->setCellValue('A2', 'No.')
                                     ->setCellValue('B2', 'ORDEN')
                                     ->setCellValue('C2', 'TIPO ORDEN')
                                     ->setCellValue('D2', 'ESTADO ORDEN')
                                     ->setCellValue('E2', 'FECHA ORDEN')
                                     ->setCellValue('F2', 'PROVEEEDOR')
                                     ->setCellValue('G2', 'DESCR. PROVEEDOR')
                                     ->setCellValue('H2', 'ITEM')
                                     ->setCellValue('I2', 'CODIGO DE BARRAS')
                                     ->setCellValue('J2', 'DESCRICPION')
                                     ->setCellValue('K2', 'CANTIDAD SOLICITADA')
                                     ->setCellValue('L2', 'CANTIDAD RECIBIDA')
                                     ->setCellValue('M2', 'CANTIDAD DEVUELTAS')
                                     ->setCellValue('N2', 'ESTADO LINEA')
                                     ->setCellValue('O2', 'OLITIT')
                                     ->setCellValue('P2', 'VALOR X UND.')
                                     ->setCellValue('Q2', 'TOTAL');
                                   //colocar titulos a las hojas de excel
                                   //$objWorkSheet->setTitle("$i");
                        $objWorkSheet->setTitle('Progreso_008');
                    }else if($conH==1){
                        $objWorkSheet = $objPHPExcel->createSheet(1);
                        $objWorkSheet->setCellValue('A2', 'No.')
                                     ->setCellValue('B2', 'ORDEN')
                                     ->setCellValue('C2', 'TIPO ORDEN')
                                     ->setCellValue('D2', 'ESTADO ORDEN')
                                     ->setCellValue('E2', 'FECHA ORDEN')
                                     ->setCellValue('F2', 'PROVEEEDOR')
                                     ->setCellValue('G2', 'DESCR. PROVEEDOR')
                                     ->setCellValue('H2', 'ITEM')
                                     ->setCellValue('I2', 'CODIGO DE BARRAS')
                                     ->setCellValue('J2', 'DESCRICPION')
                                     ->setCellValue('K2', 'CANTIDAD SOLICITADA')
                                     ->setCellValue('L2', 'CANTIDAD RECIBIDA')
                                     ->setCellValue('M2', 'CANTIDAD DEVUELTAS')
                                     ->setCellValue('N2', 'ESTADO LINEA')
                                     ->setCellValue('O2', 'OLITIT')
                                     ->setCellValue('P2', 'VALOR X UND.')
                                     ->setCellValue('Q2', 'TOTAL');
                                   //colocar titulos a las hojas de excel
                                   //$objWorkSheet->setTitle("$i");
                        $objWorkSheet->setTitle('Ganaderia_008');
                    }else if($conH==2){
                        $objWorkSheet = $objPHPExcel->createSheet(2);
                        $objWorkSheet->setCellValue('A2', 'No.')
                                     ->setCellValue('B2', 'ORDEN')
                                     ->setCellValue('C2', 'TIPO ORDEN')
                                     ->setCellValue('D2', 'ESTADO ORDEN')
                                     ->setCellValue('E2', 'FECHA ORDEN')
                                     ->setCellValue('F2', 'PROVEEEDOR')
                                     ->setCellValue('G2', 'DESCR. PROVEEDOR')
                                     ->setCellValue('H2', 'ITEM')
                                     ->setCellValue('I2', 'CODIGO DE BARRAS')
                                     ->setCellValue('J2', 'DESCRICPION')
                                     ->setCellValue('K2', 'CANTIDAD SOLICITADA')
                                     ->setCellValue('L2', 'CANTIDAD RECIBIDA')
                                     ->setCellValue('M2', 'CANTIDAD DEVUELTAS')
                                     ->setCellValue('N2', 'ESTADO LINEA')
                                     ->setCellValue('O2', 'OLITIT')
                                     ->setCellValue('P2', 'VALOR X UND.')
                                     ->setCellValue('Q2', 'TOTAL');
                                   //colocar titulos a las hojas de excel
                                   //$objWorkSheet->setTitle("$i");
                        $objWorkSheet->setTitle('Cancelado_008');
                    }else if($conH==3){
                        $objWorkSheet = $objPHPExcel->createSheet(3);
                        $objWorkSheet->setCellValue('A2', 'No.')
                                     ->setCellValue('B2', 'ORDEN')
                                     ->setCellValue('C2', 'TIPO ORDEN')
                                     ->setCellValue('D2', 'ESTADO ORDEN')
                                     ->setCellValue('E2', 'FECHA ORDEN')
                                     ->setCellValue('F2', 'PROVEEEDOR')
                                     ->setCellValue('G2', 'DESCR. PROVEEDOR')
                                     ->setCellValue('H2', 'ITEM')
                                     ->setCellValue('I2', 'CODIGO DE BARRAS')
                                     ->setCellValue('J2', 'DESCRICPION')
                                     ->setCellValue('K2', 'CANTIDAD SOLICITADA')
                                     ->setCellValue('L2', 'CANTIDAD RECIBIDA')
                                     ->setCellValue('M2', 'CANTIDAD DEVUELTAS')
                                     ->setCellValue('N2', 'ESTADO LINEA')
                                     ->setCellValue('O2', 'OLITIT')
                                     ->setCellValue('P2', 'VALOR X UND.')
                                     ->setCellValue('Q2', 'TOTAL');
                                   //colocar titulos a las hojas de excel
                                   //$objWorkSheet->setTitle("$i");
                        $objWorkSheet->setTitle('Transferido_008');
                    }else if($conH==4){
                        $objWorkSheet = $objPHPExcel->createSheet(4);
                        $objWorkSheet->setCellValue('A2', 'No.')
                                     ->setCellValue('B2', 'ORDEN')
                                     ->setCellValue('C2', 'TIPO ORDEN')
                                     ->setCellValue('D2', 'ESTADO ORDEN')
                                     ->setCellValue('E2', 'FECHA ORDEN')
                                     ->setCellValue('F2', 'PROVEEEDOR')
                                     ->setCellValue('G2', 'DESCR. PROVEEDOR')
                                     ->setCellValue('H2', 'ITEM')
                                     ->setCellValue('I2', 'CODIGO DE BARRAS')
                                     ->setCellValue('J2', 'DESCRICPION')
                                     ->setCellValue('K2', 'CANTIDAD SOLICITADA')
                                     ->setCellValue('L2', 'CANTIDAD RECIBIDA')
                                     ->setCellValue('M2', 'CANTIDAD DEVUELTAS')
                                     ->setCellValue('N2', 'ESTADO LINEA')
                                     ->setCellValue('O2', 'OLITIT')
                                     ->setCellValue('P2', 'VALOR X UND.')
                                     ->setCellValue('Q2', 'TOTAL');
                                   //colocar titulos a las hojas de excel
                                   //$objWorkSheet->setTitle("$i");
                        $objWorkSheet->setTitle('Pets_008');
                    }else if($conH==5){
                        $objWorkSheet = $objPHPExcel->createSheet(5);
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
                        $objWorkSheet->setTitle('Laboratorios_008');
                        $objPHPExcel->setActiveSheetIndex(5);
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
                    }
                    $conH++;                  
                }
            }
            
            $objPHPExcel->getProperties()->setCreator("Autor: Agrocampo");
            $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo");
            $objPHPExcel->getProperties()->setTitle("Informe Agrocampo");
            $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
            $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
            $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
            $objPHPExcel->getProperties()->setCategory("Resultado de Informe"); 
             
            //BORRAR DTOS
            $conB=0;
            for($hojB=0; $hojB<6; $hojB++){
                if($conB==0){
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
                        $fil++;
                    }
                }else if($conB==1){
                    $fil=3;
                    $objPHPExcel->setActiveSheetIndex(1);
                    $totalreg = $objPHPExcel->setActiveSheetIndex(1)->getHighestRow();
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
                        $fil++;
                    }
                }else if($conB==2){
                    $fil=3;
                    $objPHPExcel->setActiveSheetIndex(2);
                    $totalreg = $objPHPExcel->setActiveSheetIndex(2)->getHighestRow();
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
                        $fil++;
                    }
                }else if($conB==3){
                    $fil=3;
                    $objPHPExcel->setActiveSheetIndex(3);
                    $totalreg = $objPHPExcel->setActiveSheetIndex(3)->getHighestRow();
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
                        $fil++;
                    }
                }else if($conB==4){
                    $fil=3;
                    $objPHPExcel->setActiveSheetIndex(4);
                    $totalreg = $objPHPExcel->setActiveSheetIndex(4)->getHighestRow();
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
                        $fil++;
                    }
                }else if($conB==5){
                    $fil=3;
                    $objPHPExcel->setActiveSheetIndex(5);
                    $totalreg = $objPHPExcel->setActiveSheetIndex(5)->getHighestRow();
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
                        $fil++;
                    }
                }
                $conB++;
            }
            
            //ANCHOS
            $ia=0;
            while ($ia <= 5) {
                $objPHPExcel->setActiveSheetIndex($ia);
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(35);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(50);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
                
                $objPHPExcel->setActiveSheetIndex($ia)
                                ->setCellValue('C1', "Ordenes en Estado Pendiente. Compras Pendientes Por Entregar a Corte: ".$fechaActual);
                $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
                $ia++;
            }
        
        $queA=0;
        for($queB=0; $queB<6; $queB++){
            if($queA==0){
                $fd=3;
                $i0=0;
                $resultadoodoo= $Conn->prepare($query1);
                $resultadoodoo->execute();
                $datos1=$resultadoodoo->fetchAll();
                foreach($datos1 as $dato1){
                    if(($i0%2)==0){
                            $color="#AED6F1";
                        }else{
                            $color="#E8F6F3";
                        }
                    $d1=$dato1['orden'];
                    $d2=$dato1['tipo_orden'];
                    $d3=$dato1['estado_orden'];
                    $d4=$dato1['fecha_orden'];
                    $d5=$dato1['proveedor'];
                    $d6=$dato1['descr_proveedor'];
                    $d7=$dato1['item'];
                    $d8=$dato1['codigo_barras'];
                    $d9=$dato1['descripcion'];
                    $d10=$dato1['cant_solicitada'];
                    //$d11=$dato1['cant_recibida'];
                    
                    if ($dato1['validar']=='transferred'){
                        $d11r=$dato1['cant_recibida'];
                        //$d10=$dato1['cant_solicitada'];
                    }else if ($dato1['validar']=='returned'){
                        $d11d=$dato1['cant_recibida'];
                        //$d10=$dato1['cant_solicitada'];
                    }else{
                        $d11r=0;
                        $d11d=0;
                    }
                    $d12=$dato1['estado_linea'];
                    $d13=$dato1['olitit'];
                    $d14=$dato1['valor_und'];
                    $d15=$dato1['total'];
                    
                    /*
                        $r=$r."<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                        $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$i."</td>
                        <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d1."</td>
                        <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d2."</td>
                        <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d3."</td>
                        <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d4."</td>
                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d5."</td>
                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d6."</td>
                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d7."</td>
                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d8."</td>
                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d9."</td>
                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d10."</td>
                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d11r."</td>
                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d11d."</td>
                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d12."</td>
                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d13."</td>
                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d14."</td>
                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d15."</td>
                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'></td>";
                        $r=$r."</tr>";*/
    
                    //EXCEL
                    $objPHPExcel->setActiveSheetIndex($queA)
                            ->setCellValue('A'.$fd, $i0)            
                            ->setCellValue('B'.$fd, $d1)
                            ->setCellValueExplicitByColumnAndRow(2, $fd, $d2, PHPExcel_Cell_DataType::TYPE_STRING)
                            ->setCellValueExplicitByColumnAndRow(3, $fd, $d3, PHPExcel_Cell_DataType::TYPE_STRING)
                            ->setCellValue('E'.$fd, $d4)
                            ->setCellValue('F'.$fd, $d5)
                            ->setCellValue('G'.$fd, $d6)
                            ->setCellValueExplicitByColumnAndRow(7, $fd, $d7, PHPExcel_Cell_DataType::TYPE_STRING)
                            //->setCellValue('H'.$fd, $d7)
                            ->setCellValueExplicitByColumnAndRow(8, $fd, $d8, PHPExcel_Cell_DataType::TYPE_STRING)
                            ->setCellValue('J'.$fd, $d9)
                            ->setCellValueExplicitByColumnAndRow(10, $fd, $d10, PHPExcel_Cell_DataType::TYPE_STRING)
                            //->setCellValue('K'.$fd, $d10)
                            ->setCellValue('L'.$fd, $d11r)
                            ->setCellValue('M'.$fd, $d11d)
                            ->setCellValue('N'.$fd, $d12)
                            ->setCellValue('O'.$fd, $d13)
                            ->setCellValue('P'.$fd, $d14)
                            ->setCellValue('Q'.$fd, $d15);
                    
                    $i0++;
                    $fd++;
                }
            }else if($queA==1){
                $fd=3;
                $i1=0;
                $resultado2= $Conn->prepare($query2);
                $resultado2->execute();
                $datos2=$resultado2->fetchAll();

                foreach($datos2 as $dato2){
                    if(($i1%2)==0){
                            $color="#AED6F1";
                        }else{
                            $color="#E8F6F3";
                        }
                    $d1=$dato2['orden'];
                    $d2=$dato2['tipo_orden'];
                    $d3=$dato2['estado_orden'];
                    $d4=$dato2['fecha_orden'];
                    $d5=$dato2['proveedor'];
                    $d6=$dato2['descr_proveedor'];
                    $d7=$dato2['item'];
                    $d8=$dato2['codigo_barras'];
                    $d9=$dato2['descripcion'];
                    $d10=$dato2['cant_solicitada'];
                    
                    if ($dato2['validar']=='transferred'){
                        $d11r=$dato2['cant_recibida'];
                    }else if ($dato2['validar']=='returned'){
                        $d11d=$dato2['cant_recibida'];
                    }else{
                        $d11r=0;
                        $d11d=0;
                    }
                    $d12=$dato2['estado_linea'];
                    $d13=$dato2['olitit'];
                    $d14=$dato2['valor_und'];
                    $d15=$dato2['total'];
    
                    /*
                                    $r=$r."<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                                    $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$i."</td>
                                    <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d1."</td>
                                    <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d2."</td>
                                    <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d3."</td>
                                    <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d4."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d5."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d6."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d7."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d8."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d9."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d10."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d11r."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d11d."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d12."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d13."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d14."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d15."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'></td>";
                                    $r=$r."</tr>";*/
    
                    //EXCEL
                        $objPHPExcel->setActiveSheetIndex($queA)
                            ->setCellValue('A'.$fd, $i1)            
                            ->setCellValue('B'.$fd, $d1)
                            ->setCellValueExplicitByColumnAndRow(2, $fd, $d2, PHPExcel_Cell_DataType::TYPE_STRING)
                            ->setCellValueExplicitByColumnAndRow(3, $fd, $d3, PHPExcel_Cell_DataType::TYPE_STRING)
                            ->setCellValue('E'.$fd, $d4)
                            ->setCellValue('F'.$fd, $d5)
                            ->setCellValue('G'.$fd, $d6)
                            ->setCellValueExplicitByColumnAndRow(7, $fd, $d7, PHPExcel_Cell_DataType::TYPE_STRING)
                            //->setCellValue('H'.$fd, $d7)
                            ->setCellValueExplicitByColumnAndRow(8, $fd, $d8, PHPExcel_Cell_DataType::TYPE_STRING)
                            ->setCellValue('J'.$fd, $d9)
                            ->setCellValueExplicitByColumnAndRow(10, $fd, $d10, PHPExcel_Cell_DataType::TYPE_STRING)
                            //->setCellValue('K'.$fd, $d10)
                            ->setCellValue('L'.$fd, $d11r)
                            ->setCellValue('M'.$fd, $d11d)
                            ->setCellValue('N'.$fd, $d12)
                            ->setCellValue('O'.$fd, $d13)
                            ->setCellValue('P'.$fd, $d14)
                            ->setCellValue('Q'.$fd, $d15);
                    $i1++;
                    $fd++;
                }
            }else if($queA==2){
                $fd=3;
                $i2=0;
                $resultado3= $Conn->prepare($query3);
                $resultado3->execute();
                $datos3=$resultado3->fetchAll();
                foreach($datos3 as $dato3){
                    if(($i2%2)==0){
                            $color="#AED6F1";
                        }else{
                            $color="#E8F6F3";
                        }
                    $d1=$dato3['orden'];
                    $d2=$dato3['tipo_orden'];
                    $d3=$dato3['estado_orden'];
                    $d4=$dato3['fecha_orden'];
                    $d5=$dato3['proveedor'];
                    $d6=$dato3['descr_proveedor'];
                    $d7=$dato3['item'];
                    $d8=$dato3['codigo_barras'];
                    $d9=$dato3['descripcion'];
                    $d10=$dato3['cant_solicitada'];
                    
                    if ($dato3['validar']=='transferred'){
                        $d11r=$dato3['cant_recibida'];
                    }else if ($dato3['validar']=='returned'){
                        $d11d=$dato3['cant_recibida'];
                    }else{
                        $d11r=0;
                        $d11d=0;
                    }
                    $d12=$dato3['estado_linea'];
                    $d13=$dato3['olitit'];
                    $d14=$dato3['valor_und'];
                    $d15=$dato3['total'];
    
                    /*
                                    $r=$r."<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                                    $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$i."</td>
                                    <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d1."</td>
                                    <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d2."</td>
                                    <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d3."</td>
                                    <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d4."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d5."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d6."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d7."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d8."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d9."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d10."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d11r."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d11d."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d12."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d13."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d14."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d15."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'></td>";
                                    $r=$r."</tr>";*/
    
                    //EXCEL
                        $objPHPExcel->setActiveSheetIndex($queA)
                            ->setCellValue('A'.$fd, $i2)            
                            ->setCellValue('B'.$fd, $d1)
                            ->setCellValueExplicitByColumnAndRow(2, $fd, $d2, PHPExcel_Cell_DataType::TYPE_STRING)
                            ->setCellValueExplicitByColumnAndRow(3, $fd, $d3, PHPExcel_Cell_DataType::TYPE_STRING)
                            ->setCellValue('E'.$fd, $d4)
                            ->setCellValue('F'.$fd, $d5)
                            ->setCellValue('G'.$fd, $d6)
                            ->setCellValueExplicitByColumnAndRow(7, $fd, $d7, PHPExcel_Cell_DataType::TYPE_STRING)
                            //->setCellValue('H'.$fd, $d7)
                            ->setCellValueExplicitByColumnAndRow(8, $fd, $d8, PHPExcel_Cell_DataType::TYPE_STRING)
                            ->setCellValue('J'.$fd, $d9)
                            ->setCellValueExplicitByColumnAndRow(10, $fd, $d10, PHPExcel_Cell_DataType::TYPE_STRING)
                            //->setCellValue('K'.$fd, $d10)
                            ->setCellValue('L'.$fd, $d11r)
                            ->setCellValue('M'.$fd, $d11d)
                            ->setCellValue('N'.$fd, $d12)
                            ->setCellValue('O'.$fd, $d13)
                            ->setCellValue('P'.$fd, $d14)
                            ->setCellValue('Q'.$fd, $d15);
                    
                    $i2++;
                    $fd++;
                }
            }else 
            if($queA==3){
                $fd=3;
                $i3=0;
                $resultado4= $Conn->prepare($query4);
                $resultado4->execute();
                $datos4=$resultado4->fetchAll();
                foreach($datos4 as $dato4){
                    if(($i3%2)==0){
                            $color="#AED6F1";
                        }else{
                            $color="#E8F6F3";
                        }
                    $d1=$dato4['orden'];
                    $d2=$dato4['tipo_orden'];
                    $d3=$dato4['estado_orden'];
                    $d4=$dato4['fecha_orden'];
                    $d5=$dato4['proveedor'];
                    $d6=$dato4['descr_proveedor'];
                    $d7=$dato4['item'];
                    $d8=$dato4['codigo_barras'];
                    $d9=$dato4['descripcion'];
                    $d10=$dato4['cant_solicitada'];
                    
                    if ($dato4['validar']=='transferred'){
                        $d11r=$dato4['cant_recibida'];
                    }else if ($dato4['validar']=='returned'){
                        $d11d=$dato4['cant_recibida'];
                    }else{
                        $d11r=0;
                        $d11d=0;
                    }
                    $d12=$dato4['estado_linea'];
                    $d13=$dato4['olitit'];
                    $d14=$dato4['valor_und'];
                    $d15=$dato4['total'];
                    
                         /*           $r=$r."<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                                    $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$i3."</td>
                                    <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d1."</td>
                                    <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d2."</td>
                                    <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d3."</td>
                                    <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d4."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d5."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d6."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d7."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d8."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d9."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d10."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d11r."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d11d."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d12."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d13."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d14."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d15."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'></td>";
                                    $r=$r."</tr>";*/
    
                    //EXCEL
                        $objPHPExcel->setActiveSheetIndex($queA)
                                ->setCellValue('A'.$fd, $i3)            
                                ->setCellValue('B'.$fd, $d1)
                                ->setCellValueExplicitByColumnAndRow(2, $fd, $d2, PHPExcel_Cell_DataType::TYPE_STRING)
                                ->setCellValueExplicitByColumnAndRow(3, $fd, $d3, PHPExcel_Cell_DataType::TYPE_STRING)
                                ->setCellValue('E'.$fd, $d4)
                                ->setCellValue('F'.$fd, $d5)
                                ->setCellValue('G'.$fd, $d6)
                                ->setCellValueExplicitByColumnAndRow(7, $fd, $d7, PHPExcel_Cell_DataType::TYPE_STRING)
                                //->setCellValue('H'.$fd, $d7)
                                ->setCellValueExplicitByColumnAndRow(8, $fd, $d8, PHPExcel_Cell_DataType::TYPE_STRING)
                                ->setCellValue('J'.$fd, $d9)
                                ->setCellValueExplicitByColumnAndRow(10, $fd, $d10, PHPExcel_Cell_DataType::TYPE_STRING)
                                //->setCellValue('K'.$fd, $d10)
                                ->setCellValue('L'.$fd, $d11r)
                                ->setCellValue('M'.$fd, $d11d)
                                ->setCellValue('N'.$fd, $d12)
                                ->setCellValue('O'.$fd, $d13)
                                ->setCellValue('P'.$fd, $d14)
                                ->setCellValue('Q'.$fd, $d15);
                        $i3++;
                        $fd++;
                }
            }else 
            if($queA==4){
                $fd=3;
                $i4=0;
                $resultSQL = mssql_query("SELECT CTPPGN,DESCRIPCION FROM [InformesCompVentas].[dbo].[infPeriodosAcumulados] WHERE DESCRIPCION LIKE '%MASCOTAS%' ORDER BY DESCRIPCION ASC;",$cLink);
                if($resultadocat = mssql_fetch_array($resultSQL)){
                    //items de mascotas (Pets)
                    $grupo=$resultadocat["CTPPGN"];
                    $descrip=$resultadocat["DESCRIPCION"];
                    
                    //query de odoo
                    $query5 = "select scrld.qty,scrld.state,pcl.code as NombreCategoria,left(pp.default_code,3) as Grupo,
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
                    left join product_category_level pcl ON pt.category_1_id=pcl.id
                    where sw.code='008' and sp.name like '%IN%' and scrld.state in ('transferred','returned') and pp.default_code like '%$grupo%';";//sw.code='008' and sp.name like '%IN%' and scrld.state in ('transferred','returned') and
                    $resultadoodoo5= $Conn->prepare($query5);
                    $resultadoodoo5->execute();
                    $datos5=$resultadoodoo5->fetchAll();
                    $i4=1;
                    
                    foreach($datos5 as $dato5){
                            if(($i4%2)==0){
                                $color="#AED6F1";
                            }else{
                                $color="#E8F6F3";
                            }
                            $d1=$dato5['orden'];
                            $d2=$dato5['tipo_orden'];
                            $d3=$dato5['estado_orden'];
                            $d4=$dato5['fecha_orden'];
                            $d5=$dato5['proveedor'];
                            $d6=$dato5['descr_proveedor'];
                            $d7=$dato5['item'];
                            $d8=$dato5['codigo_barras'];
                            $d9=$dato5['descripcion'];
                            $d10=$dato5['cant_solicitada'];
                            //$d11=$dato1['cant_recibida'];
                            
                            if ($dato5['validar']=='transferred'){
                                $d11r=$dato5['cant_recibida'];
                            }else if ($dato5['validar']=='returned'){
                                $d11d=$dato5['cant_recibida'];
                            }else{
                                $d11r=0;
                                $d11d=0;
                            }
                            $d12=$dato5['estado_linea'];
                            $d13=$dato5['olitit'];
                            $d14=$dato5['valor_und'];
                            $d15=$dato5['total'];
                            
                           /*             $r=$r."<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                                        $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$i."</td>
                                        <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d1."</td>
                                        <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d2."</td>
                                        <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d3."</td>
                                        <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d4."</td>
                                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d5."</td>
                                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d6."</td>
                                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d7."</td>
                                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d8."</td>
                                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d9."</td>
                                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d10."</td>
                                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d11r."</td>
                                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d11d."</td>
                                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d12."</td>
                                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d13."</td>
                                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d14."</td>
                                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d15."</td>
                                        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$grupo."</td>";
                                        $r=$r."</tr>";*/
                                        
                            //EXCEL
                            $objPHPExcel->setActiveSheetIndex($queA)
                                ->setCellValue('A'.$fd, $i4)            
                                ->setCellValue('B'.$fd, $d1)
                                ->setCellValueExplicitByColumnAndRow(2, $fd, $d2, PHPExcel_Cell_DataType::TYPE_STRING)
                                ->setCellValueExplicitByColumnAndRow(3, $fd, $d3, PHPExcel_Cell_DataType::TYPE_STRING)
                                ->setCellValue('E'.$fd, $d4)
                                ->setCellValue('F'.$fd, $d5)
                                ->setCellValue('G'.$fd, $d6)
                                ->setCellValueExplicitByColumnAndRow(7, $fd, $d7, PHPExcel_Cell_DataType::TYPE_STRING)
                                //->setCellValue('H'.$fd, $d7)
                                ->setCellValueExplicitByColumnAndRow(8, $fd, $d8, PHPExcel_Cell_DataType::TYPE_STRING)
                                ->setCellValue('J'.$fd, $d9)
                                ->setCellValueExplicitByColumnAndRow(10, $fd, $d10, PHPExcel_Cell_DataType::TYPE_STRING)
                                //->setCellValue('K'.$fd, $d10)
                                ->setCellValue('L'.$fd, $d11r)
                                ->setCellValue('M'.$fd, $d11d)
                                ->setCellValue('N'.$fd, $d12)
                                ->setCellValue('O'.$fd, $d13)
                                ->setCellValue('P'.$fd, $d14)
                                ->setCellValue('Q'.$fd, $d15);
                        $i4++;
                        $fd++;
                        }
                }
            }
            if($queA==5){
                $resultado6= $Conn->prepare($query6);
                $resultado6->execute();
                $datos6=$resultado6->fetchAll();
                $salto=0;
                $i=1;
                $j=0;
                    foreach($datos6 as $dato6){
                        //proveedor
                        $pro=$dato6['proveedor'];
                        $array[$j]=$pro;
                        
                        //$r=$r."<p>".$query2."Ordenes de Compra Pendientes Por Entregar a Corte1: ".$pro."</p>";
                            $query7 = "select scrld.qty,scrld.state,
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
                            
                            $resultado7= $Conn->prepare($query7);
                            $resultado7->execute();
                            $datos7=$resultado7->fetchAll();
                            $TOT='TOTAL1';
                            foreach($datos7 as $dato7){
                                $d1=$dato7['orden'];                    
                                if($d1!=''){
                                    if($array[$j]==$pro){
                                        if($salto!=0){
                                        for($e=0;$e<=2;$e++){
                                            if($e=1){//background-color: #7189C9;
                                                $r=$r."<tr style='background-color: #8598C8; border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                                                $r=$r."<td COLSPAN=10; style='width: 10%; font-size: 0.5em; border: 1px solid rgb(113,137,201);height: 10px;padding: 5px;'></td>
                                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>TOTAL</td>
                                                <td COLSPAN=10; style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$totalS."</td>";
                                            //EXCEL
                                            $objPHPExcel->setActiveSheetIndex($queA)
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
                                            $objPHPExcel->setActiveSheetIndex($queA)
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
                                    $salto++;
                                 }
                                 
                                //$r=$r."<p>Ordenes de Compra Pendientes Por Entregar a Corte2: ".$query2."</p>";
                                if(($i%2)==0){
                                        $color="#AED6F1";
                                    }else{
                                        $color="#E8F6F3";
                                    }
                                //$d1=$dato7['orden'];
                                $d2=$dato7['tipo_orden'];
                                $d3=$dato7['fecha_orden'];
                                $d4=$dato7['descr_proveedor'];
                                $d5=$dato7['descripcion'];
                                $d6=$dato7['cant_solicitada'];
                                if ($dato7['validar']=='transferred'){
                                    $d7r=$dato7['cant_recibida'];
                                }else if ($dato7['validar']=='returned'){
                                    $d7d=$dato7['cant_recibida'];
                                }else{
                                    $d7r=0;
                                    $d7d=0;
                                }
                                $d8=$dato7['olitit'];
                                $d9=$dato7['valor_und'];
                                $d10=$dato7['total'];
                                
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
                                $objPHPExcel->setActiveSheetIndex($queA)
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
                    $TOT='TOTAL2';
                    if($d1!=''){
                        if($array[$j]==$pro){
                            for($a=0;$a<=2;$a++){
                                if($a=1){
                                            $r=$r."<tr style='background-color: #8598C8;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                                            $r=$r."<td COLSPAN=10; style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'></td>
                                            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>TOTAL</td>
                                            <td COLSPAN=10; style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$ValorT."</td>";
                                //EXCEL
                                $objPHPExcel->setActiveSheetIndex($queA)
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
                                $objPHPExcel->setActiveSheetIndex($queA)
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
            $queA++;
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