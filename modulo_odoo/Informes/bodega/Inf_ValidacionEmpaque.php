<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

$inicial=trim($_GET['i']);
$fin=trim($_GET['f']);
//fecha inicio fecha din de la consulta x mes
//$dia = cal_days_in_month(CAL_GREGORIAN, $mes, $anio); // 31
//$feini=$anio."-".$mes."-01";// 00:00:00
//$feini1=$anio.$mes."01";
//$fefin=$anio."-".$mes."-".$dia;//.$dia;  ." 23:59:59"
//$fefin1=$anio.$mes.$dia;
$query1="select cp.name as documento_validado,res_partner.name as usuario_valido,sale_order.name as orden,
    stock_picking.name as documento_entrega,account_invoice.number as factura,
    left(cast(cp.date as varchar),16) as fecha_inicio,
    left(cast(cp.date_end as varchar),16) as fecha_fin,
    (select count(id) from stock_control_packaging_line where stock_control_packaging_line.control_id=cp.id) as lineas_separo,
    cp.packages as cajas
    from stock_control_packaging cp
    inner join res_users on res_users.id=cp.user_id
    inner join res_partner on res_partner.id=res_users.partner_id
    inner join stock_picking on stock_picking.id=cp.picking_id
    left join sale_order on sale_order.name=stock_picking.origin
    left join account_invoice on account_invoice.stock_picking_id =stock_picking.id
    where cp.date between '$inicial' and '$fin'
    ORDER BY cp.date ASC";

$resultado1= $Conn->prepare($query1);
$resultado1->execute();
$datos1=$resultado1->fetchAll();
//echo "aquies2".$feini."--".$fefin;

$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Validaci&oacute;n y Empaque del periodo: ".$inicial." Hasta el: ".$fin." </p>";
//var_dump($datos); 
//echo "<span style='color: black; font-weight: bold;' >INVENTARIO BODEGA</span>";
    $r=$r."<table style=\"border: 1px solid #000; width:100%; \" class=\"#439049 green darken-1\">";
    $r=$r . "<tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">";
    $r=$r."<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Documento Validado</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Usuario Validado</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No. Orden</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Documento de Entrega</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Factura</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Fecha de Inicio</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Fecha Fin</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Lineas Separadas</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Cajas</td>
    <td><a href='Informexls/Validacion_Empaque008.xlsx' class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>";
    $r=$r . "</tr>";
    $i=1;
        //excel
        $fd=3;
       // $r="Informexls/Informe_Inventario008.xlsx"
        $miruta='../Informexls/';
        $nombre_fichero = 'Validacion_Empaque008';
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
                
                $objWorkSheet = $objPHPExcel->createSheet(0);
                    
                    $objWorkSheet->setCellValue('A2', 'No.')
                        ->setCellValue('B2', 'Documento Validado')
                        ->setCellValue('C2', 'Usuario Validado')
                        ->setCellValue('D2', 'No. Orden')
                        ->setCellValue('E2', 'Documento de Entrega')
                        ->setCellValue('F2', 'Factura')
                        ->setCellValue('G2', 'Fecha de Inicio')
                        ->setCellValue('H2', 'Fecha Fin')
                        ->setCellValue('I2', 'Lineas Separadas')
                        ->setCellValue('J2', 'Cajas');
                     
                    
                    $objWorkSheet->setTitle("Validacion y Empaque");
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
            $fil++;
        }
        //ANCHOS
        $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        
        $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1', "Validacion y Empaque ".$inicial." Hasta el: ".$fin);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);


//DATOS 
$fil=3;
foreach($datos1 as $dato1){
        if(($i%2)==0){
            $color="#AED6F1";
        }else{
            $color="#E8F6F3";
        }
        $d1=$dato1['documento_validado'];
        $d2=$dato1['usuario_valido'];
        $d3=$dato1['orden'];
        $d4=$dato1['documento_entrega'];
        $d5=$dato1['factura'];
        $d6=$dato1['fecha_inicio'];
        $d7=$dato1['fecha_fin'];
        $d8=$dato1['lineas_separo'];
        $d9=$dato1['cajas'];
        
            
            $r=$r."<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
            //$r=$r."<tr style='background-color: $color; font-size: 0.5em;'>";
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
            //padding: 5px;
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
            ->setCellValue('I'.$fd, $d8)
            ->setCellValue('J'.$fd, $d9);
                
            $i++;
            $fd++;
} //fin while 


$r=$r . "</table>";
Conexion::cerrarConexion();
//CREA ARCHIVO************************************************************
    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    //Guardar el achivo: 
    $objWriter->save($mipath2);
echo $r;
?>