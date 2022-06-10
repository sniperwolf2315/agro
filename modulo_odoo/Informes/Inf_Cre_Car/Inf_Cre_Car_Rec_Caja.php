<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

$cedula = trim($_GET['c']);

$query1 = "select rp.display_name as cliente,av.number as no_caja,av.date as fecha, av.reference as ref_pago,av.state as estado,av.amount as impo_pagado,
av.consignment_date as fec_consig,aj.name as medi_pago,ap.code as periodo2
from res_partner as rp
left join account_voucher as av on rp.id=av.partner_id
left join account_journal as aj on av.journal_id=aj.id
left join account_period as ap on av.period_id=ap.id
left join res_partner_res_partner_category_rel as rprpcr on rp.id = rprpcr.partner_id
left join res_partner_category as rpc on rprpcr.category_id=rpc.id
where av.state='posted' and rp.ref='" . $cedula . "' and rp.customer='true' and rpc.name='CREDITO';";

$resultado1 = $Conn->prepare($query1);
$resultado1->execute();
$datos1 = $resultado1->fetchAll();
$pasa_query = count($datos1);

if ($pasa_query === 0) {
    echo "<h5><strong><p style=\"text-align: center;\" class=\"z-depth-1\">No hay datos facturas para el cliente: " . $cedula . "</p></strong></h5>";
    return;
}

$i = 1;

$r = $r . "
    <p style=\"text-align: center;\" class=\"z-depth-1\">Facturas de caja del cliente: " . $cedula . "</p>                                 
    <table style=\"border: 1px solid #000; width:100%;\" class=\"#009688 teal\" >                                                      
        <tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">                                                                   
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Cliente</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No. de Caja</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Fecha</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Ref. Pago</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Estado</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Importe Pagado</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Fecha de consignaci&oacute;n</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">M&eacute;todo de Pago</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Per&iacute;odo</td>                 
        </tr>                                                                                                                                    
";

//DATOS        
foreach ($datos1 as $dato1) {
    if (($i % 2) == 0) {
        $color = "#AED6F1";
    } else {
        $color = "#E8F6F3";
    }
    $d2 = $dato1['cliente'];
    $d3 = $dato1['no_caja'];
    $d4 = $dato1['fecha'];
    $d5 = $dato1['ref_pago'];
    $d6 = $dato1['estado'];
    $d7 = $dato1['impo_pagado'];
    $d8 = $dato1['fec_consig'];
    $d9 = $dato1['medi_pago'];
    $d10 = $dato1['periodo2'];

    $Imp_pag = number_format($d7);
    $r = $r . "
            <tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>                                
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>" . $i . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>" . $d2 . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>" . $d3 . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>" . $d4 . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>" . $d5 . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>" . $d6 . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>" . $Imp_pag . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>" . $d8 . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>" . $d9 . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>" . $d10 . "</td>        
            </tr>                                                                                                                        
            ";
    $i++;
}
$r = $r . "</table>";
//CERRRAR CONEXION BASE
mssql_close();

echo $r;
