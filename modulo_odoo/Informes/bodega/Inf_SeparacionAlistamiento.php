<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

$anio_d = trim($_GET['a']);
$mes_d  = trim($_GET['m']);
$dia_d  = trim($_GET['d']);

$anio_h = trim($_GET['ah']);
$mes_h  = trim($_GET['mh']);
$dia_h  = trim($_GET['dh']);

$tipo_consulta = trim($_GET['tc']);

$filtro;

if ($tipo_consulta === 'rangos') {
    $inicial = strval($anio_d) . '-' . strval($mes_d) . '-' . strval($dia_d);
    $fin = strval($anio_h) . '-' . strval($mes_h) . '-' . strval($dia_h);
    $filtro = "and left(cast(separate_date as varchar),10) between '$inicial' AND '$fin'";
} else if ($tipo_consulta === 'normal') {
    $inicial = strval($anio_d) . '-' . strval($mes_d);
    $filtro = "and left(cast(separate_date as varchar),7) = '$inicial'";
} else {
    return;
}




$query1 = "select
      pk.name as documento_entrega,

      (CASE 
            WHEN PK.STATE = 'done' THEN 'transferido'
            WHEN PK.STATE = 'waiting' THEN 'esperando otra operacion'
            WHEN PK.STATE = 'confirmed' THEN 'esperando disponibilidad'
            WHEN PK.STATE = 'assigned' THEN 'listo para transferir'
            WHEN PK.STATE = 'partially_available' THEN 'parcialmente disponible'
            WHEN PK.STATE = 'draft' THEN 'borrador'
       ELSE
            PK.STATE END )as ESTADO,
      left(cast(separate_date as varchar),16) as fecha_separacion,
      (select 
            res_partner.name 
       from 
            res_users 
            inner join res_partner on res_partner.id=res_users.partner_id 
        where 
            res_users.id=separated_by) as usuario_separo,
       (case when pk.state='done' then (select 
                                                count (stock_pack_operation.id) 
                                            from 
                                                stock_pack_operation 
                                                inner join product_product on product_product.id=stock_pack_operation.product_id 
                                                inner join product_template on product_template.id=product_product.product_tmpl_id 
                                            where 
                                                stock_pack_operation.picking_id=pk.id and product_template.type not like 'service' ) 
                                    else (select 
                                                count (stock_quant.id) 
                                            from 
                                                stock_move inner join stock_quant on stock_quant.reservation_id=stock_move.id 
                                            where 
                                                stock_move.picking_id=pk.id ) end ) as cantidad,
                                         (select 
                                                purchase_order.name 
                                          from 
                                                purchase_order 
                                          where 
                                                purchase_order.name=pk.origin limit 1 ) as documento_compra,
                                         (select 
                                                sale_order.name 
                                          from 
                                                sale_order 
                                          where 
                                                sale_order.name=pk.origin limit 1 ) as documento_venta
    from 
        stock_picking pk
        inner join stock_picking_type t on t.id=pk.picking_type_id
    where 
        pk.state not like 'cancel'
        and (t.code='outgoing' or t.code='internal')
        $filtro
    ORDER BY 
        pk.date ASC";

$resultado1 = $Conn->prepare($query1);
$resultado1->execute();
$datos1 = $resultado1->fetchAll();
$total_reg = count($datos1);
if ($total_reg === 0) {
    echo '¡No hay registros para mostrar!';
    return;
}


//echo "aquies2".$feini."--".$fefin;

$r = $r . "<p style=\"text-align: center;\" class=\"z-depth-1\">Separaci&oacute;n y Alistamiento del periodo: " . $inicial . " Hasta el: " . $fin . " </p>";
//var_dump($datos); 
//echo "<span style='color: black; font-weight: bold;' >INVENTARIO BODEGA</span>";
$r = $r . "<table style=\"border: 1px solid #000; width:100%; \" class=\"#439049 green darken-1\">";
$r = $r . "<tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">";
$r = $r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Documento de Entrega</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Estado</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Fecha de Separacion</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Usuario Separado</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Cantidad</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Documento de Compra</td>
    <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Documento de Venta</td>
    <td><a href='Informexls/Separacion_Alistamiento008.xlsx' class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>";
