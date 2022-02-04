<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

$cedula=trim($_GET['c']);

$query1="select ai.number as nom_fac,ai.internal_number as num_factura,ai.state as estado,ai.type as tip_trans,ai.date_invoice as fecha,
ai.amount_untaxed as subtotal,ai.amount_tax as impuesto,ai.amount_total as total,ai.residual as saldo
from res_partner as rp
left join account_invoice as ai on rp.id=ai.partner_id
left join res_partner_res_partner_category_rel as rprpcr on rp.id = rprpcr.partner_id
left join res_partner_category as rpc on rprpcr.category_id=rpc.id
where rp.customer='true' and rp.customer='true' and rpc.name='CREDITO' and ai.internal_number is not null and ai.state='open' 
and ai.type='in_invoice' and rp.ref='".$cedula."';";
$resultado1= $Conn->prepare($query1);
$resultado1->execute();
$datos1=$resultado1->fetchAll();
$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Facturas en Estado Abierto del cliente: ".$cedula."</p>";
    $i=1;
        $r=$r."<table style=\"border: 1px solid #000; width:100%;\" class=\"#009688 teal\">";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">";
        $r=$r."<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Nombre de Factura</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Numero Interno Factura</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Estado</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Tipo de Transacci&oacute;n</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Fecha</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Sub Total</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Impuesto</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Total</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Saldo</td>";
        $r=$r . "</tr>";

                
 

        
//DATOS        
foreach($datos1 as $dato1){
        if(($i%2)==0){
            $color="#AED6F1";
        }else{
            $color="#E8F6F3";
        }
        $d2=$dato1['nom_fac'];
        //$x = Boolean($d2);
        $d3=$dato1['num_factura'];
        $d4=$dato1['estado'];
        $d5=$dato1['tip_trans'];
        $d6=$dato1['fecha'];
        $d7=$dato1['subtotal'];
        $d8=$dato1['impuesto'];
        $d9=$dato1['total'];
        $d10=$dato1['saldo'];
            
            
            //$Sub_total=number_format($d7);
            $Sub_total=number_format($d7);
            //$tot_cob=number_format($d7);
            //$d1=$tot_cob;

                        //$r=$r."<p>Categorizaci&oacute;n Credito y Cartera.</p>";
                            $r=$r."<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                            $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$i."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d2."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d3."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d4."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d5."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d6."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$Sub_total."</td>
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
