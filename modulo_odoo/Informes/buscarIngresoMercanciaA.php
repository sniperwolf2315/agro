<?php
include_once 'usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

$anio=trim($_GET['a']);
$mes=trim($_GET['m']);

//fecha inicio fecha din de la consulta x mes
$dia = cal_days_in_month(CAL_GREGORIAN, $mes, $anio); // 31
$feini=$anio."-".$mes."-01 00:00:00";
$fefin=$anio."-".$mes."-".$dia." 23:59:59";

        $r=$r."<table style=\"border: 1px solid #000; width:100%; \" class=\"#439049 green darken-1\">";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">";
        $r=$r."<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Orden</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CP</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Referencia Interna</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Cantidad</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Estado</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Codigo Interno</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Nombre</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">cod Bodega</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Costo</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Fecha</td>
        <td><Strong><a href='Informexls/Informe_Ingreso005.xlsx' class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>";
        $r=$r."</tr>";
//echo "dias: {$dia} <br>"."Fecha inicial: ".$feini."<br>"."fecha Fin: ".$fefin;



//echo "valo_1: ".$anio." Valor_2: ".$mes;
//".$feini."' and '".$fefin."';"
//$query = "select * from stock_control_receipt where date between '".$anio."-".$mes."-01' and '".$anio."-".$mes."-20';";
/*$query1 = "select scrl.receipt_id,scr.state as estado_recep,sp.origin as orden_compra,sp.name as referencia,scr.name as consecutivo,sw.name as bodega,scr.date as fec_recepcion,
        scrl.barcode,scrl.barcode as cod_producto,scrl.name as line_relacion,pt.description,pp.name_template as nom_producto,
        pt.category_1_name as grupo,scrld.qty as recibidos_devueltos,scrld.qty as facturados,'' as bonificados,
        scrl.expiration as vencimientos,scrl.lot_id as lote,rp.display_name as proveedor_tercero,sp.invoice_state as procesado,
        scrld.state as est_devolucion,
        scr.msg_warning,ru.login as usuario,
        scrl.max_days_expiration,
        pot.name as tipo,
        pp.default_code as refe_interna,
        sqp.name as estiba
from stock_control_receipt as scr
left join res_partner as rp on scr.provider_id=rp.id
left join res_users as ru on scr.user_id=ru.id
left join stock_warehouse as sw on scr.warehouse_id=sw.id
left join stock_control_receipt_line as scrl on scr.id=scrl.receipt_id
left join stock_control_receipt_line_detail as scrld on scrl.receipt_id=scrld.receipt_id
left join stock_picking as sp on scrld.picking_id=sp.id
left join purchase_order_type as pot on scrld.purchase_type_id=pot.id
left join product_product as pp on scrl.product_id=pp.id
left join product_template as pt on pp.product_tmpl_id=pt.id
left join stock_pack_operation as spo on scrl.receipt_id=spo.receipt_id
left join stock_quant_package as sqp on spo.result_package_id=sqp.id
where scr.state='done' and scr.type_reception='provider' and scr.date between '".$feini."' and '".$fefin."' and rp.ref not like '8600069284'
  and sw.code='005' and scrl.warehouse_id is not null and scrl.receipt_id is not null and sp.name like '%IN%' 
  and scrl.receipt_id is not null;";*/
$query1 = "select 
r.date as fecha, 
o.name as name1, 
r.name as name2, 
q.name as name3, 
m.product_qty as cantidad, 
m.state as estado, 
p.default_code as cod_int, 
p.name_template as name, 
w.code cod_bodega, 
m.cost as costo 
--m.last_product_qty as canti
from purchase_order o
left join purchase_order_line l on o.id=l.id
left join stock_move m ON o.name=m.origin
left join stock_control_receipt_line_detail d ON m.id=d.move_id
left join stock_control_receipt r ON d.receipt_id=r.id
left join product_product p ON m.product_id=p.id
left join stock_warehouse w on m.warehouse_id = w.id
right join stock_picking q ON m.picking_id=q.id
where m.state='done' and w.code='008' and r.date between '".$feini."' and '".$fefin."';";
  
