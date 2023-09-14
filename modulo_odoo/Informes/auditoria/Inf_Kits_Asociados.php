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

//echo 'Fecha Inicio: '.$inic.' Fecha Fin'.$fin.' Tipo Kits: '.$KitsA;
//exit();
$diaA = date('d');

$mesA = date('m');
//$mesA=$mesA-1;
setlocale(LC_TIME, 'es_ES');
$fecha = DateTime::createFromFormat('!m', $mesA);
$mesN = strftime("%B", $fecha->getTimestamp());

$anioA = date('Y');
$fechaActual=$diaA." - ".$mesN." - ".$anioA;

$query1="select mb.id,ai.date_invoice as fecha,ai.internal_number as factura,so.name as orden,
       (case when mb.active='true' then 'kit_activo' else 'kit_inactivo' end) AS estado,
       pt.name as nom_kit,
       pp.name_template as des_com_kit,pp.default_code as cod_producto,left(cast(pc.name as varchar),3) as grupo,
       mb.product_qty as cantidad,
       pt.description,
       sol.price_iva_tax as valor_exc_iva,pt.list_price as valor_inc_iva
from mrp_bom as mb
left join mrp_bom_line as mbl on mb.id=mbl.bom_id   
left join product_product as pp on mbl.product_id=pp.id
left join product_template as pt on mb.product_tmpl_id=pt.id
left join product_list_item AS pli ON pli.product_id=pp.id
left join product_category AS pc ON pc.id=pli.categ_id
left join sale_order_line sol on pp.id=sol.product_id
left join sale_order as so on sol.order_id=so.id
left join account_invoice as ai on so.id=ai.sale_id
WHERE pt.kit_ok='true' $buscafecha;";

$resultado1= $Conn->prepare($query1);
$resultado1->execute();
$datos1=$resultado1->fetchAll();
$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Reporte Kits Asociados a corte del: $fechaActual</p>";
    $i=1;
        $r=$r."<table style=\"border: 1px solid #000; width:100%;\" class=\"#009688 teal\" >";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">";
        $r=$r."<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Fecha</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Factura</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Orden</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Estado del kit</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Nombre de kit</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Componentes del kit</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Codigo de Producto</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Grupo</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Cantidad</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Valor Exc Iva</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Valor Inc Iva</td>
        <td><a href='Informexls/Inf_Kits_Asociados.xlsx' class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>";
        $r=$r . "</tr>";
        
        $fd=3;
        // $r="Informexls/Informe_Inventario008.xlsx"
        $miruta='../Informexls/';
        $nombre_fichero = 'Inf_Kits_Asociados';
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
                             ->setCellValue('E2', 'Estado del kit')
                             ->setCellValue('F2', 'Nombre de kit')
                             ->setCellValue('G2', 'Componentes del kit')
                             ->setCellValue('H2', 'Codigo de Producto')
                             ->setCellValue('I2', 'Grupo')
                             ->setCellValue('J2', 'Cantidad')
                             ->setCellValue('K2', 'Valor Exc Iva')
                             ->setCellValue('L2', 'Valor Inc Iva');
                //colocar titulos a las hojas de excel
                //$objWorkSheet->setTitle("$i");
                $objWorkSheet->setTitle('Kits Asociados');                    
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
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(22);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(60);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
                
                    $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('C1', "Reporte Kist Asociados a corte del: ".$fechaActual);
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
        $d5=$dato1['estado'];
        $d6=$dato1['nom_kit'];
        $d7=$dato1['des_com_kit'];
        $d8=$dato1['cod_producto'];
        $d9=$dato1['grupo'];
        $d10=$dato1['cantidad'];
        $d11=$dato1['valor_exc_iva'];
        $d12=$dato1['valor_inc_iva'];
        //$numbe=sprintf($d7);
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
            ->setCellValueExplicitByColumnAndRow(4, $fd, $d5, PHPExcel_Cell_DataType::TYPE_STRING)
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