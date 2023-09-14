<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

$KitsA=trim($_GET['k']);
$inic=trim($_GET['i']);
$fin=trim($_GET['f']);

if($inic != '' && $fin != ''){
    $buscafecha=" and (ai.date_invoice between '".$inic."' and '".$fin."')";
} else{
    $buscafecha="";
}

$diaA = date('d');

$mesA = date('m');
//$mesA=$mesA-1;
setlocale(LC_TIME, 'es_ES');
$fecha = DateTime::createFromFormat('!m', $mesA);
$mesN = strftime("%B", $fecha->getTimestamp());

$anioA = date('Y');
$fechaActual=$diaA." - ".$mesN." - ".$anioA;

$query1="select ai.date_invoice as fecha,ai.internal_number as factura,so.name as orden,
       (case when pt.active='true' then 'producto activo' else (case when pt.active='false' then 'producto inactivo' else '' end) end) AS estado_produc,
(case when pt.kit_ok='true' then 'kit_activo' else (case when pt.kit_ok='false' then 'kit_inactivo' else '' end) end) AS estado_kit,
pp.default_code as cod_producto,pp.name_template as producto,
left(cast(pc.name as varchar),3) as grupo,
sq.qty as cantidad,
mb.active,mb.name,sol.price_iva_tax as valor_exc_iva,pt.list_price as valor_inc_iva
from stock_quant sq
right join product_product AS pp ON sq.product_id=pp.id
left join product_template AS pt ON pp.product_tmpl_id=pt.id
left join  mrp_bom AS mb ON mb.product_tmpl_id=pt.id
left join product_list_item AS pli ON pli.product_id=pp.id
left join product_category AS pc ON pc.id=pli.categ_id
left join sale_order_line sol on pp.id=sol.product_id
left join sale_order as so on sol.order_id=so.id
left join account_invoice as ai on so.id=ai.sale_id
where pt.kit_ok='true' $buscafecha;";

//echo 'Fecha Inicio: '.$inic.' Fecha Fin'.$fin.' QUERY: '.$query1;
//exit();
$resultado1= $Conn->prepare($query1);
$resultado1->execute();
$datos1=$resultado1->fetchAll();
$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Reporte Kits Padre a corte del: $fechaActual</p>";
    $i=1;
        $r=$r."<table style=\"border: 1px solid #000; width:100%;\" class=\"#009688 teal\" >";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">";
        $r=$r."<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Fecha</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Factura</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Orden</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Estado del Producto</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Estado del Kit</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Item Padre</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Descr Padre</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Grupo</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Cantidad</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Valor Exc Iva</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Valor Inc Iva</td>
        <td><a href='Informexls/Inf_Kits_Padre.xlsx' class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>";
        $r=$r . "</tr>";

        $fd=3;
        // $r="Informexls/Informe_Inventario008.xlsx"
        $miruta='../Informexls/';
        $nombre_fichero = 'Inf_Kits_Padre';
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
                             ->setCellValue('B2', 'Fecha')
                             ->setCellValue('C2', 'Factura')
                             ->setCellValue('D2', 'Orden')
                             ->setCellValue('E2', 'Estado del Producto')
                             ->setCellValue('F2', 'Estado del Kit')
                             ->setCellValue('G2', 'Item Padre')
                             ->setCellValue('H2', 'Descr Padre')
                             ->setCellValue('I2', 'Grupo')
                             ->setCellValue('J2', 'Cantidad')
                             ->setCellValue('K2', 'Valor Exc Iva')
                             ->setCellValue('L2', 'Valor Inc Iva');
                //colocar titulos a las hojas de excel
                //$objWorkSheet->setTitle("$i");
                $objWorkSheet->setTitle('Kits Padre');                    
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
                        $fil++;
                }
                //ANCHOS
                $objPHPExcel->setActiveSheetIndex(0);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(50);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
                
                    $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('C1', "Reporte Kist Padre a corte del: ".$fechaActual);
                    $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        
//DATOS        
foreach($datos1 as $dato1){
        if(($i%2)==0){
            $color="#AED6F1";
        }else{
            $color="#E8F6F3";
        }
        $d2=$dato1['fecha'];
        $d3=$dato1['factura'];
        $d4=$dato1['orden'];
        $d5=$dato1['estado_produc'];
        $d6=$dato1['estado_kit'];
        $d7=$dato1['cod_producto'];
        $d8=$dato1['producto'];
        $d9=$dato1['grupo'];
        $d10=$dato1['cantidad'];
        $d11=$dato1['valor_exc_iva'];
        $d12=$dato1['valor_inc_iva'];
        
        $Imp_pag=number_format($d10);
        $val_exc=number_format($d11);
        $val_inc=number_format($d12);
            //$r=$r."<p>Categorizaci&oacute;n Credito y Cartera.</p>";
            $r=$r."<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
            $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$i."</td>
                   <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d2."</td>
                   <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d3."</td>
                   <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d4."</td>
                   <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d5."</td>
                   <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d6."</td>
                   <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d7."</td>
                   <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d8."</td>
                   <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d9."</td>
                   <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$Imp_pag."</td>
                   <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$val_exc."</td>
                   <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$val_inc."</td>
                   <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'></td>";
            $r=$r."</tr>";
            //EXCEL
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$fd, $i)
            ->setCellValueExplicitByColumnAndRow(1, $fd, $d2, PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicitByColumnAndRow(2, $fd, $d3, PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicitByColumnAndRow(3, $fd, $d4, PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValue('E'.$fd, $d5)
            ->setCellValue('F'.$fd, $d6)
            ->setCellValueExplicitByColumnAndRow(6, $fd, $d7, PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValue('H'.$fd, $d8)
            ->setCellValue('I'.$fd, $d9)
            ->setCellValue('J'.$fd, $Imp_pag)
            ->setCellValue('K'.$fd, $val_exc)
            ->setCellValue('L'.$fd, $val_inc);
        $i++;
        $fd++;                    
    }
}
$r=$r . "</table>";
//CREA ARCHIVO************************************************************
    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    //Guardar el achivo: 
    $objWriter->save($mipath2);
//CERRRAR CONEXION BASE
mssql_close();

echo $r;
?>