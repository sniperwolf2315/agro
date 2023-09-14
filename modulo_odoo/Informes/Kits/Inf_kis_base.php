<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

$KitsA=trim($_GET['k']);
$inic=trim($_GET['i']);
$fin=trim($_GET['f']);

//generar fecha actual
$diaA = date('d');
$mesA = date('m');
//$mesA=$mesA-1;
setlocale(LC_TIME, 'es_ES');
$fecha = DateTime::createFromFormat('!m', $mesA);
$mesN = strftime("%B", $fecha->getTimestamp());
$anioA = date('Y');
$fechaActual=$diaA." - ".$mesN." - ".$anioA;

$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Informe de Kits con Lista de Materiales a Corte: ".$fechaActual."</p>";//Fecha Inicio: ".$feini." - hasta: ".$fefin.".

//fecha inicio fecha din de la consulta x mes
//echo "dias: {$dia} <br>"."Fecha inicial: ".$feini."<br>"."fecha Fin: ".$fefin;
        $r=$r."<table style=\"border: 1px solid #000; width:100%; \" class=\"#439049 green darken-1\" >";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.6em;\">";
        $r=$r."<td style=\"font-weight: bold;text-align: left; padding: 5px;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">ESTADO DEL PRODUCTO</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">ESTADO KIT</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">GRUPOS</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CODIGO DE PRODUCTO</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">PRODUCTO</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CANTIDAD</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">COSTO ESTANDAR</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">PRECIO AL PUBLICO</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">GRUPO LISTA MATERIAL</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CATEGORIA LISTA MATERIAL</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CANTIDAD PRODUCTO</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">DESCIPCION PRODUCTO</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CODIGO LISTA MATERIAL</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">DESCROPCION LISTA MATERIAL</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CANTIDAD LISTA MATERIAL</td>
        <td><a href='Informexls/Inf_Kits_Lis_Mat.xlsx'class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>";
        $r=$r."</tr>";
        //Informe_Ingreso008.xlsx'>Descargar</a><Strong></td>";




//echo "valo_1: ".$anio." Valor_2: ".$mes;
//".$feini."' and '".$fefin."';"
//$query = "select * from stock_control_receipt where date between '".$anio."-".$mes."-01' and '".$anio."-".$mes."-20';";
$query1 = "select pt.id as buscar,(case when pt.active='true' then 'producto activo' else (case when pt.active='false' then 'producto inactivo' else '' end) end) AS estado_produc,
(case when pt.kit_ok='true' then 'kit_activo' else (case when pt.kit_ok='false' then 'kit_inactivo' else '' end) end) AS estado_kit,
left(cast(pc.name as varchar),3) as grupo,
pp.default_code as cod_producto,pp.name_template as producto,sq.qty as cantidad,pp.costo_standard as cost_estandar,pt.list_price as preci_publi
from stock_quant sq
right join product_product AS pp ON sq.product_id=pp.id
left join product_template AS pt ON pp.product_tmpl_id=pt.id
left join  mrp_bom AS mb ON mb.product_tmpl_id=pt.id
left join product_list_item AS pli ON pli.product_id=pp.id
left join product_category AS pc ON pc.id=pli.categ_id
where pt.kit_ok in ('true','false')
LIMIT (100);";
  
