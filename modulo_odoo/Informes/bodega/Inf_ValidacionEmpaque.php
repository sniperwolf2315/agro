<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

$ad = trim($_GET['a']);
$md = trim($_GET['m']);
$dd = trim($_GET['d']);

$ah = trim($_GET['ah']);
$mh = trim($_GET['mh']);
$dh = trim($_GET['dh']);
$tc = trim($_GET['tc']);


$inicial = trim($_GET['i']);
$fin = trim($_GET['f']);
//fecha inicio fecha din de la consulta x mes
//$dia = cal_days_in_month(CAL_GREGORIAN, $mes, $anio); // 31
//$feini=$anio."-".$mes."-01";// 00:00:00
//$feini1=$anio.$mes."01";
//$fefin=$anio."-".$mes."-".$dia;//.$dia;  ." 23:59:59"
//$fefin1=$anio.$mes.$dia;
$datos_prop_agro = array(
    'Autor: Agrocampo',
    'Agrocampo',
    'Informe Agrocampo',
    'Office 2007 XLSX Informe Empresarial',
    'Informe en Office 2007 XLSX',
    'office 2007 openxml php',
    'Resultado de Informe'
);

$cabecera_excel = array('No.', 'Documento Validado', 'Usuario Validado', 'No. Orden', 'Documento de Entrega', 'Factura', 'Fecha de Inicio', 'Fecha Fin', 'Lineas Separadas', 'Cajas');



$filtro;
// TODO: REVISAR ESTA CONSULTA

if ($tc === 'rangos') {
    $inicial = strval($ad) . '-' . strval($md) . '-' . strval($dd);
    $fin = strval($ah) . '-' . strval($mh) . '-' . strval($dh);
    $filtro = "where cp.date between '$inicial' and '$fin'";

    $titulo_cab_php = "<p style=\"text-align: center;\" class=\"z-depth-1\">Validaci&oacute;n y Empaque del periodo: " . $inicial . " Hasta el: " . $fin . " </p>";
    $titulo_cab_excel = "Validación y Empaque del periodo: " . $inical . " hasta: " . $fin . "";
} else if ($tc === 'normal') {
    $inicial = strval($ad) . '-' . strval($md);
    $filtro = "where cast(cp.date as varchar)  like'$inicial%'";
    $titulo_cab_php = "<p style=\"text-align: center;\" class=\"z-depth-1\">Validaci&oacute;n y Empaque del periodo: " . $inicial . " </p>";
    $titulo_cab_excel = "Validación y Empaque del periodo:" . $inical;
} else {
    echo '<br>0<br>';
    return;
}


$query1 = "
    select 
        cp.name as documento_validado
        ,res_partner.name as usuario_valido
        ,sale_order.name as orden
        ,stock_picking.name as documento_entrega
        ,account_invoice.number as factura
        ,left(cast(cp.date as varchar),16) as fecha_inicio
        ,left(cast(cp.date_end as varchar),16) as fecha_fin
        ,(select count(id) from stock_control_packaging_line where stock_control_packaging_line.control_id=cp.id) as lineas_separo
        ,cp.packages as cajas
    from 
        stock_control_packaging cp
        inner join res_users on res_users.id=cp.user_id
        inner join res_partner on res_partner.id=res_users.partner_id
        inner join stock_picking on stock_picking.id=cp.picking_id
        left join sale_order on sale_order.name=stock_picking.origin
        left join account_invoice on account_invoice.stock_picking_id =stock_picking.id
    $filtro
    ORDER BY 
        cp.date ASC";
        
$resultado1 = $Conn->prepare($query1);
$resultado1->execute();
$datos1 = $resultado1->fetchAll();
$pasa_query = count($datos1);
if ($pasa_query === 0) {
    echo "<h5><strong><p> No hay resultado para esta consulta. </p></strong> </h5>  ";
    return;
};
$r = "
<h6>
    $titulo_cab_php
</h6>

<table style=\"border: 1px solid #000; width:100%; \" class=\"#439049 green darken-1\">
<tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">";
foreach ($cabecera_excel as $cab) {
    $r = $r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">$cab</td>";
}
$r = $r . "
    <td><a href='Informexls/Validacion_Empaque008.xlsx' class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>
</tr>
";
/*   #ANTES
$r = "
<h4>
<div style="."width:100%;".">
<span style='color: black; font-weight: bold; width:100% ;text-align:center ;font-style:bold ' >INVENTARIO BODEGA</span>
</div>
</h4>
<table style=\"border: 1px solid #000; width:100%; \" class=\"#439049 green darken-1\">
<tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Documento Validado</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Usuario Validado</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No. Orden</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Documento de Entrega</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Factura</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Fecha de Inicio</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Fecha Fin</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Lineas Separadas</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Cajas</td>
    <td><a href='Informexls/Validacion_Empaque008.xlsx' class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>
</tr>
";

 */

$miruta = '../Informexls/';
$nombre_fichero = 'Validacion_Empaque008';
$mipath = $miruta . $nombre_fichero . '.xlsx';

