<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

$anio=trim($_GET['a']);
$mes=trim($_GET['m']);
$opc=trim($_GET['op']);
$ord=trim($_GET['or']);
$ordM=strtoupper($ord);

$dia = cal_days_in_month(CAL_GREGORIAN, $mes, $anio); // 31 30 

$ini=$anio."-".$mes."-01";
$fin=$anio."-".$mes."-".$dia;

$diaA = date('d');
$mesA = date('m');
//$mesA=$mesA-1;
setlocale(LC_TIME, 'es_ES');
$fecha = DateTime::createFromFormat('!m', $mesA);
$mesN = strftime("%B", $fecha->getTimestamp());

$anioA = date('Y');
$fechaActual=$diaA." - ".$mesN." - ".$anioA;

//calidar si campo de la ORDEN es vacio
if($ordM == 'SO' || $ordM == ''){
    $PPA="";
}else{
    if(strncmp($ordM,'SO',2)===0 ){
        $PPA=" and o.name='$ordM'";
    }else {
        $PPA=" and p.default_code='$ordM'";
    }
}

// buscar por ITEM
if($opc == ''){
    $PPB="";
} else if($opc == 'PROMOCION'){
    $PPB=" and ol.promotion=TRUE";
}else if($opc == 'BONO'){
    $PPB=" and ol.perk=true";
}else if($opc == 'ITEM'){
    $PPB="";
}
//validar fecha
if($anio=='' && $mes=='' || $anio!='' && $mes=='' || $anio=='' && $mes!=''){
    $PPC="";
}else if($anio!='' && $mes!=''){
    $PPC=" and (f.date_invoice between '".$ini."' and '".$fin."') ";
}

$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Informe Semana Promocional Consentrados a Corte: ".$fechaActual."</p><br />";//Fecha Inicio: ".$feini." - hasta: ".$fefin.".

//echo "dias: {$dia} <br>"."Fecha inicial: ".$feini."<br>"."fecha Fin: ".$fefin;
        $r=$r."<table style=\"border: 1px solid #000; width:100%; \" class=\"#439049 green darken-1\">";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.6em;\">";
        $r=$r."<td style=\"font-weight: bold;text-align: left; padding: 5px;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Orden</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Factura</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Item</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Producto</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Vlr_Exc_Iva</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Vlr_Inc_Iva</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Descuento</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Promoci&oacute;n</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Bono</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Cantidad</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Grupo</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Categoria</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Fecha</td>
        <td><a href='Informexls/Sem_Prom_Consentrados.xlsx' class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>";
        $r=$r."</tr>";
//echo ("<p style=\"text-align: center;\" class=\"z-depth-1\">anio: ".$anio." mes: ".$mes." opcion: ".$opc." orden: ".$PPA." Item: ".$PPB." fecha: ".$PPC."</p>");//Fecha Inicio: ".$feini." - hasta: ".$fefin.".
                $fd=3;
                // $r="Informexls/Informe_Inventario008.xlsx"
                $miruta='../Informexls/';
                $nombre_fichero = 'Sem_Prom_Consentrados';
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
                                ->setCellValue('B2', 'Orden')
                                ->setCellValue('C2', 'Factura')
                                ->setCellValue('D2', 'Item')
                                ->setCellValue('E2', 'Producto')
                                ->setCellValue('F2', 'Vlr_Exc_Iva')
                                ->setCellValue('G2', 'Vlr_Inc_Iva')
                                ->setCellValue('H2', 'Descuento')
                                ->setCellValue('I2', 'Promocion')
                                ->setCellValue('J2', 'Bono')
                                ->setCellValue('K2', 'Cantidad')
                                ->setCellValue('L2', 'Grupo')
                                ->setCellValue('M2', 'Categoria')
                                ->setCellValue('N2', 'Fecha');
                             //colocar titulos a las hojas de excel
                            //$objWorkSheet->setTitle("$i");
                                $objWorkSheet->setTitle('Promocionales Concentrados');                    
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
                
                    $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('C1', "Informe Semana Promocional Consentrados a Corte: ".$fechaActual);
                    $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
                
                //query de odoo
                $query1 = "select
                   o.name as orden,
                   f.number as factura,
                   p.default_code item,
                   p.name_template as producto,
                   sum((ol.price_unit*ol.product_uom_qty)-(ol.price_unit*ol.product_uom_qty)*(ol.discount/100)) AS vlr_exc_iva,
                   sum((ol.price_iva_tax*ol.product_uom_qty)-(ol.price_iva_tax*ol.product_uom_qty)*(ol.discount/100)) as vlr_inc_iva,
                   ol.discount as descuento,
                   ol.promotion as promocion,
                   ol.perk as bono,
                   sum(ol.product_uom_qty) as cantidad,
                   left(c1.name,3) as grupo,
                   c2.name as categoria,
                   f.date_invoice as fecha_fac
                    from sale_order o
                    left join sale_order_line ol ON o.id=ol.order_id
                    left join sale_order_invoice_rel of ON o.id=of.order_id
                    left join account_invoice f ON of.invoice_id=f.id and f.state='paid'
                    left join product_product p ON ol.product_id=p.id
                    left join product_template t ON p.product_tmpl_id=t.id
                    left join product_category c1 ON t.categ_id=c1.id
                    left join product_category c2 ON c1.parent_id=c2.id
                    group by o.name,f.number,p.default_code,p.name_template,ol.promotion,ol.perk,ol.discount,c2.name,c1.name,f.date_invoice
                    having left(f.number,1) IN('F','S','D','0') $PPA $PPB $PPC;";
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
                        $d2=$dato['factura'];
                        $d3=$dato['item'];
                        $d4=$dato['producto'];
                        $d5=$dato['vlr_exc_iva'];
                        $d6=$dato['vlr_inc_iva'];
                        $d7=$dato['descuento'];
                        $d8=$dato['promocion'];
                        $d9=$dato['bono'];
                        $d10=$dato['cantidad'];
                        $d11=$dato['grupo'];
                        $d12=$dato1['categoria'];
                        $d13=$dato['fecha_fac'];
                        
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
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d13."</td>
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
                            ->setCellValue('N'.$fd, $d13);
                    $i++;
                    $fd++;
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