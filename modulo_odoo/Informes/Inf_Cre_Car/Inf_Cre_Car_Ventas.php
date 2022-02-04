<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

$cedula=trim($_GET['c']);

$query1="select so.name as ped_numero,so.date_order as fecha,rp.display_name as cliente,so.user_id as buscar1,so.amount_total as total,so.state as estado,
qt.name as tip_cotiza
from res_partner as rp
left join sale_order as so on rp.id=so.partner_id
left join res_users as ru on rp.user_id=ru.id
left join quotation_type as qt on so.quotation_type_id=qt.id
left join res_partner_res_partner_category_rel as rprpcr on rp.id = rprpcr.partner_id
left join res_partner_category as rpc on rprpcr.category_id=rpc.id
where rp.ref='".$cedula."' and rp.customer='true' and rp.customer='true' and rpc.name='CREDITO';";

$resultado1= $Conn->prepare($query1);
$resultado1->execute();
$datos1=$resultado1->fetchAll();
$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Facturas de venta del cliente: ".$cedula."</p>";
    $i=1;
        $r=$r."<table style=\"border: 1px solid #000; width:100%;\" class=\"#009688 teal\" >";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">";
        $r=$r."<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Pedido Numero</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Fecha</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Cliente</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Vendedor</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Total</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Estado</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Tipo de Cotizacion</td>";
        $r=$r . "</tr>";


        
//DATOS        
foreach($datos1 as $dato1){
        if(($i%2)==0){
            $color="#AED6F1";
        }else{
            $color="#E8F6F3";
        }
        $d2=$dato1['ped_numero'];
        $d3=$dato1['fecha'];
        $d4=$dato1['cliente'];
        $d5=$dato1['total'];
        $d6=$dato1['estado'];
        $d7=$dato1['tip_cotiza'];
        
        //$id_cli=$dato1['id'];
        $id_ven=$dato1['buscar1'];
        
        if ($id_ven!=''){
            $query2="select ru.partner_id,ru.login,rp.name from res_users as ru left join res_partner as rp on ru.partner_id=rp.id where ru.id='".$id_ven."';";
            $resultado2= $Conn->prepare($query2);
            $resultado2->execute();
            $datos2=$resultado2->fetchAll();
            
            foreach($datos2 as $dato2){
                $id_aa=$dato2['name'];
            }
        }
            $Imp_pag=number_format($d5);
                        //$r=$r."<p>Categorizaci&oacute;n Credito y Cartera.</p>";
                            $r=$r."<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                            $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$i."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d2."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d3."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d4."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$id_aa."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$Imp_pag."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d6."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d7."</td>";
                            $r=$r."</tr>";
                            $i++;
}
$r=$r . "</table>";
//CERRRAR CONEXION BASE
mssql_close();

echo $r;
?>