/* ### VARIBLES */
$position_cell = 2;
$long_cabecera_excel = count($cabecera_excel);
$letra_a = 65;
$letra_z = 90;
$j = 0;
$i = 1;
$fd = 3;
$pos_fil = 0; /* ESTA VARIALBE SERVRA PARA HACER LOS SICLOS DE LAS COLUMNAS EN DATOS DEL EXCEL*/


if (file_exists($miruta)) {
    include('../Classes/PHPExcel.php');
    include('../Classes/PHPExcel/Reader/Excel2007.php');

    //Crear el objeto Excel: 
    $objPHPExcel = new PHPExcel();
    $mipath2 = $miruta . $nombre_fichero . '.xlsx';
    if (file_exists($mipath2)) {
        $archivo = $mipath2;
        $inputFileType = PHPExcel_IOFactory::identify($archivo);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($archivo);
    } else {
        /* ESTABLECER LOS DATOS HISTORICOS DE REGISTRO EN CREACION DEL ARCHIVO EXCEL CON EXTENSION XLSX */
        $objPHPExcel->getProperties()->setCreator($datos_prop_agro[0])
            ->setLastModifiedBy($datos_prop_agro[1])
            ->setTitle($datos_prop_agro[2])
            ->setSubject($datos_prop_agro[3])
            ->setDescription($datos_prop_agro[4])
            ->setKeywords($datos_prop_agro[5])
            ->setCategory($datos_prop_agro[6]);

        $objWorkSheet = $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(1)->setTitle('Hoja');
        //ALIMENTAR LAS CABECERAS DEL EXCEL EN BASE A LA CANTIDAD DE REGISTROS(long_cabecera_excel) DEL ARRAY CABECERA
        $objWorkSheet->setTitle("Validacion y Empaque");
        for ($i = $letra_a; $i <= ($letra_a + $long_cabecera_excel); $i++) {
            $letra = chr($i);
            $objWorkSheet->setCellValue($letra . '2', $cabecera_excel[$j]);
            $j++;
        }
    }
}


$fil = 3;
$objPHPExcel->setActiveSheetIndex(0);
$totalreg = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
$totalreg = $totalreg + 1;
for ($i = $letra_a; $i <= ($letra_a + $long_cabecera_excel); $i++) {
    $letra = chr($i);
    $objPHPExcel->setActiveSheetIndex()->SetCellValue($letra . '3', '');
    $objPHPExcel->setActiveSheetIndex()->getColumnDimension($letra)->setWidth(10);
}
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:' . $letra . '1');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $titulo_cab_excel);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

//DATOS 
foreach ($datos1 as $dato1) {
    if (($i % 2) == 0) {
        $color = "#AED6F1";
    } else {
        $color = "#E8F6F3";
    }
    $d1 = $dato1['documento_validado'];
    $d2 = $dato1['usuario_valido'];
    $d3 = $dato1['orden'];
    $d4 = $dato1['documento_entrega'];
    $d5 = $dato1['factura'];
    $d6 = $dato1['fecha_inicio'];
    $d7 = $dato1['fecha_fin'];
    $d8 = $dato1['lineas_separo'];
    $d9 = $dato1['cajas'];
    $r = $r . "
    
    <tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>                            
         <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $i . "</td>
         <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d1 . "</td>
         <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d2 . "</td>
         <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d3 . "</td>
         <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d4 . "</td>
         <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d5 . "</td>
         <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d6 . "</td>
         <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d7 . "</td>
         <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d8 . "</td>
         <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d9 . "</td>
         <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'></td>            
    </tr>                                                                                                                    
    
    
    
    
    ";
    /* 
    //EXCEL
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $fd, $i)
    */
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueExplicitByColumnAndRow(0, $fd, $i)
        ->setCellValueExplicitByColumnAndRow(1, $fd, $d1)
        ->setCellValueExplicitByColumnAndRow(2, $fd, $d2, PHPExcel_Cell_DataType::TYPE_STRING)
        ->setCellValueExplicitByColumnAndRow(3, $fd, $d3, PHPExcel_Cell_DataType::TYPE_STRING)
        ->setCellValueExplicitByColumnAndRow(4, $fd, $d4)
        ->setCellValueExplicitByColumnAndRow(5, $fd, $d5)
        ->setCellValueExplicitByColumnAndRow(6, $fd, $d6)
        ->setCellValueExplicitByColumnAndRow(7, $fd, $d7, PHPExcel_Cell_DataType::TYPE_STRING)
        ->setCellValueExplicitByColumnAndRow(8, $fd, $d8)
        ->setCellValueExplicitByColumnAndRow(9, $fd, $d9);


    $i++;
    $fd++;
    $pos_fil++;
} //fin while 


$r = $r . "</table>";
Conexion::cerrarConexion();
//CREA ARCHIVO************************************************************
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//Guardar el achivo: 
$objWriter->save($mipath2);
echo $r;
