<?php
include_once 'usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

//$diaA = date('d');
$mesA = date('m');
$mesA=$mesA-1;
setlocale(LC_TIME, 'es_ES');
$fecha = DateTime::createFromFormat('!m', $mesA);
$mesN = strftime("%B", $fecha->getTimestamp());

$anioA = date('Y');
$fechaActual=$mesN." - ".$anioA;
//$fechaActual = date('d-m-Y');
include('conectarbase.php');

        $r=$r."<table style=\"border: 1px solid #000; width:100%; \" class=\"#439049 green darken-1\">";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.6em;\">";
        $r=$r."<td style=\"font-weight: bold;text-align: left; padding: 5px;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">ITEM</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">DESCRIPCION</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">FACTURA</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">FECHA</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CANTIDAD</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">VLR_EXC_IVA</td>
        <td><a href='Informexls/INFORME_DE_VENTAS_SIN_IVA.xlsx' class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>";
        $r=$r."</tr>";

$resultSQL = mssql_query("SELECT* FROM [InformesCompVentas].[dbo].[infVentasSinIva]",$cLink);

/*
while($resultadoSql = mssql_fetch_array($resultSQL)){
    //items habilitados para ventas sin iva
    $itemIbs=trim($resultadoSql["ITEM"]);
    $r=$r." Dato adicional: ".$itemIbs."</p>";
    //busco el paralelo de codigos en ibs-odoo
    $resultSQL2 = mssql_query("SELECT* FROM [InformesCompVentas].[dbo].[InfItemsIbsOdoo] WHERE ItemIbs='$itemIbs'",$cLink);
    
    if($resultadoSql2 = mssql_fetch_array($resultSQL2)){
        $itemOdoo=trim($resultadoSql2["ItemOdoo"]);

        //echo "Aqui2".$itemOdoo;
        $query="SELECT p.default_code as item, p.name_template as nombre, v.number as factura, i.local_subtotal as valor, i.quantity as cantidad, v.date_invoice as fecha from product_product p
        left join account_invoice_line i on p.id=i.product_id
        left join account_invoice v on i.invoice_id=v.id
        where p.default_code='$itemOdoo' and v.number is not null and left(v.number,2)='FE'";
        $resultado= $Conn->prepare($query);
        $resultado->execute();
        $datos=$resultado->fetchAll();
        
        foreach($datos as $dato){
            if(($i%2)==0){
                $color="#AED6F1";
            }else{
                $color="#E8F6F3";
            }
             $d1=$dato['item'];
             $d2=$dato['nombre'];
             $d3=$dato['factura'];
             $d4=$dato['fecha'];
             $d5=$dato['cantidad'];
             $d6=$dato['valor'];
            //echo "-->".$d1."--".$d2."--".$d3."--".$d4."--".$d5."--".$d6."<BR>";
                                    $r=$r."<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                                    $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$i."</td>
                                    <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d1."</td>
                                    <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d2."</td>
                                    <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d3."</td>
                                    <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d4."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d5."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d6."</td>";
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
                            ->setCellValue('H'.$fd, $itemIbs);
                    $i++;
                    $fd++;
             
        }
        
    }
}*/
$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">INFORME DE VENTAS SIN IVA: AGROCAMPO: ".$fechaActual."</p>"; 

                $fd=3;
                // $r="Informexls/Informe_Inventario008.xlsx"
                $miruta='Informexls/';
                $nombre_fichero = 'INFORME_DE_VENTAS_SIN_IVA';
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
                        // columna de titulos en Excel
                        $objWorkSheet = $objPHPExcel->createSheet(0);
                            $objWorkSheet->setCellValue('A2', 'No.')
                                ->setCellValue('B2', 'ITEM')
                                ->setCellValue('C2', 'DESCRIPCION')
                                ->setCellValue('D2', 'FACTURA')
                                ->setCellValue('E2', 'FECHA')
                                ->setCellValue('F2', 'CANTIDAD')
                                ->setCellValue('G2', 'VLR_EXC_IVA');
                             //colocar titulos a las hojas de excel
                            //$objWorkSheet->setTitle("$i");
                                $objWorkSheet->setTitle('INFORME_DE_VENTAS_SIN_IVA '.$mesN);                    
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
                        $fil++;
                }
                //ANCHOS
                $objPHPExcel->setActiveSheetIndex(0);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
                
                $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A1', "INFORME_DE_VENTAS_SIN_IVA ".$mesN);
                $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
