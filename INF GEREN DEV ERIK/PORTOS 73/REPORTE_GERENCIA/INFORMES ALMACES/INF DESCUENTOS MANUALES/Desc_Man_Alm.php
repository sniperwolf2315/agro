<?php
//echo "Pere deje el afan que estamos trabajando para un futuro mejor!!!!!";
//exit();
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

$anio_hasta = trim($_GET['ah']);
$anio       = trim($_GET['a']);
$caregory   = trim($_GET['category']);
$mes_hasta  = trim($_GET['mh']);
$mes        = trim($_GET['m']);
$ord        = trim($_GET['or']);
$ordM       = strtoupper($ord);

$date = $anio . '-' . $mes . '-01';

$dia = substr(str_replace("-", "", date("Y-m-t", strtotime($date))), 6, 2);
if($dia === 2 || $dia === '02' || $dia === 02  ){
    $dia = 28;
}else{
    $dia= $dia;
}


if($caregory === 'normal' ){
    $ini = $anio . "-" . $mes . "-01";
    $fin = $anio . "-" . $mes . "-" . $dia;
}else{
    $ini = $anio . "-" . $mes . "-01";
    $fin = $anio_hasta . "-" . $mes_hasta . "-" . $dia;
}


$diaA = date('d');
$mesA = date('m');
//$mesA=$mesA-1;
setlocale(LC_TIME, 'es_ES');
$fecha = DateTime::createFromFormat('!m', $mesA);
$mesN = strftime("%B", $fecha->getTimestamp());

$anioA = date('Y');
$fechaActual = $diaA . " - " . $mesN . " - " . $anioA;

//calidar si campo de la ORDEN es vacio
if ($ordM == 'SO' || $ordM == '') {
    $PPA = " having o.name != '' ";
} else {
    if (strncmp($ordM, 'SO', 2) === 0) {
        $PPA = " HAVING o.name='$ordM' and left(f.number,1) IN('F','S','D','0') ";
    } else {
        $PPA = " HAVING p.default_code='$ordM' and left(f.number,1) IN('F','S','D','0') ";
    }
}

//validar fecha
if (($anio == '' && $mes == '') || ($anio != '' && $mes == '') || ($anio == '' && $mes != '')) {
    $PPC = " and f.date_invoice is not null ";
} else if ($anio != '' && $mes != '') {
    $PPC = " and (f.date_invoice between '" . $ini . "' and '" . $fin . "') ";
}

$r = $r . "<p style=\"text-align: center;\" class=\"z-depth-1\">Informe Descuentos Manuales: " . $fechaActual . "</p><br />"; //Fecha Inicio: ".$feini." - hasta: ".$fefin.".

//echo "dias: {$dia} <br>"."Fecha inicial: ".$feini."<br>"."fecha Fin: ".$fefin;
$r = $r . "<table style=\"border: 1px solid #000; width:100%; \" class=\"#439049 green darken-1\">";
$r = $r . "<tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">";
$r = $r . "<td style=\"font-weight: bold;text-align: left; padding: 5px;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Orden</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Tipo</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Documento</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Fecha</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Vendedor</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Responsable</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Codigo</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Descripci&oacute;n</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Cantidad</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Dcto Inicial</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Met Cambio</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Desc Cambio</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Porc Cambio</td>
        <td><a href='Informexls/Descuentos_Manuales.xlsx' class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>";