$r = $r . "</tr>";
$i = 1;
//excel
$fd = 3;
// $r="Informexls/Informe_Inventario008.xlsx"
$miruta = '../Informexls/';
$nombre_fichero = 'Separacion_Alistamiento008';
$mipath = $miruta . $nombre_fichero . '.xlsx';
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
        $objPHPExcel->getProperties()->setCreator("Autor: Agrocampo");
        $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo");
        $objPHPExcel->getProperties()->setTitle("Informe Agrocampo");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
        $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
        $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
        $objPHPExcel->getProperties()->setCategory("Resultado de Informe");

        $objWorkSheet = $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(1)->setTitle('Hoja');
        $objWorkSheet->setCellValue('A2', 'No.')
            ->setCellValue('B2', 'Documento_de_Entrega')
            ->setCellValue('C2', 'Estado')
            ->setCellValue('D2', 'Fecha_de_Separacion')
            ->setCellValue('E2', 'Usuario_Separado')
            ->setCellValue('F2', 'Cantidad')
            ->setCellValue('G2', 'Documento_de_Compra')
            ->setCellValue('H2', 'Documento_de_Venta');


        $objWorkSheet->setTitle("Separacion y Alistamiento");
    }
}
//BORRAR DTOS
$fil = 3;
$objPHPExcel->setActiveSheetIndex(0);
$totalreg = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
$totalreg = $totalreg + 1;
while ($fil <= $totalreg) {
    $objPHPExcel->getActiveSheet()->SetCellValue('A' . $fil, '');
    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $fil, '');
    $objPHPExcel->getActiveSheet()->SetCellValue('C' . $fil, '');
    $objPHPExcel->getActiveSheet()->SetCellValue('D' . $fil, '');
    $objPHPExcel->getActiveSheet()->SetCellValue('E' . $fil, '');
    $objPHPExcel->getActiveSheet()->SetCellValue('F' . $fil, '');
    $objPHPExcel->getActiveSheet()->SetCellValue('G' . $fil, '');
    $objPHPExcel->getActiveSheet()->SetCellValue('H' . $fil, '');
    $fil++;
}
//ANCHOS
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', "Separacion y Alistamiento " . $inicial . " Hasta el: " . $fin);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);


//DATOS 
$fil = 3;
foreach ($datos1 as $dato1) {
    if (($i % 2) == 0) {
        $color = "#AED6F1";
    } else {
        $color = "#E8F6F3";
    }
    $d1 = $dato1['documento_entrega'];
    $d2 = $dato1['estado'];
    $d3 = $dato1['fecha_separacion'];
    $d4 = $dato1['usuario_separo'];
    $d5 = $dato1['cantidad'];
    $d6 = $dato1['documento_compra'];
    $d7 = $dato1['documento_venta'];

    $r = $r . "<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
    //$r=$r."<tr style='background-color: $color; font-size: 0.5em;'>";
    $r = $r . "<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $i . "</td>
            <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d1 . "</td>
            <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d2 . "</td>
            <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d3 . "</td>
            <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d4 . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d5 . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d6 . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d7 . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'></td>";
    //padding: 5px;
    $r = $r . "</tr>";

    //EXCEL
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $fd, $i)
        ->setCellValue('B' . $fd, $d1)
        ->setCellValueExplicitByColumnAndRow(2, $fd, $d2, PHPExcel_Cell_DataType::TYPE_STRING)
        ->setCellValueExplicitByColumnAndRow(3, $fd, $d3, PHPExcel_Cell_DataType::TYPE_STRING)
        ->setCellValue('E' . $fd, $d4)
        ->setCellValue('F' . $fd, $d5)
        ->setCellValue('G' . $fd, $d6)
        ->setCellValueExplicitByColumnAndRow(7, $fd, $d7, PHPExcel_Cell_DataType::TYPE_STRING);

    $i++;
    $fd++;
} //fin while 


$r = $r . "</table>";
Conexion::cerrarConexion();
//CREA ARCHIVO************************************************************
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//Guardar el achivo: 
$objWriter->save($mipath2);
echo $r;
