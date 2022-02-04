<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

$cedula=trim($_GET['c']);

$query1="SELECT rp.id as id_cliente,rp.display_name as nom_completo,
rp.email as email,rp.credit_limit as lim_credito,rp.tipo_tercero as tip_tercerp,
cpq.name as pregunta,cpa.name as respuesta,ru.login as vendedor
from res_partner as rp
left join partner_question_rel as pqr on rp.id=pqr.partner
left join crm_profiling_answer as cpa on pqr.answer=cpa.id
left join crm_profiling_question as cpq on cpa.question_id=cpq.id
left join res_users as ru on rp.user_id=ru.id
left join res_partner_res_partner_category_rel as rprpcr on rp.id = rprpcr.partner_id
left join res_partner_category as rpc on rprpcr.category_id=rpc.id
where rp.ref='".$cedula."' and rp.customer='true' and rp.customer='true' and rpc.name='CREDITO';";

$resultado1= $Conn->prepare($query1);
$resultado1->execute();
$datos1=$resultado1->fetchAll();
$cantP1=count($datos1);
$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Perfil del cliente: ".$cedula."</p>";
    $i=1;
        $r=$r."<table style=\"border: 1px solid #000; width:100%;\" class=\"#009688 teal\" >";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">";
        $r=$r."<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Pregunta</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Respuesta</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Vendedor</td>";
        $r=$r . "</tr>";


        
//DATOS        
foreach($datos1 as $dato1){
        if(($i%2)==0){
            $color="#AED6F1";
        }else{
            $color="#E8F6F3";
        }
        $d2=$dato1['nom_completo'];
        $d3=$dato1['email'];
        $d4=$dato1['lim_credito'];
        $d5=$dato1['tip_tercerp'];
        $d6=$dato1['pregunta'];
        $d7=$dato1['respuesta'];
        $d8=$dato1['vendedor'];

                        //$r=$r."<p>Categorizaci&oacute;n Credito y Cartera.</p>";
                            $r=$r."<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                            $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$i."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d6."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d7."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d8."</td>";
                            $r=$r."</tr>";
                            $i++;
}
$r=$r . "</table>";
//CERRRAR CONEXION BASE
mssql_close();

echo $r;
?>