<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();
//$cedula=trim($_GET['c']);

$anio=trim($_GET['a']);
$mes=trim($_GET['m']);

//fecha inicio fecha din de la consulta x mes
$dia = cal_days_in_month(CAL_GREGORIAN, $mes, $anio); // 31
$feini=$anio."-".$mes."-01";
$fefin=$anio."-".$mes."-".$dia;

$query1="select o.name as orden, p.default_code as item, p.name_template as nombre, p.document_sale, cf.number as factura,
il.local_subtotal as valor, il.quantity as cantidad,
left(cf.origin,3) as bodega, cf.date_invoice as fecha, o.state as estado
from product_product p
left join sale_order o ON p.document_sale=o.name
left join sale_order_invoice_rel oi ON o.id=oi.order_id
left join account_invoice cf ON oi.invoice_id=cf.id and o.state='done'
left join account_invoice_line il ON cf.id=il.invoice_id and p.id=il.product_id
where cf.date_invoice between '".$feini."' and '".$fefin."' and cf.number is not null;";

$resultado1= $Conn->prepare($query1);
$resultado1->execute();
$datos1=$resultado1->fetchAll();
$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Informe General de Ventas</p>";
    $i=1;//row #439049 green darken-1
        $r=$r."<table style=\"border: 1px solid #000; width:100%;\" class=\"#439049 green darken-1\" >";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">";
        $r=$r."<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
        <td style=\"font-weight: bold;text-: left;\" class=\"z-depth-1 white-text text-darken-2\">Orden</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Item</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Nombre</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Factura</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Valor</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Cantidad</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Bodega</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Fecha</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Estado</td>";
        $r=$r . "</tr>";


        
//DATOS        
foreach($datos1 as $dato1){
        if(($i%2)==0){
            $color="#AED6F1";
        }else{
            $color="#E8F6F3";
        }
        $d2=$dato1['orden'];
        $d3=$dato1['item'];
        $d4=$dato1['nombre'];
        $d5=$dato1['factura'];
        $d6=$dato1['valor'];
        $d7=$dato1['cantidad'];
        $d8=$dato1['bodega'];
        $d9=$dato1['fecha'];
        $d10=$dato1['estado'];
        
        //$id_cli=$dato1['id'];
        
        $Val_num=number_format($d6);
            //$r=$r."<p>Categorizaci&oacute;n Credito y Cartera.</p>";
            $r=$r."<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
            $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$i."</td>
                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d2."</td>
                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d3."</td>
                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d4."</td>
                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d5."</td>
                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$Val_num."</td>
                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d7."</td>
                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d8."</td>
                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d9."</td>
                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d10."</td>";
            $r=$r."</tr>";
            $i++;
}
$r=$r . "</table>";
//CERRRAR CONEXION BASE
mssql_close();

echo $r;
?>