$r = $r . "</tr>";
//echo ("<p style=\"text-align: center;\" class=\"z-depth-1\">anio: ".$anio." mes: ".$mes." opcion: ".$opc." orden: ".$PPA." Item: ".$PPB." fecha: ".$PPC."</p>");//Fecha Inicio: ".$feini." - hasta: ".$fefin.".
$fd = 3;
// $r="Informexls/Informe_Inventario008.xlsx"
$miruta = '../Informexls/';
$nombre_fichero = 'Descuentos_Manuales';
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
        // Add new sheet
        $objWorkSheet = $objPHPExcel->createSheet(0);
        $objWorkSheet->setCellValue('A2', 'No.')
            ->setCellValue('B2', 'Orden')
            ->setCellValue('C2', 'Tipo')
            ->setCellValue('D2', 'Documento')
            ->setCellValue('E2', 'Fecha')
            ->setCellValue('F2', 'Vendedor')
            ->setCellValue('G2', 'Responsable')
            ->setCellValue('H2', 'Codigo')
            ->setCellValue('I2', 'Descripci�n')
            ->setCellValue('J2', 'Cantidad')
            ->setCellValue('K2', 'Dcto Inicial')
            ->setCellValue('L2', 'Met Cambio')
            ->setCellValue('M2', 'Desc Cambio')
            ->setCellValue('N2', 'Porc Cambio');
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
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('J' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('K' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('L' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('M' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('N' . $fil, '');
        $fil++;
    }
    //ANCHOS
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('C1', "Informe Descuentos Manuales: " . $fechaActual);
    $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
    //query de odoo
    $query1 = "select
                       o.name as orden,
                       ol.product_id as idprod,
                       LEFT(t.name,2) as tipoorden,
                       r.ref as nit,
                       f.date_invoice as fechafac,
                       u.login as vend,
                       U2.login as responsable,
                       p.default_code as codprod,
                       p.name_template as descripcion,
                       max(ol.product_uom_qty) as cantidad,
                       max(ol.discount) as porc_desc
                from sale_order o
                left join sale_order_line ol ON o.id=ol.order_id
                left join discount_discount_sale_order_line_rel ddsolr on ol.id=ddsolr.sale_order_line_id
                left join sale_order_invoice_rel of ON o.id=of.order_id
                left join stock_picking sp on o.name=sp.origin
                left join account_invoice f ON sp.name=f.origin
                left join product_product p ON ol.product_id=p.id
                left join quotation_type t ON o.quotation_type_id=t.id
                left join res_partner r ON o.partner_id=r.id
                left join res_users u ON f.user_id=u.id
                left join res_users u2 ON o.in_charge=u2.id
                left join account_invoice_line lf ON f.id=lf.invoice_id
                group by 
                    o.name,f.number,p.default_code,p.name_template,ol.promotion,ol.perk,t.name,r.ref
                ,o.date_order,f.date_invoice,u.login,U2.login,ol.product_id,o.id " . $PPA . $PPC . ";";


    // echo $query1.'<br>';

    $resultadoodoo = $Conn->prepare($query1);
    $resultadoodoo->execute();
    $datos = $resultadoodoo->fetchAll();
    $i = 1;
    $metodCambio = new ArrayIterator();
    $descCambio = new ArrayIterator();
    $porcCambio = new ArrayIterator();
    foreach ($datos as $dato) {
        if (($i % 2) == 0) {
            $color = "#AED6F1";
        } else {
            $color = "#E8F6F3";
        }
        $idp = $dato['idprod'];
        $d0 = trim($dato['orden']);
        $d1 = $dato['tipoorden'];
        $d2 = $dato['nit'];
        $d3 = $dato['fechafac'];
        $d4 = $dato['vend'];
        $d5 = $dato['responsable'];
        $d6 = trim($dato['codprod']);
        $d7 = $dato['descripcion'];
        $d8 = $dato['cantidad'];
        $d9 = $dato['porc_desc'];
        $d10 = $dato[''];
        $d11 = $dato[''];
        $d12 = $dato1[''];
        //subconsulta
        $desc_cambio = "";
        $pdesc = "";
        echo "";
        if ($idp > 0) {
            $query2 = "select distinct
                                ol.product_id
                                ,ol.discount_comments as pdesc
                                ,concat(ol.discount_comments,concat(' ',pu.name)) as desc_cambio
                                from sale_order o
                                left join sale_order_line ol on o.id=ol.order_id
                                left join discount_discount_sale_order_line_rel rel on ol.id=rel.sale_order_line_id
                                left join discount_discount ds on rel.discount_discount_id=ds.id
                                left join discount_type td on ds.discount_type_id=td.id
                                left join res_users usr on ol.discount_approver=usr.id
                                left join res_partner pu on usr.partner_id=pu.id
                                where ds.disc_type='discount' and o.name='$d0' and ol.product_id='$idp'
                            ";
            // echo " Query 2 $query2  <br>";
            $resultadoodoo2 = $Conn->prepare($query2);
            $resultadoodoo2->execute();
            $datos2 = $resultadoodoo2->fetchAll();
            foreach ($datos2 as $dato2) {
                $desc_cambios = $dato2['desc_cambio'];
                $pdesc = $dato2['pdesc'];
            }
            //terciario
            $query3 = "
                SELECT
                    trim(ds.name) as tipodescuento
                FROM 
                    sale_order o
                    left join sale_order_line ol on o.id=ol.order_id
                    left join discount_discount_sale_order_line_rel rel on ol.id=rel.sale_order_line_id
                    left join discount_discount ds on rel.discount_discount_id=ds.id
                    left join discount_type td on ds.discount_type_id=td.id
                    left join res_users usr on ol.discount_approver=usr.id
                    left join res_partner pu on usr.partner_id=pu.id
                where 
                    ds.disc_type='discount' 
                    and o.name='$d0' 
                    and ol.product_id='$idp'
                group by 
                    ds.name, o.name,ds.disc_type,ol.product_id
                            ";
            // echo "query 3<br> $query3  <br> " ;
            $desc_descuentos = "";
            $resultadoodoo3 = $Conn->prepare($query3);
            $resultadoodoo3->execute();
            $datos3 = $resultadoodoo3->fetchAll();
            foreach ($datos3 as $dato3) {
                $desc_descuentos = $desc_descuentos . " - " . $dato3['tipodescuento'];
            }
        }
        $r = $r . "<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
        $r = $r . "<td style='width: 10%; font-size: 0.8em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $i . "</td>
                                    <td style='width: 10%; font-size: 0.8em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d0 . "</td>
                                    <td style='width: 10%; font-size: 0.8em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d1 . "</td>
                                    <td style='width: 10%; font-size: 0.8em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d2 . "</td>
                                    <td style='width: 10%; font-size: 0.8em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d3 . "</td>
                                    <td style='width: 10%; font-size: 0.8em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d4 . "</td>
                                    <td style='width: 10%; font-size: 0.8em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d5 . "</td>
                                    <td style='width: 10%; font-size: 0.8em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d6 . "</td>
                                    <td style='width: 10%; font-size: 0.8em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d7 . "</td>
                                    <td style='width: 10%; font-size: 0.8em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d8 . "</td>
                                    <td style='width: 10%; font-size: 0.8em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d9 . "</td>
                                    <td style='width: 10%; font-size: 0.8em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $desc_descuentos . "</td>
                                    <td style='width: 10%; font-size: 0.8em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $desc_cambios . "</td>
                                    <td style='width: 10%; font-size: 0.8em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $pdesc . "</td>
                                    <td style='width: 10%; font-size: 0.8em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'></td>";
        $r = $r . "</tr>";

        //EXCEL
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $fd, $i)
            ->setCellValue('B' . $fd, $d0)
            ->setCellValueExplicitByColumnAndRow(2, $fd, $d1, PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValue('D' . $fd, $d2)
            ->setCellValue('E' . $fd, $d3)
            ->setCellValue('F' . $fd, $d4)
            ->setCellValue('G' . $fd, $d5)
            ->setCellValue('H' . $fd, $d6)
            ->setCellValue('I' . $fd, $d7)
            ->setCellValue('J' . $fd, $d8)
            ->setCellValue('K' . $fd, $d9)
            ->setCellValue('L' . $fd, $desc_descuentos)
            ->setCellValue('M' . $fd, $desc_cambios)
            ->setCellValue('N' . $fd, $pdesc);
        $i++;
        $fd++;
    }

    //}
}
Conexion::cerrarConexion();
mssql_close();
$r = $r . "</table>";
//CREA ARCHIVO************************************************************
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//Guardar el achivo: 
$objWriter->save($mipath2);
$r = $r . "</table>";

echo $r;
