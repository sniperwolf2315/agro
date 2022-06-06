<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

$cedula = trim($_GET['c']);
$i = 1;
$query1 = "
    select 
        rp.id as buscar,
        block as cred_cloque, 
        check_due as bloq_por_fac_vendida,
        credit_limit as lim_cre
from 
       res_partner as rp
       left join res_partner_res_partner_category_rel as rprpcr on rp.id = rprpcr.partner_id
       left join res_partner_category as rpc on rprpcr.category_id=rpc.id
where 
        rp.ref='" . $cedula . "' 
        and rp.customer='true' 
        and rpc.name='CREDITO';
        
";


$resultado1 = $Conn->prepare($query1);
$resultado1->execute();
$datos1 = $resultado1->fetchAll();
$pasa_query = count($datos1);
if ($pasa_query === 0) {
    echo "<h5><p style=\"text-align: center;\" class=\"z-depth-1\">No hay datos para mostrar en cartera por cliente</p></h5>";
    return;
}

$r = $r . "
        <p style=\"text-align: center;\" class=\"z-depth-1\">Cartera Por Cliente: " . $cedula . "</p>                                                    
        <table style=\"border: 1px solid #000; width:100%;\" class=\"#009688 teal\">                                                                     
            <tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">                                                                                 
                <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
                <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Plazo de pago de cliente</td>
                <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Total a cobrar</td>
                <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Limite de Credito</td>
                <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Bloqueo por facturas vencidas</td>
                <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Credito Bloqueado</td>                            
            </tr>                                                                                                                                            
";


// TODO: REVISAR ESTA CONSULTA ESTA GERANDO ERROR
//DATOS        
foreach ($datos1 as $dato1) {
    if (($i % 2) == 0) {
        $color = "#AED6F1";
    } else {
        $color = "#E8F6F3";
    }
    $d2 = $dato1['cred_cloque'];
    //$x = Boolean($d2);
    $d3 = $dato1['bloq_por_fac_vendida'];
    $d4 = $dato1['lim_cre'];
    $dc = $dato1['buscar'];
    $query2 = "select value_reference from ir_property where res_id like '%" . $dc . "%' and name='property_payment_term';";
    $resultado2 = $Conn->prepare($query2);
    $resultado2->execute();
    $datos2 = $resultado2->fetchAll();
    $contador = 0;
    foreach ($datos2 as $dato2) {
        $id_aa = $dato2['value_reference'];

        $respa = explode('account.payment.term,', $id_aa);
        $Resa = $respa[1];

        $querya = "select * from account_payment_term where id='" . $Resa . "';";
        $resultadoa = $Conn->prepare($querya);
        $resultadoa->execute();
        $datosa = $resultadoa->fetchAll();
        //estraer dato: plazo de pago de cliente
        foreach ($datosa as $datoa) {
            $id_na1 = $datoa['name'];
            if ($id_na1 != '') {
                $id_na1 = $datoa['name'];
            } else {
                $id_na1 = "N/A";
            }
        }
        $contador++;
    }
    $query3 = "
    
    SELECT 
        l.partner_id as id_cliente, 
        a.type as tipo, 
        SUM(l.debit-l.credit) as resultado 
    FROM 
        account_move_line l
        LEFT JOIN account_account a ON (l.account_id=a.id)
    WHERE 
        a.type IN ('receivable','payable') 
        AND l.partner_id IN ('" . $dc . "') 
        AND l.reconcile_id IS NULL 
    GROUP BY 
        l.partner_id, a.type;
    ";

    $resultado3 = $Conn->prepare($query3);
    $resultado3->execute();
    $datos3 = $resultado3->fetchAll();

    foreach ($datos3 as $dato3) {
        $id_aa3 = $dato3['tipo'];

        if ($id_aa3 == 'receivable') {
            $id_aa3 = $dato3['resultado'];
        }
    }



    $prueba = number_format($d4);
    $tot_cob = number_format($id_aa3);
    //$d1=$tot_cob;

    //$r=$r."<p>Categorizaci&oacute;n Credito y Cartera.</p>";
   /*  $r = $r . "<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>                                                          ";
    $r = $r . "<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>" . $i . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>" . $id_na1 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>" . $tot_cob . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>" . $prueba . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>" . $d3 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>" . $d2 . "</td>              ";
    $r = $r . "</tr>                                                                                                                                                  ";
 */
    $r = $r ."
    <tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>                                                          
        <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>    ". $i       . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>". $id_na1  . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>". $tot_cob . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>". $prueba  . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>". $d3      . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>". $d2      . "</td>              
        </tr>                                                                                                                                                  
            
    
    ";





    $i++;
}
$r = $r . "</table>";

//CERRRAR CONEXION BASE
mssql_close();
echo $r;