$i=1;
$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Ingreso Mercancia Almacen. Fecha Inicio: ".$feini." - hasta: ".$fefin.".</p>";

                $fd=3;
                // $r="Informexls/Informe_Inventario008.xlsx"
                $miruta='Informexls/';
                $nombre_fichero = 'Informe_Ingreso005';
                $mipath=$miruta.$nombre_fichero.'.xlsx';
                if(file_exists($miruta)) {
                    include('Classes/PHPExcel.php');
                    include('Classes/PHPExcel/Reader/Excel2007.php');
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
                        
                        $objWorkSheet = $objPHPExcel->createSheet(0);
                            
                            $objWorkSheet->setCellValue('A2', 'No.')
                                ->setCellValue('B2', 'Orden')
                                ->setCellValue('C2', 'CP')
                                ->setCellValue('D2', 'Referencia Interna')
                                ->setCellValue('E2', 'Cantidad')
                                ->setCellValue('F2', 'Estado')
                                ->setCellValue('G2', 'Codigo Interno')
                                ->setCellValue('H2', 'Nombre')
                                ->setCellValue('I2', 'cod_Bodega')
                                ->setCellValue('J2', 'Costo')
                                ->setCellValue('K2', 'Fecha');
                             
                            
                            $objWorkSheet->setTitle("Ingreso Mercancia 005");
                        }
                    
                }
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
                    $fil++;
                }
                //ANCHOS
                $objPHPExcel->setActiveSheetIndex(0);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(35);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(35);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(15);
                
                $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A1', "Ingreso Mercancia 005");
                $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                $resultado1= $Conn->prepare($query1);
            $resultado1->execute();
            $datos1=$resultado1->fetchAll();
            foreach($datos1 as $dato1){
                if(($i%2)==0){
                        $color="#AED6F1";
                    }else{
                        $color="#E8F6F3";
                    }
                $d1=$dato1['name1'];
                $d2=$dato1['name2'];
                $d3=$dato1['name3'];
                $d4=$dato1['cantidad'];
                $d5=$dato1['estado'];
                $d6=$dato1['cod_int'];
                $d7=$dato1['name'];
                $d8=$dato1['cod_bodega'];
                $d9=$dato1['costo'];
                $d10=$dato1['fecha'];
                
                                $r=$r."<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.5em;'>";
                                $r=$r."<td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(120,120,120);height: 10px;padding: 0px;'>".$i."</td>
                                <td style='width: 19%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(120,120,120);height: 10px;padding: 0px;'>".$d1."</td>
                                <td style='width: 19%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(120,120,120);height: 10px;padding: 0px;'>".$d2."</td>
                                <td style='width: 19%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(120,120,120);height: 10px;padding: 0px;'>".$d3."</td>
                                <td style='width: 19%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(120,120,120);height: 10px;padding: 0px;'>".$d4."</td>
                                <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(120,120,120);height: 10px;padding: 0px;'>".$d5."</td>
                                <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(120,120,120);height: 10px;padding: 0px;'>".$d6."</td>
                                <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(120,120,120);height: 10px;padding: 0px;'>".$d7."</td>
                                <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(120,120,120);height: 10px;padding: 0px;'>".$d8."</td>
                                <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(120,120,120);height: 10px;padding: 0px;'>".$d9."</td>
                                <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(120,120,120);height: 10px;padding: 0px;'>".$d10."</td>
                                <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(120,120,120);height: 10px;padding: 0px;'></td>";
                                $r=$r."</tr>";
                                //$r=$r . "<td style=\"font-weight: bold;text-align: left;\"><Strong><a href='Informexls/Informe_Inventario008.xlsx'>Descargar</a><Strong></td>";
                                
                /*//filas
                $r=$r . "<tr style='background-color: $color; font-size: 0.5em;'>";
                $r =$r. "<td style='padding: 5px;'>".$i."</td>
                <td style='padding: 5px;'>".$d1."</td>
                <td style='padding: 5px;'>".$d2."</td>
                <td style='padding: 5px;'>".$d3."</td>
                <td style='padding: 5px;'>".$d4."</td>
                <td style='padding: 5px;'>".$d5."</td>
                <td style='padding: 5px;'>".$d6."</td>
                <td style='padding: 5px;'>".$d7."</td>
                <td style='padding: 5px;'>".$d8."</td>
                <td style='padding: 5px;'>".$d9."</td>
                <td style='padding: 5px;'>".$d10."</td>
                <td style='padding: 5px;'>".$d11."</td>
                <td style='padding: 5px;'>".$d12."</td>
                <td style='padding: 5px;'>".$d13."</td>
                <td style='padding: 5px;'>".$d14."</td>
                <td style='padding: 5px;'>".$d15."</td>
                <td style='padding: 5px;'>".$d16."</td>
                <td style='padding: 5px;'>".$d17."</td>
                <td style='padding: 5px;'>".$d18."</td>
                <td style='padding: 5px;'>".$d19."</td>
                <td style='padding: 5px;'>".$d20."</td>
                <td style='padding: 5px;'>".$d21."</td>
                <td style='padding: 5px;'>".$d22."</td>
                <td style='padding: 5px;'>".$d23."</td>
                <td style='padding: 5px;'>".$d24."</td>
                <td style='padding: 5px;'>".$d25."</td>
                <td>&nbsp;</td>";
                $r=$r . "</tr>";
                $i++;*/
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
                    ->setCellValueExplicitByColumnAndRow(10, $fd, $d10, PHPExcel_Cell_DataType::TYPE_STRING);
                    //->setCellValue('K'.$fd, $d10)
                    /*->setCellValue('L'.$fd, $d11)
                    ->setCellValue('M'.$fd, $d12)
                    ->setCellValue('N'.$fd, $d13)
                    ->setCellValue('O'.$fd, $d14)
                    ->setCellValue('P'.$fd, $d15)
                    ->setCellValue('Q'.$fd, $d16)
                    ->setCellValue('R'.$fd, $d17)
                    ->setCellValue('S'.$fd, $d18)
                    ->setCellValue('T'.$fd, $d19)
                    ->setCellValue('U'.$fd, $d20)
                    ->setCellValue('V'.$fd, $d21)
                    ->setCellValue('W'.$fd, $d22)
                    ->setCellValue('X'.$fd, $d23)
                    ->setCellValue('Y'.$fd, $d24)
                    ->setCellValue('Z'.$fd, $d25);
                */
                    $fd++;
                    $i++;
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