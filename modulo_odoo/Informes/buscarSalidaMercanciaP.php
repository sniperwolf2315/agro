<?php
include_once 'usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();



$anio=trim($_GET['a']);
$mes=trim($_GET['m']);
//$dia=trim($_GET['d']);
$tipo=trim($_GET['tipo']);
$company=trim($_GET['comp']);
$transp=trim($_GET['tran']);

$query="select so.id as id_orden,so.date_order as fec_orden,so.state as state_orden,so.name as orden,sw.name as ubi_bodega
from sale_order as so
left join stock_warehouse as sw on so.warehouse_id=sw.id
where so.name is not null and sw.code='008';";
$resultado= $Conn->prepare($query);
$resultado->execute();
$datos=$resultado->fetchAll();
$cantP=count($datos);
$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Salida Mercancia Portos.</p>";
    $i=1;
        $r=$r."<table style=\"border: 1px solid #000; width:100%; \" class=\"#439049 green darken-1\">";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">";
        $r=$r."<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Factura</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Orden</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Tipo</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Item</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Descrip</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Cantidad</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Bodega</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">FechaFinal</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Destino</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Transportador</td>
        <td><Strong><a href='Informexls/SALIDA_MERCANCIA_008.xlsx' class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>";
        $r=$r . "</tr>";
    
    $fd=3;
       // $r="Informexls/Informe_Inventario008.xlsx"
        $miruta='Informexls/';
        $nombre_fichero = 'SALIDA_MERCANCIA_008';
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
                    
                    $objWorkSheet->setCellValue('A2', '#')
                        ->setCellValue('B2', 'Factura')
                        ->setCellValue('C2', 'Orden')
                        ->setCellValue('D2', 'Tipo')
                        ->setCellValue('E2', 'Item')
                        ->setCellValue('F2', 'Descrip')
                        ->setCellValue('G2', 'Cantidad')
                        ->setCellValue('H2', 'Bodega')
                        ->setCellValue('I2', 'FechaFinal')
                        ->setCellValue('J2', 'Destino')
                        ->setCellValue('K2', 'Transportador');
                     
                    
                    $objWorkSheet->setTitle("SALIDA MERCANCIA 008");
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
            $fil++;
        }
        //ANCHOS
        $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(45);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
        
        $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1', "SALIDA MERCANCIA 008");
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        
//DATOS        
foreach($datos as $dato){
        $d1=$dato['id_orden'];
        $d2=$dato['fec_orden'];
        $d3=$dato['state_orden'];
        $d4=$dato['orden'];
        $d5=$dato['ubi_bodega'];
        //$alm=$alm.$i."id_orden".$d1."fec_orden".$d2."state_orden".$d3."orden:".$d4."ubi_bodega".$d5."|"."<br>";
        //$or=$or.$d1."<br>";
        //$alm2=explode("|",$alm);
        /*$alm3=explode("orden:",$alm);
        $r=$r."<table>";
        $r=$r."<tr style='background-color: $color; font-size: 0.5em;'>";
        //$r=$r."<td style='padding: 5px;'>".$i."</td><td style='padding: 5px;'>".$d1."</td><td style='padding: 5px;'>".$d2."</td><td style='padding: 5px;'>".$d3."</td><td style='padding: 5px;'>".$d4."</td><td style='padding: 5px;'>".$d5."</td><td style='padding: 5px;'>".$d6."</td><td style='padding: 5px;'>".$d7."</td><td style='padding: 5px;'>".$d8."</td><td style='padding: 5px;'>".$d9."</td><td style='padding: 5px;'>".$d10."</td><td style='padding: 5px;'>".$d11."</td><td style='padding: 5px;'>".$d12."</td><td>&nbsp;</td>";
        $r=$r."</tr>";*/
            $query="select ai.sale_id as id_orden,ai.number as factura,qt.name as tipo,pp.default_code as item,pt.name as descrip,spo.product_qty as cantidad,
                sdl.create_date as hora_final,rp.street as destino,sdl.vehicle_char as transportador
                FROM account_invoice as ai
                left join stock_picking as sp on ai.stock_picking_id=sp.id
                left join stock_picking_wave as spw on sp.wave_id=spw.id
                left join quotation_type as qt on ai.quotation_type_id=qt.id
                left join res_partner as rp on ai.partner_id=rp.id
                left join stock_pack_operation as spo on sp.id=spo.picking_id
                left join product_product as pp on spo.product_id=pp.id
                left join product_template as pt on pp.product_tmpl_id=pt.id
                left join stock_dispatches_line as sdl on ai.number=sdl.invoice_number
                left join account_fiscal_position as afp on ai.fiscal_position=afp.id
                where ai.number is not null and ai.sale_id='".$d1."';";
            $resultado= $Conn->prepare($query);
            $resultado->execute();
            $datos2=$resultado->fetchAll();
            $cantP=count($datos2);
            //$i=0;

            foreach($datos2 as $dato2){
                        $d11=$dato2['id_orden'];
                        $d12=$dato2['factura'];
                        $d13=$dato2['tipo'];
                        $d14=$dato2['item'];
                        $d15=$dato2['descrip'];
                        $d16=$dato2['cantidad'];
                        $d17=$dato2['hora_final'];
                        $d18=$dato2['destino'];
                        $d19=$dato2['transportador'];
                        //$alm2=$alm2.$i." _**".$d11."_".$d12."_".$d13."_".$d14."_".$d15."_".$d16."_".$d17."_".$d18."_".$d19."_**"."<br>";
                            $r=$r."<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.5em;'>";
                            $r=$r."<td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$i."</td>
                            <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d12."</td>
                            <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d4."</td>
                            <td style='width: 4%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d13."</td>
                            <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d14."</td>
                            <td style='width: 19%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d15."</td>
                            <td style='width: 4%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d16."</td>
                            <td style='width: 4%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d5."</td>
                            <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d17."</td>
                            <td style='width: 19%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d18."</td>
                            <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d19."</td>
                            <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'></td>
                            <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'></td>";
                            $r=$r."</tr>";
    /*
        $r=$r . "<tr>";
        $r=$r . "<td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d1."</td>
        <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d2."</td>
        <td style='width: 4%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d3."</td>
        <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d4."</td>
        <td style='width: 19%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d5."</td>";
        $r=$r . "</tr>";*/
        //EXCEL
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$fd, $i)            
            ->setCellValue('B'.$fd, $d12)
            ->setCellValue('C'.$fd, $d4)
            ->setCellValue('D'.$fd, $d13)
            //->setCellValueExplicitByColumnAndRow(2, $fd, $d4, PHPExcel_Cell_DataType::TYPE_STRING)
            //->setCellValueExplicitByColumnAndRow(3, $fd, $d13, PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValue('E'.$fd, $d14)
            ->setCellValue('F'.$fd, $d15)
            ->setCellValue('G'.$fd, $d16)
            ->setCellValue('H'.$fd, $d5)
            ->setCellValue('I'.$fd, $d17)
            ->setCellValue('J'.$fd, $d18)
            //->setCellValueExplicitByColumnAndRow(8, $fd, $d18, PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValue('K'.$fd, $d19);
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
            $i++;
            $fd++;
        }
        
}
$r=$r . "</table>";
//CERRRAR CONEXION BASE
mssql_close();
    //CREA ARCHIVO************************************************************
    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    //Guardar el achivo: 
    $objWriter->save($mipath2);

echo $r;
?>