//$r=$r."<p>Ordenes de Compra Pendientes.</p>";//Fecha Inicio: ".$feini." - hasta: ".$fefin.".

                $fd=3;
                // $r="Informexls/Informe_Inventario008.xlsx"
                $miruta='../Informexls/';
                $nombre_fichero = 'Inf_Kits_Lis_Mat';
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
                                ->setCellValue('B2', 'ESTADO DEL PRODUCTO')
                                ->setCellValue('C2', 'ESTADO KIT')
                                ->setCellValue('D2', 'GRUPOS')
                                ->setCellValue('E2', 'CODIGO DE PRODUCTO')
                                ->setCellValue('F2', 'PRODUCTO')
                                ->setCellValue('G2', 'CANTIDAD')
                                ->setCellValue('H2', 'COSTO ESTANDAR')
                                ->setCellValue('I2', 'PRECIO AL PUBLICO')
                                ->setCellValue('J2', 'GRUPO LISTA MATERIAL')
                                ->setCellValue('K2', 'CATEGORIA LISTA MATERIAL')
                                ->setCellValue('L2', 'CANTIDAD PRODUCTO')
                                ->setCellValue('M2', 'DESCIPCION PRODUCTO')
                                ->setCellValue('N2', 'CODIGO LISTA MATERIAL')
                                ->setCellValue('O2', 'DESCROPCION LISTA MATERIAL')
                                ->setCellValue('P2', 'CANTIDAD LISTA MATERIAL');
                             //colocar titulos a las hojas de excel
                            //$objWorkSheet->setTitle("$i");
                                $objWorkSheet->setTitle('Inf_Kits_Lis_Mat_005');

                    
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
                        $fil++;
                }
                //ANCHOS
                $objPHPExcel->setActiveSheetIndex(0);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(45);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(35);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(25);
                
                $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('C1', "Informe de Kist con Lista de Materiales a Corte: ".$fechaActual);
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
                $bus=$dato1['buscar'];
                
                $query2 = "select mb.id,left(pc.name,3) as grupo,pc.name as categoria,mb.product_qty as cant_prod_prin,mb.name as produc_prin,pp.default_code as lis_mat_cod,
                pp.name_template as lis_mat_prod,mbl.product_qty as lis_mat_cant
                from mrp_bom as mb
                left join product_template as pt on mb.product_tmpl_id=pt.id --
                left join product_category as pc on pt.categ_id=pc.id
                left join mrp_bom_line as mbl on mb.id=mbl.bom_id
                left join product_product as pp on mbl.product_id=pp.id
                where pt.id='$bus';";
                
                $resultado2= $Conn->prepare($query2);
                $resultado2->execute();
                $datos2=$resultado2->fetchAll();
                
                foreach($datos2 as $dato2){
                    $d10=$dato2['grupo'];
                    $d11=$dato2['categoria'];
                    $d12=$dato2['cant_prod_prin'];
                    $d13=$dato2['produc_prin'];
                    $d14=$dato2['lis_mat_cod'];
                    $d15=$dato2['lis_mat_prod'];
                    $d16=$dato2['lis_mat_cant'];
                
                }
                
                $d2=$dato1['estado_produc'];
                $d3=$dato1['estado_kit'];
                $d4=$dato1['grupo'];
                $d5=$dato1['cod_producto'];
                $d6=$dato1['producto'];
                $d7=$dato1['cantidad'];
                $d8=$dato1['cost_estandar'];
                $d9=$dato1['preci_publi'];
                
                $CANT=number_format($d7);
                $COS_ESTA=number_format($d8);
                $PRE_PUBL=number_format($d9);
                                $r=$r."<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                                $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$i."</td>
                                <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d2."</td>
                                <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d3."</td>
                                <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d4."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d5."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d6."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$CANT."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$COS_ESTA."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$PRE_PUBL."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d10."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d11."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d12."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d13."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d14."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d15."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d16."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'></td>";
                                $r=$r."</tr>";

                //EXCEL
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A'.$fd, $i)            
                        //->setCellValue('B'.$fd, $d1)
                        ->setCellValueExplicitByColumnAndRow(1, $fd, $d2, PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicitByColumnAndRow(2, $fd, $d3, PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicitByColumnAndRow(3, $fd, $d4, PHPExcel_Cell_DataType::TYPE_STRING)
                        //->setCellValue('D'.$fd, $d4)
                        //->setCellValue('E'.$fd, $d5)
                        ->setCellValueExplicitByColumnAndRow(4, $fd, $d5, PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValue('F'.$fd, $d6)
                        ->setCellValueExplicitByColumnAndRow(6, $fd, $CANT, PHPExcel_Cell_DataType::TYPE_STRING)
                        //->setCellValue('H'.$fd, $d7)
                        ->setCellValueExplicitByColumnAndRow(7, $fd, $COS_ESTA, PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValue('I'.$fd, $PRE_PUBL)
                        ->setCellValueExplicitByColumnAndRow(9, $fd, $d10, PHPExcel_Cell_DataType::TYPE_STRING)
                        //->setCellValue('K'.$fd, $d10)
                        ->setCellValue('K'.$fd, $d11)
                        ->setCellValue('L'.$fd, $d12)
                        ->setCellValue('M'.$fd, $d13)
                        ->setCellValue('N'.$fd, $d14)
                        ->setCellValue('O'.$fd, $d15)
                        ->setCellValue('P'.$fd, $d16);
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