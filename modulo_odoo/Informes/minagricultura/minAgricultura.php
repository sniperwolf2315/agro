<?php
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

include('../conectarbase.php');

function cellColor($cells, $color)
{
    global $objPHPExcel;

    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => $color
        )
    ));
}

//$resultSQL = "DELETE FROM [InformesCompVentas].[dbo].[MinAgriculturaInformeOdoo]";
//mssql_query($resultSQL,  $cLink);
//ruta
$fecha = date('M', strtotime('-1 month')) . date('Y');
$mesant = date('m', strtotime('-1 month'));
$miruta = '/var/www/html/modulo_odoo/Informes/minagricultura/reporte';
$nombre_fichero = 'Informe_MinAgricultura_' . $fecha;
$mipath = $miruta . '/' . $nombre_fichero . '.xlsx';



$r = $r . "<p style=\"text-align: center;\" class=\"z-depth-1\">Reporte de Ventas Min-agricultura.</p>";

$r = $r . "<table style=\"border: 1px solid #000; width:100%; \" class=\"#439049 green darken-1\">";
$r = $r . "<tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">";
$r = $r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>";
$r = $r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Item</td>";
$r = $r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Manejador</td>";
$r = $r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Bodega</td>";
$r = $r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Inventario Final</td>";
$r = $r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Cantidad Vendida</td>";
$r = $r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Precio Promedio de Venta</td>";
$r = $r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\"><Strong>
    <a href='minagricultura/reporte/$nombre_fichero.xlsx' class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>";
$r = $r . "</tr>";

if (file_exists($miruta)) {
    include('Classes/PHPExcel.php');
    include('Classes/PHPExcel/Reader/Excel2007.php');
    //Crear el objeto Excel: 
    $objPHPExcel = new PHPExcel();
    //Configurando el archivo: 
    $objPHPExcel->getProperties()->setCreator("Autor: IngJairo");
    $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo");
    $objPHPExcel->getProperties()->setTitle("Informe de Productos sin iva");
    $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
    $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
    $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
    $objPHPExcel->getProperties()->setCategory("Resultado de Informe");
    //Seleccionamos la hoja sobre la que queremos escribir 
    //combinar celdas
    $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');

    cellColor('A1:I1', 'EAE27A');
    //titulos 
    $titulo = 'INFORME MINAGRICULTURA: AGROCAMPO ' . $fecha;
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', $titulo);

    //Alineacion
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    // Color rojo al texto
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
    $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
    $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
    $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
    $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
    $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
    $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
    $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
    $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
    $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);

    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
    //titulos
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A2', 'FANNY RODROGUEZ');

    $objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
    $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
    cellColor('A2', 'D4EE8C');
    cellColor('B2', 'D4EE8C');
    cellColor('C2', 'D4EE8C');
    cellColor('D2', 'D4EE8C');
    cellColor('E2', 'D4EE8C');
    cellColor('F2', 'D4EE8C');
    cellColor('G2', 'D4EE8C');
    cellColor('H2', 'D4EE8C');
    cellColor('I2', 'D4EE8C');

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A3', 'ITEM')
        ->setCellValue('B3', 'MANEJADOR')
        ->setCellValue('C3', 'INV FINAL')
        ->setCellValue('D3', 'CANT VEND')
        ->setCellValue('E3', 'PROM VENTA')
        ->setCellValue('F3', '')
        ->setCellValue('G3', 'INV FINAL')
        ->setCellValue('H3', 'CANT VEND')
        ->setCellValue('I3', 'PROM VENTA');
    $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
    $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
    $objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
    $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
    $objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
    $objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
    $objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
    $objPHPExcel->getActiveSheet()->getStyle('H3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
    $objPHPExcel->getActiveSheet()->getStyle('I3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
    cellColor('A3', 'BAD17B');
    cellColor('B3', 'BAD17B');
    cellColor('C3', 'BAD17B');
    cellColor('D3', 'BAD17B');
    cellColor('E3', 'BAD17B');
    cellColor('F3', 'BAD17B');
    cellColor('G3', 'BAD17B');
    cellColor('H3', 'BAD17B');
    cellColor('I3', 'BAD17B');

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('D4', 'ALMACEN');
    $objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
    cellColor('C4', '7BC3D1');
    cellColor('D4', '7BC3D1');
    cellColor('E4', '7BC3D1');

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('H4', 'PORTOS');
    $objPHPExcel->getActiveSheet()->getStyle('H4')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
    cellColor('G4', '7BC3D1');
    cellColor('H4', '7BC3D1');
    cellColor('I4', '7BC3D1');

    //negilla
    $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setBold(true);

    //ANCHOR
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);

    $objPHPExcel->getActiveSheet()->setTitle("Informe MinAgricultura");
    //datos
    $f = 5;
    $C = 0;

    $datosf73 = new ArrayIterator();
    $datosm73 = new ArrayIterator();

    //pinta los items   DISTINCT([Item]), Manejador
    $f1 = 0;
    $f2 = 0;
    $f3 = 0;
    $C = 0;
}