///////////////////////
            while($resultadoSql = mssql_fetch_array($resultSQL)){
                //items habilitados para ventas sin iva
                $itemIbs=trim($resultadoSql["ITEM"]);
                //busco el paralelo de codigos en ibs-odoo
                $resultSQL2 = mssql_query("SELECT* FROM [InformesCompVentas].[dbo].[InfItemsIbsOdoo] WHERE ItemIbs='$itemIbs'",$cLink);
                if($itemIbs=='626210060'){
                    $contar="SELECT* FROM [InformesCompVentas].[dbo].[InfItemsIbsOdoo] WHERE ItemIbs='$itemIbs'";
                }
                if($resultadoSql2 = mssql_fetch_array($resultSQL2)){
                    $itemOdoo=trim($resultadoSql2["ItemOdoo"]);
            
                    //echo "Aqui2".$itemOdoo;
                    /*$query="SELECT p.default_code as item, p.name_template as nombre, v.number as factura, i.local_subtotal as valor, i.quantity as cantidad, v.date_invoice as fecha from product_product p
                    left join account_invoice_line i on p.id=i.product_id
                    left join account_invoice v on i.invoice_id=v.id
                    where p.default_code='$itemOdoo' and v.number is not null and left(v.number,2)='FE'";*/
                    /*$query="select
                        o.name as Orden,
                        p.default_code as item,
                        p.name_template as nombre,
                        cf.number as factura,
                        il.local_subtotal as valor,
                        il.quantity as cantidad,
                        left(cf.origin,3) as bodega,
                        cf.date_invoice as fecha
                        from product_product p
                        left join sale_order o ON p.document_sale=o.name
                        left join sale_order_invoice_rel oi ON o.id=oi.order_id
                        left join account_invoice cf ON oi.invoice_id=cf.id and cf.state='paid'
                        left join account_invoice_line il ON cf.id=il.invoice_id and p.id=il.product_id
                        where p.default_code='$itemOdoo' and cf.number is not null";
                    */
                    $query="select
                                o.name as Orden,
                                p.default_code as item,
                                p.name_template as nombre,
                                p.document_sale,
                                cf.number as factura,
                                il.local_subtotal as valor,
                                il.quantity as cantidad,
                                left(cf.origin,3) as bodega,
                                cf.date_invoice as fecha,
                                o.state as estado
                                from product_product p
                                left join sale_order o ON p.document_sale=o.name
                                left join sale_order_invoice_rel oi ON o.id=oi.order_id
                                left join account_invoice cf ON oi.invoice_id=cf.id and o.state='done'
                                left join account_invoice_line il ON cf.id=il.invoice_id and p.id=il.product_id
                                where p.default_code='$itemOdoo' and cf.number is not null
                    ";
                    
                    $resultado= $Conn->prepare($query);
                    $resultado->execute();
                    $datos=$resultado->fetchAll();
                    $i=1;
                    foreach($datos as $dato){
                        if(($i%2)==0){
                            $color="#AED6F1";
                        }else{
                            $color="#E8F6F3";
                        }
                         $d1=$dato['item'];
                         $d2=$dato['nombre'];
                         $d3=$dato['factura'];
                         $d4=$dato['fecha'];
                         $d5=$dato['cantidad'];
                         $d6=$dato['valor'];
                            //echo "-->".$d1."--".$d2."--".$d3."--".$d4."--".$d5."--".$d6."<BR>";
                            $r=$r."<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                            $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$i."</td>
                            <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d1."</td>
                            <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d2."</td>
                            <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d3."</td>
                            <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d4."</td>
                            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d5."</td>
                            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d6."</td>
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
                            ->setCellValue('G'.$fd, $d6);
                            $i++;
                            $fd++;
                    }
                }
            }
////////////////////////////
}

Conexion::cerrarConexion();
mssql_close();
//CREA ARCHIVO************************************************************
    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    //Guardar el achivo: 
    $objWriter->save($mipath2);
$r=$r . "</table>";

echo $r.$contar;


?>