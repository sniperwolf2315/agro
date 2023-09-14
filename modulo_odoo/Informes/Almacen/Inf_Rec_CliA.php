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

$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Informe Reclamaci&oacute;n Por Cliente a Corte: ".$fechaActual."</p>";//Fecha Inicio: ".$feini." - hasta: ".$fefin.".

//fecha inicio fecha din de la consulta x mes
//echo "dias: {$dia} <br>"."Fecha inicial: ".$feini."<br>"."fecha Fin: ".$fefin;
        $r=$r."<table style=\"border: 1px solid #000; width:100%; \" class=\"#439049 green darken-1\" >";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.6em;\">";
        $r=$r."<td style=\"font-weight: bold;text-align: left; padding: 5px;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Numero de Factura</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Numero de Orden</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Tipo De Orden</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Bodega</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Item</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Item Descripci&oacute;n</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Cliente</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Fecha Orden</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Estado Orden</td>
        <td><a href='Informexls/Inf_His_ComprasA.xlsx'class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>";
        $r=$r."</tr>";
        //Informe_Ingreso008.xlsx'>Descargar</a><Strong></td>";




//echo "valo_1: ".$anio." Valor_2: ".$mes;
//".$feini."' and '".$fefin."';"
//$query = "select * from stock_control_receipt where date between '".$anio."-".$mes."-01' and '".$anio."-".$mes."-20';";
$query1 = "select ai.number as factura,so.name as orden,qt.name as tip_orden,sw.name as bodega,
       pp.default_code as item,pp.name_template as descripci,rp.name as cliente,so.date_order as fec_orden,so.state as estado,ai.id
from quotation_type qt
left join sale_order so on qt.id=so.quotation_type_id
left join account_invoice ai on so.id=ai.sale_id
left join stock_warehouse sw on so.warehouse_id=sw.id
left join account_invoice_line ail on ai.id=ail.invoice_id
left join product_product pp on ail.product_id=pp.id
left join res_partner rp on so.partner_id=rp.id
where left(qt.name ,2) in ('77','Z7');";
  
//$r=$r."<p>Ordenes de Compra Pendientes.</p>";//Fecha Inicio: ".$feini." - hasta: ".$fefin.".

                $fd=3;
                // $r="Informexls/Informe_Inventario008.xlsx"
                $miruta='../Informexls/';
                $nombre_fichero = 'Inf_His_ComprasA';
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
                                ->setCellValue('B2', 'Numero de Factura')
                                ->setCellValue('C2', 'Numero de Orden')
                                ->setCellValue('D2', 'Tipo De Orden')
                                ->setCellValue('E2', 'Bodega')
                                ->setCellValue('F2', 'Item')
                                ->setCellValue('G2', 'Item Descripcion')
                                ->setCellValue('H2', 'Cliente')
                                ->setCellValue('I2', 'Fecha Orden')
                                ->setCellValue('J2', 'Estado Orden');
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
                        $fil++;
                }
                //ANCHOS
                $objPHPExcel->setActiveSheetIndex(0);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(45);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(35);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(35);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
                
                $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('C1', "Informe Reclamacion Por Cliente a Corte: ".$fechaActual);
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
                $d1=$dato1['factura'];
                $d2=$dato1['orden'];
                $d3=$dato1['tip_orden'];
                $d4=$dato1['bodega'];
                $d5=$dato1['item'];
                $d6=$dato1['descripci'];
                $d7=$dato1['cliente'];
                $d8=$dato1['fec_orden'];
                $d9=$dato1['estado'];
                
                //$Imp_pag=number_format($d13);
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
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'></td>";
                                $r=$r."</tr>";

                //EXCEL
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A'.$fd, $i)            
                        //->setCellValue('B'.$fd, $d1)
                        ->setCellValueExplicitByColumnAndRow(1, $fd, $d1, PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicitByColumnAndRow(2, $fd, $d2, PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicitByColumnAndRow(3, $fd, $d3, PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValue('E'.$fd, $d4)
                        ->setCellValue('F'.$fd, $d5)
                        ->setCellValue('G'.$fd, $d6)
                        ->setCellValueExplicitByColumnAndRow(7, $fd, $d7, PHPExcel_Cell_DataType::TYPE_STRING)
                        //->setCellValue('H'.$fd, $d7)
                        ->setCellValueExplicitByColumnAndRow(8, $fd, $d8, PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValue('J'.$fd, $d9);
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