$mes_anterior = $mesant;
if ((int)$mes_anterior == 1 || $mes_anterior == '01') {
    $anioact = (int)date("Y") - 1;
    $mes_anterior = '12';
} else {
    $mes_anterior = $mesant; //date('m', strtotime('-1 month'));
    $anioact = (int)date("Y");
}
if (strlen($mes_anterior) == 1) {
    $mes_anterior = '0' . $mes_anterior;
}
$f = 5;
$f005 = 0;
$ft = 1;
$datoscod = new ArrayIterator();
$filascod = new ArrayIterator();
$resultSQL = mssql_query(" select SUBSTRING(Item ,2,30) Item , Manejador  FROM [InformesCompVentas].[dbo].[InfItemsMinAgricultura] ORDER BY Manejador DESC", $cLink);
/*TODO: 
CAMBIAR LA CONSULTA a: select * from vskl_product_odooibs esta vista tiene la informacion de los productos de Odoo
con su codigo asociativo para IBS
*/

while ($resultadoSql = mssql_fetch_array($resultSQL)) {

    //items habilitados para ventas sin iva
    $itemIbs = $resultadoSql["Item"];
    $itemIbs = substr($itemIbs, 1, 30);
    $itemIbs = trim($itemIbs);

    $manejadorIbs = trim($resultadoSql["Manejador"]);

    //busco el paralelo de codigos en ibs-odoo
    $resultSQL2 = mssql_query(" select ItemOdoo FROM [InformesCompVentas].[dbo].[InfItemsIbsOdoo] WHERE ItemIbs like '%$itemIbs'", $cLink);

    //echo $itemIbs."----";
    if ($resultadoSql2 = mssql_fetch_array($resultSQL2)) {
        $itemOdoo = trim($resultadoSql2["ItemOdoo"]);
        // $itemOdoo = trim($resultadoSql2["ItemIbs"]);
        // echo $itemOdoo."<br>----";
        $Bod008Existen = 0;
        $Bod005Existen = 0;
        $queryExist = "
            select
                p.default_code as item,
                l.complete_name as locacionbodega,
                case when trim(split_part(l.complete_name, '/', 1))='Agro' then trim(split_part(l.complete_name, '/', 2)) else trim(split_part(l.complete_name, '/', 1)) end AS bodega,
                sum(q.qty) as existen
            from 
                stock_quant q
                right join product_product p ON q.product_id=p.id
                left join stock_location l ON l.id = q.location_id
            group by 
                p.default_code,q.location_id,l.complete_name
            having 
                p.default_code='$itemOdoo' and q.location_id not in(9)
        ";

        // echo $queryExist.'<br> <br> <br><br>';
        $resultadomex = $Conn->prepare($queryExist);
        $resultadomex->execute();
        $datosex = $resultadomex->fetchAll();
        foreach ($datosex as $datoex) {
            $Bodega = $datoex['bodega'];
            $Existen = $datoex['existen'];
            if ($Bodega == '005') {
                $Bod005Existen = $Bod005Existen + $Existen;
            } else if ($Bodega == '008') {
                $Bod008Existen = $Bod008Existen + $Existen;
            }
        }
        //fin existencias***************************************
        $query = "select
            p.id as idproducto,
            o.name as Orden,
            cf.number as factura,
            cf.internal_number,
            ltrim(split_part(il.name, ']', 1),'[') as item,
            split_part(il.name, ']', 2) AS nombre,
            left(cf.origin,3) AS bodega,
            il.price_subtotal as precio,
            il.quantity as cantidadvend,
            cf.date_sale_order,
            u.login as manejador,
            o.state as estadoorden
            from sale_order o
            left join sale_order_invoice_rel oi ON o.id=oi.order_id
            --left join stock_quant st ON o.id=st.product_id
            left join account_invoice cf ON oi.invoice_id=cf.id and o.state='done'
            left join account_invoice_line il ON cf.id=il.invoice_id
            left join product_product p ON (ltrim(split_part(il.name, ']', 1),'['))=p.default_code
            left join product_template t ON p.product_tmpl_id=t.id
            left join res_users u ON t.product_manager=u.id
            where EXTRACT(YEAR FROM  cf.date_invoice)  = '$anioact' AND EXTRACT(MONTH FROM  cf.date_invoice) = '06'
            and left(cf.internal_number,1) IN('F','S','D','0') and ltrim(split_part(il.name, ']', 1),'[')='$itemOdoo'
            and u.login IN('RODRIGUEZF','PINILLOSM') and left(cf.origin,3) IN('005','008')
            order by u.login desc";

        $resultadom = $Conn->prepare($query);
        $resultadom->execute();
        $datos = $resultadom->fetchAll();
        $d3 = '0';
        $fila = 0;
        $C2 = 0;

        foreach ($datos as $dato) {
            if (($ft % 2) == 0) {
                $color = "#AED6F1";
            } else {
                $color = "#E8F6F3";
            }
            $d0 = $dato['idproducto'];
            $d1 = $dato['item'];
            $d1 = trim($d1);
            $d2 = $dato['bodega'];
            $d4 = $dato['manejador'];
            $d5 = $dato['cantidadvend'];
            $d6 = $dato['precio'];
            //echo $d1."---".$d2."---".$d4."; ";
            //promedio venta
            $pv = $d6 / $d5;
            if (trim($d2) == '005') {
                $d3 = $Bod005Existen;
            } else if (trim($d2) == '008') {
                $d3 = $Bod008Existen;
            }
            //carga datos en arreglo
            if ($d2 != "") {
                $datoscod[$f005] = $d2 . "^" . $d1 . "^" . $d3 . "^" . $d4 . "^" . $d5 . "^" . $pv;
                $f005++;
            }

            //inserta datos en sql los datos de minagricultura
            /*
            $query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[MinAgriculturaInformeOdoo] WHERE Item='".$d1."',Manejador='".$d4."',Bodega='".$d2."',InvFinal='".$d3."',CantVendida='".$d5."',PromVenta='".$d6."'");
            if (!mssql_num_rows($query)) {
                $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[MinAgriculturaInformeOdoo](Item,Manejador,Bodega,InvFinal,CantVendida,PromVenta) 
                VALUES('$d1','$d4','$d2','$d3','$d5','$pv')"; 
                mssql_query($sqlv,$cLink);
            }*/
            $r = $r . "<tr style='background-color: $color;font-size: 0.8em;'>";
            $r = $r . "<td style='padding: 5px;'>" . $ft . "</td>";
            $r = $r . "<td style='padding: 5px;'>" . $d1 . "</td>";
            $r = $r . "<td style='padding: 5px;'>" . $d4 . "</td>";
            $r = $r . "<td style='padding: 5px;'>" . $d2 . "</td>";
            $r = $r . "<td style='padding: 5px;'>" . $d3 . "</td>";
            $r = $r . "<td style='padding: 5px;'>" . $d5 . "</td>";
            $r = $r . "<td style='padding: 5px;'>" . $pv . "</td>";
            $r = $r . "<td style='padding: 5px;'>&nbsp;</td>";
            $r = $r . "</tr>";
            $ft++;
        }   //fin foreach


    }
}
//arma archivo excel
$tam = count($datoscod);
$f = 0;
$fil = 5;
while ($f < $tam) {
    $datos = explode("^", $datoscod[$f]);
    $bod = $datos[0];
    $item = $datos[1];
    $exis = $datos[2];
    $manj = $datos[3];
    $cant = $datos[4];
    $valor = $datos[5];
    if ($bod == '005' && $manj == 'RODRIGUEZF') {
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $fil, "'" . $item)
            ->setCellValue('B' . $fil, $manj)
            ->setCellValue('C' . $fil, $exis)
            ->setCellValue('D' . $fil, $cant)
            ->setCellValue('E' . $fil, $valor);
        //bodega 008 rodriguez
        $f2 = 0;
        while ($f2 < $tam) {
            $datos2 = explode("^", $datoscod[$f2]);
            $bod2 = $datos2[0];
            $item2 = $datos2[1];
            $exis2 = $datos2[2];
            $manj2 = $datos2[3];
            $cant2 = $datos2[4];
            $valor2 = $datos2[5];
            if ($bod2 == '008' && $manj2 == 'RODRIGUEZF' && $item == $item2) {
                $objPHPExcel->setActiveSheetIndex(0)
                    //->setCellValue('A'.$f, $item)
                    //->setCellValue('B'.$f, $manj2)
                    ->setCellValue('G' . $fil, $exis2)
                    ->setCellValue('H' . $fil, $cant2)
                    ->setCellValue('I' . $fil, $valor2);
            }
            $f2++;
        }
        $fil++;
    }

    $f++;
}

