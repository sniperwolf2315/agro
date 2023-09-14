<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

$tipo=trim($_GET['t']);
$diaA = date('d');

$mesA = date('m');
//$mesA=$mesA-1;
setlocale(LC_TIME, 'es_ES');
$fecha = DateTime::createFromFormat('!m', $mesA);
$mesN = strftime("%B", $fecha->getTimestamp());

$anioA = date('Y');
$fechaActual=$diaA." - ".$mesN." - ".$anioA;

include('conectarbase.php');

$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Esta visualizando el informe: ".$tipo."</p>";
$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Ordenes en Estado Pendiente. Compras Pendientes Por Entregar a Corte: ".$fechaActual."</p>";//Fecha Inicio: ".$feini." - hasta: ".$fefin.".

//echo "dias: {$dia} <br>"."Fecha inicial: ".$feini."<br>"."fecha Fin: ".$fefin;
        $r=$r."<table style=\"border: 1px solid #000; width:100%; \" class=\"#439049 green darken-1\" >";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.6em;\">";
        $r=$r."<td style=\"font-weight: bold;text-align: left; padding: 5px;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">ORDEN</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">TIPO ORDEN</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">ESTADO ORDEN</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">FECHA ORDEN</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">PROVEEEDOR</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">DESCR. PROVEEDOR</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">ITEM</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Codigo_Barras</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">DESCRICPION</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CANTIDAD SOLICITADA</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CANTIDAD RECIBIDA</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CANTIDAD DEVUELTAS</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">ESTADO LINEA</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">OLITIT</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">VALOR X UND.</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">TOTAL</td>
        <td><a href='Informexls/ORDENES_Pest_008.xlsx' class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>";
        $r=$r."</tr>";
$resultSQL = mssql_query("SELECT CTPPGN,DESCRIPCION FROM [InformesCompVentas].[dbo].[infPeriodosAcumulados] WHERE DESCRIPCION LIKE '%MASCOTAS%' ORDER BY DESCRIPCION ASC;",$cLink);

                $fd=3;
                // $r="Informexls/Informe_Inventario008.xlsx"
                $miruta='../Informexls/';
                $nombre_fichero = 'ORDENES_Pest_008';
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
                                $objWorkSheet->setTitle('PETS_008');                    
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
                        $objPHPExcel->getActiveSheet()->SetCellValue('N'.$fil, '');
                        $objPHPExcel->getActiveSheet()->SetCellValue('O'.$fil, '');
                        $objPHPExcel->getActiveSheet()->SetCellValue('P'.$fil, '');
                        $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$fil, '');
                        $fil++;
                }
                //ANCHOS
                $objPHPExcel->setActiveSheetIndex(0);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
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
                
                    $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('C1', "Ordenes en Estado Pendiente. Compras Pendientes Por Entregar a Corte: ".$fechaActual);
                    $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);

            if($resultadocat = mssql_fetch_array($resultSQL)){
                //items de mascotas (Pets)
                $grupo=$resultadocat["CTPPGN"];
                $descrip=$resultadocat["DESCRIPCION"];
                
                //query de odoo
                $query1 = "select scrld.qty,scrld.state,pcl.code as NombreCategoria,left(pp.default_code,3) as Grupo,
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
                $resultadoodoo= $Conn->prepare($query1);
                $resultadoodoo->execute();
                $datos=$resultadoodoo->fetchAll();
                $i=1;
                foreach($datos as $dato){
                        if(($i%2)==0){
                            $color="#AED6F1";
                        }else{
                            $color="#E8F6F3";
                        }
                        $d1=$dato['orden'];
                        $d2=$dato['tipo_orden'];
                        $d3=$dato['estado_orden'];
                        $d4=$dato['fecha_orden'];
                        $d5=$dato['proveedor'];
                        $d6=$dato['descr_proveedor'];
                        $d7=$dato['item'];
                        $d8=$dato['codigo_barras'];
                        $d9=$dato['descripcion'];
                        $d10=$dato['cant_solicitada'];
                        //$d11=$dato1['cant_recibida'];
                        
                        if ($dato['validar']=='transferred'){
                            $d11r=$dato['cant_recibida'];
                            //$d10=$dato1['cant_solicitada'];
                        }else if ($dato['validar']=='returned'){
                            $d11d=$dato['cant_recibida'];
                            //$d10=$dato1['cant_solicitada'];
                        }else{
                            $d11r=0;
                            $d11d=0;
                        }
                        $d12=$dato['estado_linea'];
                        $d13=$dato['olitit'];
                        $d14=$dato['valor_und'];
                        $d15=$dato['total'];
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
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$grupo."</td>";
                                    $r=$r."</tr>";
                                    
                        //EXCEL
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$fd, $i)            
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
                    $i++;
                    $fd++;
                    }
            }
    //}
}
Conexion::cerrarConexion();
mssql_close();
$r=$r . "</table>";
//CREA ARCHIVO************************************************************
    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    //Guardar el achivo: 
    $objWriter->save($mipath2);
$r=$r . "</table>";

echo $r;
?>