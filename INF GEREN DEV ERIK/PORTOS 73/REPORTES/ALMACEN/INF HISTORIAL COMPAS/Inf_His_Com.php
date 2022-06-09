<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

//$anio=trim($_GET['a']);
//$mes=trim($_GET['m']);

//generar fecha actual
$diaA = date('d');
$mesA = date('m');
//$mesA=$mesA-1;
setlocale(LC_TIME, 'es_ES');
$fecha = DateTime::createFromFormat('!m', $mesA);
$mesN = strftime("%B", $fecha->getTimestamp());
$anioA = date('Y');
$fechaActual=$diaA." - ".$mesN." - ".$anioA;

$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Informe Historial de Compras a Corte: ".$fechaActual."</p>";//Fecha Inicio: ".$feini." - hasta: ".$fefin.".

//fecha inicio fecha din de la consulta x mes
//echo "dias: {$dia} <br>"."Fecha inicial: ".$feini."<br>"."fecha Fin: ".$fefin;
        $r=$r."<table style=\"border: 1px solid #000; width:100%; \" class=\"#439049 green darken-1\" >";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.6em;\">";
        $r=$r."<td style=\"font-weight: bold;text-align: left; padding: 5px;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">ITEM</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">DESCRIPCIÓN</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">GRUPOS</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">ORDEN</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">TIPO ORDEN</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">ESTADO ORDEN</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">FECHA ORDEN</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">FECHA ORDEN LINEA</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">FECHA DE INGRESO</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CANTIDAD ORDEN</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CANTIDAD RECIBIDA</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">COSTO PROM</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">COSTO TOTAL</td>
        <td><a href='Informexls/Inf_His_Compras.xlsx'class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>";
        $r=$r."</tr>";
        //Informe_Ingreso008.xlsx'>Descargar</a><Strong></td>";




//echo "valo_1: ".$anio." Valor_2: ".$mes;
//".$feini."' and '".$fefin."';"
//$query = "select * from stock_control_receipt where date between '".$anio."-".$mes."-01' and '".$anio."-".$mes."-20';";
$query1 = "select pp.default_code as item,pp.name_template as descripcion,left(pc.name,3) as grupos,po.name as orden,pot.type_type as tipo_orden,po.state as estado_orden,
po.date_order as fecha_orden,'' as fecha_orden_linea,scr.date as fecha_ingreso,scrld.qty as cant_orden,scrld.qty as cant_recibida,
scr.name as nom_recep,'' as costo_promedio,po.amount_total as costo_total
from stock_control_receipt as scr
    left join stock_control_receipt_line as scrl on scr.id=scrl.receipt_id
    left join stock_control_receipt_line_detail as scrld on scrl.id=scrld.line_id
    left join purchase_order as po on scrld.purchase_id=po.id
    left join purchase_order_type as pot on scrld.purchase_type_id=pot.id
left join product_product pp on scrld.product_id=pp.id
left join product_template pt on pp.product_tmpl_id=pt.id
left join product_category pc on pt.categ_id=pc.id
where po.name is not null;";
  
//$r=$r."<p>Ordenes de Compra Pendientes.</p>";//Fecha Inicio: ".$feini." - hasta: ".$fefin.".

                $fd=3;
                // $r="Informexls/Informe_Inventario008.xlsx"
                $miruta='../Informexls/';
                $nombre_fichero = 'Inf_His_Compras';
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
                                ->setCellValue('B2', 'ITEM')
                                ->setCellValue('C2', 'DESCRIPCIÓN')
                                ->setCellValue('D2', 'GRUPOS')
                                ->setCellValue('E2', 'ORDEN')
                                ->setCellValue('F2', 'TIPO ORDEN')
                                ->setCellValue('G2', 'ESTADO ORDEN')
                                ->setCellValue('H2', 'FECHA ORDEN')
                                ->setCellValue('I2', 'FECHA ORDEN LINEA')
                                ->setCellValue('J2', 'FECHA DE INGRESO')
                                ->setCellValue('K2', 'CANTIDAD ORDEN')
                                ->setCellValue('L2', 'CANTIDAD RECIBIDA')
                                ->setCellValue('M2', 'COSTO PROM')
                                ->setCellValue('N2', 'COSTO TOTAL');
                             //colocar titulos a las hojas de excel
                            //$objWorkSheet->setTitle("$i");
                                $objWorkSheet->setTitle('Inf_His_Compras_005');

                    
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
                        $fil++;
                }
                //ANCHOS
                $objPHPExcel->setActiveSheetIndex(0);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(35);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
                
                $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('C1', "Informe Historial de Compras a Corte: ".$fechaActual);
                $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
                $resultado1= $Conn->prepare($query1);
            $resultado1->execute();
            $datos1=$resultado1->fetchAll();

            $i=1;
            foreach($datos1 as $dato1){
                if(($i%2)==0){
                        $color="#AED6F1";
                    }else{
                        $color="#E8F6F3";
                    }
                $d1=$dato1['item'];
                $d2=$dato1['descripcion'];
                $d3=$dato1['grupos'];
                $d4=$dato1['orden'];
                $d5=$dato1['tipo_orden'];
                $d6=$dato1['estado_orden'];
                $d7=$dato1['fecha_orden'];
                $d8=$dato1['fecha_orden_linea'];
                $d9=$dato1['fecha_ingreso'];
                $d10=$dato1['cant_orden'];
                $d11=$dato1['cant_recibida'];
                $d12=$dato1['costo_promedio'];
                $d13=$dato1['costo_total'];
                $Imp_pag=number_format($d13);
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
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d11."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d12."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$Imp_pag."</td>
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
                        ->setCellValue('G'.$fd, $d6)
                        ->setCellValueExplicitByColumnAndRow(7, $fd, $d7, PHPExcel_Cell_DataType::TYPE_STRING)
                        //->setCellValue('H'.$fd, $d7)
                        ->setCellValueExplicitByColumnAndRow(8, $fd, $d8, PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValue('J'.$fd, $d9)
                        ->setCellValueExplicitByColumnAndRow(10, $fd, $d10, PHPExcel_Cell_DataType::TYPE_STRING)
                        //->setCellValue('K'.$fd, $d10)
                        ->setCellValue('L'.$fd, $d11)
                        ->setCellValue('M'.$fd, $d12)
                        ->setCellValue('N'.$fd, $Imp_pag);
                $i++;
                $fd++;
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