//pinillos
$fil = $f + 2;
$objPHPExcel->getActiveSheet()->mergeCells('D' . $fil . ':' . 'E' . $fil);
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('D' . $fil, 'MARTA PINILLOS');

$objPHPExcel->getActiveSheet()->getStyle('D' . $fil)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D' . $fil)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
$objPHPExcel->getActiveSheet()->getStyle('D' . $fil)->getFont()->setBold(true);
cellColor('A' . $fil, 'D4EE8C');
cellColor('B' . $fil, 'D4EE8C');
cellColor('C' . $fil, 'D4EE8C');
cellColor('D' . $fil, 'D4EE8C');
cellColor('E' . $fil, 'D4EE8C');
cellColor('F' . $fil, 'D4EE8C');
cellColor('G' . $fil, 'D4EE8C');
cellColor('H' . $fil, 'D4EE8C');
cellColor('I' . $fil, 'D4EE8C');
$fil++;
$f = 0;
while ($f < $tam) {
    $datos = explode("^", $datoscod[$f]);
    $bod = $datos[0];
    $item = $datos[1];
    $exis = $datos[2];
    $manj = $datos[3];
    $cant = $datos[4];
    $valor = $datos[5];
    if ($bod == '005' && $manj == 'PINILLOSM') {
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $fil, "'" . $item)
            ->setCellValue('B' . $fil, $manj)
            ->setCellValue('C' . $fil, $exis)
            ->setCellValue('D' . $fil, $cant)
            ->setCellValue('E' . $fil, $valor);
        $fil++;
    }
    $f++;
}

//exit();
$r = $r . "</table>";
//crear objeto writer
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//Guardar el achivo: 
$objWriter->save($mipath);
//echo "<br /><br />";
$descarga = $nombre_fichero . ".xlsx";
Conexion::cerrarConexion();
mssql_close();
echo $r;
