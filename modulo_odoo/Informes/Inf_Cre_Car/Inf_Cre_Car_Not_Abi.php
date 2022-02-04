<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

$cedula=trim($_GET['c']);

$query1="select ai.date_invoice as fecha,rp.display_name as cliente,ai.number as titulo_nt,ai.name as titulo_2,ai.internal_number as numero_fact,
ai.type as tipo,ai.origin as origen,ai.state as estado,ai.amount_untaxed as subtotal,
ai.residual as saldo,ai.amount_total as total,aj.name as comprobante,ai.move_name as secuen_asiento
from account_invoice as ai
left join res_partner as rp on ai.partner_id=rp.id
left join account_journal as aj on ai.journal_id=aj.id
where ai.type='out_refund' and ai.internal_number is not null and ai.state='open' and rp.ref='".$cedula."';";
$resultado1= $Conn->prepare($query1);
$resultado1->execute();
$datos1=$resultado1->fetchAll();
$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Notas en Estado Abierto: ".$cedula."</p>";
    $i=1;
        $r=$r."<table style=\"border: 1px solid #000; width:100%;\" class=\"#009688 teal\">";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">";
        $r=$r."<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Fecha</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Cliente</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Titulo</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Titulo 2</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Numero de Factura</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Tipo</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Origen</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Estado</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Subtotal</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Saldo</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Total</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Comprobante</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Secuen de Asientos</td>";
        $r=$r . "</tr>";

                
 

        
//DATOS        
foreach($datos1 as $dato1){
        if(($i%2)==0){
            $color="#AED6F1";
        }else{
            $color="#E8F6F3";
        }
        $d2=$dato1['fecha'];
        //$x = Boolean($d2);
        $d3=$dato1['cliente'];
        $d4=$dato1['titulo_nt'];
        $d5=$dato1['titulo_2'];
        $d6=$dato1['numero_fact'];
        $d7=$dato1['tipo'];
        $d8=$dato1['origen'];
        $d9=$dato1['estado'];
        $d10=$dato1['subtotal'];
        $d11=$dato1['saldo'];
        $d12=$dato1['total'];
        $d13=$dato1['comprobante'];
        $d14=$dato1['secuen_asiento'];
            
            //$Sub_total=number_format($d7);
            //$Sub_total=number_format($d7);
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
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d7."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d8."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d9."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d10."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d11."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d12."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d13."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d14."</td>";
                            $r=$r."</tr>";
        
                            $i++;
}
$r=$r . "</table>";

//CERRRAR CONEXION BASE
mssql_close();
echo $r;
?>
